<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
}
