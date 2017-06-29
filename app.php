<?
session_start();
include("config.inc.php");

if(!$_SESSION['access_token']){
	header("Location: index.php");
	exit;
}

include("header.php");

$profile_url = $api_url . "/connect/profile?access_token=" . $_SESSION['access_token'];
$profile_info = kcurl($profile_url);

if($_GET['server_mode']){
  $server_mode = true;
}

if($_GET['logging']){
  $logging = true;
}

/// first step
if (!$_SESSION['account_id']){
$_SESSION['email'] = $profile_info->data->email;
$_SESSION['ctrader_id'] = $profile_info->data->userId;

$accounts_url = $api_url . "/connect/tradingaccounts?access_token=" . $_SESSION['access_token'];
$accounts_info = kcurl($accounts_url);
$accounts_array = (array) $accounts_info;
?>
 <div class="row">
    <div class="twelve columns">
    	<form method="post" action="session_creator.php">
    	<label>Select account:</label>
    	<select name="account_id">
    		<?
			 $_SESSION['all_accounts_data'] = $accounts_array['data'];

       foreach ($accounts_array['data'] as $single_account) {
			?>
			<option value="<?= $single_account->accountId ?>"><?= $single_account->accountNumber ?></option>
			<?
			}
			?>
    	</select>
    	<input type="hidden" name="type" value="accounts" />
    	<input type="submit" value="Confirm" />
    	</form>
    </div>
 </div>
<?
}
else{
/// second step
	
    $array['payloadType'] = 2000;
    $array['payload']['clientId'] = "60_4gmzw2ce4io0c08g4o0scgo8g4wo48s88gw8g4o88wgswo448w";
    $array['payload']['clientSecret'] = "5e0rds1cpf8cccwogcsgsc8cwgcsogo884cg80w8gwc0o8wocc";
    $json = json_encode($array);

    if (!$_SESSION['selected_symbol']){
      $symbol = "US2000";
    }
    else{
      $symbol = $_SESSION['selected_symbol'];
    }

    if ($symbol == "EURUSD"){
      $roundnumber = "5";
    }
    else{
      $roundnumber = "1";
    }

    $selected_symbols_arr[] = "US2000";
    $selected_symbols_arr[] = "UK100";
    $selected_symbols_arr[] = "US30";
    $selected_symbols_arr[] = "EURUSD";
    $selected_symbols_arr[] = "F40";
    $selected_symbols_arr[] = "DE30";
    $selected_symbols_arr[] = "US500";
    $selected_symbols_arr[] = "USTEC";



    $array2['payloadType'] = 2021;
    $array2['payload']['accountId'] = $_SESSION['account_id'];
    $array2['payload']['accountId'] = intval($array2['payload']['accountId']);
    $array2['payload']['accessToken'] = $_SESSION['access_token'];
    $array2['payload']['symblolName'] = $symbol;

    $json2 = json_encode($array2);

    $array3['payloadType'] = 2002;
    $array3['payload']['accountId'] = $_SESSION['account_id'];
    $array3['payload']['accountId'] = intval($array3['payload']['accountId']);
    $array3['payload']['accessToken'] = $_SESSION['access_token'];
    $json3 = json_encode($array3);

    $array4['payloadType'] = 2013 ;
    $array4['payload']['accessToken'] = $_SESSION['access_token'];
    $array4['payload']['accountId'] = $_SESSION['account_id'];
    $array4['payload']['accountId'] = intval($array4['payload']['accountId']);
    $array4['payload']['symbolName'] = $symbol;
    $array4['payload']['orderType'] = 1;
    $array4['payload']['tradeSide'] = 1; // BUY
    $array4['payload']['volume'] = 10000000;
    $array4['payload']['relativeTakeProfitInPips'] = 20;
    

    
    $json4 = json_encode($array4);




?>


<script> 




  function play_closing_sound() {
    document.getElementById('kding').play();
  }

  function play_opening_sound() {
      document.getElementById('kbleep').play();
  }

  
  function headlog(text){
    $(".header_console").html(text);
  }

  function klog(text, color){
    $(".kconsole").prepend("<span style=\"color:" + color + ";\">" + text + "</span><br />");
  }


  function kformat(value){
    var product = '<?= $symbol ?>';
    if (product == "EURUSD"){
      //var newvalue = parseFloat(value).toFixed(5);
      var newvalue = parseFloat(value);
    }
    else{
      var newvalue = parseFloat(Math.round(value * 100) / 100).toFixed(2);
    }
    return newvalue;
  }

  function dblog(value){
    var dataString = 'value='+ value + '&symbol=<?= $symbol ?>';
          $.ajax({
            type: "POST",
            url: "ajax/db_log.php",
            data: dataString,
            success: function(data) {
              console.log(data);
            }
        });
  }

  function devlog(text){
    <? if($_GET['developer']){ ?>
      $("#developer_console").prepend(text + "<br /><br />");
    <? } ?>
  }

  function send_notification(message){
    <?
    if($_GET['notifications']){
    ?>
    var dataString = 'message='+ message;
          $.ajax({
            type: "POST",
            url: "ajax/push_notifications.php",
            data: dataString,
            success: function(data) {
              //console.log(data);
            }
          });
    <?
    }
    ?>
  }


  function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
    var dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;   
     return dateTime;
  }

  

