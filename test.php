<?php
include "api/coingecko.php";
$data = getMarketCoins(5);
var_dump($data);
