<?php

namespace MarioNowaksgiven\BinaryTree;

interface Tree
{
    public function find(int $valueToFind): ?Tree;
    public function insert(int $valueToInsert): void;
    public function asArray(): array;
    public function asString(): string;
}
