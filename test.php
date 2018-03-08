<?php
require __DIR__ . '/vendor/autoload.php';


function validate(Blockchain $chain)
{
    echo 'Blockchain valid? ';
    echo $chain->isValid() ? 'true' : 'false';
    echo PHP_EOL;

}

$blocks = new Blockchain();

$blocks->addBlock(new Block(date('d/m/Y'), ['amount' => 4]));
$blocks->addBlock(new Block(date('d/m/Y'), ['amount' => 8]));

validate($blocks);

//try to alter some value
$blocks->chain[1]->data = ['amount' => 100];

validate($blocks);

/*
//results for  `php test.php`

Blockchain valid? true
Blockchain valid? false
*/
