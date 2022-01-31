<?php


use Dodocanfly\SolidEdgeBom\RtfParser;
use Dodocanfly\SolidEdgeBom\Exceptions\NoBomHeadersFoundException;
use Dodocanfly\SolidEdgeBom\Exceptions\NoBomItemsFoundException;
use Dodocanfly\SolidEdgeBom\Str;
use PHPUnit\Framework\TestCase;

class RtfParserTest extends TestCase
{
    public function testGetHeadersFromSampleFile()
    {
        $rtfContent = file_get_contents(__DIR__ . '/../rtf/sample-se-report-export-cp1250.rtf');
        $expectedHeaders = ["Nr elementu", "Numer dokumentu", "Rewizja", "Tytuł", "Ilość", "Nazwa pliku", "Materiał",
            "Grubość materiału", "Komentarze", "Utworzony", "Autor", "Zmodyfikowany", "Ostatni autor"
        ];
        $rtfParser = new RtfParser( Str::cp1250ToUtf8($rtfContent) );
        $headers = $rtfParser->getHeaders();
        self::assertIsArray($headers);
        self::assertCount(13, $headers);
        self::assertEquals($expectedHeaders, $headers);
    }


    public function testGetHeadersFromEmptyString()
    {
        $rtfParser = new RtfParser('');
        self::expectException(NoBomHeadersFoundException::class);
        $rtfParser->getHeaders();
    }


    public function testGetItemsFromSampleFile()
    {
        $rtfContent = file_get_contents(__DIR__ . '/../rtf/sample-se-report-export-cp1250.rtf');
        $rtfParser = new RtfParser( Str::cp1250ToUtf8($rtfContent) );
        $items = $rtfParser->getItems();
        self::assertIsArray($items);
        self::assertCount(43, $items);
        self::assertCount(13, $items[0]);
    }


    public function testGetItemsFromEmptyString()
    {
        $rtfParser = new RtfParser('');
        self::expectException(NoBomItemsFoundException::class);
        $rtfParser->getItems();
    }
}
