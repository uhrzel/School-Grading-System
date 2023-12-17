<?php

class Email{

    public function send($to, $subject, $body){
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = Config::get('mail/host');
        $mail->SMTPAuth = true;
        $mail->Username = Config::get('mail/username');
        $mail->Password = Config::get('mail/password');
        $mail->SMTPSecure = 'tls';
        $mail->Port = Config::get('mail/port');
        $mail->setFrom(Config::get('mail/from'), Config::get('mail/name'));
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }
}