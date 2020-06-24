<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
ini_set('display_errors', 1);
include "config/config.php";

require_once "classes/DB.class.php";
require_once "classes/Animal.class.php";
require_once "classes/Usuario.class.php";