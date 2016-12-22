<?php
require_once ("skill.class.php");


class news extends skill {
        public $module = "News";
        public $version = "0.0.1";
        public $title = "News processing module";
        public $description = "The News module gives you access to NPR News";
        public $enabled = true;

        private $api_url = "";

        private function check_intent() {
		 if(strpos($this->text,"news") !== false  ){return true;}else {return false;}
        }

        private function get_output(){
		$settings = json_decode($this->settings);
                $channel = $settings->npr_channel;

		$value=XmlToJson::Parse("http://www.npr.org/rss/rss.php?id=".$channel);
                $newval="";

		$i=0;
                foreach(json_decode($value)->channel->item as &$myitem){
		if ($i < 15){
                $newval=strip_tags($newval . "".$myitem->title. ".  ". $myitem->description."\r\n\r\n");
                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$newval.'"}';;
                }
		$i++;
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
