<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\TwoPairResolver;
use PHPUnit\Framework\TestCase;

class TwoPairResolverTest extends TestCase
{
    private TwoPairResolver $twoPairResolver;
    private GameCardBuilder $gameCardBuilder;

    public function setUp(): void
    {
        $this->twoPairResolver = new TwoPairResolver();
        $this->gameCardBuilder = new GameCardBuilder();
    }

    public function testTwoPairExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Diamods),
        ];

        $resolverResult = $this->twoPairResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Seven->value, $resolverResult->getKicker()->getRank());
    }

    public function testTwoPairNotExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Diamods),
        ];

        $resolverResult = $this->twoPairResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
    }
}