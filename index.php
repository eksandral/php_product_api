<?php

require_once dirname(__FILE__)
    .DIRECTORY_SEPARATOR
    ."vendor"
    .DIRECTORY_SEPARATOR
    ."autoload.php";

use Eksandral\ProductsApi\Server;

$server = new Server();
$server->run();

