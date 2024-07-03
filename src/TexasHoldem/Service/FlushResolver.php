<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;

class FlushResolver implements ResolverInterface
{
    private const NAME     = 'Flush';
    private const PRIORITY = 6;

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
        $gameCards = new GameCardDeck($gameCards);

        $suits = [
            SuitEnum::Clubs->value,
            SuitEnum::Diamods->value,
            SuitEnum::Hearts->value,
            SuitEnum::Spades->value,
        ];

        foreach ($suits as $suit) {
            $cardsBySuit = $gameCards->findBySuit($suit);
            if (count ($cardsBySuit) < 5) {
                continue;
            }

            $kicker      = null;
            $pocketCards = (new GameCardDeck($pocketCards))->sortAsc();
            if ($pocketCards[1]->getSuit() === $suit) {
                $kicker = $pocketCards[1];
            } else if ($pocketCards[0]->getSuit() === $suit) {
                $kicker = $pocketCards[0];
            }

            return new ResolverResult(self::NAME, self::PRIORITY, true, $kicker);
        }

        return new ResolverResult(self::NAME, self::PRIORITY, false);
    }
}