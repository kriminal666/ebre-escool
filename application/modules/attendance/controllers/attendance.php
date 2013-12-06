<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class attendance extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;
	
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

	public function mentoring_groups () {

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
		
		$this->_load_body_header();
		
		echo "TODO";	

		$this->_load_body_footer();		

	}

	public function mentoring_attendance_by_student () {
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
		
		$this->_load_body_header();
		
		echo "TODO";	

		$this->_load_body_footer();		
	}
	
	public function pdf_exemple() {
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('fpdf');
		$pdf=new FPDF();
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Image('http://fpdf.org/logo.gif');
		$pdf->Cell(0,10,utf8_decode('¡Hola, Món!'),1,2,'L');
		$pdf->Output();
	}




	public function classroom_groups() {
		//Cargar la llibreria fpdf
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('pdf');
		$pdf=new PDF();




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

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

		//Mandatory fields
        $this->grocery_crud->required_fields('group_name','group_shortName','group_markedForDeletion');
        
        //express fields
        $this->grocery_crud->express_fields('name','shortName','externalCode');

        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_add_field('group_lastupdate',array($this,'add_field_callback_last_update'));
      
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('group_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('group_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('group_lastupdate',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('group_lastupdate');
        
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('group_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('group_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("group_creationUserId","group_lastupdateUserId","group_parentLocation");
        
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'group_parentLocation',1);
        
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'group_markedForDeletion','n');

        $this->grocery_crud->display_as('groupCode',lang('GroupCode'));
		$this->grocery_crud->display_as('groupShortName',lang('GroupShortName'));
		$this->grocery_crud->display_as('groupName',lang('GroupName'));
		$this->grocery_crud->display_as('groupDescription',lang('GroupDescription'));
		$this->grocery_crud->display_as('educationalLevelId',lang('EducationalLevelId'));
		$this->grocery_crud->display_as('mentorId',lang('MentorId'));

		/* show only specified columns */
		$this->grocery_crud->columns('group_id','group_code','group_shortName','group_name','group_description','group_mentorId','group_entryDate','group_lastupdate','group_creationUserId','group_lastupdateUserId');

		$output = $this->grocery_crud->render();
                        
        $this->_load_html_header($header_data,$output); 
	    $this->_load_body_header();
			
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="group_";
		$this->load->view('defaultvalues_view.php',$default_values); 

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
	
}
