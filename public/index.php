<?php
use Controllers\AppController;

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once __DIR__ . '/../src/Controllers/appController.php';

$app = new appController();
$app->start();