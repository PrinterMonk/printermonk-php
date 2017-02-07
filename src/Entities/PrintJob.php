<?php

namespace PrinterMonk\Entities;

use PrinterMonk\Exceptions\PrinterMonkClientException;
use PrinterMonk\PrinterMonkClient;

/**
 * Class Printer
 * @package PrinterMonk\Entities
 *
 * @property string $id
 * @property string $printerId
 * @property string $name
 * @property string $content
 * @property string $contentType
 */

class PrintJob extends BaseEntity
{
    const PRINTJOB_CONTENT_TYPE_PDF = 'pdf';

    public function post(PrinterMonkClient $client)
    {
        if (!isset($this->printerId) || !isset($this->name) || !isset($this->content)) {
            throw new PrinterMonkClientException('No printer, name or content given.');
        }

        $data = json_encode([
            'printer_id' => $this->printerId,
            'name' => $this->name,
            'content' => $this->content,
            'content_type' => self::PRINTJOB_CONTENT_TYPE_PDF,
        ]);

        $result = $client->post('jobs', $data);

        $resultObject = json_decode($result);
        if ($resultObject === false) {
            throw new PrinterMonkClientException('Could not decode server response');
        }
        
        $this->id = $resultObject->data->id;
        
        return $this;
    }
}
