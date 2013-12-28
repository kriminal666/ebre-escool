<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class timetables extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;

    public $body_header_lang_file ='ebre_escool_body_header' ;

	function __construct()
    {
        parent::__construct();

        $this->load->model('timetables_model');

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language','skeleton_auth');
        }
        $this->grocery_crud->set_language($current_language);
        $this->lang->load('skeleton', $current_language);          
        
        $this->lang->load('timetables', $current_language);

	}

    public function allteacherstimetables($teacher_code = null) {
        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $header_data= $this->add_css_to_html_header_data(
                $this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/tribal-timetable.css'));        
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");

            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
                    
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.ba-resize.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-tooltip.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-collapse.js'));                
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-shared.js'));        
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-timetable.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
            
            $this->_load_html_header($header_data);
            $this->_load_body_header();

            //TODO: select current user (sessions user as default teacher)
            if ($teacher_code == null) {
                $teacher_code = 43;
            }
        
            //Load teachers from Model
            $teachers_array = $this->timetables_model->get_all_teachers_ids_and_names();

            $data['teachers'] = $teachers_array;

            //TODO: select current user (sessions user as default teacher)
            $data['default_teacher'] = $teacher_code;                           
            

            $time_slots_array = $this->timetables_model->getAllTimeSlots()->result_array();

            $data['time_slots_array'] = $time_slots_array;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time= $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];

                //Obtain lesson for this teacher date and time slot

                //$time_slots_array = $this->attendance_model->getLesson($teacher_code,$time_slot['time_slot_id'])->result_array();

                $all_time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }

            $data['all_time_slots']=$all_time_slots;

            

            $days = $this->timetables_model->getAllLectiveDays();

            $data['days']=$days;

            $this->load->view('timetables/allteacherstimetables',$data);
            
            $this->_load_body_footer();       

    }

    public function allgroupstimetables() {
        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $header_data= $this->add_css_to_html_header_data(
                $this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/tribal-timetable.css'));        

            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
                    
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.ba-resize.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-tooltip.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-collapse.js'));                
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-shared.js'));        
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-timetable.js'));
            
            $this->_load_html_header($header_data);
            $this->_load_body_header();                           
                                                                                
            $this->load->view('timetables/allgroupstimetables');
            
            $this->_load_body_footer();       

    }
	
	public function mytymetables() {
	    if (!$this->skeleton_auth->logged_in())
	        {
	        //redirect them to the login page
	        redirect($this->skeleton_auth->login_page, 'refresh');
	        }
            
            $header_data= $this->add_css_to_html_header_data(
				$this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
				$header_data,
                    base_url('assets/css/tribal-timetable.css'));        
            
            //<link href="css/docs.css" rel="stylesheet" />
            //<link href="css/tribal-bootstrap.css" rel="stylesheet" />
			//<link href="css/tribal-timetable.css" rel="stylesheet" />        
            //JS
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
                    
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.ba-resize.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-tooltip.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-collapse.js'));                
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-shared.js'));        
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-timetable.js'));
			
            $this->_load_html_header($header_data);
            $this->_load_body_header();                           
                                                                                
            $this->load->view('timetables/mytimetables');
    	    
            $this->_load_body_footer();       
    	                    
	}
	
	public function index() {
		$this->mytimetables();
	}
	
	
}
