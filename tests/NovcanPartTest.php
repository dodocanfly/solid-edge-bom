<?php


use Dodocanfly\SolidEdgeBom\Exceptions\MappedHeaderNotFoundException;
use Dodocanfly\SolidEdgeBom\NovcanPart;
use Dodocanfly\SolidEdgeBom\RtfParser;
use Dodocanfly\SolidEdgeBom\Str;
use PHPUnit\Framework\TestCase;

class NovcanPartTest extends TestCase
{
    private array $headers;
    private array $items;
    private NovcanPart $part0;
    private NovcanPart $part26;

    protected function setUp(): void
    {
        $rtfContent = file_get_contents(__DIR__ . '/../rtf/sample-se-report-export-cp1250.rtf');
        $rtfParser = new RtfParser(Str::cp1250ToUtf8($rtfContent));
        $this->headers = $rtfParser->getHeaders();
        $this->items = $rtfParser->getItems();
        $this->part0 = new NovcanPart($this->headers, $this->items[0]);
        $this->part26 = new NovcanPart($this->headers, $this->items[26]);
    }

    public function testGetComment()
    {
        self::assertEquals('', $this->part0->getComment());
        self::assertEquals('', $this->part26->getComment());
    }

    public function testGetUpdatedBy()
    {
        self::assertEquals('MarcinRedys', $this->part0->getUpdatedBy());
        self::assertEquals('DarekBlank', $this->part26->getUpdatedBy());
    }

    public function testGetQuantity()
    {
        self::assertEquals(1, $this->part0->getQuantity());
        self::assertEquals(2, $this->part26->getQuantity());
    }

    public function testGetThickness()
    {
        self::assertEquals(0.0, $this->part0->getThickness());
        self::assertEquals(0.8, $this->part26->getThickness());
    }

    public function testIsSelfPart()
    {
        self::assertFalse($this->part0->isSelfPart());
        self::assertTrue($this->part26->isSelfPart());
    }

    public function testGetFilename()
    {
        self::assertEquals('SquareTubing 30x30x2.par', $this->part0->getFilename());
        self::assertEquals('08_MSG_Uchwyt_drążka-2L.psm', $this->part26->getFilename());
    }

    public function testGetCreatedBy()
    {
        self::assertEquals('MarcinRedys', $this->part0->getCreatedBy());
        self::assertEquals('MarcinRedys', $this->part26->getCreatedBy());
    }

    public function testGetIndex()
    {
        self::assertEquals('30x30x2', $this->part0->getIndex());
        self::assertEquals('MSG_13-04', $this->part26->getIndex());
    }

    public function testGetMaterial()
    {
        self::assertEquals('Stal konstrukcyjna', $this->part0->getMaterial());
        self::assertEquals('DC01', $this->part26->getMaterial());
    }

    public function testGetCreatedAt()
    {
        self::assertEquals('10.10.2019 07:41:30', $this->part0->getCreatedAt());
        self::assertEquals('24.04.2017 08:59:49', $this->part26->getCreatedAt());
    }

    public function testGetName()
    {
        self::assertEquals('Profil kwadratowy', $this->part0->getName());
        self::assertEquals('Uchwyt drążka 2L', $this->part26->getName());
    }

    public function testGetUpdatedAt()
    {
        self::assertEquals('10.10.2019 08:02:45', $this->part0->getUpdatedAt());
        self::assertEquals('29.10.2021 11:26:37', $this->part26->getUpdatedAt());
    }

    public function testGetOriginals()
    {
        self::assertEmpty($this->part0->getOriginals());
        self::assertEquals(
            ['material' => '#0,8 DC01, V8, R0,65'],
            $this->part26->getOriginals()
        );
    }

    public function testPartWithCustomHeadersMap()
    {
        $customHeadersMap = [
            'index' => 'Autor',
            'name' => 'Nazwa pliku',
            'filename' => 'Ostatni autor',
            'comment' => 'Tytuł',
            'material' => 'Utworzony',
            'createdAt' => 'Numer dokumentu',
        ];
        $part33 = new NovcanPart($this->headers, $this->items[33], $customHeadersMap);

        self::assertEquals('MarcinRedys', $part33->getIndex());
        self::assertEquals('15_MSG_Haczyk.psm', $part33->getName());
        self::assertEquals('Marcin Wilczewski', $part33->getFilename());
        self::assertEquals(0, $part33->getQuantity());
        self::assertEquals('24.04.2017 09:00:33', $part33->getMaterial());
        self::assertEquals(0.0, $part33->getThickness());
        self::assertEquals('Haczyk', $part33->getComment());
        self::assertEquals('MSG_10-05', $part33->getCreatedAt());
        self::assertEquals('', $part33->getCreatedBy());
        self::assertEquals('', $part33->getUpdatedAt());
        self::assertEquals('', $part33->getUpdatedBy());
    }

    public function testPartWithCustomHeadersAndMapNotExistingProperty()
    {
        $customHeadersMap = [
            'notExistingProperty' => 'Autor',
        ];
        self::expectException(ReflectionException::class);
        $part = new NovcanPart($this->headers, $this->items[0], $customHeadersMap);
    }

    public function testPartWithCustomHeadersMapAndNotExistingRtfHeader()
    {
        $customHeadersMap = [
            'index' => 'not existing header',
        ];
        self::expectException(MappedHeaderNotFoundException::class);
        $part = new NovcanPart($this->headers, $this->items[0], $customHeadersMap);
    }
}
