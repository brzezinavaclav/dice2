<link href="//fonts.googleapis.com/css?family=Lora:700" rel="stylesheet" xmlns="http://www.w3.org/1999/html">
    <link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/emojione/1.3.0/assets/css/emojione.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="https://dicecoin.io/images/favicon.png">

    <!--[if IE]>
    <link rel="icon" href="https://dicecoin.io/images/favicon.ico" type="image/x-icon" />
    <![endif]-->


<body>
<div class="wrapper">
    <div class="mainCanteiner">
        <div class="header adaptive-block">
            <div class="logo">
                <a href="http://<?php echo $settings['url']; ?>">
                    <img src="themes/DiceCoin2/images/logo.png" alt="<?php echo $settings['title']; ?>" title="<?php echo $settings['title']; ?>">
                </a>
            </div>
            <div class="user-menu">
                <?php if ($settings['inv_enable']==1) { ?><a href="#" onclick="javascript:return invest();">INVEST</a><?php } ?>
                <a href="#" onclick="javascript:return fair();">FAIR?</a>
                <a href="#" onclick="javascript:return account();">ACCOUNT</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="winner-alert">
            <div class="winner-text">We Have New Winner!</div>
            <div class="winner-amount">
                <i class="fa fa-btc"></i><span>0.197</span>
            </div>
            <div class="winner-player">Player
                <span><a href="#">Ajewad</a> won</span>
            </div>
        </div>
        <div class="content main adaptive-block">
            <div id="tab_bet">
                <div class="main-ui-row">
                    <ul role="tablist" class="nav nav-tabs">
                        <li role="presentation" class="tab active"><a href="#manual" aria-controls="manual" role="tab" data-toggle="tab">Manual bet</a></li>
                        <li role="presentation" class="tab"><a href="#automatic" aria-controls="automatic" role="tab" data-toggle="tab">Automatic bet</a></li>
                    </ul>
                </div>
                <div class="total-info">
                    <div class="game-info">
                        <div class="tab-content">
                            <div class="select info-block">
                                <div class="block-content value">
                                    <table>
                                        <thead>
                                        <tr>
                                            <td><span id="under_over_txt">Roll under</span></td>
                                            <td class="second">Multiplier</td>
                                            <td class="third">Win chance</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td onclick="javascript:inverse();" style="font-weight: 300; font-size: 21px;cursor: pointer;"><span id="under_over_num">49.50</span></td>
                                            <td class="second"><input type="text" id="betTb_multiplier" value="2.00"><span class="input_addon">X</span></td>
                                            <td class="third"><input type="text" id="betTb_chance" value="49.50"><span class="input_addon">%</span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            <div role="tabpanel" class="tab-pane active" id="manual">
                                    <div class="play-block">
                                        <input  id="bt_wager" class="input"  placeholder="Input Bet" required="" autofocus="" type="text"  value="0.00000000">
                                        <div class="choise">
                                            <div class="block-content">
                                                <div class="mbet blue b2x"><a href="#" onclick="javascript:clickdouble();return false;" class="bt_button double rightSep">2x</a></div>
                                                <div class="mbet blue" id="bet_max"><a href="#" onclick="javascript:maxProfit();return false;" class="bt_button max">Bet Max</a></div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                <a href="#" onclick="javascript:place($('#bt_wager').val(),$('#betTb_multiplier').val(),false);return false;" id="betBtn" class="button roll-dice">ROLL DICE</a>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="automatic">
                                <form action="#" id="auto_form">
                                    <div class="auto-play-block">
                                        <div class="row">
                                            <input class="input" id="bt_wager_bB" placeholder="Base bet" type="text">
                                            <input class="input" id="bB_max_loss_val" placeholder="Max loss" type="text">
                                            <input class="input" id="bB_max_win_val" placeholder="Max Profit" type="text">
                                        </div>
                                        <div class="row">
                                            <div style="width: 145px; float: left;">
                                                <div style="padding-left: 3px">
                                                    <label>Operate</label>
                                                    <br>
                                                    <input id="bB_operate_rolls" class="bB_checkbox" type="checkbox" checked="checked">
                                                    <label for="bB_operate_rolls" class="bB_label"><small>Rolls</small></label>
                                                </div>
                                                <div style="padding-left: 3px">
                                                    <input id="bB_operate_secs" class="bB_checkbox" type="checkbox">
                                                    <label for="bB_operate_secs" class="bB_label"><small>Seconds</small></label><br>
                                                </div>
                                                <input class="input" id="bt_rolls_bB" placeholder="100" type="text" style="margin-top: 10px;">
                                            </div>
                                            <div style="width: 145px; float: left;">
                                                <div style="padding-left: 3px">
                                                    <label>On loss</label>
                                                    <br>
                                                    <input class="input" id="bB_loss_return" class="bB_checkbox" type="checkbox">
                                                    <label for="bB_loss_return" class="bB_label"><small>Return to Base</small></label>
                                                </div>
                                                <div style="padding-left: 3px">
                                                    <input id="bB_loss_increase" class="bB_checkbox" type="checkbox" checked="checked">
                                                    <label for="bB_loss_increase" class="bB_label"><small>Increase Bet by:</small></label><br>
                                                </div>
                                                <input class="input" type="text" id="bB_loss_increase_by" placeholder="0.00" style="margin-top: 10px;">
                                            </div>
                                            <div style="width: 140px; float: left;">
                                                <div style="padding-left: 3px">
                                                    <label>On win</label>
                                                    <br>
                                                    <input class="input" id="bB_win_return" type="checkbox" checked="checked">
                                                    <label for="bB_win_return" class="bB_label"><small>Return to Base</small></label>
                                                </div>
                                                <div style="padding-left: 3px">
                                                    <input id="bB_win_increase" type="checkbox">
                                                    <label for="bB_win_increase" class="bB_label"><small>Increase Bet by:</small></label><br>
                                                </div>
                                                <input class="input" type="text" id="bB_win_increase_by" placeholder="0.00" style="margin-top: 10px;">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" onclick="javascript:startAutomat();return false;" id="botBtn" class="button roll-dice">Start</a>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="player-info">
                        <div class="player-table">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="label">Login:</div>
                                </div>
                                <div class="col-xs-8">
                                    <span class="blue"><a href="#" id="login"><?php echo $player['alias']; ?></a></span>
                                    <a onclick="javascript:return account();" id="change_login" title="Change login" class="fa fa-pencil"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="label">Password:</div>
                                </div>
                                <div class="col-xs-8">
                                    <span id="password"><?php if ($player['password']!='') echo 'Yes'; else echo 'No'; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="label">Bets:</div>
                                </div>
                                <div class="col-xs-8">
                                    <span id="bets"><?php echo $player['t_bets'];?></span> - <span class="green" id="wins"><?php echo $player['t_wins'];?></span> / <span class="red" id="loses"><?php echo ($player['t_bets']-$player['t_wins']);?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="label">Your balance:</div>
                                </div>
                                <div class="col-xs-8">
                                    <i class="fa fa-btc"></i><strong id="balance" data-balance="">0</strong>
                                </div>
                            </div>
                            <div data-original-title="Awaiting 1 confirmation(s)" id="pending_balance" class="row unconfirmed" title="" data-toggle="tooltip" data-placement="top" style="display:none" "="">
                            <div class="col-xs-4">
                                <div class="label">Pending balance:</div>
                            </div>
                            <div class="col-xs-8">
                                <i class="fa fa-btc"></i><strong id="unconfirmed_balance">0</strong>
                            </div>
                        </div>
                    </div>

                    <div class="buttons-group player-group">
                        <span class="buttons-group-glued">
                        <a class="button deposit deposit-block" href="#" onclick="javascript:return deposit();">DEPOSIT</a>
                        <a id="faucet" class="button faucet deposit-block" onclick="javascript:_stats_content('giveaway');return false;">FAUCET</a>
                        </span>
                        <a class="button withdraw withdraw-block" href="#" onclick="javascript:return withdraw();">WITHDRAW</a>
                        <a id="history" class="button history" onclick="javascript:return viewPending();"><span class="fa fa-align-justify"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="data downer" id="tab_bets" role="tabpanel">
            <ul id="content" class="nav nav-tabs stats_switcher" role="tablist">
                <li role="presentation"><a href="#" onclick="javascript:_stats_content('all_bets');return false;" id="_st_all_bets">All bets</a></li>
                <li role="presentation"><a href="#" onclick="javascript:_stats_content('my_bets');return false;" id="_st_my_bets">My bets</a></li>
                <li role="presentation"><a href="#" onclick="javascript:_stats_content('high_rollers');return false;" id="_st_high_rollers">High Rollers</a></li>
            </ul>
            <div id="all" class="stats">
                <div id="content">
                </div>
            </div>
        </div>

        </div>
    </div>
