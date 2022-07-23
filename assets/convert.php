<?php
$source = file_get_contents(__DIR__ . '/daysoff.source.txt');
$destinationWithDescription = __DIR__ . '/daysoff.json';
$destinationDates = __DIR__ . '/holidayDates.json';

$sourceLines = explode("\n", $source);

$destinationData = array_map(
    function ($item) {
        [$date, $description] = explode(" - ", $item);
        return [
            'date' => $date,
            'description' => $description
        ];
    },
    $sourceLines
);

file_put_contents($destinationWithDescription, json_encode($destinationData, JSON_UNESCAPED_UNICODE));

$destinationData = array_map(
    function ($item) {
        [$date] = explode(" - ", $item);
        return $date;
    },
    $sourceLines
);

file_put_contents($destinationDates, json_encode($destinationData, JSON_UNESCAPED_UNICODE));