<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;

class FourOfKindResolver implements ResolverInterface
{
    private const NAME     = 'FourOfKind';
    private const PRIORITY = 8;

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
        $groupedByRanks = [];
        $gameCards      = array_merge($pocketCards, $boardCards);

        foreach ($gameCards as $gameCard) {
            if (!isset($groupedByRanks[$gameCard->getRank()])) {
                $groupedByRanks[$gameCard->getRank()] = 0;
            }

            $groupedByRanks[$gameCard->getRank()]++;

            if ($groupedByRanks[$gameCard->getRank()] === 4) {
                return new ResolverResult(self::NAME, self::PRIORITY, true, $gameCard);
            }
        }

        return new ResolverResult(self::NAME, self::PRIORITY, false);
    }
}