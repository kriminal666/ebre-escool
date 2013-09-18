<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "skeleton_main.php";

class attendance extends skeleton_main {
	
	function __construct()
    {
        parent::__construct();
        
        //$this->load->library('attendance');
        $this->load->model('attendance_model');
        
	}
	
	public function prova() {
		$this->load->view('attendance/prova');
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
