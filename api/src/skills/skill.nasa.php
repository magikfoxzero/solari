<?php
require_once ("skill.class.php");


class nasa_news extends skill {
        public $module = "Nasa News";
        public $version = "0.0.1";
        public $title = "Nasa News processing module";
        public $description = "The News module gives you access to Nasa News";
        public $enabled = true;

        private $api_url = "";

        private function check_intent() {
		 if(strpos($this->text,"nasa") !== false  ){return "nasa";}else {return "empty";}
        }

        private function get_output($intent){
		$rssurl=null;
		if ($intent == "nasa breaking news"){$rssurl="https://www.nasa.gov/rss/dyn/breaking_news.rss";}
		else {$rssurl="https://www.nasa.gov/rss/dyn/breaking_news.rss";}
		
		
		$value=XmlToJson::Parse($rssurl);
                $newval="";
		$i=0;
                foreach(json_decode($value)->channel->item as &$myitem){
		if ($i < 15){
                $newval=strip_tags($newval . "".$myitem->title. ".  ". $myitem->description."\r\n\r\n");
                }
		$i++;
		}
		
		
                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$newval.'"}';;
                

		
		return $value;

        }
        public function process(){
                $intent_check = $this->check_intent();
                if ($intent_check != "empty"){
                        $value=$this->get_output($intent_check);
                        return $value;
                }
                        else
                {
                        return null;
                }

        }

}


?>
