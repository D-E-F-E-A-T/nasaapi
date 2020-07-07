<?php

declare(strict_types=1);

namespace App\NasaMarsAPI;

use App\Entity\MarsPhotos;

class MarsPhotosCollection implements \Iterator
{
    private int $position = 0;
    private array $photos = [];

    public function add(MarsPhotos $photo): void
    {
        $this->photos[] = $photo;
    }

    public function current(): MarsPhotos
    {
        return $this->photos[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->photos[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

}