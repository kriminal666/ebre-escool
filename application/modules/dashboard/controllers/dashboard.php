<?php defined('BASEPATH') OR exit('No direct script access allowed');


include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class dashboard extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;

	public $body_footer_view ='include/ebre_escool_body_footer' ;

	public function load_header_data(){

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			"http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css");
		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			"http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 
		
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/ace-fonts.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/ace.min.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/ace-responsive.min.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/ace-skins.min.css'));

		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));
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
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));

		return $header_data; 
        
    }

	
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

		$header_data = $this->load_header_data();
        $this->_load_html_header($header_data);

        /*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();
		
		$this->load->view('dashboard'); 
                
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		 
	}		
}
