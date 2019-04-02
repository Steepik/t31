<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * @var $products
     */
    public $products;

    public $guest;

    /**
     * Create a new message instance.
     *
     * CartNotify constructor.
     * @param User $user
     * @param $products
     *
     * @return void
     */
    public function __construct(?User $user, $products, $guest)
    {
        $this->user = $user;
        $this->products = $products;
        $this->guest = $guest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('APP_EMAIL'), 'Каретный Двор')->subject('Покупка на сайте')->markdown('admin.emails.cart_notify');
    }
}
