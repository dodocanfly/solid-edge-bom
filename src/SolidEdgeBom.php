<?php

namespace Dodocanfly\SolidEdgeBom;

use Dodocanfly\SolidEdgeBom\Exceptions\PartClassNotImplementsPartInterfaceException;
use Dodocanfly\SolidEdgeBom\Interfaces\PartInterface;
use Dodocanfly\SolidEdgeBom\Interfaces\RtfParserInterface;
use Dodocanfly\SolidEdgeBom\Interfaces\SolidEdgeBomInterface;
use ReflectionClass;
use ReflectionException;

class SolidEdgeBom implements SolidEdgeBomInterface
{
    private RtfParserInterface $rtf;
    private string $partClass;
    private array $parts = [];
    private array $headersMap;


    /**
     * @throws ReflectionException
     * @throws PartClassNotImplementsPartInterfaceException
     */
    public function __construct(RtfParserInterface $rtf, string $partClass, array $headersMap = [])
    {
        $this->rtf = $rtf;
        $this->checkPartClass($partClass);
        $this->headersMap = $headersMap;
    }


    /**
     * @throws ReflectionException
     * @throws PartClassNotImplementsPartInterfaceException
     */
    private function checkPartClass(string $partClass): void
    {
        $class = new ReflectionClass($partClass);
        if ($class->implementsInterface(PartInterface::class)) {
            $this->partClass = $partClass;
        } else {
            throw new PartClassNotImplementsPartInterfaceException($partClass);
        }
    }


    public function getParts(): array
    {
        foreach ($this->rtf->getItems() as $itemValues) {
            $this->parts[] = new $this->partClass($this->rtf->getHeaders(), $itemValues, $this->headersMap);
        }
        return $this->parts;
    }
}
