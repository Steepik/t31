<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Birthday extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * Birthday constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $text = (User::checkDaysBirthday(env('BIRTHDAY_DATE_BEFORE'), true, false, $notifiable->id)) ? 'наступающим днем рождения!' : '';
        $text .= (User::isBirthday($notifiable->id)) ? 'днем рождения!' : '';

        return (new MailMessage)
            ->from(env('APP_EMAIL'))
            ->subject('C ' . $text)
            ->greeting('C ' . $text)
            ->line($notifiable->name . ', от всего нашего коллектива поздравляем Вас с ' . $text)
            ->line('Теперь Вы можете покупать товар по оптовым ценам.')
            ->action('Перейти на сайт', url('/'))
            ->markdown('vendor.notifications.email');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
