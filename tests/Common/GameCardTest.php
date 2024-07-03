<?php

namespace ForestYeti\Tests\Common;

use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use PHPUnit\Framework\TestCase;

class GameCardTest extends TestCase
{
    private GameCardBuilder $gameCardBuilder;

    public function setUp(): void
    {
        $this->gameCardBuilder = new GameCardBuilder();
    }

    public function testGameCardBuilder(): void
    {
        $gameCard = $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts);

        $this->assertEquals(RankEnum::Ace->value, $gameCard->getRank());
        $this->assertEquals(SuitEnum::Hearts->value, $gameCard->getSuit());
    }
}