<?php
require_once("/var/www/solari/api/src/functions.php");


class skill {

	public $module = "default_module";
	public $version = "0.0.1";
	public $title = "Default Module";
	public $description = "Default Description";
	public $enabled = false;

	public $text = null;
	public $convo_id = null;
	public $settings = null;
	public $original_text = "";
	public $forbidden_words= null;

	function __construct($arr0,$arr1,$arr2) {
		$this->text=urldecode($arr0);
		$this->convo_id=urldecode($arr1);
		$this->settings=urldecode($arr2);
		$temp=json_decode($this->settings);
		$this->original_text = $temp->original_text;
	}

        public function is_forbidden($forbiddennames, $string)
        {
                foreach ($forbiddennames as &$name){
                        if (strpos($string, $name) !== false) {return true;} 

                }
        return false;
        }


}




?>
