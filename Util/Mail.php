<?php
namespace util;

class Mail {

    // private $sender;
    // private $receiver;
    // private $subject;
    // private $message;

    // public function __construct($sender, $receiver, $subject, $message) {
    //     $this->sender = $sender;
    //     $this->receiver = $receiver;
    //     $this->subject = $subject;
    //     $this->message = $message;
    // } 

    public static function send($sender, $receiver, $subject, $message) {
        $header = "From: $sender \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        
        show(mail($receiver, $subject, $message, $header));
    }

}