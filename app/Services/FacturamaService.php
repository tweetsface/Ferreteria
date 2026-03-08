<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacturamaService
{
    protected $user;
    protected $password;
    protected $url;

    public function __construct()
    {
        $this->user = config('services.facturama.user');
        $this->password = config('services.facturama.password');
        $this->url = config('services.facturama.url');
    }

    protected function client()
    {
        return Http::withoutVerifying()->withBasicAuth($this->user, $this->password)
            ->baseUrl($this->url)
            ->acceptJson();
    }

    public function crearFactura(array $data)
    {

         
        $response = $this->client()->post('/3/cfdis', $data);
        if ($response->failed()) {

            return [
                'success' => false,
                'error' => $response->json()
            ];
        }
           

        return [
            'success' => true,
            'data' => $response->json()
        ];
    }
    

   public function cancelarFactura($uuid, $motivo = "02", $uuidSustituto = null)
{
    $data = [
        "Uuid" => $uuid,
        "Motivo" => $motivo
    ];

    if($uuidSustituto){
        $data["FolioSustitucion"] = $uuidSustituto;
    }

    $response = $this->client()
        ->post('/3/cfdis/cancel', $data);

    if ($response->failed()) {
        return [
            'success' => false,
            'error' => $response->json()
        ];
    }

    return [
        'success' => true,
        'data' => $response->json()
    ];
}

public function consultarFactura($uuid)
{
    $response = $this->client()
        ->get("/3/cfdis/{$uuid}");

    if ($response->failed()) {
        return [
            'success' => false,
            'error' => $response->json()
        ];
    }

    return [
        'success' => true,
        'data' => $response->json()
    ];
}

public function descargarXML($id)
{

    $url = "https://apisandbox.facturama.mx/cfdi/xml/".$id;

    $response = Http::withBasicAuth(
        config('services.facturama.user'),
        config('services.facturama.password')
    )->get($url);



        if (!$response->successful()) {
        throw new \Exception("Error al descargar XML: ".$response->body());
    }

      $data = $response->json();

    return base64_decode($data['Content']);
}

public function descargarPDF($id)
{

    $url = "https://apisandbox.facturama.mx/cfdi/pdf/issued/".$id;

    $response = Http::withoutVerifying()->withBasicAuth(
        config('services.facturama.user'),
        config('services.facturama.password')
    )->get($url);

     if (!$response->successful()) {
        throw new \Exception("Error al descargar PDF: ".$response->body());
    }

    return base64_decode($response->body());
}

}