<?php

class Transaction
{
    /**
     * @var string
     */
    public $fromAddress;
    /**
     * @var string
     */
    public $toAddress;
    /**
     * @var float
     */
    public $amount;

    public function __construct(?string $fromAddress, string $toAddress, float $amount)
    {
        $this->fromAddress = $fromAddress;
        $this->toAddress = $toAddress;
        $this->amount = $amount;
    }
}