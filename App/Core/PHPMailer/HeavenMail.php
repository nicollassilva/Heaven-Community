<?php

namespace App\Core\PHPMailer;

use App\Boot\ForumConfiguration;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class HeavenMail {
    protected $mail;
    protected $modeDevelopment;
    
    protected $serverSettings;
    protected $subject;
    protected $bodyMail;
    protected $altBody;

    function __construct()
    {
        $this->modeDevelopment = ForumConfiguration::$forumMode == 'development' ? true : false;
        $this->mail = new PHPMailer();
        $this->delegateSettings();
    }

    private function delegateSettings()
    {
        if (empty($this->serverSettings)) {
            $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3) . '/App/Boot/');
            $dotenv->load();
    
            $this->serverSettings = [
                'SMTPDebug' => $this->modeDevelopment ? SMTP::DEBUG_SERVER : 'off',
                'host' => $_ENV['MAIL_HOST'],
                'username' => $_ENV['MAIL_USERNAME'],
                'password' => $_ENV['MAIL_PASSWORD'],
                'port' => $_ENV['MAIL_PORT'],
                'encrypt' => $_ENV['MAIL_ENCRYPTION'],
                'from_address' => $_ENV['MAIL_FROM_ADDRESS'],
                'from_name' => $_ENV['MAIL_FROM_NAME']
            ];
        }

        return $this;
    }

    /**
     * @param string $toEmail
     * @param string $toUser
     **/
    protected function prepareInstance(String $toEmail, String $toUser)
    {
        if (!empty($this->serverSettings)) {
            $this->mail->isSMTP();
            $this->mail->SMTPDebug   = $this->serverSettings['SMTPDebug'];
            $this->mail->Host        = $this->serverSettings['host'];
            $this->mail->Port        = $this->serverSettings['port'];
            $this->mail->SMTPSecure  = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->SMTPAuth    = true;
            // $this->mail->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            //     )
            // );
            $this->mail->Username    = $this->serverSettings['from_address'];
            $this->mail->Password    = $this->serverSettings['password'];
            $this->mail->Charset     = 'UTF-8';

            $this->mail->isHTML(true);
            $this->mail->Subject     = $this->subject;
            $this->mail->msgHTML($this->bodyMail);
            $this->mail->AltBody     = $this->altBody;

            $this->mail->setFrom($this->serverSettings['from_address'], utf8_decode($this->serverSettings['from_name']));
            $this->mail->addReplyTo($this->serverSettings['from_address'], utf8_decode($this->serverSettings['from_name']));
            $this->mail->addAddress($toEmail, $toUser);
        }

        return $this;
    }

    /**
     * @param string $toEmail
     * @param string $toUsername
     * @param string $titleMail
     * @param string $bodyFile
     * @param string $titleEndBody
     */
    public function sendMail(String $toEmail, String $toUsername, String $titleMail, String $bodyFile, String $titleEndBody = ''): Bool
    {
        $this->subject = $titleMail;
        $this->bodyMail = @file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $bodyFile . '.html');
        $this->altBody = $titleEndBody;
        if (!$this->bodyMail) {
            return false;
        } else {
            $this->prepareInstance($toEmail, $toUsername);
            try {
                if($this->mail->send()) {
                    return true;
                }
            } catch(Exception $e) {
                return false;
            }
        }
    }
}