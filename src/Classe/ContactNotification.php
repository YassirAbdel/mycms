<?php 

namespace App\Classe;

use App\Entity\Contact;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification 
{
    private $mailer;
    

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }   

    public function notify(Contact $contact)
    {
        $emailTo = (new TemplatedEmail())
            ->from('abdel.montet@cnd.fr')
            ->to('abdel.montet@cnd.fr')
            ->subject('Demande de : ' . $contact->getNom())
            ->htmlTemplate('contact/contact.html.twig')
            ->context([
                'contact' => $contact
            ])
            ;
        $this->mailer->send($emailTo);

        $emailFrom = (new TemplatedEmail())
            ->from('abdel.montet@cnd.fr')
            ->to($contact->getEmail())
            ->subject('CN D - votre question du ' . date("d/m/y"))
            ->htmlTemplate('contact/reponse.html.twig')
            ->context([
                'contact' => $contact
            ])
            ;
        $this->mailer->send($emailFrom);
    }
}