function checkTime() {
    var d = new Date(); // current time
    var hours = d.getHours();
    var mins = d.getMinutes();
    var day = d.getDay();
    <?
    if ($symbol == "EURUSD"){
    ?>
    return day >= 1
        && day <= 5
        && (hours > 2 || hours === 2 && mins >= 0)
        && (hours < 16 || hours === 16 && mins <= 0);
    <?
    }
    else {
    ?>
    return day >= 1
        && day <= 5
        && (hours > 9 || hours === 9 && mins >= 30)
        && (hours < 15 || hours === 15 && mins <= 30);
    <?
    }
    ?>

    
}

function checkResetTime() {
    var d = new Date(); // current time
    var hours = d.getHours();
    var mins = d.getMinutes();
    var day = d.getDay();
    
    <?
    if ($symbol == "EURUSD"){
    ?>
    return day >= 1
        && day <= 5
        && (hours === 1 && mins === 59);

    <?
    }
    else {
    ?>
    return day >= 1
        && day <= 5
        && (hours === 9 && mins === 29);
    <?
    }
    ?>
    

}

    /// global variables ///

    var echo_service = null;

    var api_url = 'wss://tradeapi.spotware.com:5033';
    //var api_url = 'wss://tradeapi-fr.spotware.com:5033';

    var megacounter = 0;

    var askPrice = 0;
    var bidPrice = 0;
    var oldBid = 0;
    var buyenabled = false;
    var is_position_open = false;
    var open_position_details = new Object;
    var timerenabled = false;
    
    var direction = null;
    var direction_before = null;
    var previous_val = 0;
    var just_changed = false;


    var trendstart = 0;
    var logged_arr = new Array;


    var prima_mm = 0;
    var seconda_mm = 0;
    var terza_mm = 0;

    var open_position_type = null;

    var first_arr = new Array;
    var second_arr = new Array;
    var third_arr = new Array;

    // Interface variable (init)
    
    var pipsprofit = 0;
    var ncontracts = 0;
    var mm1 = 0;
    var mm2 = 0;
    var mm3 = 0;

    var api_connected = false;
    var reconnect_timer = null;

    ///////

    





    function reconnect(){
      if (api_connected == false){
          send_notification("Re-connecting to " + api_url);
          devlog("Re-connecting to " + api_url);
          ktrade();
        }
    }


    function close_position(){
      var order_json = '{"payloadType":2018, "payload":{"accessToken":"<?= $_SESSION['access_token'] ?>","accountId":<?= $_SESSION['account_id'] ?>, "volume":' + ncontracts + ', "positionId": '+ open_position_details['pid']  + '}}';
      devlog("CLOSING POSITION");
      console.log("CLOSING POSITION");
      devlog(order_json);
      echo_service.send(order_json);
    }


    function updateInterface(){
      
      console.log("update");
      
      // interface variables
      
      pipsprofit = $("#pips_profit").val();
      pipsprofit = parseInt(pipsprofit);

      
      

      ncontracts = $("#n_contracts").val();
      ncontracts = parseInt(ncontracts);
      
      <?
      if ($symbol == "EURUSD"){
      ?>
      ncontracts = ncontracts * 10000000;
      <?
      }
      else {
      ?>
      ncontracts = ncontracts * 100;
      <?  
      }
      ?>

      mm1 = $("#mm1").val();
      mm1 = parseInt(mm1);

      mm2 = $("#mm2").val();
      mm2 = parseInt(mm2);

      mm3 = $("#mm3").val();
      mm3 = parseInt(mm3);
      //


      
      

    }


    function pinger(){
      var ping_json = '{"payloadType":52, "payload":{"timestamp":' + Date.now() + '}}';
      echo_service.send(ping_json);
      devlog(ping_json);
    }


    function ktrade(){

    

    echo_service = new WebSocket(api_url); 

    updateInterface();
    

    var initial_json = '<?= $json  ?>';
    var json2 = '<?= $json2  ?>';
    var json3 = '<?= $json3  ?>';
    var json4 = '<?= $json4  ?>';

    var access_token = '<?= $_SESSION['access_token'] ?>';
    var account_id = <?= $_SESSION['account_id']; ?>;

    
    $("button#ktest").on("click", function() {
       echo_service.send(json4);  
       devlog(json4);
    });

    

    $("button#ktest3").on("click", function() {
       close_position();
    });

    var pinger_timer = null;


    

    echo_service.onmessage = function(event){
      //console.log(event);
      //console.log(event.data); 
      devlog(event.data);
      
      var parsed_obj = JSON.parse(event.data);

      if(parsed_obj.payloadType == 2001){
        headlog("API Authentication: OK");
        echo_service.send(json2); // Subscribe to Symbol
        devlog(json2);
        echo_service.send(json3); // Subscribe to Trading Events
        devlog(json3);
      }
      else if(parsed_obj.payloadType == 2022){
        headlog("<span style=\"color: green; font-size: 30px; line-height: 0; position: relative; top: 7px;\">•</span> Connected to <?= $symbol ?>");
        pinger_timer = setInterval(function(){ pinger() }, 5000);
        api_connected = true;
        clearTimeout(reconnect_timer);
      }
      else if(parsed_obj.payloadType == 50){
        close_position();
      }
      else if(parsed_obj.payloadType == 2029){
        
        var symbolObj = parsed_obj.payload;

        if (symbolObj.askPrice != undefined){
          askPrice = symbolObj.askPrice;
        }
        
        if (symbolObj.bidPrice != undefined){
          bidPrice = symbolObj.bidPrice;
        }

        if (bidPrice != 0){
          var bidPriceX = parseFloat(bidPrice).toFixed(<?= $roundnumber ?>);
          var bidDifference = bidPrice - oldBid;
          
            if (bidDifference > 0){
              var showSign = "+";
              var color = "green";
            }
            else{
              var showSign = "";
              var color = "red";
            }

          var bidDifferenceX = parseFloat(bidDifference).toFixed(<?= $roundnumber ?>);
          var dateX = new Date().toTimeString().split(" ")[0];
          if (bidDifference != bidPrice){
            klog(bidPriceX + " • " + dateX + " • " + showSign + bidDifferenceX, color);
            <? if ($logging){ ?>
            //dblog(bidPriceX);
            dblog(bidPrice);
            <? } ?>
          }
          oldBid = bidPrice;
        } 


        logged_arr.push(bidPrice);

        first_arr = logged_arr.slice((mm1+1) * -1);
        second_arr = logged_arr.slice((mm2+1) * -1);
        third_arr = logged_arr.slice((mm3+1) * -1);


        if(prima_mm != 0){
          if(first_arr.length == mm1+1){
            prima_mm = (prima_mm * mm1 - first_arr[0] + bidPrice) / mm1;
          }
          else{
            prima_mm = (prima_mm * (logged_arr.length -1 ) + bidPrice) / logged_arr.length;
          }
        }
        else{
          prima_mm = bidPrice;
        }

        if(seconda_mm != 0){
          if(second_arr.length == mm2+1){
            seconda_mm = (seconda_mm * mm2 - second_arr[0] + bidPrice) / mm2;
          }
          else{
            seconda_mm = (seconda_mm * (logged_arr.length -1 ) + bidPrice) / logged_arr.length;
          }
        }
        else{
          seconda_mm = bidPrice;
        }

        if(terza_mm != 0){
          if(third_arr.length == mm3+1){
            terza_mm = (terza_mm * mm3 - third_arr[0] + bidPrice) / mm3;
          }
          else{
            terza_mm = (terza_mm * (logged_arr.length -1 ) + bidPrice) / logged_arr.length;
          }
        }
        else{
          terza_mm = bidPrice;
        }


        prima_mm = kformat(prima_mm);
        seconda_mm = kformat(seconda_mm);
        terza_mm = kformat(terza_mm);

        var prima_diff = kformat(prima_mm - seconda_mm);
        var seconda_diff = kformat(prima_mm - terza_mm);

        if (prima_diff > 0 && seconda_diff > 0){
          direction = "buy";
        }
        else if (prima_diff < 0 && seconda_diff < 0){
          direction = "sell";
        }
        

        if (direction != direction_before && direction != null && direction_before != null){
          just_changed = true;
          if (is_position_open){
            close_position();
          }
        }


        if (is_position_open){
          // disabling this feature - closing only on direction change 11.10.16
          /*
          if (open_position_type == "regular"){
            if (open_position_details.positionType == 1 && (prima_diff < 0 || seconda_diff < 0)){
              close_position();
            }
            if (open_position_details.positionType == 2 && (prima_diff > 0 || seconda_diff > 0)){
              close_position();
            }
          }
          if (open_position_type == "inverted"){
            if (open_position_details.positionType == 1 && (prima_diff > 0 || seconda_diff > 0)){
              close_position();
            }
          }
          */
        }
        else{
          if(buyenabled && is_position_open == false){
              if (!just_changed){
                  if (bidPrice < previous_val && direction == "sell"){
                      var order_json = '{"payloadType":2013, "payload":{"accessToken":"<?= $_SESSION['access_token'] ?>","accountId":<?= $_SESSION['account_id'] ?>,"symbolName":"<?= $symbol ?>","orderType":1, "tradeSide":2,"volume":' + ncontracts + '}}';
                      devlog("SELL");
                      devlog(order_json);
                      echo_service.send(order_json);
                      open_position_type = "regular";
                      is_position_open = true;
                  }

                  if (bidPrice > previous_val && direction == "buy"){
                      var order_json = '{"payloadType":2013, "payload":{"accessToken":"<?= $_SESSION['access_token'] ?>","accountId":<?= $_SESSION['account_id'] ?>,"symbolName":"<?= $symbol ?>","orderType":1, "tradeSide":1,"volume":' + ncontracts + '}}';
                      devlog("BUY");
                      devlog(order_json);
                      echo_service.send(order_json);
                      open_position_type = "regular";
                      is_position_open = true;
                  }

              }
          }

        }






        

        if (timerenabled){

          if(checkResetTime()){
            $(".kconsole").html("");
            is_position_open = false;
            trendstart = 0;
            direction = null;

            prima_mm = 0;
            seconda_mm = 0;
            terza_mm = 0;

            first_arr = new Array;
            second_arr = new Array;
            third_arr = new Array;

            logged_arr = new Array;

            megacounter = 0;

            console.log("RESETTING");




          }

          if (checkTime()){
            if ($("#enable_buy_sell").attr("status") == "off"){
              $("#enable_buy_sell").click();
              send_notification("Ktrade Enabled");
            }
          
            

          }
          else{
            if ($("#enable_buy_sell").attr("status") == "on"){
              $("#enable_buy_sell").click();
              if (is_position_open){
                close_position();
              }
            }
          }
        }

        megacounter++;

        ///// Logging variables
        
        var log_object = new Object;

        log_object.number = megacounter;
        log_object.thetime = dateX;
        log_object.bidprice = bidPrice;
        log_object.prima_mm = prima_mm;
        log_object.seconda_mm = seconda_mm;
        log_object.terza_mm = terza_mm;
        log_object.prima_diff = prima_diff;
        log_object.seconda_diff = seconda_diff;
        log_object.direction = direction;
        log_object.positiontype = open_position_type;


        console.log(log_object);

        /////

        // Resets

        direction_before = direction;
        previous_val = bidPrice;
        just_changed = false;

        ///

      }

      else if(parsed_obj.payloadType == 2016){
        
        var payload_details = parsed_obj.payload;
        var position_details = payload_details.position;
        var order_details = payload_details.order;

        
        if (payload_details.executionType == 2){
          
          if (order_details.closePositionDetails){
            var closeDetails = order_details.closePositionDetails;
            var curBalance = closeDetails.balance / 100;
            // CHIUSURA
            $("span#account_balance").html(curBalance);
            $("span.balance_zone").show();
            $(".open_position_zone").hide();
            devlog("CLOSING");
            //send_notification("Position Closed");
            send_notification("Balance: " + curBalance);
            is_position_open = false;
            trendstart = 0;
            direction = null;
            direction_before = null;
            open_position_type = null;
          }
          else {
            // APERTURA
            devlog("OPENING");
            console.log("OPENING");

            open_position_details.positionType = position_details.tradeSide;
            open_position_details.entryPrice = position_details.entryPrice;
            open_position_details.entryTime = getDateTime();
            open_position_details.pid = position_details.positionId;
            open_position_details.ncontracts = position_details.volume / 100;

            

            if (open_position_details.positionType == 1){
              var position_type_text = "BUY";
            }
            else if (open_position_details.positionType == 2){
              var position_type_text = "SELL";
            }

            send_notification("Open position: " + position_type_text);

            console.log(open_position_details);

            $("#op_position_type").html(position_type_text);
            $("#op_entry_price").html(open_position_details.entryPrice);
            $("#op_entry_time").html(open_position_details.entryTime);
            $("#op_n_contracts").html(open_position_details.ncontracts);
            $(".open_position_zone").show();
          }

        }

        if (payload_details.executionType == 5){
            open_position_details.takeProfitPrice = position_details.takeProfitPrice;
            $("#op_closing_price").html(open_position_details.takeProfitPrice);
        }

      

      } 

      else{
        //console.log("other");
      }


      //echo_service.close();
      
    } 
    echo_service.onopen = function(){
      headlog("Connected to Spotware API") 
      send_notification("Connected to API");
      echo_service.send(initial_json);
    } 
    echo_service.onclose = function(){
      headlog("Connection closed");
      clearTimeout(pinger_timer);
      send_notification("Connection Closed");
      api_connected = false;
      
      reconnect_timer = setTimeout(function() { 
        reconnect(); 
      }, 5000);
      
    } 
    echo_service.onerror = function(){
      headlog("Connection Error");
    }
    

  }


