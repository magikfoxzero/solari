<?php
require_once ("skill.class.php");


class weather extends skill {
        public $module = "Weather";
        public $version = "0.0.1";
        public $title = "Weather processing module";
        public $description = "The Weather module gives you access to a RESTful weather api";
        public $enabled = true;

	public $weather_api_key ="";

        private $api_url = ""; //You will need to define this api key

        private function check_intent() {
		 if(strpos($this->text,"weather") !== false){return true;}else {return false;}
        }

        private function get_output(){
      		$settings = json_decode($this->settings);
		$COUNTRY = $settings->country;
		$ZIP = $settings->zip;
		$UNITS = $settings->units;
		$TZ = $settings->timezone;
                date_default_timezone_set($TZ); 


		if (strpos($this->text,"tomorrow") !== false){
		$this->api_url="http://api.openweathermap.org/data/2.5/forecast/daily?zip=".$ZIP.",".$COUNTRY."&APPID=".$this->weather_api_key."&units=".$UNITS;
		$value=CallAPI("GET", $this->api_url);
                $weather=json_decode($value); 
		
		$timestamp=strtotime('tomorrow noon');

		$list=$weather->list;
		$tomorrow = null;

		foreach($list as &$day){
		if ($day->dt==$timestamp){$tomorrow=$day;}
		}

		$max=$tomorrow->temp->max;
		$min=$tomorrow->temp->min;
		$text=$tomorrow->weather[0]->description;
		$city=$weather->city->name;	

		 if ($text=="clear sky"){$text="clear skies";}
                $value= "Tomorrow in ".$city.",  the weather will be ".$text." with a high of ".$max." degrees and a low of ".$min." degrees.  ";

                $value='{"convo_id":"'.$convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$value.'"}';

		} else {

		$this->api_url="http://api.openweathermap.org/data/2.5/weather?zip=".$ZIP.",".$COUNTRY."&APPID=".$this->weather_api_key."&units=".$UNITS."&mode=json";

		$value=CallAPI("GET", $this->api_url);
                $weather=json_decode($value); 

                $city=$weather->name;
                $current_temp=$weather->main->temp;
                $textdescr=$weather->weather[0]->description;
                $high=$weather->main->temp_max;
                $low=$weather->main->temp_min;
                $main=$weather->weather[0]->main;

                if ($textdescr=="clear sky"){$textdescr="clear skies";}
                $value= "Currently in ".$city.",  its ".$current_temp." degrees with ".$textdescr.".";
                $value='{"convo_id":"'.$convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$value.'"}';
		}
		return $value;

        }
        public function process(){
                $intent_check = $this->check_intent();
                if ($intent_check !== false){
                        $value=$this->get_output();
                        return $value;
                }
                        else
                {
                        return null;
                }

        }

}


?>
