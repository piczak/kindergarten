<?php

namespace App\Services;

use App\Entity\EmailTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

/**
 * Class MailerService
 * @package App\Services
 */
class MailerService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $cc;

    /**
     * @var string
     */
    private $bcc;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $fromName;

    /**
     * @var string
     */
    private $replyTo;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $attachment = [];

    /**
     * MailerService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @param Environment $twig
     */
    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer, Environment $twig)
    {
        $this->entityManager = $entityManager;

        $this->mailer = $mailer;

        $this->twig = $twig;
    }

    /**
     * @param $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param $to
     *
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param $cc
     *
     * @return $this
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param $bcc
     *
     * @return $this
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param $fromName
     *
     * @return $this
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param $replyto
     *
     * @return $this
     */
    public function setReplyTo($replyto)
    {
        $this->replyTo = $replyto;

        return $this;
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    public function send()
    {
        $findOneBy = [
            'hash' => $this->getTemplate()
        ];

        $item = $this->entityManager
            ->getRepository(EmailTemplate::class)
            ->findOneBy($findOneBy);

        if (!$item) {
            return;
        }

        $twigEnv = new Environment(new ArrayLoader([]));

        //Dzieki temu w treści e-mail możemy stosować wszystko co oferuje twig
        $titleTemplate = $twigEnv->createTemplate($item->getSubject());
        $subject = $titleTemplate->render($this->getParameters());

        $contentHtml = null;
        if ($item->getContentHtml()) {
            $bodyTemplate = $twigEnv->createTemplate($item->getContentHtml());
            $contentHtml = $bodyTemplate->render($this->getParameters());
        }

        $contentText = null;
        if ($item->getContentText()) {
            $bodyTxtTemplate = $twigEnv->createTemplate($item->getContentText());
            $contentText = $bodyTxtTemplate->render($this->getParameters());
        }

        $templateHtml = $this->twig
            ->render('emails/template.html.twig', [
                'subject' => $subject,
                'content' => $contentHtml
            ]);

        $templateText = $this->twig
            ->render('emails/template.txt.twig', [
                'subject' => $subject,
                'content' => $contentText
            ]);

        $email = (new Email())
            ->subject($subject)
            ->from(new Address($this->getFrom()));

        if ($this->getTo()) {
            $email->to(new Address($this->getTo()));
        }

        if ($this->getReplyTo()) {
            $email->replyTo(new Address($this->getReplyTo()));
        }

        $email->html($templateHtml)
            ->text($templateText)
        ;

        if (!empty($this->attachment)) {
            foreach ($this->attachment as $attachment) {
                $email->attachFromPath($attachment);
            }
        }

        $this->mailer->send($email);
    }
}
