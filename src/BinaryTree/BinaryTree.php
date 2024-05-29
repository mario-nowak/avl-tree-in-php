<?php

namespace MarioNowaksgiven\BinaryTree;

class BinaryTree implements Tree
{
    public ?BinaryTreeNode $root = null;

    public function __construct(
        ...$values,
    )
    {
        if (count($values) and !$this->root) {
            $this->root = new BinaryTreeNode($values[0]);
        }
        foreach ($values as $value) {
            $this->root?->insert($value);
            $this->updateRoot();
        }
    }

    public function updateRoot(): void
    {
        $this->root = $this->root->getRoot();
    }

    public function find(int $valueToFind): ?BinaryTreeNode
    {
        return $this->root?->find($valueToFind);
    }

    public function insert(int $valueToInsert): void
    {
        $this->root?->insert($valueToInsert);
    }

    public function asArray(): array
    {
        return $this->root?->asArray();
    }

    public function asString(): string
    {
        return $this->root?->asString();
    }
}
