<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;

class HighCardResolver implements ResolverInterface
{
    private const NAME     = 'HighCard';
    private const PRIORITY = 1;

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
        $gameCards = (new GameCardDeck())->sortAsc();

        $kicker = null;
        if (!empty($gameCards)) {
            $kicker = $gameCards[count($gameCards) - 1];
        }
        
        return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
    }
}