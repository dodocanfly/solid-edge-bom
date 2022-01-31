<?php


use Dodocanfly\SolidEdgeBom\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{

    public function testConvertCp1250ToUtf8()
    {
        $strCp1250 = file_get_contents(__DIR__ . '/../rtf/sample-se-report-export-cp1250.rtf');
        $strUtf8 = file_get_contents(__DIR__ . '/../rtf/sample-se-report-export-utf8.rtf');
        self::assertEquals($strUtf8, Str::cp1250ToUtf8($strCp1250));
    }

}
