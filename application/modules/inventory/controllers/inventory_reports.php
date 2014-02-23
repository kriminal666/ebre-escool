<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";


class inventory_reports extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;



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

public function inventory()	{
	$this->index();
}

public function index()	{

    $this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files();  

    $output = array();   
    
    $all_inventory_objects = array();

    $all_inventory_objects = $this->inventory_model->getAllInventoryObjects();

    //Aply filters TODO

	$output['inventory_objects'] = $all_inventory_objects;

	$this->_load_html_header($header_data,$output); 
    $this->_load_body_header();      
    
    $this->load->view('inventory_reports.php',$output);     
       
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
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/css/jquery.dataTables.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/ColReorder/media/css/ColReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/ColVis/media/css/ColVis.css'));
        
        
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
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/js/jquery.dataTables.min.js'));  
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