<?php

class Blockchain
{
    public $chain;
    public $difficulty = 2;
    /**
     * @var array
     */
    public $pendingTransactions;
    /**
     * @var int
     */
    private $miningReward;

    public function __construct()
    {
        $this->chain = [$this->createGenesisBlock()];
        $this->difficulty = 5;

        // Place to store transactions in between block creation
        $this->pendingTransactions = [];
        // How many coins a miner will get as a reward for his/her efforts
        $this->miningReward = 100;

    }

    protected function createGenesisBlock(): Block
    {
        return new Block(date('d/m/Y'), '0', ...[]);
    }

    public function getLatestBlock(): Block
    {
        return $this->chain[count($this->chain) - 1];
    }

    public function createTransaction(Transaction $transaction)
    {
        //TODO: validate the transaction here

        $this->pendingTransactions[] = $transaction;
    }

    public function minePendingTransactions(string $miningRewardAddress)
    {
        $block = new Block(date('d/m/Y'), $this->getLatestBlock()->hash, ...$this->pendingTransactions);
        $block->mine($this->difficulty);
        $this->chain[] = $block;

        // Reset the pending transactions and send the mining reward
        $this->pendingTransactions = [
            new Transaction(null, $miningRewardAddress, $this->miningReward)
        ];
    }

    public function getBalanceOfAddress(string $address): float
    {
        $balance = 0;
        /** @var Block $block */
        foreach ($this->chain as $block) {
            foreach ($block->transactions as $transaction) {
                if ($transaction->fromAddress === $address) {
                    $balance -= $transaction->amount;
                }
                if ($transaction->toAddress === $address) {
                    $balance += $transaction->amount;
                }
            }
        }

        return $balance;
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