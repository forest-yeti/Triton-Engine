<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\FlushResolver;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use PHPUnit\Framework\TestCase;

class FlushResolverTest extends TestCase
{
    private FlushResolver   $fourOfKindResolver;
    private GameCardBuilder $gameCardBuilder;

    public function setUp(): void
    {
        $this->fourOfKindResolver = new FlushResolver();
        $this->gameCardBuilder    = new GameCardBuilder();
    }

    public function testFlushExistWithKicker()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::King, SuitEnum::Hearts),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Clubs),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Diamods),
        ];

        $resolverResult = $this->fourOfKindResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertEquals(RankEnum::Ace->value, $resolverResult->getKicker()->getRank());
    }

    public function testFlushExistWitoutKicker()
    {
        $pocketCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Diamods),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Clubs),
        ];

        $boardCards = [
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Three, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Five, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
        ];

        $resolverResult = $this->fourOfKindResolver->execute($pocketCards, $boardCards);

        $this->assertTrue($resolverResult->isCombinationExist());
        $this->assertNull($resolverResult->getKicker());
    }
}