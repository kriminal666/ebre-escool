<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "skeleton_main.php";

class attendance extends skeleton_main {
	
	function __construct()
    {
        parent::__construct();
        
        //$this->load->library('attendance');
        $this->load->model('attendance_model');

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language','skeleton_auth');
		}
		$this->grocery_crud->set_language($current_language);
    	$this->lang->load('skeleton', $current_language);	       
    	
    	$this->lang->load('attendance', $current_language);	
    	
		$this->lang->load('managment', $current_language);        
        
	}
	
	public function prova() {
		$this->load->view('attendance/prova');
	}

	public function classroom_groups() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			
		

		$this->current_table="classroom_group";
        $this->grocery_crud->set_table($this->current_table);

        //ESTABLISH SUBJECT        
        $this->grocery_crud->set_subject(lang('ClassroomGroup'));

		//Mandatory fields
        $this->grocery_crud->required_fields('groupName','groupShortName','markedForDeletion');
        
        //express fields
        $this->grocery_crud->express_fields('name','shortName','externalCode');

        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_add_field('last_update',array($this,'add_field_callback_last_update'));
      
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('last_update');
        
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lastupdateUserId',$this->session->userdata('user_id'));

        /*
        $this->set_common_columns_name();
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        $this->grocery_crud->unset_add_fields('last_update');
        
        $this->grocery_crud->set_default_value($this->current_table,'creationUserId',$this->session->userdata('user_id'));
        $this->grocery_crud->set_default_value($this->current_table,'lastupdateUserId',$this->session->userdata('user_id'));
		*/

        $this->grocery_crud->display_as('groupCode',lang('GroupCode'));
		$this->grocery_crud->display_as('groupShortName',lang('GroupShortName'));
		$this->grocery_crud->display_as('groupName',lang('GroupName'));
		$this->grocery_crud->display_as('groupDescription',lang('GroupDescription'));
		$this->grocery_crud->display_as('educationalLevelId',lang('EducationalLevelId'));
		$this->grocery_crud->display_as('mentorId',lang('MentorId'));


		$output = $this->grocery_crud->render();
                        
        $this->_load_html_header($header_data,$output); 
	    $this->_load_body_header();
			
        $this->load->view('attendance/classroom_groups_view.php',$output);     


		$this->_load_body_footer();

	}
	
	public function check_attendance() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			
		$this->_load_html_header($header_data); 
		
		/*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();
		
		//Obtain all teacher groups for selected date
		
		//$teacher_code = $_SESSION['codi_professor'];
		
		//$teacher_code = $_SESSION['codi_professor'];
		
		$teacher_code = 41;
		
		//teacher: teacher_code:
		//day
		
		
		$data= array();
		$data['check_attendance_day']="TODO";
		$data['check_attendance_table_title']=lang('check_attendance_table_title');
		$data['choose_date_string']=lang('choose_date_string');
		$data['today']=date('d-m-Y');
		
		$teacher_groups_current_day=array();
		
		$group = new stdClass;
		$group->time_interval="8:00 - 9:00";
		$group->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		$group->group_name="i automa (S)";
		$group->group_code="M 1";
		
		$teacher_groups_current_day['key1']= $group;
		
		$group1 = new stdClass;
		$group1->time_interval="9:00 - 1:00";
		$group1->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		$group1->group_name="GRUP MPROVA";
		$group1->group_code="M 8";
		
		$group2 = new stdClass;
		$group2->time_interval="11:00 - 12:00";
		$group2->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		$group2->group_name="GRUP M9";
		$group2->group_code="M 9";
		
		
		$teacher_groups_current_day['key2']=$group;
		$teacher_groups_current_day['key3']=$group1;
		$teacher_groups_current_day['key4']=$group;
		$teacher_groups_current_day['key4']=$group2;
		
		$data['teacher_groups_current_day']=$teacher_groups_current_day;
		
		$this->load->view('attendance/check_attendance',$data);
		
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		
	}
	
	public function index() {
		$this->check_attendance();
	}
	/*
	function add_field_callback_entryDate(){  
		  $data= date('d/m/Y H:i:s', time());
		  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="entryDate" id="field-entryDate" readonly>';    
	}

	function edit_field_callback_entryDate($value, $primary_key){  
		  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="entryDate" id="field-entryDate" readonly>';    
	    }
	    
	function edit_callback_last_update($value, $primary_key){  
		 return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'"  name="last_update" id="field-last_update" readonly>';
	    }    	

	function edit_field_callback_lastupdate($value, $primary_key){
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="entryDate" id="field-last_update" readonly>';    	
	}

	//UPDATE AUTOMATIC FIELDS BEFORE INSERT
	function before_insert_user_preference_callback($post_array, $primary_key) {
			//UPDATE LAST UPDATE FIELD
			$data= date('d/m/Y H:i:s', time());
			$post_array['last_update'] = $data;
			
			$user_id=$this->session->userdata('user_id');
			$post_array['userId'] = $user_id;
			$post_array['creationUserId'] = $user_id;
			$post_array['lastupdateUserId'] = $user_id;
			
			
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
	*/
	
}
