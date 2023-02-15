<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Perfil Coperve - Recuperação de Senha')
            ->markdown('auth.reset.email')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.')
            ->action('Alterar Senha', url('password/reset', $this->token))
            ->line(Lang::get('Este link de redefinição de senha irá expirar em :count minutos.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line('Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.');
    }
}