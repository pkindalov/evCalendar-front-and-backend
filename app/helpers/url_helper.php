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

function getLinkAddressFromHtmlText($htmlStr){
    $links = [];
    /* $re = '/<a\s+href=.*?"\s*(https*:.*?)".*?>/m'; */
    $re = '/https*:\/*[a-zA-Z0-9_-]*\.*[a-zA-Z0-9_-]*\/*[a-zA-Z0-9_-]*\/*[a-zA-Z0-9_-]*\\\\*/m';
    $titleRe = '/title=\\\\*"\w+\\\\*"* *\w* *\\\\* *\w* *\w*\\\\*"*/m';
    preg_match_all($re, $htmlStr, $matches, PREG_SET_ORDER, 0);
    preg_match_all($titleRe, $htmlStr, $titles, PREG_SET_ORDER, 0);

    foreach($matches as $key => $value){
        $links[$key]['url'] = $matches[$key][0];
    }

    // print_r($titles);
    foreach($titles as $key => $value){
        $links[$key]['title'] = explode("title=", $titles[$key][0])[1]; 
    }
    
  
   return $links;
    // $links = [];
    // $index = 0;
    // $end = -1;
    // $start = -1;
    // $search = '<a href="';
    // $searchCount = strlen($search);
    
    // //<a href="https://wikipedia.org/wiki/2018_Maryland_flood"
    // while($index > -1){
    //     $index = strpos($htmlStr, $search, $index + $searchCount);
    //     $start = $index + $searchCount;
    //     $end = (strpos($htmlStr, '"', $start));
    //     $link = substr($htmlStr, $start, $end - $start);
    //     if($link !== 'href='){
    //         $links[] = $link;
    //     }
    // }
    
    // print_r($matches);
}