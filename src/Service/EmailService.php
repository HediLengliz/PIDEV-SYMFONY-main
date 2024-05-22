<?php
// src/Service/EmailService.php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $subject, $body)
    {
        $email = (new Email())
            ->from('oussemaa782@gmail.com') // Remplacez par votre adresse email
            ->to($to)
            ->subject($subject)
            ->html($body);

        $this->mailer->send($email);
    }
}
