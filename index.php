<?php

\define('LARAVEL_START', \microtime(\true));
$projectPath = $argv[1] ?? __DIR__ . '/../app';
require __DIR__ . '/vendor/autoload.php';
require $projectPath . '/vendor/autoload.php';
$app = (require_once $projectPath . '/bootstrap/app.php');

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use PatentLobster\StinkerPhar\StinkerCommand;
$stinker = new \PatentLobster\StinkerPhar\StinkerCommand($argv);
//$stinker->execute();
echo $stinker->execute();



