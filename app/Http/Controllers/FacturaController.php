<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FacturamaService;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\RegimenFiscal;
use Illuminate\Support\Str;
use DB;

class FacturaController extends Controller
{
public function index()
{
    $ventas = Venta::whereNotNull('uuid_factura')
        ->orderBy('created_at','desc')
        ->paginate(10);

    $regimenes=RegimenFiscal::orderBy('clave')->get();
    return view('facturacion', compact(
        'ventas',
        'regimenes'
    ));
}
    // 
public function facturar(Request $request, $id)
{
    $email = $request->email;
    $enviarEmail = $request->has('enviar_email');
    $venta = Venta::with('detalles')->findOrFail($id);

    if ($venta->uuid_factura) {
        return back()->withErrors('Esta venta ya fue facturada.');
    }

    if ($venta->detalles->isEmpty()) {
        return back()->withErrors('La venta no tiene productos.');
    }

    /*
    |-----------------------------------------
    | VALIDACIONES
    |-----------------------------------------
    */

    $request->validate([
        'rfc' => 'required',
        'razon_social' => 'required|min:3|max:254',
        'codigo_postal' => 'required|digits:5',
        'regimen_fiscal' => 'required',
        'uso_cfdi' => 'required'
    ]);

    $regimen = RegimenFiscal::findOrFail($request->regimen_fiscal);

    /*
    |-----------------------------------------
    | VALIDAR COMBINACIÓN USO CFDI
    |-----------------------------------------
    */

    if (!$this->validarUsoCfdi($regimen->clave, $request->uso_cfdi)) {
        return back()->withErrors(
            'La combinación de Régimen Fiscal y Uso CFDI no es válida.'
        );
    }

    /*
    |-----------------------------------------
    | ARMAR REQUEST FACTURAMA
    |-----------------------------------------
    */

    $data = [

        "CfdiType" => "I",

        "PaymentForm" => "01",

        "PaymentMethod" => "PUE",

        "Currency" => "MXN",

        "ExpeditionPlace" => "42501",

        "Receiver" => [

            "Rfc" => strtoupper($request->rfc),

            "Name" => strtoupper($request->razon_social),

            "CfdiUse" => $request->uso_cfdi,

            "FiscalRegime" => $regimen->clave,

            "TaxZipCode" => $request->codigo_postal

        ],

        "Items" => []

    ];

    /*
    |-----------------------------------------
    | CONCEPTOS
    |-----------------------------------------
    */

    foreach ($venta->detalles as $detalle) {

        $data['Items'][] = [

            "ProductCode" => $detalle->clave_sat ?? "01010101",

            "Description" => $detalle->descripcion ?? "Producto",

            "Unit" => $detalle->unidad_sat ?? "Pieza",

            "UnitCode" => $detalle->clave_unidad_sat ?? "H87",

            "Quantity" => (float) $detalle->cantidad,

            "UnitPrice" => round((float) $detalle->precio_unitario, 2),

            "Subtotal" => round((float) $detalle->subtotal, 2),

            "TaxObject" => $detalle->objeto_impuesto ?? "02",

            "Taxes" => [[

                "Total" => round((float) $detalle->iva, 2),

                "Name" => "IVA",

                "Base" => round((float) $detalle->subtotal, 2),

                "Rate" => 0.16,

                "IsRetention" => false

            ]],

            "Total" => round((float) $detalle->total, 2)

        ];

    }

    /*
    |-----------------------------------------
    | ENVIAR A FACTURAMA
    |-----------------------------------------
    */

    $facturama = new FacturamaService();

    $respuesta = $facturama->crearFactura($data);

    if (!$respuesta['success']) {

        return back()->withErrors(
            $respuesta['error']['Message'] ?? 'Error al generar factura.'
        );
    }

    if($enviarEmail && $email){
        $pdf = $facturama->descargarPDF($venta->facturama_id);
        $xml = $facturama->descargarXML($venta->facturama_id);
        Mail::to($email)->send(new FacturaMail($pdf,$xml,$venta));
    }

    $facturamaId = $respuesta['data']['Id'];
    $uuid = $respuesta['data']['Complement']['TaxStamp']['Uuid'];

    /*
    |-----------------------------------------
    | GUARDAR UUID
    |-----------------------------------------
    */

    $venta->update([

        'uuid_factura' => $uuid,

        'facturama_id' => $respuesta['data']['Id'],

        'status_factura' => 'timbrada',

        'fecha_facturacion' => now()

    ]);

    return back()->with('success', 'Factura generada correctamente');
}
public function cancelar($id)
{
    $venta = Venta::findOrFail($id);

    if(!$venta->uuid_factura){
        return back()->withErrors('Esta venta no tiene factura.');
    }

    if($venta->status_factura === 'cancelada'){
        return back()->withErrors('La factura ya está cancelada.');
    }

    $facturama = new FacturamaService();

    $respuesta = $facturama->cancelarFactura($venta->facturama_id, "02");

    if(!$respuesta['success']){
        return back()->withErrors('Error al cancelar factura.');
    }

    $venta->update([
        'status_factura' => 'cancelada'
    ]);

    return back()->with('success','Factura cancelada correctamente.');
}

public function buscar(Request $request)
{
    $request->validate([
        'folio' => 'required'
    ]);

$venta = Venta::with('detalles.producto')
    ->where('folio', $request->folio)
    ->orWhere('id_venta', $request->folio)
    ->first();

    if(!$venta){
        return back()->withErrors('No se encontró la venta.');
    }
    $clientes = Cliente::orderBy('razon_social')->get();

     $regimenes=RegimenFiscal::orderBy('clave')->get();

    return view('facturacion', compact('venta','clientes','regimenes'));
}

public function descargarXML($uuid)
{

    $facturama = new FacturamaService();

    $xml = $facturama->descargarXML($uuid);
    return response($xml)
        ->header('Content-Type','application/xml')
        ->header('Content-Disposition',"attachment; filename=factura.xml");

}

public function descargarPDF($uuid)
{

    $facturama = new FacturamaService();

    $pdf = $facturama->descargarPDF($uuid);

    return response($pdf)
        ->header('Content-Type','application/pdf')
        ->header('Content-Disposition',"inline; filename=factura.pdf");

}

public function verFactura($uuid)
{

    $facturama = new FacturamaService();

    $pdf = $facturama->descargarPDF($uuid);

    return response($pdf)
        ->header('Content-Type','application/pdf')
        ->header('Content-Disposition','inline');

}  
public function usosPorRegimen($id)
{

$regimen = RegimenFiscal::with('usosCfdi')
->where('id_regimen',$id)
->firstOrFail();

return response()->json([

'usos' => $regimen->usosCfdi,
'tipo_persona' => $regimen->tipo_persona

]);

}

private function validarUsoCfdi($regimen, $uso)
{

    $combinaciones = [

        "601" => ["G01","G02","G03","I01","I02","I03","I04","I05","I06","I07","I08","D01","D02","D03","D04","D05","D06","D07","D08","S01"],

        "603" => ["G03","S01"],

        "605" => ["S01"],

        "606" => ["G03","S01"],

        "612" => ["G01","G02","G03","D01","D02","D03","D04","D05","D06","D07","D08","S01"],

        "620" => ["G03","S01"],

        "621" => ["G01","G02","G03","D01","D02","D03","D04","D05","D06","D07","D08","S01"],

        "626" => ["G01","G02","G03","D01","D02","D03","D04","D05","D06","D07","D08","S01"],

        "616" => ["S01"]

    ];

    if (!isset($combinaciones[$regimen])) {
        return false;
    }

    return in_array($uso, $combinaciones[$regimen]);
}


}
