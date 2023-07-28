<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }
    public function sendEmail(

        $to = 'cedricduakon@gmail.com',
        $content = '<p>See Twig integration for better HTML integration!</p>'
    ) {
        $email = (new Email())
            ->from('cedricduakon@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            //->text('Sending emails is fun again!')
            ->html($content);

        $this->mailer->send($email);
    }
}
