<?php
require_once "system/global.php";
global $config;

if(isset($_GET['pagina']))
    $page = $_GET['pagina'];
else
    $page = "login";

if($page == "index" || ($page == "login" && Usuario::isLoggedIn()))
    $page = "inicio";

if(!in_array($page, array_keys($config['pages'])))
    exit("Não encontrada.");

if(!Usuario::isLoggedIn() && $config['pages'][$page]) {
    header("Location: /login");
    exit();
}

if($page == "logout") {
    session_destroy();
    header("Location: /login");
    exit();
}

if(!file_exists("pages/".$page.".php"))
    exit("Não encontrada. (2)");

include "pages/".$page.".php";