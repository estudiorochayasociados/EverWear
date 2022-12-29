<?php namespace Clases;
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';

class Email
{
    private $asunto;
    private $receptor;
    private $emisor;
    private $mensaje;
    private $attachment;
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function emailEnviar()
    {
        require dirname(__DIR__)."/vendor/autoload.php";
        require_once dirname(__DIR__)."/vendor/phpmailer/phpmailer/src/PHPMailer.php";
        require_once dirname(__DIR__)."/vendor/phpmailer/phpmailer/src/SMTP.php";
        $mail = new PHPMailer(true);
        $mensaje = '<body style="background: #e5b509;margin:0;padding:0"><div style="background: #fff;width:700px;margin:auto;padding:20px"><div><br/><img src="'.LOGO.'" width="200"/><br/><hr/></div>'.$this->mensaje.'<br/></div></body>';
        $emailData=$this->config->viewEmail();
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            // Set mailer to use SMTP
            $mail->Host = $emailData['data']['smtp'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $emailData['data']['email'];                 // SMTP username
            $mail->Password = $emailData['data']['password'];                           // SMTP password
            $mail->SMTPSecure = $emailData['data']['smtp_secure'];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $emailData['data']['puerto'];                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($this->emisor, TITULO);
            $mail->addAddress($this->receptor, '');     // Add a recipient

            if(!empty($this->attachment)){
                foreach ($this->attachment as $attachment){
                    $mail->addAttachment($attachment);
                }
            }

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->asunto;
            $mail->Body = $mensaje;
            $mail->AltBody = strip_tags($mensaje);

            $mail->send();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function emailEnviarCurl()
    {
        require "../../vendor/autoload.php";
        require_once "../../vendor/phpmailer/phpmailer/src/PHPMailer.php";
        require_once "../../vendor/phpmailer/phpmailer/src/SMTP.php";
        $mail = new PHPMailer(true);
        $mensaje = '<body style="background: #e5b509;margin:0;padding:0"><div style="background: #fff;width:700px;margin:auto;padding:20px"><div><br/><img src="'.LOGO.'" width="200"/><br/><hr/></div>'.$this->mensaje.'<br/></div></body>';
        $emailData=$this->config->viewEmail();
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            // Set mailer to use SMTP
            $mail->Host = $emailData['data']['smtp'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $emailData['data']['email'];                 // SMTP username
            $mail->Password = $emailData['data']['password'];                           // SMTP password
            $mail->SMTPSecure = $emailData['data']['smtp_secure'];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $emailData['data']['puerto'];                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($this->emisor, TITULO);
            $mail->addAddress($this->receptor, '');     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->asunto;
            $mail->Body = $mensaje;
            $mail->AltBody = strip_tags($mensaje);

            $mail->send();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}

?>