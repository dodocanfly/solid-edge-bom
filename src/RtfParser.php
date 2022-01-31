<?php

namespace Dodocanfly\SolidEdgeBom;

use Dodocanfly\SolidEdgeBom\Interfaces\RtfParserInterface;
use Dodocanfly\SolidEdgeBom\Exceptions\NoBomHeadersFoundException;
use Dodocanfly\SolidEdgeBom\Exceptions\NoBomItemsFoundException;

class RtfParser implements RtfParserInterface
{
    private string $rtfContent;
    private array $rowBlocks;


    public function __construct(string $rtfContent)
    {
        $this->rtfContent = $rtfContent;
        $this->explodeTableToRowBlocks();
    }


    /**
     * @throws NoBomHeadersFoundException
     */
    public function getHeaders(): array
    {
        if (count($this->rowBlocks) === 0) throw new NoBomHeadersFoundException();
        return self::explodeRowBlock($this->rowBlocks[0]);
    }


    /**
     * @throws NoBomItemsFoundException
     */
    public function getItems(): array
    {
        $numberOfItems = $this->numberOfItems();
        if ($numberOfItems === 0) throw new NoBomItemsFoundException();

        $items = [];
        for ($rowIndex = 1; $rowIndex <= $numberOfItems; $rowIndex ++) {
            $items[] = self::explodeRowBlock($this->rowBlocks[$rowIndex]);
        }
        return $items;
    }


    public function numberOfItems(): int
    {
        $rows = count($this->rowBlocks);
        return $rows < 2 ? 0 : $rows - 1;
    }


    private function explodeTableToRowBlocks(): void
    {
        $matches = [];
        preg_match_all('/\\\intbl \\\ql(.+)\\\cell \\\row/', $this->rtfContent, $matches);
        $this->rowBlocks = $matches[1];
    }


    private static function clearArrayValues(array $array): array
    {
        return array_map('trim', $array);
    }


    private static function explodeRowBlock(string $rowBlock): array
    {
        return self::clearArrayValues(
            explode('\cell', $rowBlock)
        );
    }
}
