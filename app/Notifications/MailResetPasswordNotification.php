<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;

class MailResetPasswordNotification extends Notification
{
    use Queueable;
    protected $pageUrl;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        // parent::__construct($token);
        $this->token = $token;
        $this->pageUrl = 'localhost:8080';
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

        $url = url('/owner/password/reset/' . $this->token);
        return (new MailMessage)
            // ->subject('Owner Reset Password')
            // ->subject(Lang::getFromJson('Reset Password Notification'))
            // ->line(Lang::getFromJson('You are receiving this email because we received a password reset request for your account.'))
            // ->action(Lang::getFromJson('Reset Password'), $url)
            // ->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.owners.expire')]))
            // ->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));
        
            // if (static::$toMailCallback) {
            //     return call_user_func(static::$toMailCallback, $notifiable, $this->token);
            // }
            // return (new MailMessage)
                ->subject(Lang::get('Reset application Password'))
                ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
                ->action(Lang::get('Reset Password'), $url)
                // ->action(Lang::get('Reset Password'), $this->pageUrl."?token=".$this->token)
                ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
                ->line(Lang::get('If you did not request a password reset, no further action is required.'));
        
        
        
                // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
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
