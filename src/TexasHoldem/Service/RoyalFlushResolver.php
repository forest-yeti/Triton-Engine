<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;

class RoyalFlushResolver implements ResolverInterface
{
    private const NAME     = 'RoyalFlush';
    private const PRIORITY = 10;

    public function getName(): string
    {
        return self::NAME;
    }

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    /**
     * @param GameCardEntity[] $pockerCards
     * @param GameCardEntity[] $boardCards
     */
    public function execute(array $pocketCards, array $boardCards): ResolverResult
    {
        $gameCards = array_merge($pocketCards, $boardCards);

        $gameCardDeck = new GameCardDeck($gameCards);
    }
}