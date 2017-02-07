<?php

use PrinterMonk\PrinterMonkClient;
use PrinterMonk\Repositories\PrinterRepository;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = getenv('PRINTERMONK_API_KEY');  // Your PrinterMonk API key

$client = new PrinterMonkClient($apiKey);
$printers = PrinterRepository::all($client);

var_dump($printers);