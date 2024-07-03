<?php

namespace ForestYeti\TritonEngine\TexasHoldem\Service;

use ForestYeti\TritonEngine\Common\Poker\DTO\ResolverResult;
use ForestYeti\TritonEngine\Common\Poker\Service\ResolverInterface;
use LogicException;

class GameResolver
{
    /**
     * @var ResolverInterface[]
     */
    private array $resolvers;

    public function __construct()
    {
        $this->resolvers = [
            new RoyalFlushResolver(),
            new StraightFlushResolver(),
            new FourOfKindResolver(),
            new FullHouseResolver(),
            new FlushResolver(),
            new StraightResolver(),
            new ThreeOfKindResolver(),
            new TwoPairResolver(),
            new OnePairResolver(),
            new HighCardResolver(),
        ];
    }

    public function resolve(array $pocketCards, array $boardCards): ResolverResult
    {
        foreach ($this->resolvers as $resolver) {
            $resolverResult = $resolver->execute($pocketCards, $boardCards);
            if ($resolverResult->isCombinationExist()) {
                return $resolverResult;
            }
        }

        throw new LogicException('Resolver logic exception');
    }
}