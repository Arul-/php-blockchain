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

    public function __construct(string $timestamp, array $data, string $previousHash = '')
    {
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previousHash = $previousHash;
        $this->hash = $this->calculateHash();
    }

    public function calculateHash(): string
    {
        return hash('sha256', $this->previousHash . $this->timestamp. json_encode($this->data));
    }
}