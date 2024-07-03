<?php

namespace ForestYeti\TritonEngine\GameCard\Repository;

use ForestYeti\TritonEngine\Common\Exception\ApplicationException;
use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;

class GameCardDeck
{   
    /**
     * @param GameCardEntity[]
     */
    public function __construct(
        private array $gameCards = []
    ) {}

    /**
     * @return GameCardEntity[]
     */
    public function getAll(): array
    {
        return $this->gameCards;
    }

    public function add(GameCardEntity $gameCardEntity): self
    {
        $this->gameCards[] = $gameCardEntity;

        return $this;
    }

    public function pop(): GameCardEntity
    {
        $gameCard = array_shift($this->gameCards);
        if ($gameCard === null) {
            throw new ApplicationException('Empty deck');
        }

        return $gameCard;
    }

    /**
     * @return GameCardEntity[]
     */
    public function findByRank(int $rank): array
    {
        $founded = [];

        foreach ($this->gameCards as $gameCard) {
            if ($gameCard->getRank() === $rank) {
                $founded[] = $gameCard;
            }
        }

        return $founded;
    }

    /**
     * @return GameCardEntity[]
     */
    public function findBySuit(string $suit): array
    {
        $founded = [];

        foreach ($this->gameCards as $gameCard) {
            if ($gameCard->getSuit() === $suit) {
                $founded[] = $gameCard;
            }
        }

        return $founded;
    }

    /**
     * @return GameCardEntity[]
     */
    public function shuffle(): array
    {
        shuffle($this->gameCards);

        return $this->gameCards;
    }

    /**
     * @return GameCardEntity[]
     */
    public function sortAsc(): array
    {
        $sortedGameCards = $this->gameCards;

        usort($sortedGameCards, function (GameCardEntity $a, GameCardEntity $b) {
            return $a->getRank() <=> $b->getRank();
        });

        return $sortedGameCards;
    }
}