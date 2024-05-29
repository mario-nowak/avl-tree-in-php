<?php

namespace MarioNowaksGiven\AvlTree;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class AvlTreeTest extends TestCase
{
    public function test_insertsTheProvidedValuesIntoTheAvlTree() {
        $avlTree = new AvlTree(1, 2, 3, 4, 5, 6, 7, 8);

        self::assertEquals(
            [1, 2, 3, 4, 5, 6, 7, 8],
            $avlTree->asArray(),
        );
    }

    #[TestDox("Balances the binary tree when inserting items such that the balance is not grater than 1")]
    public function test_balancesTheAvlTreeWhenInsertingItemsSuchThatTheBalanceIsNotGreaterThanOne(): void {
        $avlTree = new AvlTree(1, 2, 3, 4, 5, 6, 7, 8);

        self::assertLessThanOrEqual(1, $avlTree->root->getBalanceFactor() );
    }

    #[TestDox("Balances the binary tree when inserting items such that the balance is not less than -1")]
    public function test_balancesTheAvlTreeWhenInsertingItemsSuchThatTheBalanceIsNotLessThanMinusOne(): void {
        $avlTree = new AvlTree(1, 2, 3, 4, 5, 6, 7, 8);

        self::assertGreaterThanOrEqual( -1, $avlTree->root->getBalanceFactor());
    }
}
