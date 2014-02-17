<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";

class skeleton extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

  	public $body_header_lang_file ='ebre_escool_body_header' ;

  	public $html_header_view ='include/ebre_escool_html_header' ;

	public $body_footer_view ='include/ebre_escool_body_footer' ;
	
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
