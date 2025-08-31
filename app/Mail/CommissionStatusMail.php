<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commissionId;
    public $status;

    public function __construct($commissionId, $status)
    {
        $this->commissionId = $commissionId;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject("Commission {$this->status}")
            ->view('emails.commission_status');
    }
}
