<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$path = FCPATH;
$path .= "/application/controllers/skeleton_main.php";

include_once($path);

class inventory extends skeleton_main {


function __construct()	{
		parent::__construct();

	}	

public function index()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	$header_data= $this->add_css_to_html_header_data(
		$this->_get_html_header_data(),
		"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
	//JS
	$header_data= $this->add_javascript_to_html_header_data(
		$header_data,
		"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
		$header_data,
		"http://code.jquery.com/ui/1.10.3/jquery-ui.js");
	
	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
			
    $this->load->view('inventory',$output);


	$this->_load_body_footer();

	}
	
}
 
/* End of file inventory.php */
/* Location: ./application/modules/inventory/controllers/inventory.php */