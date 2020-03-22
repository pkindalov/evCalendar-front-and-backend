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