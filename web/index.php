<?php

use application\App;


require __DIR__ . '/../application/App.php';

$config = require __DIR__ . '/../config/main.php';

$app = new App($config);
$app->init();