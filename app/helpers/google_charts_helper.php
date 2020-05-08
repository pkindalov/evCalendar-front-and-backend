<?php
/**
 * $labelsArr must be with max two labels inside for this chart
 */
function convertForGoogleBarChart($data, $labelsArr)
{
    $googleData = [
        $labelsArr
    ];

    foreach ($data as $key => $value) {
        $row = [$key, $value];
        $googleData[] = $row;
    }
    if (count($data) == 0) {
        $googleData[] = [0, 0];
    }
    return $googleData;
}
