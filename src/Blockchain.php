<?php

class Blockchain
{
    public $chain;

    public function __construct()
    {
        $this->chain = [$this->createGenesisBlock()];
    }

    protected function createGenesisBlock(): Block
    {
        return new Block(date('d/m/Y'), ['first' => true], '0');
    }

    public function getLatestBlock(): Block
    {
        return $this->chain[count($this->chain) - 1];
    }

    public function addBlock(Block $block)
    {
        $block->previousHash = $this->getLatestBlock()->hash;
        $block->hash = $block->calculateHash();
        $this->chain[] = $block;
    }

    public function isValid(): bool
    {
        for ($i = 1; $i < count($this->chain); $i++) {
            $currentBlock = $this->chain[$i];
            $previousBlock = $this->chain[$i - 1];

            if ($currentBlock->previousHash !== $previousBlock->hash) {
                return false;
            }

            if ($currentBlock->hash !== $currentBlock->calculateHash()) {
                return false;
            }
        }
        return true;
    }
}