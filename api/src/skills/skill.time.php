<?php
require_once ("skill.class.php");


class date_time extends skill {
        public $module = "Time";
        public $version = "0.0.1";
        public $title = "Time processing module";
        public $description = "The Time module gives you access to processing questions about time";
        public $enabled = true;

	private $api_url = "";
	public $forbidden_words=array("appointment","my");

        private function check_intent() {
		 if((strpos($this->text,"time") !== false || strpos($this->text,"date") !== false || strpos($this->text,"day is it") !== false || strpos($this->text,"day is tomorrow") !== false ||strpos($this->text,"day was yesterday") !== false  ) && $this->is_forbidden($this->forbidden_words,$this->text)===false){return true;}else {return false;}
        }

        private function get_output(){

		$settings = json_decode($this->settings);
                $TZ = $settings->timezone;
		date_default_timezone_set($TZ);	

		 if(strpos($this->text,"time") !== false){ $value = "The current time is ".date('h:i A'); }
		 elseif(strpos($this->text,"date") !== false ) {$value = "The current date is is ".date('F j, Y.');}
		 elseif(strpos($this->text,"day is it") !== false){$value = "Today is ".date('l, F j, Y.'); }
                 elseif(strpos($this->text,"day is tomorrow") !== false){$value = "Tomorrow is ".date('l, F j, Y.',time()+86400); }
		elseif(strpos($this->text,"day was yesterday") !== false){$value = "Yesterday was ".date('l, F j, Y.',time()-86400); }
		

                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$value.'"}';;
		
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
