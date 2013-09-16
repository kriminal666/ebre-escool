<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "skeleton_main.php";

class attendance extends skeleton_main {
	
	function __construct()
    {
        parent::__construct();
        
	}
	
	public function check_attendance() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		//redirect($this->skeleton_auth->login_page, 'refresh');
		
		//LOAD VIEW
		
		/*******************
		/*      HEADER     *
		/******************/
		$this->_load_html_header($this->_get_html_header_data());
		
		
		/*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();
		
		$data= array();
		$data['check_attendance_day']="TODO";
		$data['check_attendance_table_title']=lang('check_attendance_table_title');
		
		$teacher_groups_current_day=array();
		
		$group = new stdClass;
		$group->time_interval="8:00 - 9:00";
		$group->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		$group->group_name="i automa (S)";
		$group->group_code="M 1";
		
		$teacher_groups_current_day['key1']= $group;
		
		$group = new stdClass;
		$group->time_interval="8:00 - 9:00";
		$group->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		$group->group_name="i automa (S)";
		$group->group_code="M 1";
		
		
		$teacher_groups_current_day['key2']=$group;
		$teacher_groups_current_day['key3']=$group;
		$teacher_groups_current_day['key4']=$group;
		
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
