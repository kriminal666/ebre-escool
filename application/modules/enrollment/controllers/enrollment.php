<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include "skeleton_main.php";
include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class enrollment extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;       

	function __construct()
    {
        parent::__construct();
        
        //$this->load->model('attendance_model');
        $this->load->model('enrollment_model');
        //$this->load->library('ebre_escool_ldap');
        //$this->config->load('managment');        
        $this->config->load('wizard');
        
        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('enrollment',$current_language);
        $this->load->helper('language');

	}
	
	protected function _getvar($name){
		if (isset($_GET[$name])) return $_GET[$name];
		else if (isset($_POST[$name])) return $_POST[$name];
		else return false;
	}

	public function index() {
		$this->enrollment();
	}

/* ENROLLMENT */

	public function enrollment() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment';

        $this->check_logged_user();
		
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment'));       
 
        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS

        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));        
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
   		
        $this->userCreation_userModification($this->current_table);
        
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);                   

	}

/* FI ENROLLMENT */

/* ENROLLMENT STUDIES */

	public function enrollment_studies() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_studies';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_studies";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_studies'));       
        
        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));          
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));   
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
   		
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);        
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);
	}

/* FI ENROLLMENT STUDIES */

/* ENROLLMENT CLASS GROUP */

	public function enrollment_class_group() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_class_group';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_class_group";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_class_group'));       

        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));          
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));   
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('group_id'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code}');        

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);
           
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);	
	}

/* FI ENROLLMENT CLASS GROUP */

/* ENROLLMENT MODULES */

	public function enrollment_modules() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_modules';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_modules";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_modules'));       

        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));          
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('group_id'));   
        $this->grocery_crud->display_as($this->current_table.'_moduleid',lang('moduleid'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code}');      
        $this->grocery_crud->set_relation($this->current_table.'_moduleid','study_module','{study_module_name}');      

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);
           
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);  ;
	}

/* FI ENROLLMENT MODULES */

/* ENROLLMENT SUBMODULES */

	public function enrollment_submodules() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_submodules';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_submodules";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_submodules'));       

        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));          
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('group_id'));   
        $this->grocery_crud->display_as($this->current_table.'_moduleid',lang('moduleid'));        		
		$this->grocery_crud->display_as($this->current_table.'_submoduleid',lang('submoduleid'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code}');      
        $this->grocery_crud->set_relation($this->current_table.'_moduleid','study_module','{study_module_name}');      
        $this->grocery_crud->set_relation($this->current_table.'_submoduleid','study_submodules','{study_submodules_name}');      

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);
           
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);  ;
	}

/* FI ENROLLMENT SUBMODULES */

	private function set_header_data() {

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));			

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  


		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");						
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js"));				
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/js/jquery.tooltipster.min.js"));		
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));
        
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();		

	}

public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}

