<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail; 

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $userEmail, string $emailText): void
    {
        $email = (new Email())
            ->from('contact@immoval.com')
            ->to("$userEmail")
            ->subject('Notification de soumission de formulaire')
            ->text($emailText);

        $this->mailer->send($email);
    }

    public function sendResetPasswordEmail(string $userEmail, string $resetToken): void
    {
        $expirationMessageKey = 'reset_password.expiration_message';
        $expirationMessageData = ['count' => 24];
    
        $email = (new TemplatedEmail())
            ->from('contact@immoval.com')
            ->to($userEmail)
            ->subject('Réinitialisation de mot de passe')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => [
                    'token' => $resetToken,
                    'expirationMessageKey' => $expirationMessageKey,
                    'expirationMessageData' => $expirationMessageData
                ]
            ]);
        $this->mailer->send($email);
    }
}
