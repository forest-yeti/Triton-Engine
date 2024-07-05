<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\StraightFlushResolver;
use PHPUnit\Framework\TestCase;

class StraightFlushResolverTest extends TestCase
{
    private StraightFlushResolver $straightFlushResolver;
    private GameCardBuilder       $gameCardBuilder;

    public function setUp(): void
    {
        $this->straightFlushResolver = new StraightFlushResolver();
        $this->gameCardBuilder       = new GameCardBuilder();
    }

    public function testStraightFlushExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Six, SuitEnum::Diamods),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Eight, SuitEnum::Diamods),
        ];

        $resolverResult = $this->straightFlushResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Nine->value, $resolverResult->getKicker()->getRank());
        $this->assertEquals(SuitEnum::Diamods->value, $resolverResult->getKicker()->getSuit());
    }

    public function testStraightFlushWitLowAceExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Four, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Diamods),
        ];

        $resolverResult = $this->straightFlushResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Five->value, $resolverResult->getKicker()->getRank());
        $this->assertEquals(SuitEnum::Diamods->value, $resolverResult->getKicker()->getSuit());
    }

    public function testStraightFlushNotExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Six, SuitEnum::Diamods),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Eight, SuitEnum::Hearts),
        ];

        $resolverResult = $this->straightFlushResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
        $this->assertNull($resolverResult->getKicker());
    }
}