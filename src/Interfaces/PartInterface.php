<?php

namespace Dodocanfly\SolidEdgeBom\Interfaces;

interface PartInterface
{
    const HEADERS_MAP = [
        'index' => 'Numer dokumentu',
        'name' => 'Tytuł',
        'filename' => 'Nazwa pliku',
        'quantity' => 'Ilość',
        'material' => 'Materiał',
        'thickness' => 'Grubość materiału',
        'comment' => 'Komentarze',
        'createdAt' => 'Utworzony',
        'createdBy' => 'Autor',
        'updatedAt' => 'Zmodyfikowany',
        'updatedBy' => 'Ostatni autor',
    ];

    public function getIndex(): string;
    public function getName(): string;
    public function getFilename(): string;
    public function getQuantity(): int;
    public function getMaterial(): string;
    public function getThickness(): float;
    public function getComment(): string;
    public function getCreatedAt(): string;
    public function getCreatedBy(): string;
    public function getUpdatedAt(): string;
    public function getUpdatedBy(): string;
}
