<?php

use PrinterMonk\PrinterMonkClient;
use PrinterMonk\Repositories\PrinterRepository;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = getenv('PRINTERMONK_API_KEY');  // Your PrinterMonk API key
$printerId = 'prtr_uniqueprinterkey';

$client = new PrinterMonkClient($apiKey);
$printer = PrinterRepository::find($printerId, $client);

var_dump($printer);