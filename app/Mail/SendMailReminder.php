<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Potency;
use App\Sales;
use App\Customers;


class SendMailReminder extends Mailable
{
    use SerializesModels;
    public $reminder;
    public $sekarang;

    public function __construct($reminder,$sekarang)
    {
        $this->reminder = $reminder;
        $this->sekarang = $sekarang;
    }

    public function build()
    {
        $reminder = $this->reminder;
        $sekarang = $this->sekarang;
        return $this->from('me@arismrd.my.id')
            ->subject('PEMBERITAHUAN DATA POTENSI')
            ->view('emails.reminder',compact('reminder','sekarang'));
    }
}