$(document).ready(function() {

  // Triggers

    $("#enable_buy_sell").on("click", function() {
      var thisstatus = $(this).attr("status");
      if (thisstatus == "off"){
        $(this).addClass("green");
        $("#enable_buy_sell").html("Enabled");
        $(this).attr("status", "on");
        buyenabled = true;
      }
      else{
        $(this).removeClass("green");
        $("#enable_buy_sell").html("Disabled");
        $(this).attr("status", "off"); 
        buyenabled = false;
      }
    });

    $("a.timerbtn").on("click", function() {
      var thisstatus = $(this).attr("timer");
      if (thisstatus == "disabled"){
        $(this).find("img").css("opacity", "1");
        $(this).attr("timer", "enabled");
        timerenabled = true;
      }
      else{
        $(this).find("img").css("opacity", "0.4");
        $(this).attr("timer", "disabled");
        timerenabled = false; 
      }
      return false;
    });

    
    $("button#clear_console").on("click", function() {
        $(".kconsole").html("");
    });


    $("#n_contracts" ).change(function() {
      updateInterface();
    });

    $("#mm1" ).change(function() {
      updateInterface();
    });

    $("#mm2" ).change(function() {
      updateInterface();
    });

    $("#mm3" ).change(function() {
      updateInterface();
    });

    
    ///////


    ktrade();



});


  </script> 

