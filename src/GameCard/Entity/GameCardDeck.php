<?php

namespace ForestYeti\TritonEngine\GameCard\Entity;

use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;

class GameCardDeck
{
    /**
     * @var GameCardEntity[]
     */
    private array $gameCards = [];

    public function add(GameCardEntity $gameCardEntity): self
    {
        $this->gameCards[] = $gameCardEntity;

        return $this;
    }

    public function getAll(): array
    {
        return $this->gameCards;
    }

    public function pop(): GameCardEntity
    {
        $gameCard = array_shift($this->gameCards);

        return $gameCard;
    }
}