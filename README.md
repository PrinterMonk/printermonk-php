# PrinterMonk client for PHP
This is an open source PHP client for the PrinterMonk API

## Installation
Get it with [composer](https://getcomposer.org)

```
composer require printermonk/printermonk-php
```

## Example: get all printers
```php
<?php

use PrinterMonk\PrinterMonkClient;
use PrinterMonk\Repositories\PrinterRepository;

require __DIR__ . '/vendor/autoload.php';

$apiKey = getenv('PRINTERMONK_API_KEY');  // Your PrinterMonk API key

$client = new PrinterMonkClient($apiKey);
$printers = PrinterRepository::all($client);

var_dump($printers);
```

## Example: get a single printer
```php
<?php

use PrinterMonk\PrinterMonkClient;
use PrinterMonk\Repositories\PrinterRepository;

require __DIR__ . '/vendor/autoload.php';

$apiKey = getenv('PRINTERMONK_API_KEY');  // Your PrinterMonk API key
$printerId = 'prtr_uniqueprinterkey';

$client = new PrinterMonkClient($apiKey);
$printer = PrinterRepository::find($printerId, $client);

var_dump($printer);
```

## Example: send a new print job to PrinterMonk
```php
<?php

use PrinterMonk\Entities\PrintJob;
use PrinterMonk\PrinterMonkClient;

require __DIR__ . '/vendor/autoload.php';

$apiKey = getenv('PRINTERMONK_API_KEY');  // Your PrinterMonk API key
$printerId = 'prtr_uniqueprinterkey';

$client = new PrinterMonkClient($apiKey);

$printJob = new PrintJob();
$printJob->printerId = $printerId;
$printJob->name = 'Example document';
$printJob->contentType = 'pdf';
$printJob->content = base64_encode(file_get_contents('example.pdf'));

$printJob->post($client);

```