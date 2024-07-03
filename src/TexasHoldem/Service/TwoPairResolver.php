<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;

class TwoPairResolver implements ResolverInterface
{
    private const NAME     = 'TwoPair';
    private const PRIORITY = 3;

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

        $firstPair  = null;
        $secondPair = null;

        foreach ($gameCards as $gameCard) {
            if (!isset($groupedByRanks[$gameCard->getRank()])) {
                $groupedByRanks[$gameCard->getRank()] = 0;
            }

            $groupedByRanks[$gameCard->getRank()]++;
        }

        foreach ($groupedByRanks as $rank => $counter) {
            if ($counter === 2 && $firstPair === null) {
                $firstPair = new GameCardEntity($rank, SuitEnum::Diamods->value);
            } else if ($counter === 2 && $secondPair === null) {
                $secondPair = new GameCardEntity($rank, SuitEnum::Diamods->value);
            }
        }

        if ($firstPair === null || $secondPair === null) {
            return new ResolverResult(self::NAME, self::PRIORITY, false);
        }

        $kicker = $firstPair;
        if ($secondPair->getRank() > $firstPair->getRank()) {
            $kicker = $secondPair;
        }

        return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
    }
}