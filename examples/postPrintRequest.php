<?php

use PrinterMonk\Entities\PrintJob;
use PrinterMonk\PrinterMonkClient;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = getenv('PRINTERMONK_API_KEY');  // Your PrinterMonk API key
$printerId = 'prtr_uniqueprinterkey';

$client = new PrinterMonkClient($apiKey);

$printJob = new PrintJob();
$printJob->printerId = $printerId;
$printJob->name = 'Example document';
$printJob->contentType = 'pdf';
$printJob->content = base64_encode(file_get_contents('example.pdf'));

$printJob->post($client);