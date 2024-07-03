<?php

namespace ForestYeti\TritonEngine\GameCard\Service;

use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;

class GameCardBuilder
{
    public function build(RankEnum $rankEnum, SuitEnum $suitEnum): GameCardEntity
    {
        return new GameCardEntity($rankEnum->value, $suitEnum->value);
    }
}