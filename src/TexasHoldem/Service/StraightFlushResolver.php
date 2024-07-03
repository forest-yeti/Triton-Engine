<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;

class StraightFlushResolver implements ResolverInterface
{
    private const NAME     = 'StraightFlush';
    private const PRIORITY = 9;

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
        $gameCards      = array_merge($pocketCards, $boardCards);
        $groupedBySuits = [];

        foreach ($gameCards as $gameCard) {
            if (!isset($groupedBySuits[$gameCard->getSuit()])) {
                $groupedBySuits[$gameCard->getSuit()] = [];
            }

            $groupedBySuits[$gameCard->getSuit()][] = $gameCard;
        }

        $targetSuit = null; 
        foreach ($groupedBySuits as $suit => $cardsBySuit) {
            if (count($cardsBySuit) < 5) {
                continue;
            }

            $gameCards = (new GameCardDeck($cardsBySuit))->sortAsc();
            $counter = 1;
            for ($i = 0; $i < count($gameCards) - 1; $i++) {
                if ($this->hasStraightFlushDro($gameCards[$i], $gameCards[$i + 1])) {
                    $counter++;
                }
            }

            if ($counter >= 5) {
                $targetSuit = $suit;
                break;
            }
        }

        if ($targetSuit === null) {
            return new ResolverResult(self::NAME, self::PRIORITY, false);
        }

        $kicker = null;
        if ($pocketCards[1]->getSuit() === $targetSuit) {
            $kicker = $pocketCards[1];
        } else if ($pocketCards[0]->getSuit() === $targetSuit) {
            $kicker = $pocketCards[0];
        }

        return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
    }

    private function hasStraightFlushDro(GameCardEntity $first, GameCardEntity $next): bool
    {
        return 
            $first->getRank() + 1 === $next->getRank() && 
            $first->getSuit() === $next->getSuit();
    }
}