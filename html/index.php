<?php
include("/var/www/solari/api/src/apicalls.php");

if (isset($_POST['say'])) {
$settings_json='{"zip":"'.$_POST['zip'].'","country":"'.$_POST['country'].'","npr_channel":"'.$_POST['npr_channel'].'","timezone":"'.$_POST['timezone'].'","engine":"'.$_POST['engine'].'","convo_id":"'.$_POST['convo_id'].'","units":"'.$_POST['units'].'"}';
$settings_array=json_decode($settings_json,true);
$query=solari_ask($accepted_key,base64_encode($settings_json),base64_encode($_POST['say']));
$result="User: ".base64_decode($query->usersay)."<br />Solari: ".$query->botsay;

}

?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="./favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Solari Test</title>
    <meta name="Description" content="A Free Open Source AIML PHP MySQL Chatbot called Program-O. Version2" />
    <meta name="keywords" content="Open Source, AIML, PHP, MySQL, Chatbot, Program-O, Version2" />
    <style type="text/css">
      body{
        height:100%;
        margin: 0;
        padding: 0;
      }
      #responses {
        width: 90%;
        min-width: 515px;
        height: auto;
        min-height: 150px;
        max-height: 500px;
        overflow: auto;
        border: 3px inset #666;
        margin-left: auto;
        margin-right: auto;
        padding: 5px;
      }
      #input {
        width: 90%;
        min-width: 535px;
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
      }
      #shameless_plug {
        position: absolute;
        right: 10px;
        bottom: 10px;
        border: 1px solid red;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: 2px 2px 2px 0 #808080;
        padding: 5px;
        border-radius: 5px;
      }
      #convo_id {
        position: absolute;
        top: 10px;
        right: 10px;
        border: 1px solid red;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: 2px 2px 2px 0 #808080;
        padding: 5px;
        border-radius: 5px;
      }
    </style>
  </head>
  <body onload="document.getElementById('say').focus()">
    <h3>Solari</h3>
    <form name="chatform" method="post" action="index.php#end" onsubmit="if(document.getElementById('say').value == '') return false;">
      <div id="input">
        <label for="say">Say:</label>
        <input type="text" name="say" id="say" size="70" />
        <input type="submit" name="submit" id="btn_say" value="say" />
      </div>
    <div id="responses">
      <?php echo $result . '<div id="end">&nbsp;</div>' . PHP_EOL ?>


<?php

if (isset($result)){

$tts=solari_tts($accepted_key,$settings_array["engine"],$query->botsay);
$ttsresult=$tts->base64;
echo '<audio src="' . $ttsresult . '" autoplay="autoplay"></audio>';
}
?>



    </div>
	
  <br />
  <br />
Zip Code <input type="text" name="zip" value="28645" /><br />
Country  <input type="text" name="country" value="US" /><br />
NPR_Channel <input type="text" name="npr_channel" value="1003" /><br />
Timezone <input type="text" name="timezone" value="America/New_York" /><br />
Engine <input type="text" name="engine" value="1" /><br />
convo_id <input type="text" name="convo_id" value="default" /><br />
units <input type="text" name="units" value="imperial" /><br />
<br />
    </form>
  </body>
</html>
