<?php
    //Simple page redirect
function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
}

function getQueryData($url){
    if(!strpos($url, '&')){
        echo 'Invalid query string';
        return;
    }
    $resultData = [];
    $querySplittedData = explode('&', $url);
    for ($i=0; $i < count($querySplittedData) ; $i++) { 
        // echo $querySplittedData[$i] . "<br />";
        if($i > 0){
            $splitParam = explode('=', $querySplittedData[$i]);
            $resultData[$splitParam[0]] = $splitParam[1];
        }
    }
    // print_r($resultData);
    // $resultData[] = $querySplittedData[1];
    // $resultData[] = $querySplittedData[2];
    return $resultData;
}


function sendMail($mail, $subject, $body, $receiver){
    try {

        $mail->setIsSMTP();
        $mail->setSMTPAuth(SMTP_AUTH);
        $mail->setSMTPSecure(SMTP_SECURE);
        $mail->setIsHTML(IS_HTML);
        $mail->setFrom(SET_FROM);
        $mail->setSubject($subject);
        $mail->setBody($body);
        $mail->setReceiver($receiver);
        $mail->setMsgSentSuccess('Message sent successfully!');


        // print_r($this->phpMailer->getAllSettings());    

        //    var_dump($this->phpMailer);
        return $mail->sendMail();
        // var_dump(method_exists($this->phpMailer, 'IsSMTP'));

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->getError()}";
    }
}