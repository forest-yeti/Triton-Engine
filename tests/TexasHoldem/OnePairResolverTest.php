<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\OnePairResolver;
use PHPUnit\Framework\TestCase;

class OnePairResolverTest extends TestCase
{
    private OnePairResolver $onePairResolver;
    private GameCardBuilder $gameCardBuilder;

    public function setUp(): void
    {
        $this->onePairResolver = new OnePairResolver();
        $this->gameCardBuilder = new GameCardBuilder();
    }

    public function testOnePairExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Diamods),
        ];

        $resolverResult = $this->onePairResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Seven->value, $resolverResult->getKicker()->getRank());
    }

    public function testOnePairNotExist()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Seven, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Nine, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Diamods),
        ];

        $resolverResult = $this->onePairResolver->execute($pocketCards, $boardCards);

        $this->assertFalse($resolverResult->isCombinationExist());
    }
}