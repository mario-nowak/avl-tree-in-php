<?php

namespace MarioNowaksgiven\BinaryTree;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class BinaryTreeTest extends TestCase
{
    public function test_insertsTheProvidedValuesIntoTheTree() {
        $binaryTree = new BinaryTree(1, 2, 3, 4, 5, 6, 7, 8);

        self::assertEquals(
            [1, 2, 3, 4, 5, 6, 7, 8],
            $binaryTree->asArray(),
        );
    }

    #[TestDox("Balances the binary tree when inserting items such that the balance is not grater than 1")]
    public function test_balancesTheBinaryTreeWhenInsertingItemsSuchThatTheBalanceIsNotGreaterThanOne(): void {
        $binaryTree = new BinaryTree(1, 2, 3, 4, 5, 6, 7, 8);

        self::assertLessThanOrEqual(1, $binaryTree->root->getBalanceFactor() );
    }

    #[TestDox("Balances the binary tree when inserting items such that the balance is not less than -1")]
    public function test_balancesTheBinaryTreeWhenInsertingItemsSuchThatTheBalanceIsNotLessThanMinusOne(): void {
        $binaryTree = new BinaryTree(1, 2, 3, 4, 5, 6, 7, 8);

        self::assertGreaterThanOrEqual( -1, $binaryTree->root->getBalanceFactor());
    }
}
