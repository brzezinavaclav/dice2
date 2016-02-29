<?php
/*
 *  © CoinDice 
 *  Demo: http://www.btcircle.com/dice
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


header('X-Frame-Options: DENY'); 

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

if (empty($_GET['_unique']) || mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();

$settings=mysql_fetch_array(mysql_query("SELECT * FROM `system` LIMIT 1"));

$player=mysql_fetch_array(mysql_query("SELECT * FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

if ((double)$_GET['amount']==0) {
  echo json_encode(array('error'=>'yes'));
  exit();
}

$amount=(double)$_GET['amount'];

if ($player['balance']<$amount || $amount<$settings['inv_min']) {
  echo json_encode(array('error'=>'yes'));
  exit();
}

mysql_query("UPDATE `players` SET `balance`=TRUNCATE(ROUND((`balance`-$amount),9),8) WHERE `id`=$player[id] LIMIT 1");


if (mysql_num_rows(mysql_query("SELECT `id` FROM `investors` WHERE `player_id`=$player[id] LIMIT 1"))==0) {
  mysql_query("INSERT INTO `investors` (`player_id`) VALUES ($player[id])");
}

$investor=mysql_fetch_array(mysql_query("SELECT * FROM `investors` WHERE `player_id`=$player[id] LIMIT 1"));


mysql_query("UPDATE `investors` SET `amount`=TRUNCATE(ROUND((`amount`+$amount),9),8) WHERE `player_id`=$player[id] LIMIT 1");

echo json_encode(array('error'=>'no'));


?> 