<div class="footer">
    <div class="copyright">&copy; <?php echo Date('Y').' '.$settings['title']; ?>. All rights reserved.</div>
    <div class="links">
        <a href="/admin">Login</a>
        <a href="#">Contact</a>
        <a href="https://bitcointalk.org/index.php?topic=463273.0">Bitcointalk</a>
        <a href="#">Facebook</a>
        <a href="#">Terms of Use</a>
    </div>
    <div class="clear"></div>
</div>
<script>
    (function() {

        'use strict';

        /**
         * tabs
         *
         * @description The Tabs component.
         * @param {Object} options The options hash
         */
        var tabs = function(options) {

            var el = document.querySelector(options.el);
            var tabNavigationLinks = el.querySelectorAll(options.tabNavigationLinks);
            var tabContentContainers = el.querySelectorAll(options.tabContentContainers);
            var activeIndex = 0;
            var initCalled = false;

            /**
             * init
             *
             * @description Initializes the component by removing the no-js class from
             *   the component, and attaching event listeners to each of the nav items.
             *   Returns nothing.
             */
            var init = function() {
                if (!initCalled) {
                    initCalled = true;
                    for (var i = 0; i < tabNavigationLinks.length; i++) {
                        var link = tabNavigationLinks[i];
                        handleClick(link, i);
                    }
                }
            };

            /**
             * handleClick
             *
             * @description Handles click event listeners on each of the links in the
             *   tab navigation. Returns nothing.
             * @param {HTMLElement} link The link to listen for events on
             * @param {Number} index The index of that link
             */
            var handleClick = function(link, index) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToTab(index);
                });
            };

            /**
             * goToTab
             *
             * @description Goes to a specific tab based on index. Returns nothing.
             * @param {Number} index The index of the tab to go to
             */
            var goToTab = function(index) {
                if (index !== activeIndex && index >= 0 && index <= tabNavigationLinks.length) {
                    tabNavigationLinks[activeIndex].classList.remove('active');
                    tabNavigationLinks[index].classList.add('active');
                    tabContentContainers[activeIndex].classList.remove('active');
                    tabContentContainers[activeIndex].classList.remove('in');
                    tabContentContainers[index].classList.add('active');
                    tabContentContainers[index].classList.add('in');
                    activeIndex = index;
                }
            };

            /**
             * Returns init and goToTab
             */
            return {
                init: init,
                goToTab: goToTab
            };

        };

        /**
         * Attach to global namespace
         */
        window.tabs = tabs;

    })();
    var tabBet = tabs({
        el: '#tab_bet',
        tabNavigationLinks: '.tab',
        tabContentContainers: '.tab-pane'
    });
    tabBet.init();

</script>