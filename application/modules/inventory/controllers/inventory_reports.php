<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";


class inventory_reports extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;   

function __construct()	{
		parent::__construct();

		$this->load->model('inventory_model');
		$this->load->library('session');

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}
		
		$this->config->load('config');

		$this->lang->load('inventory', $current_language);		
        //LANGUAGE HELPER:
        $this->load->helper('language');
	}	

public function inventory($filter=null)	{
	$this->index($filter);
}

public function index($filter=null)	{

$array = $this->uri->uri_to_assoc(4);

    $active_menu = array();
    $active_menu['menu']='#reports';
    $active_menu['submenu1']='#inventory_reports';
    $active_menu['submenu2']='#inventory_reports_filters';

    $this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

    $output = array();   
    
    $all_inventory_objects = array();
    $all_inventory_objects = $this->inventory_model->getAllInventoryObjects();

    $all_organizational_units = array();
    $all_organizational_units = $this->inventory_model->getAllorganizationalUnits();    

    $all_materials = array();
    $all_materials = $this->inventory_model->getAllMaterials();    

    $all_locations = array();
    $all_locations = $this->inventory_model->getAllLocations();    

    $all_brands = array();
    $all_brands = $this->inventory_model->getAllBrands(); 



    $all_models = array();
    $all_models = $this->inventory_model->getAllModels(); 

    $all_providers = array();
    $all_providers = $this->inventory_model->getAllProviders(); 

    $all_users = array();
    $all_users = $this->inventory_model->getAllUsers(); 

    $all_money_sources = array();
    $all_money_sources = $this->inventory_model->getAllMoneySources(); 



    //Aply filters TODO

	$output['inventory_objects'] = $all_inventory_objects;
    $output['organizational_units'] = $all_organizational_units;
    $output['materials'] = $all_materials;
    $output['locations'] = $all_locations;
    $output['brands'] = $all_brands;
    $output['models'] = $all_models;
    $output['providers'] = $all_providers;
    $output['users'] = $all_users;
    $output['money_sources'] = $all_money_sources;


	$this->_load_html_header($header_data,$output); 
    $this->_load_body_header();      
    
    $this->load->view('inventory_reports.php',$output);     
       
    $this->_load_body_footer();  
                
}
	
function load_ace_files($active_menu){

	$header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
/*
	$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/ 
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/ColReorder/media/css/ColReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/ColVis/media/css/ColVis.css'));
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
                "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");        


        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "https://code.jquery.com/jquery-1.11.0.min.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-migrate-1.2.1.min.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");  
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/js/jquery.dataTables.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/jquery.dataTables.bootstrap.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/ColReorder/media/js/ColReorder.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/ColVis/media/js/ColVis.min.js')); 
        $header_data= $this->add_javascript_to_html_header_data(
                $header_data,
                "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");


        $header_data['menu']= $active_menu;
        return $header_data; 
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

}
/* End of file inventory_reports.php */
/* Location: ./application/modules/inventory/controllers/inventory_reports.php */