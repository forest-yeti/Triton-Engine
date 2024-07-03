<?php

require_once 'vendor/autoload.php';

use ForestYeti\TritonEngine\TexasHoldem\Service\GameResolver;
use ForestYeti\TritonEngine\GameCard\Service\GameCardDeckFactory;

$gameResolver = new GameResolver();

$counters = [];
for ($i = 0; $i < 500000; $i++) {
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

    if (!isset($counters[$resolverResut->getCombinationName()])) {
        $counters[$resolverResut->getCombinationName()] = 0;
    }

    $counters[$resolverResut->getCombinationName()]++;
}

asort($counters);

foreach ($counters as $combinationName => $counter) {
    echo $combinationName . ' - ' . $counter . PHP_EOL;
}