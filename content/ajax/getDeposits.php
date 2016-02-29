<?php
/*
 *  © CoinDice 
 *  Demo: http://www.btcircle.com/dice
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


error_reporting(0);
header('X-Frame-Options: DENY'); 

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

if (ini_get('safe_mode')==false) set_time_limit(0);

if (/*true) {*/mysql_num_rows(mysql_query("SELECT * FROM `system` WHERE `id`=1 AND `deposits_last_round`<NOW()-INTERVAL 10 SECOND LIMIT 1"))==1) {
  include '../../inc/check_deposits.php';
  _checkDeposits();
}

?>
