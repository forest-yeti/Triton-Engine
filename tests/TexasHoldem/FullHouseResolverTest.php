<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\FullHouseResolver;
use PHPUnit\Framework\TestCase;

class FullHouseResolverTest extends TestCase
{
    private FullHouseResolver $fullHouseResolver;
    private GameCardBuilder   $gameCardBuilder;

    public function setUp(): void
    {
        $this->fullHouseResolver = new FullHouseResolver();
        $this->gameCardBuilder   = new GameCardBuilder();
    }

    public function testFullHouseExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Hearts),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Clubs),
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Clubs),
        ];

        $resolverResult = $this->fullHouseResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Queen->value, $resolverResult->getKicker()->getRank());
    }

    public function testFullHouseNotExist()
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

        $resolverResult = $this->fullHouseResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
        $this->assertNull($resolverResult->getKicker());
    } 
}