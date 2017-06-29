<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>KTRADE</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- JQUERY
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script src="js/jquery-2.2.3.min.js"></script>

  

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">


    <div class="row">
      <div class="six columns">
        <img style="width:100px; margin-left:-9px; height:auto;" src="images/ktrade-logo.png">
      </div>
      <div class="three columns header_account">
      <?
      if ($_SESSION['account_details']->live == 1){
        $theword = " - LIVE";
      }
      else{
        $theword = " - DEMO";
      }
      if ($_SESSION['account_details']){
      ?>
      Account: <?= $_SESSION['account_details']->accountNumber; ?> (<?= $_SESSION['account_details']->brokerTitle  ?><?= $theword ?>) <br /><span class="balance_zone">Balance: &euro; <span id="account_balance">-</span></span>
      <?
      }
      ?>
      </div>
      <div class="three columns header_console">
      </div>
    </div>