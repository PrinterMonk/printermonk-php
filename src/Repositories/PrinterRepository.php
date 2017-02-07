<?php

namespace PrinterMonk\Repositories;

use PrinterMonk\Entities\Printer;
use PrinterMonk\PrinterMonkClient;

class PrinterRepository
{
    public static function all(PrinterMonkClient $client)
    {
        $printers = [];

        $apiResult = $client->get('printers');
        $apiResult = json_decode($apiResult);

        foreach ($apiResult->data as $result) {
            $printer = new Printer();
            $printer->id = $result->id;
            $printer->name = $result->name;
            $printer->friendlyName = $result->friendly_name;
            $printer->modelName = $result->model_name;
            $printer->status = $result->status;

            $printers[] = $printer;
        }

        return $printers;
    }

    public static function find($id, PrinterMonkClient $client)
    {
        $result = $client->get('printers/' . $id);
        $result = json_decode($result);

        $printer = new Printer();
        $printer->id = $result->data->id;
        $printer->name = $result->data->name;
        $printer->friendlyName = $result->data->friendly_name;
        $printer->modelName = $result->data->model_name;
        $printer->status = $result->data->status;

        return $printer;
    }
}