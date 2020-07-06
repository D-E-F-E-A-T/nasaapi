<?php

declare(strict_types=1);

namespace App\ProvidedData;

class HolidaysDatesCollection implements \Iterator
{
    private int $position = 0;
    private array $dates = [];

    public function add(\DateTimeInterface $date): void
    {
        $this->dates[] = $date;
    }

    public function current(): \DateTimeInterface
    {
        return $this->dates[$this->position];
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
        return isset($this->dates[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

}