<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class reports extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php';
	//public $html_header_view ='/include/ebre_escool_html_header.php';

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;
	public $body_footer_view ='include/ebre_escool_body_footer' ;


	public function load_header_data($menu = false){

		$active_menu = $menu;

		//CSS URLS
		$jquery_ui_css_url = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		$jquery_ui_editable_css_url = "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
		$select2_css_url = "http://cdn.jsdelivr.net/select2/3.4.5/select2.css";
		//JS URLS
		$jquery_url= "http://code.jquery.com/jquery-1.9.1.js";
		$jquery_ui_url= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$select2_url= "http://cdn.jsdelivr.net/select2/3.4.5/select2.js";
		$jquery_ui_editable_url= "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

		if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
  			$jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
  			$jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
  			$select2_css_url = base_url('assets/css/select2.css');

  			//$jquery_url= base_url('assets/js/jquery-1.9.1.js');
  			$jquery_url= base_url('assets/js/jquery-1.10.2.min.js');
			$jquery_ui_url= base_url('assets/js/jquery-ui.js');
			$select2_url= base_url('assets/js/select2.js');
			$jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			$jquery_ui_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$jquery_ui_editable_css_url);

		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$select2_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 

		
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

//ACE
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

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'));

/*        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));        


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));        
*/
		//JS Already load at skeleton main!!!
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_url);

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_url);	


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$select2_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_editable_url);


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

 //ACE        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));
                    
/*
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));
*/

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'));

		$header_data['menu']= $active_menu;
		return $header_data; 
        
    }
	
	function __construct()
    {
        parent::__construct();
        
        /*
        $this->load->model('attendance_model');
        $this->load->model('timetables_model');
        $this->load->library('ebre_escool_ldap');

        $this->load->library('ebre_escool');

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		/*$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language','skeleton_auth');
		}
		$this->grocery_crud->set_language($current_language);
    	$this->lang->load('skeleton', $current_language);	       
    	
    	$this->lang->load('attendance', $current_language);	
    	
		$this->lang->load('managment', $current_language);        
		* */
        
	}

	function teacher_sheet() {
		echo "TODO";
	}

}
