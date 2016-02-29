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
include '../../inc/wallet_driver.php';
$wallet=new jsonRPCClient($driver_login);
include '../../inc/functions.php';

if (empty($_GET['_unique']) || mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
$player=mysql_fetch_array(mysql_query("SELECT * FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));
$settings=mysql_fetch_array(mysql_query("SELECT * FROM `system` WHERE `id`=1 LIMIT 1"));

if (mysql_num_rows(mysql_query("SELECT `id` FROM `investors` WHERE `player_id`=$player[id] LIMIT 1"))==0) {
  mysql_query("INSERT INTO `investors` (`player_id`) VALUES ($player[id])");
}


$investor=mysql_fetch_array(mysql_query("SELECT * FROM `investors` WHERE `player_id`=$player[id]"));

$reservedBalance=mysql_fetch_array(mysql_query("SELECT SUM(`balance`) AS `sum` FROM `players`"));
$reservedWaitingBalance=mysql_fetch_array(mysql_query("SELECT SUM(`amount`) AS `sum` FROM `deposits`"));
$serverBalance=$wallet->getbalance();
$serverFreeBalance=($serverBalance-$reservedBalance['sum']-$reservedWaitingBalance['sum']);

$invested=$investor['amount'];
$share=(($serverFreeBalance)==0)?0:(($invested/$serverFreeBalance)*(100-$settings['inv_perc']));

$return=array(
  'con' => "
  <p>You can invest:<b>".sprintf("%.8f",$player['balance'])."</b> ".$settings['currency_sign']."</p>
  <p>Invested:<b>".sprintf("%.8f",$invested)."</b> ".$settings['currency_sign']."</p>
  <p>Bakroll share:<b>".rtrim(rtrim(sprintf("%.8f",$share),'0'),'.')."</b> %</p>

  <input type='text' class='_inv_amount'><a class='btn' onclick='javascript:_invest();'>INVEST</a>
  <br><input type='text' class='_div_amount'><a class='btn' onclick='javascript:_divest();'>DIVEST</a>
  <p>Minimum investment is <b>".sprintf("%.8f",$settings['inv_min'])."</b> ".$settings['currency_sign']."</p>
  "
);
echo json_encode($return);

?>