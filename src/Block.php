<?php

class Block
{
    /**
     * @var string
     */
    public $timestamp;
    /**
     * @var array
     */
    public $data;
    /**
     * @var string
     */
    public $previousHash;
    /**
     * @var string
     */
    public $hash;

    /**
     * @var integer
     */
    public $nonce;

    public function __construct(string $timestamp, array $data, string $previousHash = '')
    {
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previousHash = $previousHash;
        $this->hash = $this->calculateHash();
        $this->nonce = 0;
    }

    public function calculateHash(): string
    {
        return hash(
            'sha256',
            $this->previousHash .
            $this->timestamp .
            json_encode($this->data) .
            $this->nonce
        );
    }

    public function mine(int $difficulty)
    {
        $expected = str_pad('', $difficulty, '0');
        while (0 !== strpos($this->hash, $expected)) {
            $this->nonce++;
            $this->hash = $this->calculateHash();
        }
        echo 'BLOCK MINED: ' . $this->hash . PHP_EOL;
    }
}