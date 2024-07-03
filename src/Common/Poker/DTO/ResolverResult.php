<?php

namespace ForestYeti\TritonEngine\Common\Poker\DTO;

use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;

class ResolverResult
{
    public function __construct(
        private readonly string          $combinationName,
        private readonly int             $priority,
        private readonly bool            $combinationExist,
        private readonly ?GameCardEntity $kicker
    ) {}

    public function getCombinationName(): string
    {
        return $this->combinationName;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function isCombinationExist()
    {
        return $this->combinationExist;
    }

    public function getKicker(): ?GameCardEntity
    {
        return $this->kicker;
    }
}