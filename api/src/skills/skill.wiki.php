<?php
require_once ("skill.class.php");


class wiki extends skill {
        public $module = "Wikipedia";
        public $version = "0.0.1";
        public $title = "Wikipedia processing module";
        public $description = "The Wikipedia module gives you access to a RESTful wiki api";
        public $enabled = true;
	
        private $api_url = "";

        public $forbidden_words=array("news","date","time","weather","your","my name");

        private function check_intent() {
		 if((strpos($this->text,"wiki") !== false || strpos($this->text,"wikipedia") !== false || strpos($this->text,"what is ") !== false ) && $this->is_forbidden($this->forbidden_words,$this->text)===false){return true;}else {return false;}
        }

        private function get_output(){

		if (strpos($this->text,"wiki") !== false || strpos($this->text,"wikipedia") !== false ){
		$myarg=substr($this->text,strpos($this->text," for ")+5);
		}
		elseif(strpos($this->text,"what is ") !== false ){
			$wordlist=array("what is a ", "what is an ", "what is the ");
			foreach($wordlist as &$word){
				$word = '/\b'. preg_quote($word, '/') . '\b/';
			}
		$tmptxt = preg_replace($wordlist,'what is ',$this->text);
		$myarg=substr($tmptxt,strpos($tmptxt,"what is ")+8);
		}

		$this->api_url="https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro=&explaintext=&format=json&titles=".$myarg;
		$value=CallAPI("GET", $this->api_url);
                $newval="";
                $x=json_decode($value);$x=current((array)$x->query->pages);$x=$x->extract;$x=strtok($x, "\n");
                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$x.'"}';;
		
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
