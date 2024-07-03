<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;

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

        $onePairRank = null;
        $setRank     = null;

        foreach ($gameCards as $gameCard) {
            if (!isset($groupedByRanks[$gameCard->getRank()])) {
                $groupedByRanks[$gameCard->getRank()] = 0;
            }

            $groupedByRanks[$gameCard->getRank()]++;
        }

        foreach ($groupedByRanks as $rank => $counter) {
            if ($counter === 2) {
                $onePairRank = $rank;
            }

            if ($counter === 3) {
                $setRank = $rank;
            }
        }

        if ($onePairRank !== null && $setRank !== null) {
            $kickerRank = $onePairRank;
            if ($setRank > $onePairRank) {
                $kickerRank = $setRank;
            }

            $gameCard = new GameCardEntity($kickerRank, SuitEnum::Diamods->value);
            return new ResolverResult(self::NAME, self::PRIORITY, true, $gameCard);
        }

        return new ResolverResult(self::NAME, self::PRIORITY, false);
    }
}