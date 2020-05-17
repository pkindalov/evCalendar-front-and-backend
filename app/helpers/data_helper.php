<?php
function checkIfArrAndIfEmpty($data)
{
    if (gettype($data) == 'array' && count($data) == 0) {
        return true;
    }

    return false;
}


function getDateLabelsChartJs($data){
  $dateLabels = [];
  foreach ($data as $key => $value) {
      $dateLabels[] = $key;
  }

  return $dateLabels;
}

function getValueForEachDateChartJs($data){
    $values = [];
    $dates = getDateLabelsChartJs($data);
    foreach ($dates as $key => $value) {
        $values[] = $data[$value][0];
        // echo $data[$value][0] . "<br />";
    }

   return $values;
}

function extractEventsDataFromAPIData($data){

    $eventsData = [];
    foreach ($data->data->Events as $key => $value){
        $eventsData[$key]['year'] = $value->year;
        $eventsData[$key]['text'] = $value->text;
        $eventsData[$key]['html'] = $value->html;
        $eventsData[$key]['id'] = $key;
    }

    rsort($eventsData);

    return $eventsData;
    
}

function getIds($data){
    $ids = [];
    foreach($data as $value){
        $ids[] = $value->id;
    }
    return $ids;
}

function getIdsAndDates($data){
    $idsDates = [];
    foreach($data as $key => $value){
        $idsDates[$key]['id'] = $value->id;
        $idsDates[$key]['date'] = $value->date;
    }
    return $idsDates;
}