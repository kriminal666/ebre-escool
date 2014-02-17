<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";


class inventory extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;



function __construct()	{
		parent::__construct();

		$this->load->model('inventory_model');

		//GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

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

public function images(){
	    if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		
		$this->image_crud = new image_CRUD();
		
		//CHECK IF USER IS READONLY --> unset upload & delete actions
		$readonly_group = $this->config->item('readonly_group');
		if ($this->skeleton_auth->in_group($readonly_group)) {
			$this->image_crud->unset_upload();
			$this->image_crud->unset_delete();
		}

		$this->current_table = "inventory_images";
	
		$this->image_crud->set_table($this->current_table);
	
		$this->image_crud->set_primary_key_field('imageId');
		$this->image_crud->set_url_field('url');
		$this->image_crud->set_title_field('title');
		$this->image_crud->set_ordering_field('priority');
		$this->image_crud->set_image_path('uploads/inventory_files');
		$this->image_crud->set_relation_field('inventory_objectId');
		
		$this->set_theme($this->grocery_crud);
		$this->set_dialogforms($this->grocery_crud);
	
		/* Ace */
    	$header_data = $this->load_ace_files(); 

	    $this->image_crud_render($this->current_table,$header_data);
	}	

public function index()	{

	if (!$this->skeleton_auth->logged_in())	{
		//redirect them to the login page
		redirect($this->skeleton_auth->login_page, 'refresh');
	}

	/* Ace */
    $header_data = $this->load_ace_files();  

	$data = array();

	//CHECK IF USER IS READONLY --> unset add, edit & delete actions
	$readonly_group = $this->config->item('readonly_group');
	if ($this->skeleton_auth->in_group($readonly_group)) {
		$this->grocery_crud->unset_add();
		$this->grocery_crud->unset_edit();
		$this->grocery_crud->unset_delete();
	}

	//ESPECIFIC CUSTOM ACTIONS
    $this->grocery_crud->add_action(lang('Images'),base_url('assets/img/images.png'), '/inventory/images',"images_button");
    $this->grocery_crud->add_action(lang('QRCode'),base_url('assets/img/qr_code.png'), '/inventory/qr/generate',"qr_button");
		
	$this->current_table="inventory_object";
    $this->grocery_crud->set_table($this->current_table);
        
    //EXAMPLE FILTER BY ORGANIZATIONAL UNIT
	//Relation n a n table: inventory_object_organizational_unit
	//$crud->where('status','active');->where('status','active');
        
    //Establish subject:
    $this->grocery_crud->set_subject(lang('object_subject'));
                        
    //COMMON_COLUMNS               
    //$this->set_common_columns_name();

    //ESPECIFIC COLUMNS                                            
        $this->grocery_crud->display_as('publicId',lang('publicId'));
        $this->grocery_crud->display_as('externalID',lang('externalId')); 
        $this->grocery_crud->display_as('externalIDType',lang('externalIDType')); 
        $this->grocery_crud->display_as('materialId',lang('materialId'));
        $this->grocery_crud->display_as('brandId',lang('brandId'));
        $this->grocery_crud->display_as('modelId',lang('modelId'));
        $this->grocery_crud->display_as('location',lang('location'));
        $this->grocery_crud->display_as('quantityInStock',lang('quantityInStock'));
        $this->grocery_crud->display_as('price',lang('price'));
        $this->grocery_crud->display_as('moneySourceId',lang('moneySourceIdcolumn'));
        $this->grocery_crud->display_as('providerId',lang('providerId'));
        $this->grocery_crud->display_as('preservationState',lang('preservationState'));                
        $this->grocery_crud->display_as('file_url',lang('file_url'));
        $this->grocery_crud->display_as('OwnerOrganizationalUnit',lang('OwnerOrganizationalUnit'));
        $this->grocery_crud->display_as('mainOrganizationaUnitId',lang('mainOrganizationaUnitId'));
        
        //Establish fields/columns order and wich camps to show
        //example: $this->grocery_crud->columns("inventory_objectId","name","shortName");       
        //$this->grocery_crud->columns($this->session->userdata('inventory_object_current_fields_to_show'));       
        
        //Mandatory fields
        $this->grocery_crud->required_fields('name','shortName','location','markedForDeletion');
        //$this->grocery_crud->required_fields('externalCode','name','shortName','location','markedForDeletion');
        
        //Express fields
        $this->grocery_crud->express_fields('name','shortName');

		//Do not show in add form
        $this->grocery_crud->unset_add_fields('manualLast_update','last_update');
               
        //ExternalID types
        $this->grocery_crud->set_relation('externalIDType','externalIDType','{name}',array('markedForDeletion' => 'n'));
        
        //BRAND RELATION
        $this->grocery_crud->set_relation('brandId','brand','{name}',array('markedForDeletion' => 'n'));
        
        //MODEL RELATION
        $this->grocery_crud->set_relation('modelId','model','{name}',array('markedForDeletion' => 'n'));
        
        //MATERIAL RELATION
        $this->grocery_crud->set_relation('materialId','material','{name}',array('markedForDeletion' => 'n'));
        
        //ORGANIZATIONAL UNIT
        $this->grocery_crud->set_relation_n_n('OwnerOrganizationalUnit', 'inventory_object_organizational_unit', 'organizational_unit', 'organitzational_unitId','inventory_objectId', 'organizational_unit_name','priority');
        
        //MAIN ORGANIZATIONAL UNIT
        $this->grocery_crud->set_relation('mainOrganizationaUnitId','organizational_unit','{organizational_unit_name}',array('organizational_unit_markedForDeletion' => 'n'));
        
        //LOCATION
        $this->grocery_crud->set_relation('location','location','{location_name}',array('location_markedForDeletion' => 'n'));
        
        //PROVIDERS
        $this->grocery_crud->set_relation('providerId','provider','{name}',array('markedForDeletion' => 'n'));
        
        //MONEYSOURCEID
        $this->grocery_crud->set_relation('moneySourceId','money_source ','{name}',array('markedForDeletion' => 'n'));
                
        //Validation example. Natural non zero
        $this->grocery_crud->set_rules('quantityInStock','Quantitat','is_natural_no_zero');
       	
       	//Show current datetime
		$this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
			
		//ENTRY DATE
		//DEFAULT VALUE=NOW. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
		$this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
		$this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
		
		//LAST UPDATE
		//DEFAULT VALUE=NOW. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
		$this->grocery_crud->callback_add_field('last_update',array($this,'add_callback_last_update'));
		$this->grocery_crud->callback_edit_field('last_update',array($this,'edit_callback_last_update'));

		//TODO
		//$this->grocery_crud->callback_column('price',array($this,'valueToEuro'));
		$this->grocery_crud->callback_field('Link Imatges',array($this,'field_callback_Link'));
		
		//UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		
        $this->grocery_crud->set_field_upload('file_url','uploads/inventory_files');
        
        //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("creationUserId","lastupdateUserId");
     
		$current_organizational_unit = $this->session->userdata("current_organizational_unit");
        if ($current_organizational_unit != "all")
			$this->grocery_crud->where('`inventory_object`.mainOrganizationaUnitId',$current_organizational_unit);    
		
		$current_role_id   = $this->session->userdata('role');	
		$current_role_name = $this->_get_rolename_byId($current_role_id);
        
        if ($current_role_name == $this->config->item('organizationalunit_group') ) {
			$this->grocery_crud->field_type('mainOrganizationaUnitId', 'hidden', $current_organizational_unit);
		}
		
		//DEFAULT VALUES
		//$this->grocery_crud->set_default_value($table_name,"materialId","2");
		
		//$this->set_theme($this->grocery_crud);
		$this->grocery_crud->set_theme("datatables");
		$this->set_dialogforms($this->grocery_crud);

        $this->render($this->current_table,$header_data);
                
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


function image_crud_render($table_name,$header_data)
{
       $output = $this->image_crud->render();

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
	
function render($table_name,$header_data)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
       $this->_load_html_header($header_data,$output); 
    
       //BODY       
       $this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       //$this->load->view('course.php',$output);     
       $this->load->view($table_name.'.php',$output);     
       
       //FOOTER     
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

//UPDATE AUTOMATIC FIELDS BEFORE INSERT
function before_insert_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['entryDate'] = $data;
        
        $post_array['creationUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

//UPDATE AUTOMATIC FIELDS BEFORE UPDATE
function before_update_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['last_update'] = $data;
        
        $post_array['lastupdateUserId'] = $this->session->userdata('user_id');
        return $post_array;
}



}

/* End of file inventory.php */
/* Location: ./application/modules/inventory/controllers/inventory.php */