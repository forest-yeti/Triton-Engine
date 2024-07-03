<?php

namespace ForestYeti\TritonEngine\Common\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;

interface ResolverInterface
{
    public function getName(): string;

    public function getPriority(): int;

    /**
     * @param GameCardEntity[] $gameCards
     */
    public function execute(array $gameCards): ResolverResult;
}