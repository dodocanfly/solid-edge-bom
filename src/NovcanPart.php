<?php

namespace Dodocanfly\SolidEdgeBom;

class NovcanPart extends Part
{
    protected bool $selfPart = false;
    protected array $originals = [];


    public function __construct(array $headers, array $values, array $headersMap = [])
    {
        parent::__construct($headers, $values, $headersMap);
        $this->prepareSelfPart();
        $this->prepareIndex();
        $this->prepareThickness();
        $this->prepareMaterial();
    }


    private function prepareSelfPart(): void
    {
        $this->selfPart = strstr($this->getMaterial(), '#');
    }


    private function prepareIndex()
    {
        preg_match('/^index:? ?(\w?\d+)/i', $this->comment, $matches);
        if ($matches) {
            $newIndex = trim($matches[1]);
            if ($this->index !== $newIndex) {
                $this->originals['index'] = $this->index;
                $this->index = $newIndex;
            }
        }
    }


    private function prepareThickness()
    {
        if (!$this->selfPart) return;
        preg_match('/# ?(\d+([,.]\d)?)+.*/', $this->material, $matches);
        if ($matches) {
            $newThickness = floatval(str_replace(',', '.', trim($matches[1])));
            if ($this->thickness != $newThickness) {
                $this->originals['thickness'] = $this->thickness;
                $this->thickness = $newThickness;
            }
        }
    }


    private function prepareMaterial()
    {
        if (!$this->selfPart) return;
        $newMaterial = false;
        preg_match('/# ?(\d+([,.]\d)?) ([A-Z0-9]+).*/', $this->material, $matches);
        if ($matches) {
            $newMaterial = trim($matches[3]);
        } elseif (strstr($this->material, 'X120Mn12')) {
            $newMaterial = 'X120Mn12';
        }
        if ($newMaterial && $this->material !== $newMaterial) {
            $this->originals['material'] = $this->material;
            $this->material = $newMaterial;
        }
    }


    public function getOriginals(): array
    {
        return $this->originals;
    }


    public function isSelfPart(): bool
    {
        return $this->selfPart;
    }
}
