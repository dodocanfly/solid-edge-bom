<?php

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once __DIR__ . '/../vendor/autoload.php';


use Dodocanfly\SolidEdgeBom\NovcanPart;
use Dodocanfly\SolidEdgeBom\SolidEdgeBom;
use Dodocanfly\SolidEdgeBom\RtfParser;
use Dodocanfly\SolidEdgeBom\Str;


$rtfContent = file_get_contents(__DIR__ . '/../rtf/sample-se-report-export-cp1250.rtf');

$bom = new SolidEdgeBom(new RtfParser(Str::cp1250ToUtf8($rtfContent)), NovcanPart::class);

dd($bom->getParts());
