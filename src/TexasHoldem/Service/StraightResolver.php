<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
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
        $gameCards = (new GameCardDeck($gameCards));

        $aces = $gameCards->findByRank(RankEnum::Ace->value);
        if (!empty($aces)) {
            foreach ($aces as $ace) {
                $gameCards->add(new GameCardEntity(RankEnum::LowAce->value, $ace->getSuit()));
            }
        }

        $counter     = 1;
        $kicker      = null;
        $sortedCards = $gameCards->sortAsc();
        for ($i = 0; $i < count($sortedCards) - 1; $i++) {
            if ($sortedCards[$i]->getRank() + 1 === $sortedCards[$i + 1]->getRank()) {
                $counter++;
                $kicker = $sortedCards[$i + 1];
            } else {
                $counter = 1;
            }

            if ($counter >= 5) {
                break;
            }
        }

        if ($counter < 5) {
            return new ResolverResult(self::NAME, self::PRIORITY, false);
        }

        return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
    }
}