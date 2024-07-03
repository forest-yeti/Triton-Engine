<?php

namespace ForestYeti\TritonEngine\GameCard\Entity;

class GameCardEntity
{
    public function __construct(
        private readonly int    $rank,
        private readonly string $suit
    ) {}

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }
}