<?php

namespace PrinterMonk\Entities;

/**
 * Class Printer
 * @package PrinterMonk\Entities
 *
 * @property string $id
 * @property string $name
 * @property string $friendlyName
 * @property string $modelName
 * @property string $status
 */

class Printer extends BaseEntity
{
    const STATUS_ONLINE = 'online';
    const STATUS_OFFLINE = 'offline';
}