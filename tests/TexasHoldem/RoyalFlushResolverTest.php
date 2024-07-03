<?php

namespace ForestYeti\Tests\TexasHoldem;

use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\GameCard\Repository\GameCardDeck;
use ForestYeti\TritonEngine\GameCard\Service\GameCardBuilder;
use ForestYeti\TritonEngine\TexasHoldem\Service\RoyalFlushResolver;
use PHPUnit\Framework\TestCase;

class RoyalFlushResolverTest extends TestCase
{
    private RoyalFlushResolver $royalFlushResolver;
    private GameCardBuilder    $gameCardBuilder;

    public function setUp(): void
    {
        $this->royalFlushResolver = new RoyalFlushResolver();
        $this->gameCardBuilder    = new GameCardBuilder();
    }

    public function testRoyalFlushExist()
    {
        $gameCardDeck = new GameCardDeck([
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::King, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Spades),
        ]);

        $resolverResult = $this->royalFlushResolver->execute([], $gameCardDeck->getAll());

        $this->assertTrue($resolverResult->isCombinationExist());
    }

    public function testRoyalFlushNotExist()
    {
        $gameCardDeck = new GameCardDeck([
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Hearts),
            $this->gameCardBuilder->build(RankEnum::Two, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Queen, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ace, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Ten, SuitEnum::Spades),
            $this->gameCardBuilder->build(RankEnum::Jack, SuitEnum::Spades),
        ]);

        $resolverResult = $this->royalFlushResolver->execute([], $gameCardDeck->getAll());

        $this->assertFalse($resolverResult->isCombinationExist());
    }
}