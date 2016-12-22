<?php
require_once ("skill.class.php");


class zzz_default extends skill {
        public $module = "Default";
        public $version = "0.0.1";
        public $title = "Default processing module";
        public $description = "The Default processing module.";
        public $enabled = true;

        private $api_url = "";

        private function check_intent() {
                //Always return true
                return true;
        }

        private function get_output(){
                $value=null;
                $strings = array(
                        'I am afraid I don\'t understand.  Can you rephrase that?',
                        'I do not understand.  Can you ask that again differently?',
                        'I am unsure of what you mean. Can you reword the question?'
                );
                $key = array_rand($strings);
                $x=$strings[$key];

                $value='{"convo_id":"'.$this->convo_id.'",  "usersay":"'.$this->original_text.'", "botsay":"'.$x.'"}';;

                return $value;

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
