<?php

namespace ForestYeti\TritonEngine\GameCard\Service;

use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;

class GameCardDeckFactory
{
    private GameCardBuilder $gameCardBuilder;

    public function __construct()
    {
        $this->gameCardBuilder = new GameCardBuilder();
    }

    public function factoryEmpty(): GameCardDeck
    {
        return new GameCardDeck();
    }

    public function factoryClassicDeck(): GameCardDeck
    {
        $gameCardDeck = new GameCardDeck();

        $ranks = [
            RankEnum::Two,
            RankEnum::Three,
            RankEnum::Four,
            RankEnum::Five,
            RankEnum::Six,
            RankEnum::Seven,
            RankEnum::Eight,
            RankEnum::Nine,
            RankEnum::Ten,
            RankEnum::Jack,
            RankEnum::Queen,
            RankEnum::King,
            RankEnum::Ace,
        ];

        $suits = [
            SuitEnum::Diamods,
            SuitEnum::Hearts,
            SuitEnum::Clubs,
            SuitEnum::Spades,
        ];

        foreach ($ranks as $rank) {
            foreach ($suits as $suit) {
                $gameCardDeck->add(
                    $this->gameCardBuilder->build($rank, $suit)
                );
            }
        }

        return $gameCardDeck;
    }
}