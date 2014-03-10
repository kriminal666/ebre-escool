<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class wizard extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header.php' ;
  public $body_header_lang_file ='ebre_escool_body_header' ;

	
	function __construct()
    {
        parent::__construct();
        
            /* Model */
            $this->load->model('wizard_model');

		    /* Set language */
		    $current_language=$this->session->userdata("current_language");
		    if ($current_language == "") {
		      $current_language= $this->config->item('default_language');
		    }
		    $this->lang->load('wizard', $current_language);	       

        //LANGUAGE HELPER:
        $this->load->helper('language');
	}



	public function wizard($study=false,$classroom_group=false,$study_modules=false) {

    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files();  

    /* Wizard */
    $header_data= $this->load_wizard_files($header_data);    

    if(!$study){
        $study = 2;
    }    
    
    if(!$classroom_group){
        $classroom_group = 3;  
    }
    
    if(!$study_modules){
        $study_modules = array();
        $study_modules[]=282;   //  "M1"
        $study_modules[]=268;   //  "M2";
    }    

       $this->_load_html_header($header_data); 
       $data = array();
       $enrollment_studies = $this->wizard_model->get_enrollment_studies();
       $data['enrollment_studies'] = $enrollment_studies;
       $enrollment_classroom_groups = $this->wizard_model->get_enrollment_classroom_groups($study);
       $data['enrollment_classroom_groups'] = $enrollment_classroom_groups;
       $enrollment_study_modules = $this->wizard_model->get_enrollment_study_modules($classroom_group);
       $data['enrollment_study_modules'] = $enrollment_study_modules;
       $enrollment_study_submodules = $this->wizard_model->get_enrollment_study_submodules($study_modules);
       $data['enrollment_study_submodules'] = $enrollment_study_submodules;       
       $enrollment_students = $this->wizard_model->get_students();
       $data['enrollment_students'] = $enrollment_students;              

       // BODY       
       $this->_load_body_header();
       $this->load->view('wizard.php',$data);     
       
       // FOOTER     
       $this->_load_body_footer(); 

	}

    public function classroom_group($study = false) {
        echo $study;

        $resultat = array();

        $enrollment_classroom_groups = $this->wizard_model->get_enrollment_classroom_groups($study);
        foreach($enrollment_classroom_groups as $key => $value){
            $resultat[$key]=$value;
        }
        print_r(json_encode($resultat));

    }

   
	public function index() {
		$this->wizard();
	}

function check_logged_user()
{
    if (!$this->skeleton_auth->logged_in())
    {
        //redirect them to the login page
        redirect($this->skeleton_auth->login_page, 'refresh');
    }

    //CHECK IF USER IS READONLY --> unset add, edit & delete actions
    $readonly_group = $this->config->item('readonly_group');
    if ($this->skeleton_auth->in_group($readonly_group)) {
        $this->grocery_crud->unset_add();
        $this->grocery_crud->unset_edit();
        $this->grocery_crud->unset_delete();
    }
}

function load_wizard_files($header_data){


        //CSS
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/select2.css'));  

        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/fuelux.wizard.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/typeahead-bs2.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.validate.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootbox.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.maskedinput.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/fuelux.wizard.min.js'));                                                  
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/select2.min.js'));        

        return $header_data;

}

function load_ace_files(){

        //CSS
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
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
            base_url('assets/css/no_padding_top.css'));  


        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");   
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

}
