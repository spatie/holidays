<?php

require_once 'vendor/autoload.php'; // Adjust this path if necessary

use Spatie\Holidays\Countries\SriLanka;

$srilanka = new SriLanka();
$srilanka->variableHolidays(2023);
