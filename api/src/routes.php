<?php
// Routes
require_once("solari_settings.php");
require_once("functions.php");

foreach (glob("/var/www/solari/api/src/skills/*.php") as $filename)
{
    require_once($filename);
}

require '../vendor/autoload.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

define('generalerror','{"status":"error","code":"-22","text":"Something went wrong."}');
define('incorrect_key','{"status":"error","code":"-1","text":"Incorrect API Key."}');

define('accepted_key', $SolariAPIKey);


$app->post('/tts', function (Request $request, Response $response) {   
         global $VoiceRSSKey;
         $parsedBody = $request->getParsedBody();
         $text = urldecode($parsedBody["text"]);
         $key=$parsedBody["key"];
         $engine=$parsedBody["engine"];
if ($key != accepted_key){$response = $response->withStatus(404);$response = $response->withHeader('Content-Type', 'application/json'); $response->getBody()->write(incorrect_key); return $response;} 

if ($engine=="auto"){
$engine=1;
if (strlen($text)>255){$engine=2;}
}

$OUTPUT = null;
if ($engine == 1){
$OUTPUT = shell_exec('/var/www/solari/api/src/tts.sh "'.$text.'" 2>&1');
$OUTPUT = trim(preg_replace('/\s\s+/','',$OUTPUT));
$OUTPUT = "data:audio/wav;base64,".str_replace(array(" ","\n","\r"),'',$OUTPUT);
}
elseif ($engine == 2){
require_once('library/voicerss_tts.php');
$tts = new VoiceRSS;
$voice = $tts->speech([
    'key' => $VoiceRSSKey,  
    'hl' => 'en-us',
    'src' => $text,
    'r' => '0',
    'c' => 'mp3',
    'f' => '44khz_16bit_stereo',
    'ssml' => 'false',
    'b64' => 'true'
]);

$OUTPUT=$voice['response'] ;
}
                $response = $response->withStatus(200);
                $response = $response->withHeader('Content-Type', 'application/json');
                $response->getBody()->write('{"base64":"'.$OUTPUT.'"}');
                return $response;
});



$app->post('/ask', function (Request $request, Response $response) {    
        $parsedBody = $request->getParsedBody();
         $text = urlencode($parsedBody["text"]);
	 $original_text = urldecode($text);
	$text=strtolower($text);
         $key=$parsedBody["key"];
	 $settings=urldecode(base64_decode($parsedBody["settings"]));
	$settings_array=json_decode($settings,true);
	$convo_id=$settings_array["convo_id"];
if ($key != accepted_key){$response = $response->withStatus(404);$response = $response->withHeader('Content-Type', 'application/json'); $response->getBody()->write(incorrect_key); return $response;} 

		$children = array();
		$value="";
		foreach( get_declared_classes() as $class ){
		  if( is_subclass_of( $class, 'skill' ) )
		    $children[] = $class;
		}

		sort($children);

		$i=0;

		foreach ($children as &$class) {
		        if ($i ==0 ){
		                $reflectionClass = new ReflectionClass($class);
                		$module = $reflectionClass->newInstanceArgs(array($text,$convo_id,'{"units":"'.$settings_array["units"].'","zip":"'.$settings_array["zip"].'","country":"'.$settings_array["country"].'","npr_channel":"'.$settings_array["npr_channel"].'","original_text":"'.$original_text.'", "timezone":"'.$settings_array["timezone"].'"}'));
		                $results=$module->process();    
                		if ($results != null && $module->enabled==1){$i=1;$value = $results;}
		        }
		}



                $response = $response->withStatus(200);
                $response = $response->withHeader('Content-Type', 'application/json');
                $response->getBody()->write($value);
                return $response;
});

