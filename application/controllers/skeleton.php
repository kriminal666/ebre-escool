<?php defined('BASEPATH') OR exit('No direct script access allowed');


include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class skeleton extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

  	public $body_header_lang_file ='ebre_escool_body_header' ;
	
	function __construct()
    {
		parent::__construct();
	}
	
	public function index() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		redirect('dashboard','refresh');
		
	}
}
