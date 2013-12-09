<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class timetables extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

	function __construct()
    {
        parent::__construct();
        
        //$this->load->model('timetables_model');
        
	}
	
	public function mytymetables() {
	    if (!$this->skeleton_auth->logged_in())
	        {
	        //redirect them to the login page
	        redirect($this->skeleton_auth->login_page, 'refresh');
	        }
            
            $header_data= $this->add_css_to_html_header_data(
				$this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
				$header_data,
                    base_url('assets/css/tribal-timetable.css'));        
            
            //<link href="css/docs.css" rel="stylesheet" />
            //<link href="css/tribal-bootstrap.css" rel="stylesheet" />
			//<link href="css/tribal-timetable.css" rel="stylesheet" />        
            //JS
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
                    
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.ba-resize.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-tooltip.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-collapse.js'));                
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-shared.js'));        
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-timetable.js'));
			
            $this->_load_html_header($header_data);
            $this->_load_body_header();                           
                                                                                
            $this->load->view('timetables/mytimetables');
    	    
            $this->_load_body_footer();       
    	                    
	}
	
	public function index() {
		$this->mytimetables();
	}
	
	
}
