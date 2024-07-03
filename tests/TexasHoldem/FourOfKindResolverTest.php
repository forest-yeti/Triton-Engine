<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\FourOfKindResolver;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use PHPUnit\Framework\TestCase;

class FourOfKindResolverTest extends TestCase
{
    private FourOfKindResolver $fourOfKindResolver;
    private GameCardBuilder    $gameCardBuilder;

    public function setUp(): void
    {
        $this->fourOfKindResolver = new FourOfKindResolver();
        $this->gameCardBuilder    = new GameCardBuilder();
    }

    public function testFourOfKindExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Clubs),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Clubs),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Diamods),
        ];

        $resolverResult = $this->fourOfKindResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Ace->value, $resolverResult->getKicker()->getRank());
    }

    public function testFourOfKindNotExist()
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

        $resolverResult = $this->fourOfKindResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
        $this->assertNull($resolverResult->getKicker());
    }    
}