public function add_field_callback_entryDate(){  
      $data= date('d/m/Y H:i:s', time());
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function edit_field_callback_entryDate($value, $primary_key){  
    //$this->session->flashdata('table_name');
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
    }
    
public function edit_callback_last_update($value, $primary_key){ 
    //$this->session->flashdata('table_name'); 
     return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', time()) .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
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


function common_callbacks()
{
        //CALLBACKS        
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

function userCreation_userModification($table_name)
{   
    //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($table_name.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($table_name.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_lastupdateUserId',$this->session->userdata('user_id'));
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

function set_common_columns_name($table_name){
    $this->grocery_crud->display_as($table_name.'_entryDate',lang('entryDate'));
    $this->grocery_crud->display_as($table_name.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($table_name.'_creationUserId',lang('creationUserId'));                  
    $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang('lastupdateUserId'));   
    $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang('markedForDeletion'));       
    $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang('markedForDeletionDate')); 
}

function load_ace_files($active_menu){

$header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/select2.css')); 
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/modifications_select2.css')); 


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
/*                      
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/
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

        $header_data['menu']= $active_menu;
        return $header_data;
}

/* Enrollment Wizzard */

    public function wizard($study=false,$classroom_group=false,$study_modules=false) {

    $this->check_logged_user(); 

    $active_menu = array();
    $active_menu['menu']='#enrollment_wizard';
    $active_menu['submenu1']='#wizard';


    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Wizard */
    $header_data= $this->load_wizard_files($header_data); 


    if($study == false){
        $study = 2;
    }    
    
    if($classroom_group == false){
        $classroom_group = 3;  
    }
    
    if($study_modules == false){
        $study_modules = array();
        $study_modules[]=282;   //  "M1"
        $study_modules[]=268;   //  "M2";
    }    

       $this->_load_html_header($header_data); 
       $data = array();
       
       $enrollment_studies = $this->enrollment_model->get_enrollment_studies();
       $data['enrollment_studies'] = $enrollment_studies;
       $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups($study);
       $data['enrollment_classroom_groups'] = $enrollment_classroom_groups;
       $enrollment_study_modules = $this->enrollment_model->get_enrollment_study_modules($classroom_group);
       $data['enrollment_study_modules'] = $enrollment_study_modules;
       $enrollment_study_submodules = $this->enrollment_model->get_enrollment_study_submodules($study_modules);
       $data['enrollment_study_submodules'] = $enrollment_study_submodules;       
       $enrollment_students = $this->enrollment_model->get_students();
       $data['enrollment_students'] = $enrollment_students;              

      // print_r($enrollment_students);
       
       // BODY       
       $this->_load_body_header();
       $this->load->view('wizard.php',$data);     
       
       // FOOTER     
       $this->_load_body_footer(); 

    }

    public function check_student($person_official_id=false) {

        if($person_official_id==false){
            if(isset($_POST['student_official_id'])){
                $official_id = $_POST['student_official_id'];
                $student_data = $this->enrollment_model->get_student_data($official_id);
                if($student_data){
                    print_r(json_encode($student_data));
                } else {
                    return false;
                }
            }
        } else {
            $official_id = $person_official_id;
            $student_data = $this->enrollment_model->get_student_data($official_id);
            if($student_data){
                return $student_data;
            } else {
                return false;
            }            
        }
/*
        $resultat = array();

        $enrollment_classroom_groups = $this->wizard_model->get_enrollment_classroom_groups($study);
        foreach($enrollment_classroom_groups as $key => $value){
            $resultat[$key]=$value;
        }
*/        

    }

    public function classroom_course() {
        
        if(isset($_POST['study_id'])){
            $study_id = $_POST['study_id'];
            $resultat = array();
            $enrollment_courses = $this->enrollment_model->get_enrollment_courses($study_id);
            foreach($enrollment_courses as $key => $value){
                $resultat[$key]=$value;
            }
            print_r(json_encode($resultat));
        } else {
            return false;
        }
    }

    public function get_user_by_username() {

        if(isset($_POST['username'])){
            $username = $_POST['username'];
            $resultat = array();
                $index=1;
                /*
                $user_exists = $this->enrollment_model->get_student_by_username($username);
                if($user_exists){
                    $username = $username . $index;
                }
                echo $username;
                */
                $user_new = $username;
                do{
                    $user_exists = $this->enrollment_model->get_student_by_username($user_new);
                    if($user_exists){
                        $user_new = $username . $index;
                        $index++;
                    }
                }while($user_exists==true);
                //echo $user_new;
            echo $user_new;
        } else {
            return false;
        }
    }

    public function generate_password() {

        $length = 10;

        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = array();
        
        $password['password'] = substr(str_shuffle($chars),0,$length);
            
        print_r(json_encode($password));    
    }

    public function classroom_group() {
        //echo $study;

        if(isset($_POST['study_id'])){
            $resultat = array();

            $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups($_POST['study_id']);
            foreach($enrollment_classroom_groups as $key => $value){
                $resultat[$key]=$value;
            }
            print_r(json_encode($resultat));
        } else {
            return false;
        }
    }

    public function study_modules() {
        //echo $classroom_group;

        $classroom_group = $_POST['classroom_group_id'];
        $classroom_groups = $_POST['classroom_groups'];

        $resultat = array();

        $enrollment_study_modules = $this->enrollment_model->get_enrollment_study_modules($classroom_groups,$classroom_group);

        $grups = array();
        foreach($enrollment_study_modules as $key => $value){
            $resultat[$key]=$value;
            $grups[] = $value['classroom_group_code'];
        }
                $grups = array_unique($grups);
                $res = array();
                foreach ($grups as $grup)
                {
                    foreach ($enrollment_study_modules as $enrollment_study_module){
                        if($enrollment_study_module['classroom_group_code'] == $grup){
                            $res[$grup][]=$enrollment_study_module;    
                        }
                        
                    }
                }

        //print_r(json_encode($resultat));
        print_r(json_encode($res));

    }

    public function study_submodules() {
        
        $modules = $_POST['study_module_ids'];
        $classroom_group_id = $_POST['classroom_group_id'];
        $classroom_groups = $_POST['classroom_groups'];

        $modules = explode("-",$modules);
        
        $resultat = array();

        $enrollment_study_submodules = $this->enrollment_model->get_enrollment_study_submodules($modules,$classroom_group_id);
    //    $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups_from_id($classroom_groups);


            foreach($enrollment_study_submodules as $key => $value){
               $resultat[$key]=$value;
            }
/*
                echo "Grups de classe --><pre>";
                print_r($classroom_groups);
                echo "</pre>";
*/
        print_r(json_encode($resultat));
    }

    public function enrollment_wizard() {

            $resultat = array();

            $period_id = $_POST['period_id'];
            $person_id = $_POST['person_id'];
            $study_id = $_POST['study_id'];
            $classroom_group_id = $_POST['classroom_group_id'];
            $study_module_ids = $_POST['study_module_ids'];
            $study_submodules_ids = $_POST['study_submodules_ids'];

            $study_submodules_ids = explode('-',$study_submodules_ids);
            $study_module_ids = explode('-',$study_module_ids);

            //echo "<script>alert(".print_r($study_module_ids).")</script>";die();

            /*echo "<script>alert(".print_r($study_submodules_ids).")</script>";die();*/

            $enrollment = $this->enrollment_model->insert_enrollment($period_id, $person_id);
            $enrollment_studies = $this->enrollment_model->insert_enrollment_studies($period_id, $person_id, $study_id);
            $enrollment_class_group = $this->enrollment_model->insert_enrollment_class_group($period_id, $person_id, $study_id, $classroom_group_id);
            $enrollment_modules = $this->enrollment_model->insert_enrollment_modules($period_id, $person_id, $study_id, $classroom_group_id, $study_module_ids);
            $enrollment_submodules = $this->enrollment_model->insert_enrollment_submodules($period_id, $person_id, $study_id, $classroom_group_id, $study_module_ids, $study_submodules_ids);

            $resultat['enrollment'] = $enrollment;
            $resultat['enrollment_studies'] = $enrollment_studies;
            $resultat['enrollment_class_group'] = $enrollment_class_group;
            $resultat['enrollment_modules'] = $enrollment_modules;
            $resultat['enrollment_submodules'] = $enrollment_submodules;

            print_r(json_encode($resultat));
    }   

function insert_update_user(){

    $student = array();
    if(isset($_POST['student_person_id'])){
        $person_id = $_POST['student_person_id'];    
    }
    $student['person_official_id'] = $_POST['student_official_id'];
    $student['person_secondary_official_id'] = $_POST['student_secondary_official_id'];
    $student['person_givenName'] = $_POST['student_givenName'];
    $student['person_sn1'] = $_POST['student_sn1'];
    $student['person_sn2'] = $_POST['student_sn2'];
    $student['username'] = $_POST['student_username'];

/*    
    if($_POST['student_password'] != ''){
        if($_POST['student_password'] == $_POST['student_verify_password']){
            $student['student_password'] = $_POST['student_password'];
    } else {
        $_POST['student_password'] == $_POST['student_generated_password'] &&
    }
*/
    $student['person_photo'] = $student['username'].'.jpg';
    $student['person_email'] = $_POST['student_email'];
    $student['person_homePostalAddress'] = $_POST['student_homePostalAddress'];
    $student['person_locality_name'] = $_POST['student_locality_name'];
//    $student['student_postal_code'] = $_POST['student_postal_code'];
    $student['person_telephoneNumber'] = $_POST['student_telephoneNumber'];                
    $student['person_mobile'] = $_POST['student_mobile'];   
    $student['person_date_of_birth'] = $_POST['student_date_of_birth'];   
    $student['person_gender'] = $_POST['student_gender'];   

    $action = $_POST['action'];
    if($action=='update'){
        //echo "S'ha d'actualitzar";
        $enrollment = $this->enrollment_model->update_student_data($person_id, $student);
    } else {
        //echo "S'ha d'insertar";
        $enrollment = $this->enrollment_model->insert_student_data($student);
        if($enrollment){
            $inserted_student = $this->check_student($student['person_official_id']);
            print_r($inserted_student);
        }
    }

}


function load_wizard_files($header_data=false){


        //CSS
        if($header_data != false){
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");    
        } else {
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");                
        }


        //JS
       /* 
       $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");  
        */    
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/select2.min.js'));           
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.gritter.min.js'));          
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/fuelux.spinner.min.js'));         
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-editable.min.js'));          
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-editable.min.js'));                   
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
                    base_url('assets/js/ebre-escool.js'));        
        /*
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/fuelux.wizard.min.js'));                                                  
        */

        return $header_data;

}

}
