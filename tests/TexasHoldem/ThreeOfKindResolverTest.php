<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\ThreeOfKindResolver;
use PHPUnit\Framework\TestCase;

class ThreeOfKindResolverTest extends TestCase
{
    private ThreeOfKindResolver $threeOfKindResolver;
    private GameCardBuilder     $gameCardBuilder;

    public function setUp(): void
    {
        $this->threeOfKindResolver = new ThreeOfKindResolver();
        $this->gameCardBuilder     = new GameCardBuilder();
    }

    public function testThreeOfKindExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Diamods),
        ];

        $resolverResult = $this->threeOfKindResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Seven->value, $resolverResult->getKicker()->getRank());
    }

    public function testThreeOfKindNotExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::King, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Diamods),
        ];

        $resolverResult = $this->threeOfKindResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
    }
}