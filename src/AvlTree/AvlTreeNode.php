<?php

namespace MarioNowaksGiven\AvlTree;

class AvlTreeNode implements Tree
{
    public ?AvlTreeNode $left = null;
    public ?AvlTreeNode $right = null;
    public ?AvlTreeNode $parent = null;

    public function __construct(
        public int $value,
    ) { }

    public function find(int $valueToFind): ?AvlTreeNode
    {
        if ($valueToFind > $this->value) {
            return $this->right?->find($valueToFind);
        }
        if ($valueToFind < $this->value) {
            return $this->left?->find($valueToFind);
        }

        return $valueToFind === $this->value ? $this : null;
    }

    public function insert(int $valueToInsert): void
    {
        if ($this->value === $valueToInsert)
        {
            return;
        }

        $newNode =  new AvlTreeNode($valueToInsert);
        if ($valueToInsert > $this->value) {
            if ($this->right) {
                $this->right->insert($valueToInsert);
            } else {
                $this->setRightChild($newNode);
            }
        }
        if ($valueToInsert < $this->value) {
            if ($this->left) {
                $this->left->insert($valueToInsert);
            } else {
                $this->setLeftChild($newNode);
            }
        }

        $this->parent?->rebalance(child: $this, grandchild: $newNode);
    }

    public function rebalance(?AvlTreeNode $child, ?AvlTreeNode $grandchild): void {
        $balanceFactor = $this->getBalanceFactor();
        $isUnbalanced = ($balanceFactor > 1) || ($balanceFactor < -1);

        if ($isUnbalanced) {
            if ($child === $this->left) {

                if ($grandchild === $this->left?->left) {
                    // Left left case
                    $this->rotateRight();
                } else if ($grandchild === $this->left?->right) {
                    // Left right case
                    $child->rotateLeft();
                    $this->rotateRight();
                }

            } elseif ($child === $this->right) {

                if ($grandchild === $this->right?->left) {
                    // Right left case
                    $child->rotateRight();
                    $this->rotateLeft();
                } else if ($grandchild === $this->right?->right) {
                    // Right rigth case
                    $this->rotateLeft();
                }

            }
        }

        $isRoot = $this->parent === null;
        if (!$isRoot) {
            $this->parent->rebalance(
                $this,
                $this->left === $child ? $this->left : $this->right,
            );
        }
    }

    public function asArray(): array
    {
        $avlTreeAsArray = [];
        if ($this->left) {
            $avlTreeAsArray = [...$avlTreeAsArray, ...$this->left->asArray()];
        }
        $avlTreeAsArray[] = $this->value;
        if ($this->right) {
            $avlTreeAsArray = [...$avlTreeAsArray, ...$this->right->asArray()];
        }

        return $avlTreeAsArray;
    }

    public function asString(int $depth = 0): string
    {
        $treeAsString = "$this->value";
        $leftPart = (
            "\n"
            . str_repeat("  ", $depth) . "|" . "\n"
            . str_repeat("  ", $depth) . "L "
        );
        if ($this->left) {
            $newDepth = $depth + 1;
            $leftPart = $leftPart . $this->left->asString($newDepth);
        } else {
            $leftPart = $leftPart . "\n";
        }
        $rightPart = (
            "\n"
            . str_repeat("  ", $depth) . "|" . "\n"
            . str_repeat("  ", $depth) . "L "
        );
        if ($this->right) {
            $newDepth = $depth + 1;
            $rightPart = $rightPart . $this->right->asString($newDepth);
        } else {
            $rightPart = $rightPart . "\n";
        }

        return $treeAsString . $leftPart .  $rightPart;
    }

    public function getRoot(): AvlTreeNode
    {
        $isRoot = $this->parent === null;
        if ($isRoot) {
            return $this;
        }

        return $this->parent->getRoot();
    }

    public function rotateLeft(): void
    {
        if (!$this->parent) {
            return;
        }

        $previousParent = $this->parent;
        $previousLeft = $this->left;
        $newParent = $previousParent->parent;

        $previousParent->setRightChild($previousLeft);
        $this->setLeftChild($previousParent);

        $this->parent = $newParent;
    }

    public function rotateRight(): void
    {
        if (!$this->parent) {
            return;
        }

        $previousParent = $this->parent;
        $previousRight = $this->right;
        $newParent = $previousParent->parent;

        $previousParent->setLeftChild($previousRight);
        $this->setRightChild($previousParent);

        $this->parent = $newParent;
    }

    public function setLeftChild(?AvlTreeNode $node)
    {
        $this->left = $node;
        if ($node) {
            $node->parent = $this;
        }
    }

    public function setRightChild(?AvlTreeNode $node){
        $this->right = $node;
        if ($node) {
            $node->parent = $this;
        }
    }

    public function getHeight(): int {
        $isLeaf = ($this->left === null) && ($this->right === null);
        if ($isLeaf) {
            return 0;
        }

        $leftHeight = ($this->left?->getHeight() ?? 0);
        $rightHeight = ($this->right?->getHeight() ?? 0);

        return 1 + max($leftHeight, $rightHeight);
    }

    public function getBalanceFactor(): int {
        $leftHeight = ($this->left?->getHeight() ?? 0);
        $rightHeight = ($this->right?->getHeight() ?? 0);

        return $leftHeight - $rightHeight;
    }
}
