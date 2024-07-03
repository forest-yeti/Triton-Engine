<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\StraightResolver;
use PHPUnit\Framework\TestCase;

class StraightResolverTest extends TestCase
{
    private StraightResolver $straightResolver;
    private GameCardBuilder  $gameCardBuilder;

    public function setUp(): void
    {
        $this->straightResolver = new StraightResolver();
        $this->gameCardBuilder  = new GameCardBuilder();
    }

    public function testStraightExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Spades),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::King, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Diamods),
        ];

        $resolverResult = $this->straightResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Ace->value, $resolverResult->getKicker()->getRank());
    }

    public function testStraightNotExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Diamods),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Hearts),
        ];

        $resolverResult = $this->straightResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
        $this->assertNull($resolverResult->getKicker());
    }
}