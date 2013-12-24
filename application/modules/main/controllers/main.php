<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class main extends skeleton_main  {
	
	public $body_header_view ='include/ebre_escool_body_header.php' ;

  	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $preferences_page = "main/user_preferences";

}
