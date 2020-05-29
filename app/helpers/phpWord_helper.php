<?php

function appendLinksToSection($links, $section){
//    $section->addLine();
    $section->addTextBreak();
    foreach($links as $link){
//        $section->addLine();
        $section->addTextBreak();
        $section->addLink($link['url'], isset($link['title']) ? $link['title'] : $link['url'], array('color'=>'0000FF'));
    }
}