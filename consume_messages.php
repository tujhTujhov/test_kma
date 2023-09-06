<?php
require 'vendor/autoload.php';
use ESemenkov\TestTaskKma\helpers\QueueHelper;

$helper = new QueueHelper();
$helper->consume();



