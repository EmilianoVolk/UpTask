<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

#[\AllowDynamicProperties]

class Email{
    protected $email;
    protected $name;
    protected $token;

    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '65781b112c8c00';
        $mail->Password = '22ccc04345e072';

        $mail->setFrom('cuentas@upTask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirm your account';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';

        $content .= "<p><strong>Hello " . $this->name . "</strong> You have created an account in UpTask, confirm your account in the next link</p>";
        $content .= "<p>Click here: <a href='http://localhost:3000/confirm?token=" . $this->token ."'>Confirm account</a></p>";
        $content .= '<p>If you did not create this account, you can ignore this message</p>';
        $content .= '</html>';

        $mail->Body = $content;

        //Enviar Email
        $mail->send();
    }
    

    public function sendNewPass(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '65781b112c8c00';
        $mail->Password = '22ccc04345e072';

        $mail->setFrom('cuentas@upTask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Recover your Password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';

        $content .= "<p><strong>Hello " . $this->name . "</strong> you have tried to change your password in  UpTask, Click in the next link to chage it</p>";
        $content .= "<p>Presiona aqui: <a href='http://localhost:3000/restore?token=" . $this->token ."'>Recover Password</a></p>";
        $content .= '<p>If you did not create this account, you can ignore this message</p>';
        $content .= '</html>';

        $mail->Body = $content;

        //Enviar Email
        $mail->send();
    }

}