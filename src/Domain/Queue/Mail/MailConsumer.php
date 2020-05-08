<?php

namespace App\Domain\Queue\Mail;

use PhpAmqpLib\Message\AMQPMessage;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;

class MailConsumer implements ConsumerInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $templating;

    /**
     * MailConsumer constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $templating
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
    }

    /**
     * Executes the code in the queue and requeue in case of fail.
     *
     * @param AMQPMessage $msg
     * @return bool|mixed
     */
    public function execute(AMQPMessage $msg)
    {
        try {
            $response = json_decode($msg->body, true);
            $message = (new \Swift_Message())
                ->setSubject($response['subject'])
                ->addFrom(getenv('NO_REPLY_EMAIL','no-reply@bookmeforphotographers.com'))
                ->addTo($response['data']['email'])
                ->setBody(
                    $this->templating->render(
                        $response['template'],
                        $response
                    ),
                    'text/html'
                );
            $this->mailer->getTransport()->setStreamOptions(
                [
                    "ssl" => [
                        "allow_self_signed" => true,
                        "verify_peer"       => false,
                        "verify_peer_name"  => false,
                    ],
                ]
            );
            $sentRecipients = $this->mailer->send($message);
            echo $sentRecipients;
            return true;
        }catch(\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
