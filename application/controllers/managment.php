<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "skeleton_main.php";

class managment extends skeleton_main {
	
	function __construct()
    {
        parent::__construct();
        
        //$this->load->library('attendance');
        //$this->load->model('attendance_model');
        
	}
	
	public function massive_change_password() {
		if (!$this->skeleton_auth->logged_in())
		{
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
		
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
		
		$data['prova']="prova";
		
		$this->load->view('managment/massive_change_password',$data);
		
		$this->_load_body_footer();	
	}
	
	
	public function index() {
		$this->massive_change_password();
	}
	
	public function statistics_checkings_groups() {
		$skeleton_admin_group = $this->config->item('skeleton_admin_group','skeleton_auth');
		
		if (!$this->skeleton_auth->logged_in() || !
				$this->skeleton_auth->in_group($skeleton_admin_group))
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/css/jquery.dataTables.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/js/jquery.dataTables.min.js"));					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));				
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
		
		$data['prova']="prova";
		
		$this->load->view('managment/statistics_checkings_groups.php',$data);
		
		$this->_load_body_footer();	
	}
	
	public function statistics_checkings() {
		$this->statistics_checkings_groups();
	}
	
}
