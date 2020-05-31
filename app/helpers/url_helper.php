<?php
//Simple page redirect
function redirect($page)
{
    header('location: ' . URLROOT . '/' . $page);
}

function getQueryData($url)
{
    if (!strpos($url, '&')) {
        echo 'Invalid query string';
        return;
    }
    $resultData = [];
    $querySplittedData = explode('&', $url);
    for ($i = 0; $i < count($querySplittedData); $i++) {
        // echo $querySplittedData[$i] . "<br />";
        if ($i > 0) {
            $splitParam = explode('=', $querySplittedData[$i]);
            $resultData[$splitParam[0]] = $splitParam[1];
        }
    }
    // print_r($resultData);
    // $resultData[] = $querySplittedData[1];
    // $resultData[] = $querySplittedData[2];
    return $resultData;
}


function sendMail($mail, $subject, $body, $receiver)
{
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

function getURLs($str)
{
    $search = '<a';
    $endSearch = '</a>';
    $indexStart = 0;
    $indexEnd = 0;
    $links = [];

    $indexStart = strpos($str, $search, $indexStart);
    $indexEnd = strpos($str, $endSearch, $indexEnd);

    while (!empty($indexStart) || !empty($indexEnd)) {
        $tempURL = substr($str, $indexStart, ($indexEnd - $indexStart) + strlen($endSearch));

        $urlArr = explode('href="', $tempURL);
        if (!empty(strpos($urlArr[1], 'class="'))) {
            $tempArr = explode('class="', $urlArr[1]);
            $titleStrArr = explode(' ', $tempArr[1]);
            array_shift($titleStrArr);
            $titleStr = implode(' ', $titleStrArr);
            $urlArr[1] = $tempArr[0] . ' ' . $titleStr;
        }

        $link = explode('title="', $urlArr[1]);
        $titleStr = explode('">', $link[1])[1];

        $links[] = [
//           'url' => trim($link[0]),
            'url' => trim(substr($link[0], 0, -2)),
            'title' => substr($titleStr, 0, -4)
        ];
//         $links[]['url'] = trim($link[0]);
//         $links[]['title'] = trim(substr($titleStr, 0, -4));

        $indexStart = strpos($str, $search, $indexStart + strlen($search));
        $indexEnd = strpos($str, $endSearch, $indexEnd + strlen($endSearch));
        //  $indexEnd = strpos($str, $endSearch, $indexEnd + 1);
    }

    return $links;
}

function getLinkAddressFromHtmlText($htmlStr)
{
    $links = getURLs($htmlStr);
    return $links;

    /* $re = '/<a\s+href=.*?"\s*(https*:.*?)".*?>/m'; */
    // $re = '/https*:\/*[a-zA-Z0-9_-]*\.*[a-zA-Z0-9_-]*\/*[a-zA-Z0-9_-]*\/*[a-zA-Z0-9_-]*\\\\*/m';

//    $titleRe = '/title=\\\\*"\w+\\\\*"* *\w* *\\\\* *\w* *\w*\\\\*"*/m';
    // preg_match_all($re, $htmlStr, $matches, PREG_SET_ORDER, 0);
//    preg_match_all($titleRe, $htmlStr, $titles, PREG_SET_ORDER, 0);

    // print_r($links);

    // foreach($matches as $key => $value){
    //     $links[$key]['url'] = $matches[$key][0];
    // }

    // print_r($titles);
//    foreach($titles as $key => $value){
//        $links[$key]['title'] = explode("title=", $titles[$key][0])[1];
//    }

//    print_r($links);
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