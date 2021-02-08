<?php

$baseUrl = 'https://escape.go2tech.de/api/track?';

$data = [
    ['1.9', 'Isles of Cumbrae', 'CUP RU vs BAF', 4, 'end1', true, false, false, false, 2541, 'Mission', 'go2tech.de'],
    ['1.9', 'Isles of Cumbrae', 'CUP RU vs BAF', 10, 'end2', true, false, true, true, 685, 'Mission', ''],
    ['1.9', 'Altis', 'BIS CSAT vs. NATO', 6, 'end4', true, true, false, false, 120, 'Mission', 'go2tech.de'],
    ['1.10', 'Isles of Cumbrae', 'CUP RU vs BAF', 1, 'end1', false, false, false, false, 3254, 'Mission', ''],
    ['1.9', 'Isles of Cumbrae', 'CUP RU vs BAF', 2, 'end3', false, false, false, false, 9754, 'Mission', ''],
    ['1.10', 'Chernarus', 'RHS US vs RU', 8, 'end1', true, false, false, false, 654, 'Mission', ''],
    ['1.9', 'Altis', 'BIS CSAT vs. NATO', 4, 'end1', true, false, false, false, 325, 'Mission', 'go2tech.de'],
    ['1.11', 'Chernarus', 'RHS US vs RU', 2, 'end4', true, true, false, false, 7542, 'Addon', ''],
    ['1.9', 'Isles of Cumbrae', 'CUP RU vs BAF', 1, 'end1', false, false, false, false, 96542, 'Mission', ''],
    ['1.10', 'Chernarus', 'RHS US vs RU', 8, 'end2', true, true, true, true, 3254, 'Mission', ''],
    ['1.9', 'Isles of Cumbrae', 'CUP RU vs BAF', 1, 'end3', false, false, false, false, 854, 'Mission', ''],
    ['1.11', 'Altis', 'BIS CSAT vs. NATO', 10, 'end2', true, true, true, false, 658, 'Mission', ''],
    ['1.11', 'Isles of Cumbrae', 'CUP RU vs BAF', 3, 'end1', true, false, false, false, 235, 'Mission', ''],
];

foreach ($data as $row) {
    $queryString = http_build_query([
        'event' => 'endmission',
        'map' => $row[1],
        'mod' => $row[2],
        'version' => $row[0],
        'players' => $row[3],
        'end' => $row[4],
        't1' => $row[5] ? '1' : '0',
        't2' => $row[6] ? '1' : '0',
        't3' => $row[7] ? '1' : '0',
        't4' => $row[8] ? '1' : '0',
        'server' => $row[11],
        'time' => $row[9],
        'release' => $row[10],
    ]);
    file_get_contents($baseUrl . $queryString);
}
