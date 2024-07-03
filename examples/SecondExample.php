<?php

require_once 'vendor/autoload.php';

use ForestYeti\TritonEngine\GameCard\Entity\GameCardEntity;
use ForestYeti\TritonEngine\GameCard\Enum\RankEnum;
use ForestYeti\TritonEngine\GameCard\Enum\SuitEnum;
use ForestYeti\TritonEngine\TexasHoldem\Service\GameResolver;
use ForestYeti\TritonEngine\GameCard\Service\GameCardDeckFactory;

function formatCard(GameCardEntity $gameCard): string
{
    $rank = $gameCard->getRank();
    $suit = '';

    if ($gameCard->getSuit() === SuitEnum::Clubs->value) {
        $suit = 'Clubs';
    } else if ($gameCard->getSuit() === SuitEnum::Diamods->value) {
        $suit = 'Diamods';
    } else if ($gameCard->getSuit() === SuitEnum::Hearts->value) {
        $suit = 'Hearts';
    } else if ($gameCard->getSuit() === SuitEnum::Spades->value) {
        $suit = 'Spades';
    }

    if ($gameCard->getRank() === RankEnum::Jack->value) {
        $rank = 'Jack';
    } else if ($gameCard->getRank() === RankEnum::Queen->value) {
        $rank = 'Queen';
    } else if ($gameCard->getRank() === RankEnum::King->value) {
        $rank = 'King';
    } else if ($gameCard->getRank() === RankEnum::Ace->value) {
        $rank = 'Ace';
    } 

    return $rank . ' ' . $suit;
}

$gameResolver = new GameResolver();
$targetCombinations = 'StraightFlush';

$counter = 0;
for ($i = 0; $i < 10000; $i++) {
    $gameCardsDeck = (new GameCardDeckFactory())->factoryClassicDeck();
    $gameCardsDeck->shuffle();

    $pockerCards = [
        $gameCardsDeck->pop(),
        $gameCardsDeck->pop(),
    ];

    $boardCards = [
        $gameCardsDeck->pop(),
        $gameCardsDeck->pop(),
        $gameCardsDeck->pop(),
        $gameCardsDeck->pop(),
        $gameCardsDeck->pop(),
    ];

    $resolverResut = $gameResolver->resolve($pockerCards, $boardCards);

    if ($resolverResut->getCombinationName() !== $targetCombinations) {
        continue;
    }

    echo formatCard($pockerCards[0]) . ', ' . formatCard($pockerCards[1]) . PHP_EOL;

    foreach ($boardCards as $boardCard) {
        echo formatCard($boardCard) . ', ';
    }

    echo PHP_EOL;
    
    echo 'Combination - ' . $resolverResut->getCombinationName() . PHP_EOL;

    $kickerFormatted = 'Not exist';
    if ($resolverResut->getKicker() !== null) {
        $kickerFormatted = formatCard($resolverResut->getKicker());
    }

    echo 'Kicker - ' . $kickerFormatted;
    echo PHP_EOL;

    echo '-';
    echo PHP_EOL;

    $counter++;
}

echo 'Total - ' . $counter;