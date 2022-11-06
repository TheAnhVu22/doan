<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotifyOrder extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('theanhvu666@gmail.com', 'ATV')
            ->to($this->data['email'])
            ->subject('Mail Xác nhận đơn đặt hàng')
            ->view('user.checkout.mail_order')
            ->with([
                'data' => $this->data
            ]);
    }
}
