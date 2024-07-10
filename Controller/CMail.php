<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CMail {
    private static $instance = null;
    private $mail;

    private function __construct() {
        $this->mail = new PHPMailer(true);
        // Configurazione del server SMTP
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'jampodPodcast@gmail.com';
        $this->mail->Password = 'vpwplldclywbwdlv';
        $this->mail->SMTPSecure = 'tls'; // Utilizzare TLS per una connessione crittografata
        $this->mail->Port = 587;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function sendMail($receivermail, $subject, $message) {
        try {
            // Configurazione del mittente e del destinatario
            $this->mail->setFrom('jampodPodcast@gmail.com');
            $this->mail->addAddress($receivermail);

            // Contenuto dell'email
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;

            // Inviare l'email
            $this->mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            // Gestione degli errori
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

