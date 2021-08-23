<?php

namespace App\Mail\Export;

use GuzzleHttp\Psr7\MimeType;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VirtualTourExportMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.export.virtualtour')->attachData($this->data, 'Export VirtualTour '.time().'.xlsx', [
            'mime' => MimeType::fromExtension('xlsx'),
        ]);
    }
}
