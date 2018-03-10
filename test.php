<?php
require __DIR__ . '/vendor/autoload.php';


function validate(Blockchain $chain)
{
    echo 'Blockchain valid? ';
    echo $chain->isValid() ? 'true' : 'false';
    echo PHP_EOL;

}

$blocks = new Blockchain();

echo "Creating some transactions...\n";

$blocks->createTransaction(new Transaction('address1', 'address2', 100));
$blocks->createTransaction(new Transaction('address2', 'address1', 50));

echo "Starting the miner...\n";

$miner = 'aruls-address';

$blocks->minePendingTransactions($miner);

echo "Balance for address1 is " . $blocks->getBalanceOfAddress('address1') . PHP_EOL;

echo "Balance for $miner is " . $blocks->getBalanceOfAddress($miner) . PHP_EOL;

$blocks->minePendingTransactions($miner);

echo "Balance for $miner is " . $blocks->getBalanceOfAddress($miner) . PHP_EOL;

validate($blocks);

/*

  php test.php

    Creating some transactions...
    Starting the miner...
    BLOCK MINED: 000001cdfa25df1b96408764c5a234996584c310ca0f5277c88cd5e4b02de998
    Balance for address1 is -50
    Balance for aruls-address is 0
    BLOCK MINED: 000004ba1127cdc7a328d9a4b404456e5a628c5b43ddb1b858633d0c5eae39ba
    Balance for aruls-address is 100
    Blockchain valid? true

 */