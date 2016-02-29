<?php
/*
 *  © CoinDice 
 *  Demo: http://www.btcircle.com/dice
 *  Please do not copy or redistribute.
 *  More licences we sell, more products we develop in the future.  
*/


header('X-Frame-Options: DENY'); 

if (empty($_GET['con'])) exit();

$included=true;
include '../../inc/db-conf.php';
include '../../inc/functions.php';

$settings=mysql_fetch_array(mysql_query("SELECT * FROM `system` LIMIT 1"));

$content='';

switch ($_GET['con']) {
  case 'my_bets':
    if (empty($_GET['_unique']) || mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
    $player=mysql_fetch_array(mysql_query("SELECT * FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));
    
    $my_bets=mysql_query("SELECT * FROM `bets` WHERE `player`=$player[id] ORDER BY `time` DESC LIMIT 30");
    if (mysql_num_rows($my_bets)==0) $content.='<br><br><br><i>You haven\'t bet yet.</i>';
    else {
      $content.='<div class="default-row headingrow">';
      $content.='<table id="bets_st_table">';
      $content.='<thead>';
      $content.='<tr>';
      $content.='<td>Result</td>';
      $content.='<td>Multiplier</td>';
      $content.='<td>Roll</td>';
      $content.='<td>Target</td>';
      $content.='<td>Bet</td>';
      $content.='<td>Profit</td>';
      $content.='</tr>';
      $content.='</thead>';
      $content.='</table>';
      $content.='</div>';
      $suda=0;
      while ($my_bet=mysql_fetch_array($my_bets)) {
        $content.=($suda==0)?'<tr>':'<tr class="suda">';

        $username=mysql_fetch_array(mysql_query("SELECT `alias` FROM `players` WHERE `id`=$my_bet[player] LIMIT 1"));

        $chance['under']=floor((1/($my_bet['multiplier']/100)*((100-$settings['house_edge'])/100))*100)/100;
        $chance['over']=100-$chance['under'];

        $target=($my_bet['under_over']==0)?'<'.sprintf("%.2f",$chance['under']):'>'.sprintf("%.2f",$chance['over']);
        $profit=-$my_bet['bet_amount'];
        $profit_class='lose';
        $plusko=($my_bet['bet_amount']==0)?'-':'';
        if ($my_bet['win_lose']==1) {
          $profit+=$my_bet['bet_amount']*$my_bet['multiplier'];
          $profit_class='win';
        }
        $content.='<div style="" class="default-row '. $profit_class .'">';
        $content.='<table>';
        $content.='<tbody>';
        $content.='<tr>';
        $content.= '<td class="color status">'. $profit_class .'</td>';
        $content.='<td>'.sprintf("%.2f",$my_bet['multiplier']).' x</td>';
        $content.='<td>'.sprintf("%.2f",$my_bet['result']).'</td>';
        $content.='<td>'.$target.'</td>';
        $content.='<td><i class="fa fa-btc"></i>'.sprintf("%.8f",$my_bet['bet_amount']).'</td>';
        $content.='<td class="color"><i class="fa fa-btc"></i>'.sprintf("%.8f",floor($profit*100000000)/100000000).'</td>';
        $content.='</tr>';
        $content.='</tbody>';
        $content.='</table>';
        $content.='</div>';
        $suda=($suda==0)?1:0;
      }

    }
  break;
  case 'all_bets':
    $all_bets=mysql_query("SELECT * FROM `bets` WHERE `bet_amount`!=0 ORDER BY `time` DESC LIMIT 30");
    if (mysql_num_rows($all_bets)==0) $content.='<br><br><br><i>No one has bet yet.</i>';
    else {
      $content.='<div class="default-row headingrow">';
      $content.='<table id="bets_st_table">';
      $content.='<thead>';
      $content.='<tr>';
      $content.='<td>Result</td>';
      $content.='<td>Multiplier</td>';
      $content.='<td>Roll</td>';
      $content.='<td>Target</td>';
      $content.='<td>Bet</td>';
      $content.='<td>Profit</td>';
      $content.='</tr>';
      $content.='</thead>';
      $content.='</table>';
      $content.='</div>';
      $suda=0;
      while ($all_bet=mysql_fetch_array($all_bets)) {
        $content.=($suda==0)?'<tr>':'<tr class="suda">';
        
        if (mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `id`=$all_bet[player] LIMIT 1"))!=0)
          $username=mysql_fetch_array(mysql_query("SELECT `alias` FROM `players` WHERE `id`=$all_bet[player] LIMIT 1"));
        else $username['alias']='[unknown]';
        
        $chance['under']=floor((1/($all_bet['multiplier']/100)*((100-$settings['house_edge'])/100))*100)/100;
        $chance['over']=100-$chance['under'];

        $target=($all_bet['under_over']==0)?'<'.sprintf("%.2f",$chance['under']):'>'.sprintf("%.2f",$chance['over']);
        $profit=-$all_bet['bet_amount'];
        $profit_class='lose';
        $plusko=($all_bet['bet_amount']==0)?'-':'';
        if ($all_bet['win_lose']==1) {
          $profit+=$all_bet['bet_amount']*$all_bet['multiplier'];
          $profit_class='win';
          $plusko='+';
        }

        $content.='<div style="" class="default-row '. $profit_class .'">';
        $content.='<table>';
        $content.='<tbody>';
        $content.='<tr>';
        $content.= '<td class="color status">'. $profit_class .'</td>';
        $content.='<td>'.sprintf("%.2f",$my_bet['multiplier']).' x</td>';
        $content.='<td>'.sprintf("%.2f",$my_bet['result']).'</td>';
        $content.='<td>'.$target.'</td>';
        $content.='<td><i class="fa fa-btc"></i>'.sprintf("%.8f",$my_bet['bet_amount']).'</td>';
        $content.='<td class="color"><i class="fa fa-btc"></i>'.sprintf("%.8f",floor($profit*100000000)/100000000).'</td>';
        $content.='</tr>';
        $content.='</tbody>';
        $content.='</table>';
        $content.='</div>';
        $suda=($suda==0)?1:0;
      }
    }
  break;
  case 'news':
    $content.='<br><br><br>';
    $query=mysql_query("SELECT * FROM `news` ORDER BY `time` DESC");
    while ($row=mysql_fetch_array($query)) {
      $content.='<div class="news_single">';
      $content.=str_replace('[I]','<i>',str_replace('[/I]','</i>',str_replace('[BR]','<br>',str_replace('[/B]','</b>',str_replace('[B]','<b>',$row['content']))))).'<br><span class="news_single_time">'.$row['time'].'</span>';
      $content.='</div>';
    }
    if (mysql_num_rows($query)==0) $content.='<i>No news available.</i>';    
  break;
  case 'giveaway':
    if ($settings['giveaway']!=1) {
      $content.='<p>Giveaway is not supported now.</p>';
    }
    else {
      if (empty($_GET['_unique']) || mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
      $player=mysql_fetch_array(mysql_query("SELECT * FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));
      $content.='<div class="msgBoxContent">';
      if ($player['balance']!=0) {
        $content.='<p>Sorry, your balance must be <b>0</b> to claim the '.$settings['currency'].' bonus.</p>';
      }
      else {
        $content.='<p>You can claim the '.$settings['currency'].' bonus now:</p>';
        $content.='<p><big><b>'.sprintf("%.8f",$settings['giveaway_amount']).'</b> '.$settings['currency_sign'].'</big></p>';
        $content.='<img src="./content/captcha/genImage.php" style="margin: 15px 0px" />
    <input type="text" id="captchatext" style="text-transform: uppercase;" placeholder="Captcha">
<div class="msgBoxButtons"><input type="button" onclick="javascript:claim($(\'#captchatext\').val());return false;" value="Claim" class="msgButton" id="msgClaim"></div>';      }
    }
    $content.= '</div>';
  break;
  case 'stats':
    if (empty($_GET['_unique']) || mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"))==0) exit();
    $player=mysql_fetch_array(mysql_query("SELECT * FROM `players` WHERE `hash`='".prot($_GET['_unique'])."' LIMIT 1"));

    $content.='<br><br><br>';
    $content.='<div class="stats_">';

    $content.='<table width="100%">';
    $content.='<tr><th>Your Stats</th><th class="center"><img src="./content/images/diceStats.png"></th><th>Global Stats</th></tr>';
    $content.='<tr><td>'.$player['t_bets'].'</td><td class="center">NUMBER OF BETS</td><td>'.$settings['t_bets'].'</td></tr>';    
    $content.='<tr><td>'.$player['t_wagered'].'</td><td class="center">TOTAL WAGERED</td><td>'.$settings['t_wagered'].'</td></tr>';    
    $content.='<tr><td>'.$player['t_profit'].'</td><td class="center">TOTAL PROFIT</td><td>'.$settings['t_player_profit'].'</td></tr>';    
    $content.='<tr class="wins"><td>'.$player['t_wins'].'</td><td class="center">WINS</td><td>'.$settings['t_wins'].'</td></tr>';    
    $content.='<tr class="losses"><td>'.($player['t_bets']-$player['t_wins']).'</td><td class="center">LOSSES</td><td>'.($settings['t_bets']-$settings['t_wins']).'</td></tr>';    
    $content.='<tr class="wl"><td>'.sprintf("%.3f",$player['t_wins']/($player['t_bets']-$player['t_wins'])).'</td><td class="center">W/L RATIO</td><td>'.sprintf("%.3f",$settings['t_wins']/($settings['t_bets']-$settings['t_wins'])).'</td></tr>';    
    $content.='</table>';
    
    $content.='</div>';
  break;
  case 'chat':
    if ($settings['chat_enable']!=1) {
      $content.='
    <div class="chat-header">
        <div class="chat-title">Dicecoin Chat</div><div class="chat-close"><i class="fa fa-times"></i></div>
    </div>
    <div class="chat-history" id="chat-history">
    <i>Chat is not supported now.</i>
    </div>';
    }
    else {
      $content.='

      ';
      $content.='<br><br><br><input type="text" id="composeTxt"><button onclick="javascript:compose($(\'#composeTxt\').val());return false;" id="composeBtn">Send</button>';
      $content.='<div id="chatWindow"></div>';
      $content.='<script type="text/javascript">';
      $content.='initializeRefreshingFrameChat();';
      $content.='$("#composeTxt").keypress(function(e) { if (e.which==13) compose($("#composeTxt").val()); });';
      $content.='$("#composeTxt").qtip({content:{text:\'Press enter to send\'},style:{classes:\'qtip-bootstrap qtip-shadow\'},position:{my:\'bottom left\',at:\'top left\'}});';
      $content.='</script>';
    }
  break;
  case 'high_rollers':
    $all_bets=mysql_query("SELECT *,(`bet_amount`*`multiplier`) AS `profit_on_win` FROM `bets` WHERE `bet_amount`!=0 AND `win_lose`=1 ORDER BY `profit_on_win` DESC LIMIT 30");
    if (mysql_num_rows($all_bets)==0) $content.='<br><br><br><i>No one has bet yet.</i>';
    else {
      $content.='<div class="default-row headingrow">';
      $content.='<table id="bets_st_table">';
      $content.='<thead>';
      $content.='<tr>';
      $content.='<td>Result</td>';
      $content.='<td>Multiplier</td>';
      $content.='<td>Roll</td>';
      $content.='<td>Target</td>';
      $content.='<td>Bet</td>';
      $content.='<td>Profit</td>';
      $content.='</tr>';
      $content.='</thead>';
      $content.='</table>';
      $content.='</div>';
      $suda=0;
      while ($all_bet=mysql_fetch_array($all_bets)) {
        $content.=($suda==0)?'<tr>':'<tr class="suda">';
        
        if (mysql_num_rows(mysql_query("SELECT `id` FROM `players` WHERE `id`=$all_bet[player] LIMIT 1"))!=0)
          $username=mysql_fetch_array(mysql_query("SELECT `alias` FROM `players` WHERE `id`=$all_bet[player] LIMIT 1"));
        else $username['alias']='[unknown]';

        $chance['under']=floor((1/($all_bet['multiplier']/100)*((100-$settings['house_edge'])/100))*100)/100;
        $chance['over']=100-$chance['under'];

        $target=($all_bet['under_over']==0)?'<'.sprintf("%.2f",$chance['under']):'>'.sprintf("%.2f",$chance['over']);
        $profit=-$all_bet['bet_amount'];
        $profit_class='lose';
        $plusko=($all_bet['bet_amount']==0)?'-':'';
        if ($all_bet['win_lose']==1) {
          $profit+=$all_bet['bet_amount']*$all_bet['multiplier'];
          $profit_class='win';
          $plusko='+';
        }

        $content.='<div style="" class="default-row '. $profit_class .'">';
        $content.='<table>';
        $content.='<tbody>';
        $content.='<tr>';
        $content.= '<td class="color status">'. $profit_class .'</td>';
        $content.='<td>'.sprintf("%.2f",$my_bet['multiplier']).' x</td>';
        $content.='<td>'.sprintf("%.2f",$my_bet['result']).'</td>';
        $content.='<td>'.$target.'</td>';
        $content.='<td><i class="fa fa-btc"></i>'.sprintf("%.8f",$my_bet['bet_amount']).'</td>';
        $content.='<td class="color"><i class="fa fa-btc"></i>'.sprintf("%.8f",floor($profit*100000000)/100000000).'</td>';
        $content.='</tr>';
        $content.='</tbody>';
        $content.='</table>';
        $content.='</div>';
        $suda=($suda==0)?1:0;
      }
      $content.='</table>';
    }
  break;
}


echo json_encode(array('content'=>$content));
?>