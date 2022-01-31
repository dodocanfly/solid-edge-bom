<?php

namespace Dodocanfly\SolidEdgeBom;

use Dodocanfly\SolidEdgeBom\Exceptions\MappedHeaderNotFoundException;
use Dodocanfly\SolidEdgeBom\Interfaces\PartInterface;
use ReflectionProperty;
use ReflectionException;

class Part implements PartInterface
{
    protected string $index;
    protected string $name;
    protected string $filename;
    protected int $quantity;
    protected string $material;
    protected float $thickness;
    protected string $comment;
    protected string $createdAt;
    protected string $createdBy;
    protected string $updatedAt;
    protected string $updatedBy;


    /**
     * @throws ReflectionException
     * @throws MappedHeaderNotFoundException
     */
    public function __construct(array $headers, array $values, array $headersMap = [])
    {
        if (empty($headersMap)) $headersMap = self::HEADERS_MAP;
        $this->assignValues($headers, $values, $headersMap);
    }


    /**
     * @throws ReflectionException
     * @throws MappedHeaderNotFoundException
     */
    private function assignValues(array $headers, array $values, array $headersMap = self::HEADERS_MAP): void
    {
        foreach ($headersMap as $property => $mappedHeader) {
            if ($index = array_search($mappedHeader, $headers, true)) {
                $reflection = new ReflectionProperty($this, $property);
                switch ($reflection->getType()->getName()) {
                    case 'int':
                        $this->$property = (int)$values[$index];
                        break;
                    case 'float':
                        $this->$property = (float)str_replace(',', '.', $values[$index]);
                        break;
                    default:
                        $this->$property = (string)$values[$index];
                        break;
                }
            } else {
                throw new MappedHeaderNotFoundException($mappedHeader);
            }
        }
    }


    public function getIndex(): string
    {
        return $this->index;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getFilename(): string
    {
        return $this->filename;
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }


    public function getMaterial(): string
    {
        return $this->material;
    }


    public function getThickness(): float
    {
        return $this->thickness;
    }


    public function getComment(): string
    {
        return $this->comment;
    }


    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }


    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }


    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }


    public function getUpdatedBy(): string
    {
        return $this->updatedBy;
    }

}
