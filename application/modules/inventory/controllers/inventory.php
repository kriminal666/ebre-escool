<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class inventory extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;



function __construct()	{
		parent::__construct();

		//GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}
		

		$this->lang->load('inventory', $current_language);

		
        //LANGUAGE HELPER:
        $this->load->helper('language');

	}	

public function index()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('inventory',$output); 
                
	$this->_load_body_footer();

	}
	
 
public function externalIDType()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('externalIDType',$output); 
                
	$this->_load_body_footer();

	}
	
public function material()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('material',$output); 
                
	$this->_load_body_footer();

	}

public function brand()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('brand',$output); 
                
	$this->_load_body_footer();

	}

public function model()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('model',$output); 
                
	$this->_load_body_footer();

	}

public function provider()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('provider',$output); 
                
	$this->_load_body_footer();

	}

public function money_source()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('money_source',$output); 
                
	$this->_load_body_footer();

	}
	
public function barcode()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$output = array();
	
	$this->_load_html_header($header_data,$output); 
	$this->_load_body_header();
	
	
	$this->load->view('barcode',$output); 
                
	$this->_load_body_footer();

	}

	
function renderitzar($table_name,$header_data)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
       $this->_load_html_header($header_data,$output); 
    
       //      BODY       

       $this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       //$this->load->view('course.php',$output);     
       $this->load->view($table_name.'.php',$output);     
       
       //      FOOTER     
       $this->_load_body_footer();  

}

function load_ace_files(){

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

/* End of file inventory.php */
/* Location: ./application/modules/inventory/controllers/inventory.php */