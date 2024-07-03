<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;

class StraightResolver implements ResolverInterface
{
    private const NAME     = 'Straight';
    private const PRIORITY = 5;

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
        $gameCards = (new GameCardDeck($gameCards))->sortAsc();

        $counter = 0;
        $kicker  = null;
        for ($i = 0; $i < count($gameCards) - 1; $i++) {
            if ($gameCards[$i]->getRank() + 1 === $gameCards[$i + 1]->getRank()) {
                $counter++;
                $kicker = $gameCards[$i + 1];
            }
        }

        if ($counter < 5) {
            return new ResolverResult(self::NAME, self::PRIORITY, false);
        }

        return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
    }
}