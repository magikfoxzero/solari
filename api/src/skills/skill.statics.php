<?php
require_once ("skill.class.php");


class zy_statics extends skill {
        public $module = "Statics";
        public $version = "0.0.1";
        public $title = "Static Routes processing module";
        public $description = "The Statics module gives you access to customize the bot.";
        public $enabled = true;

        private $api_url = "";

        private function check_intent() {
		//Always return true
		return true;
        }

        private function get_output(){
		$x = "";
		if(strpos($this->text,"pootinwiggles") !== false  ){$x="I like the way you talk.";}

                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$x.'"}';;
		if($x!=null){return $value;}else{return null;}

        }
        public function process(){
                $intent_check = $this->check_intent();
                if ($intent_check !== false){
                        $value=$this->get_output();

			if ($value!=null){return $value;}else{return null;}
                }
                        else
                {
                        return null;
                }

        }

}


?>
