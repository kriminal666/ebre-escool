<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include "skeleton_main.php";
include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class curriculum extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('curriculum_model');
        //$this->config->load('curriculum');        
        
        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('curriculum',$current_language);
        $this->load->helper('language');

	}
	
	protected function _getvar($name){
		if (isset($_GET[$name])) return $_GET[$name];
		else if (isset($_POST[$name])) return $_POST[$name];
		else return false;
	}
	
	public function index() {
		$this->lessons();
	}

    

    public function departments_families() {
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

        /* Grocery Crud */
        $this->current_table="department";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('department'));       

        //Relació de Taules
        $this->grocery_crud->set_relation('department_parent_department_id','department','{department_shortname} - {department_name} ({department_id})'); 
        

        //Mandatory fields
        //$this->grocery_crud->required_fields('department_code','department_classroom_group_id','department_teacher_id','department_day','department_time_slot_id');

        //CALLBACKS        
        //$this->grocery_crud->callback_add_field('department_entryDate',array($this,'add_field_callback_department_entryDate'));
        //$this->grocery_crud->callback_edit_field('department_entryDate',array($this,'edit_field_callback_department_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('department_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        //$this->grocery_crud->express_fields('department_code','department_day');

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('department_shortname',lang('department_shortname'));
        $this->grocery_crud->display_as('department_name',lang('department_name'));
        $this->grocery_crud->display_as('department_parent_department_id',lang('department_parent_department_id'));
        $this->grocery_crud->display_as('department_entryDate',lang('department_entryDate'));
        $this->grocery_crud->display_as('department_last_update',lang('department_last_update'));
        $this->grocery_crud->display_as('department_creationUserId',lang('department_creationUserId'));          
        $this->grocery_crud->display_as('department_lastupdateUserId',lang('department_lastupdateUserId'));   
        $this->grocery_crud->display_as('department_markedForDeletion',lang('department_markedForDeletion'));       
        $this->grocery_crud->display_as('department_markedForDeletionDate',lang('department_markedForDeletionDate'));       

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('department_last_update');
        
        //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('department_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'department_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('department_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'department_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("department_creationUserId","department_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'department_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
       /* HTML HEADER     *
       /******************/
       $this->_load_html_header($this->_get_html_header_data(),$output); 
       
       /*******************
       /*      BODY       *
       /******************/
       $this->_load_body_header();
       
        $default_values=$this->_get_default_values();
        $default_values["table_name"]=$this->current_table;
        $default_values["field_prefix"]="course_";
        $this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('course.php',$output);     
       
       /*******************
       /*      FOOTER     *
       *******************/
       $this->_load_body_footer();  

    }
	
	/* Menú Managment -> Curricul | Manteniment -> Pla Estudis */

	public function lessons($department_code=null) {
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

		/* Grocery Crud */
		$this->current_table="lesson";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table.'_'); 
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('lesson'));       

        //Relació de Taules
        $this->grocery_crud->set_relation('lesson_classroom_group_id','classroom_group','{group_code} - {group_shortName} ({group_id})'); 
		$this->grocery_crud->set_relation('lesson_teacher_id','teacher','{teacher_code} - ({teacher_id})');        
		$this->grocery_crud->set_relation('lesson_location_id','location','locationId');
		$this->grocery_crud->set_relation('lesson_time_slot_id','time_slot','{time_slot_start_time} - {time_slot_end_time} ({time_slot_id})');

		//Mandatory fields
        $this->grocery_crud->required_fields('lesson_code','lesson_classroom_group_id','lesson_teacher_id','lesson_day','lesson_time_slot_id');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('lesson_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('lesson_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('lesson_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        //$this->grocery_crud->express_fields('lesson_code','lesson_day');

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('lesson_code',lang('lesson_code'));
        $this->grocery_crud->display_as('lesson_classroom_group_id',lang('lesson_classroom_group_id'));
        $this->grocery_crud->display_as('lesson_teacher_id',lang('lesson_teacher_id'));
        $this->grocery_crud->display_as('lesson_study_module_id',lang('lesson_study_module_id'));
        $this->grocery_crud->display_as('lesson_location_id',lang('lesson_location_id')); 
        $this->grocery_crud->display_as('lesson_day',lang('lesson_day'));
        $this->grocery_crud->display_as('lesson_time_slot_id',lang('lesson_time_slot_id'));        
        $this->grocery_crud->display_as('lesson_entryDate',lang('lesson_entryDate'));
        $this->grocery_crud->display_as('lesson_last_update',lang('lesson_last_update'));
        $this->grocery_crud->display_as('lesson_creationUserId',lang('lesson_creationUserId'));          
        $this->grocery_crud->display_as('lesson_lastupdateUserId',lang('lesson_lastupdateUserId'));   
        $this->grocery_crud->display_as('lesson_markedForDeletion',lang('lesson_markedForDeletion'));       
        $this->grocery_crud->display_as('lesson_markedForDeletionDate',lang('lesson_markedForDeletionDate'));       

         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('lesson_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('lesson_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lesson_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('lesson_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lesson_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("lesson_creationUserId","lesson_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'lesson_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="course_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('course.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	

	}

	public function course() {

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

		/* Grocery Crud */
		$this->current_table="course";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table.'_'); 

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('course'));       

        //Relació de Taules
        $this->grocery_crud->set_relation('course_cycle_id','cycle','cycle_shortname'); 
		$this->grocery_crud->set_relation('course_estudies_id','studies','studies_shortname');        

	    //Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
    	//Param 2: The relation table (cycle)
    	//Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)

		//Mandatory fields
        $this->grocery_crud->required_fields('course_name','course_shortname','course_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('course_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('course_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('course_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        $this->grocery_crud->express_fields('course_name','course_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('course_shortname',lang('shortName'));
        $this->grocery_crud->display_as('course_name',lang('name'));
        $this->grocery_crud->display_as('course_number',lang('course_number'));
        $this->grocery_crud->display_as('course_cycle_id',lang('course_cycle_id')); 
        $this->grocery_crud->display_as('course_estudies_id',lang('course_estudies_id'));
        $this->grocery_crud->display_as('course_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('course_last_update',lang('last_update'));
        $this->grocery_crud->display_as('course_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('course_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('course_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('course_markedForDeletionDate',lang('markedForDeletionDate'));              

/*       
        //Relacions entre taules
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
*/        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('course_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('course_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'course_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('course_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'course_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("course_creationUserId","course_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'course_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="course_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('course.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* GRUP */

	public function classroom_group() {

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

		/* Grocery Crud */
		$this->current_table="classroom_group";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', 'group_'); 

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('classroom_group'));       

		//Mandatory fields
        $this->grocery_crud->required_fields('group_name','group_shortsame','group_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('group_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('group_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('group_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        $this->grocery_crud->express_fields('group_name','group_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('group_shortName',lang('shortName'));
        $this->grocery_crud->display_as('group_name',lang('name'));
        $this->grocery_crud->display_as('group_code',lang('group_code'));  
        $this->grocery_crud->display_as('group_lastupdate',lang('last_update'));        
		$this->grocery_crud->display_as('group_description',lang('description'));
        $this->grocery_crud->display_as('group_creationUserId',lang('creationUserId'));	
        $this->grocery_crud->display_as('group_last_updateUserId',lang('lastupdateUserId')); 
		$this->grocery_crud->display_as('group_entryDate',lang('entryDate'));   
		$this->grocery_crud->display_as('group_educationalLevelId',lang('group_EducationalLevelId')); 
		$this->grocery_crud->display_as('group_parentLocation',lang('parentLocation')); 		
		$this->grocery_crud->display_as('group_mentorId',lang('mentor_code')); 
		$this->grocery_crud->display_as('group_course_id',lang('course')); 
        $this->grocery_crud->display_as('group_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('group_markedForDeletionDate',lang('markedForDeletionDate'));		

//      RELACIONS
        $this->grocery_crud->set_relation('group_course_id','course','{course_name} ({course_shortname} - {course_id})');

        //$this->grocery_crud->set_relation('group_course_id','course','{course_name} ({course_shortname} - {course_id})',array('status' => 'active'));

/*		$this->grocery_crud->set_relation('course_estudies_id','studies','studies_shortname');        
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
	    Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
    	Param 2: The relation table (cycle)
    	Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)        
*/        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('group_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('group_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('group_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("group_creationUserId","group_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'group_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="group_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('classroom_group.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI GRUP */


/* ASSIGNATURA */

	public function study_module() {

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

		/* Grocery Crud */
		$this->current_table="study_module";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table.'_'); 

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('study_module'));       

		//Mandatory fields
        $this->grocery_crud->required_fields('study_module_name','study_module_shortname','study_module_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('study_module_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('study_module_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('study_module_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        $this->grocery_crud->express_fields('study_module_name','study_module_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('study_module_shortname',lang('shortName'));
		$this->grocery_crud->display_as('study_module_name',lang('name'));
        $this->grocery_crud->display_as('study_module_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('study_module_last_update',lang('last_update'));
        $this->grocery_crud->display_as('study_module_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('study_module_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('study_module_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('study_module_markedForDeletionDate',lang('markedForDeletionDate'));        		
		$this->grocery_crud->display_as('study_module_hoursPerWeek',lang('study_module_hoursPerWeek'));
        $this->grocery_crud->display_as('study_module_course_id',lang('course'));        
        $this->grocery_crud->display_as('study_module_teacher_id',lang('study_module_teacher_id'));
        $this->grocery_crud->display_as('study_module_initialDate',lang('study_module_initialDate'));
        $this->grocery_crud->display_as('study_module_endDate',lang('study_module_endDate'));          
        $this->grocery_crud->display_as('study_module_type',lang('type'));   
        $this->grocery_crud->display_as('study_module_subtype',lang('subtype'));        

        //RELACIONS
        $this->grocery_crud->set_relation('study_module_course_id','course','course_shortname'); 
        $this->grocery_crud->set_relation('study_module_teacher_id','teacher','({teacher_code} - {teacher_id})');
/*
	    Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
    	Param 2: The relation table (cycle)
    	Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)        
*/        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('study_module_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('study_module_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_module_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('study_module_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_module_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("study_module_creationUserId","study_module_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'study_module_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="study_module_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('study_module.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ASSIGNATURA */

/* UNITATS FORMATIVES */

	public function study_submodules() {

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

		/* Grocery Crud */
		$this->current_table="study_submodules";
        $this->grocery_crud->set_table($this->current_table);

        $this->session->set_flashdata('table_name', $this->current_table.'_');        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('study_submodules'));       

		//Mandatory fields
        $this->grocery_crud->required_fields('study_submodules_name','study_submodules_shortname','study_submodules_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('study_submodules_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('study_submodules_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('study_submodules_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        $this->grocery_crud->express_fields('study_submodules_name','study_submodules_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('study_submodules_shortname',lang('shortName'));
		$this->grocery_crud->display_as('study_submodules_name',lang('name'));
        $this->grocery_crud->display_as('study_submodules_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('study_submodules_last_update',lang('last_update'));
        $this->grocery_crud->display_as('study_submodules_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('study_submodules_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('study_submodules_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('study_submodules_markedForDeletionDate',lang('markedForDeletionDate'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('study_submodules_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('study_submodules_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_submodules_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('study_submodules_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_submodules_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("study_submodules_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'study_submodules_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="study_submodules_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('study_submodules.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI UNITATS FORMATIVES */


	public function studies() {
		/* Grocery Crud */
		$this->current_table="studies";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table.'_');

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('studies'));          

		//Mandatory fields
        $this->grocery_crud->required_fields('studies_name','studies_shortname','studies_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('studies_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('studies_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('studies_last_update',array($this,'edit_callback_last_update'));
        
        //Express fields
        $this->grocery_crud->express_fields('studies_name','studies_shortname');

        //RELATIONS
        $this->grocery_crud->set_relation_n_n('studies_departments', 'study_department', 'department', 'study_id', 'department_id', 'department_name');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        $this->grocery_crud->fields('studies_shortname', 'studies_name', 'studies_departments' ,  'studies_entryDate' ,'studies_last_update', 'studies_creationUserId', 
            'studies_lastupdateUserId', 'studies_markedForDeletion', 'studies_markedForDeletionDate');

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('studies_shortname',lang('shortName'));
        $this->grocery_crud->display_as('studies_name',lang('name'));
        $this->grocery_crud->display_as('studies_departments',lang('studies_departments'));
        $this->grocery_crud->display_as('studies_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('studies_last_update',lang('last_update'));
        $this->grocery_crud->display_as('studies_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('studies_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('studies_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('studies_markedForDeletionDate',lang('markedForDeletionDate')); 

         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('studies_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('studies_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studies_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('studies_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studies_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("studies_creationUserId","studies_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'studies_markedForDeletion','n');

        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();

		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="studies_";
		$this->load->view('defaultvalues_view.php',$default_values); 
	   
        $this->load->view('studies.php');     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

	public function cycle() {
		/* Grocery Crud */
		$this->current_table="cycle";
        $this->grocery_crud->set_table($this->current_table);

        $this->session->set_flashdata('table_name', $this->current_table.'_');

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('cycles'));          

		//Mandatory fields
        $this->grocery_crud->required_fields('cycle_name','cycle_shortname','cycle_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('cycle_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('cycle_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('cycle_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        $this->grocery_crud->express_fields('cycle_name','cycle_shortname');
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('cycle_shortname',lang('shortName'));
        $this->grocery_crud->display_as('cycle_name',lang('name'));
        $this->grocery_crud->display_as('cycle_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('cycle_last_update',lang('last_update'));
        $this->grocery_crud->display_as('cycle_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('cycle_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('cycle_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('cycle_markedForDeletionDate',lang('markedForDeletionDate')); 

         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('cycle_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('cycle_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'cycle_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('cycle_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'cycle_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("cycle_creationUserId","cycle_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'cycle_markedForDeletion','n');

        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header(); 

		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="cycle_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('cycle.php');     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}			

	public function studies_organizational_unit() {
		/* Grocery Crud */
		$this->current_table="studies_organizational_unit";
        $this->grocery_crud->set_table($this->current_table);
        //$_SESSION['table_name'] = 'studiesOU_';
        $this->session->set_flashdata('table_name', 'studiesOU_');
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('organizational_unit'));          

		//Mandatory fields
        $this->grocery_crud->required_fields('studiesOU_name','studiesOU_shortname','studiesOU_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('studiesOU_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('studiesOU_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('studiesOU_last_update',array($this,'edit_callback_last_update'));
        
        //Camps last update no editable i automàtic        
        //$this->grocery_crud->callback_edit_field('studiesOU_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('studiesOU_name','studiesOU_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('studiesOU_shortname',lang('shortName'));
        $this->grocery_crud->display_as('studiesOU_name',lang('name'));
        $this->grocery_crud->display_as('studiesOU_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('studiesOU_last_update',lang('last_update'));
        $this->grocery_crud->display_as('studiesOU_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('studiesOU_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('studiesOU_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('studiesOU_markedForDeletionDate',lang('markedForDeletionDate')); 
 
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('studiesOU_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('studiesOU_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studiesOU_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('studiesOU_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studiesOU_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("studiesOU_creationUserId","studiesOU_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'studiesOU_markedForDeletion','n');

        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();

		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="studiesOU_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('studies_organizational_unit.php');     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

//<--

public function add_callback_last_update(){  
    //echo $_SESSION['table_name'];
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'last_update" id="field-last_update" readonly>';
}

public function add_field_callback_entryDate(){  
      $data= date('d/m/Y H:i:s', time());
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'entryDate" id="field-entryDate" readonly>';    
}

public function edit_field_callback_entryDate($value, $primary_key){  
    //$this->session->flashdata('table_name');
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'entryDate" id="field-entryDate" readonly>';    
    }
    
function edit_callback_last_update($value, $primary_key){ 
    //$this->session->flashdata('table_name'); 
     return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', time()) .'"  name="'.$this->session->flashdata('table_name').'last_update" id="field-last_update" readonly>';
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
    
//-->


}
