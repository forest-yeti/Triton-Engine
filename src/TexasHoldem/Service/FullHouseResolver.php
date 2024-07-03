<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;

class FullHouseResolver implements ResolverInterface
{
    private const NAME     = 'FullHouse';
    private const PRIORITY = 7;

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

        $onePairKicker = null;
        $setKicker     = null;

        foreach ($gameCards as $gameCard) {
            if (!isset($groupedByRanks[$gameCard->getRank()])) {
                $groupedByRanks[$gameCard->getRank()] = 0;
            }

            $groupedByRanks[$gameCard->getRank()]++;

            if ($groupedByRanks[$gameCard->getRank()] === 3) {
                $setKicker = $gameCard;
            }
            if ($groupedByRanks[$gameCard->getRank()] === 2) {
                $onePairKicker = $gameCard;
            }
        }

        if ($onePairKicker !== null && $setKicker !== null) {
            $kicker = $onePairKicker;
            if ($setKicker->getRank() > $onePairKicker->getRank()) {
                $kicker = $setKicker;
            }

            return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
        }

        return new ResolverResult(self::NAME, self::PRIORITY, false);
    }
}