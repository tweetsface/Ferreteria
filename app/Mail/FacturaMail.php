<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;

public function __construct($pdf,$xml,$venta)
{
$this->pdf=$pdf;
$this->xml=$xml;
$this->venta=$venta;
}

public function build()
{
return $this->subject('Factura '.$this->venta->folio)
->view('emails.factura')
->attachData($this->pdf,'factura.pdf')
->attachData($this->xml,'factura.xml');

}
}
