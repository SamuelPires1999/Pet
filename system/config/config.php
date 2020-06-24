<?php
$config = [
    "db" => [
        "usuario" => "root",
        "senha" => "",
        "ip" => "localhost",
        "banco" => "pet"
    ],
    "pages" => [
        "index" => false,
        "login" => false,
        "registro" => false,
        "sobre" => false,
        "contato" => false,
        "inicio" => true,
        "logout" => true,
        "animal_novo" => true,
        "animal" => true
    ],
    "callbacks" => [
        "login" => false,
        "register" => false,
        "animal_novo" => true
    ]
];

function getTimeAgo($timestamp, $addBehind = true) {
    $units = [["name" => "segundo", "limit" => 60, "in_seconds" => 1],
        ["name" => "minuto", "limit" => 3600, "in_seconds" => 60],
        ["name" => "hora", "limit" => 86400, "in_seconds" => 3600],
        ["name" => "dia", "limit" => 604800, "in_seconds" => 86400],
        ["name" => "semana", "limit" => 2629743, "in_seconds" => 604800],
        ["name" => "mês", "limit" => 31556926, "in_seconds" => 2629743],
        ["name" => "ano", "limit" => null, "in_seconds" => 31556926]
    ];
    $diff = (time() - $timestamp);
    $isAgo = true;

    if ($diff < 0)
        $isAgo = false;

    if ($diff < 5)
        return "agora";

    $i = 0;

    while ($unit = $units[$i++]) {
        if ($diff < $unit['limit'] || !$unit['limit']) {
            $diff = floor($diff / $unit['in_seconds']);

            if($i == 6)
                return $diff . " " . ($diff > 1 ? "meses" : "mês") . (($isAgo && $addBehind) ? " atrás" : "");
            else
                return  $diff . " " . $unit['name'] . ($diff > 1 ? "s" : "") . (($isAgo && $addBehind) ? " atrás" : "");
        }
    }
}