<div class="row">
  <div class="six columns">
    <div class="kconsole">
    </div>
  </div>

  <div class="three columns">
      
      <div class="mobile_vspacer"></div>

      <?
      if ($server_mode){
        $default_parameter['profit'] = "30";
        $default_parameter['ncontracts'] = "50";
        $default_parameter['mm1'] = "10";
        $default_parameter['mm2'] = "20";
        $default_parameter['mm3'] = "30";
      }
      else{
        $default_parameter['profit'] = "30";
        $default_parameter['ncontracts'] = "2";
        $default_parameter['mm1'] = "300";
        $default_parameter['mm2'] = "2000";
        $default_parameter['mm3'] = "5000";
        
      }

      ?>

      <label>N.Contracts:</label>
      <input id="n_contracts" type="number" value="<?= $default_parameter['ncontracts'] ?>" />

      <label>Media Mobile 1:</label>
      <input id="mm1" type="number" value="<?= $default_parameter['mm1'] ?>" />

      <label>Media Mobile 2:</label>
      <input id="mm2" type="number" value="<?= $default_parameter['mm2'] ?>" />

      <label>Media Mobile 3:</label>
      <input id="mm3" type="number" value="<?= $default_parameter['mm3'] ?>" />

      <label>BUY / SELL:</label>
      <button status="off" id="enable_buy_sell">Disabled</button>

      <a title="Automatically enable" href="" timer="disabled" class="timerbtn">
        <img src="images/clock.png" />
      </a>

      <br /><br />

      <button id="clear_console">Clear Console</button>

  </div>
  <div class="three columns">
      
      <div class="mobile_vspacer"></div>

      <label>Current Symbol:</label>
      <form method="post" action="session_creator.php">
        <select name="selected_symbol" onchange="this.form.submit()">
          <?
          foreach ($selected_symbols_arr as $single_symbol) {
          if ($single_symbol == $symbol){
            $selected = " selected ";
          }
          else{
            $selected = "";
          }
          ?>
          <option<?= $selected ?>><?= $single_symbol ?></option>
          <?
          }
          ?>
        </select>
        <input type="hidden" name="type" value="symbol" />
      </form>

      <? if($_GET['developer'] && $kose){ ?>
      <br /><br />
      <button id="ktest">Order Test</button>
      <button id="ktest3">Close Position</button>
      <? } ?>

      <div class="open_position_zone">
        <center>
          <strong class="optitle">OPEN POSITION</strong>
        </center>
        <br />
        <table>
          
          <tr>
            <td><strong>Position Type:</strong></td>
            <td><span id="op_position_type">n</span></td>
          </tr>

          <tr>
            <td><strong>Entry Price:</strong></td>
            <td><span id="op_entry_price">0</span></td>
          </tr>

          <tr>
            <td><strong>Entry Time:</strong></td>
            <td><span id="op_entry_time">0</span></td>
          </tr>

          <tr>
            <td><strong>N.Contracts:</strong></td>
            <td><span id="op_n_contracts">0</span></td>
          </tr>
        </table>
      </div>

  </div>
  

</div>


<div class="row">
  <div class="twelve columns" id="developer_console">
  </div>
</div>

<audio id="kding" src="audio/ding.mp3" preload="auto"></audio>
<audio id="kbleep" src="audio/bleep.mp3" preload="auto"></audio>


<?
}
///

include("footer.php");
?>