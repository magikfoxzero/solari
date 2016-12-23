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

        private function get_output(){
		if ($intent == "nasa"){$newval="https://www.nasa.gov/rss/dyn/breaking_news.rss";}
                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$newval.'"}';;
                }
		$i++;
		}

		
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
