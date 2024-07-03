<?php

namespace ForestYeti\Tests\Common;

use ForestYeti\TritonEngine\Common\Exception\ApplicationException;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardDeckFactory;
use PHPUnit\Framework\TestCase;

class GameCardTest extends TestCase
{
    private GameCardBuilder     $gameCardBuilder;
    private GameCardDeckFactory $gameCardDeckFactory;

    public function setUp(): void
    {
        $this->gameCardBuilder     = new GameCardBuilder();
        $this->gameCardDeckFactory = new GameCardDeckFactory();
    }

    public function testGameCardBuilder(): void
    {
        $gameCard = $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts);

        $this->assertEquals(RankEnum::Ace->value, $gameCard->getRank());
        $this->assertEquals(SuitEnum::Hearts->value, $gameCard->getSuit());
    }

    public function testGameCardEmptyDeck(): void
    {
        $gameCardDeck = $this->gameCardDeckFactory->factoryEmpty();

        $this->assertEmpty($gameCardDeck->getAll());
        $this->expectException(ApplicationException::class);
        $gameCardDeck->pop();
    }

    public function testGameCardClassicDeck(): void
    {
        $gameCardDeck = $this->gameCardDeckFactory->factoryClassicDeck();

        $this->assertCount(52, $gameCardDeck->getAll());
    }
}