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

$content='';

$messages=mysql_query("SELECT * FROM `chat` WHERE `time`>NOW()-INTERVAL 10 MINUTE ORDER BY `time` ASC");
while ($message=mysql_fetch_array($messages)) {
  $sender=mysql_fetch_array(mysql_query("SELECT `alias` FROM `players` WHERE `id`=$message[sender] LIMIT 1"));
  $content.= '
  <div class="chat-entry">
            <div class="chat-time">'.$message['time'].'</div>
            <div class="chat-sender">
                <a href="/user/stats/zmBNaP">'.$sender['alias'].':</a>
            </div>
            <div class="chat-message">'.$message['content'].'</div>
        </div>
  ';
}

echo json_encode(array('content'=>$content));

mysql_query("DELETE FROM `chat` WHERE `time`<=NOW()-INTERVAL 10 MINUTE");
?>