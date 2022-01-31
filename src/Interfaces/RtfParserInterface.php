<?php

namespace Dodocanfly\SolidEdgeBom\Interfaces;

interface RtfParserInterface
{
    /**
     * @return array ['header 1', 'header 2', 'header 3', ...]
     */
    public function getHeaders(): array;

    /**
     * @return array [['value 1 of row 1', 'value 2 of row 1', 'value 3 of row 1', ...], ['value 1 of row 2', ...], ...]
     */
    public function getItems(): array;

    public function numberOfItems(): int;
}
