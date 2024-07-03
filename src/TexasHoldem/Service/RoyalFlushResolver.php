<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
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

        $aces = $gameCardDeck->findByRank(RankEnum::Ace->value);
        foreach ($aces as $ace) {
            $gameCardsBySuit = new GameCardDeck(
                $gameCardDeck->findBySuit($ace->getSuit())
            );
            
            if ($gameCardsBySuit->count() < 5) {
                continue;
            }

            $sortedCards = array_reverse($gameCardsBySuit->sortAsc());
            $targetRank  = RankEnum::Ace->value;

            foreach ($sortedCards as $targetCard) {
                if ($targetCard->getRank() === $targetRank) {
                    $targetRank--;
                } else {
                    return new ResolverResult(self::NAME, self::PRIORITY, false);
                }
            }

            return new ResolverResult(self::NAME, self::PRIORITY, true);
        }

        return new ResolverResult(self::NAME, self::PRIORITY, false);
    }
}