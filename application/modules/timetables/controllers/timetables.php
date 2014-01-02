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
                $teacher_code = 41;
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

            //Load classroom_groups from Model
            $classroom_groups_array = $this->timetables_model->get_all_classroom_groups_ids_and_names();

            $data['classroom_groups'] = $classroom_groups_array;

            //TODO
            $data['default_classroom_group'] = 1;                           
            
            $time_slots_array = $this->timetables_model->getAllTimeSlots()->result_array();

            $data['time_slots_array'] = $time_slots_array;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time= $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];



                $all_time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }

            $data['all_time_slots']=$all_time_slots;

            $days = $this->timetables_model->getAllLectiveDays();

            $data['days']=$days;

            $this->load->view('timetables/allgroupstimetables',$data);
            
            $this->_load_body_footer();   
    }
	
	public function mytymetables($compact = "") {

        /*
        if ($compact == "compact") {
            echo "compact: TRUE";
        } else {
            echo "compact: FALSE";
        }*/

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
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css");                 
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap-switch.min.css'));
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
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");
			$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data["teacher_full_name"] = "Tur Badenas, Sergi";

            //TODO: set teacher codes by session values (current session user)

            $teacher_code=41;
            $teacher_id=39;

            $data["teacher_code"] = $teacher_code;
            $data["teacher_id"] = $teacher_id;

            if ($compact) {
                $time_slots_array = $this->timetables_model->getAllTimeSlots()->result_array();
            } else {
                $time_slots_array = $this->timetables_model->getCompactTimeSlots($teacher_id)->result_array();
            }

            $data['time_slots_array'] = $time_slots_array;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time= $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];

                $time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }

            $data['time_slots']=$time_slots;
            $data['time_slots_count']=count($time_slots);

            $days = $this->timetables_model->getAllLectiveDays();

            $data['days']=$days;

            $lessonsfortimetablebyteacherid = $this->timetables_model->get_all_lessonsfortimetablebyteacherid($teacher_id);

            $lessonsfortimetablebyteacherid = $this->add_breaks($lessonsfortimetablebyteacherid);

            //print_r($lessonsfortimetablebyteacherid);                                  

            $data['lessonsfortimetablebyteacherid']= $lessonsfortimetablebyteacherid;

            $all_teacher_study_modules = $this->timetables_model->get_all_teacher_study_modules($teacher_id)->result();

            $data['all_teacher_study_modules']= $all_teacher_study_modules;

            $study_modules_colours = $this->_assign_colours_to_study_modules($all_teacher_study_modules);

            $data['study_modules_colours']= $study_modules_colours;

            $data['compact']= $compact;
                                                                                
            $this->load->view('timetables/mytimetables',$data);

            $this->_load_body_footer();       
    	                    
	}

    protected function _assign_colours_to_study_modules($study_modules) {
        $study_modules_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info" ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger" ,
                   6 => "btn-default");
        $index=1;
        foreach ($study_modules as $study_module) {
            $study_modules_colours[$study_module->study_module_id] = $bootstrap_button_colours[$index];
            $index++;
        }
            
        return $study_modules_colours;
    }

    public function add_breaks($lessonsfortimetablebyteacherid) {
        
        $days = $this->timetables_model->getAllLectiveDays();

        //ADD BREAKS
        $not_lective_time_slots_array = $this->timetables_model->getNotLectiveTimeSlots()->result_array();

        //print_r($not_lective_time_slots_array);

        foreach ($days as $day) {
            $day_number = $day->day_number;
            //echo $day->day_shortname . " : " . print_r($lessonsfortimetablebyteacherid[$day_number]) . "<br/><br/>";
            $day_lessons = $lessonsfortimetablebyteacherid[$day_number]->lesson_by_day;

            
            foreach ($not_lective_time_slots_array as $not_lective_time_slot)   {
                $time_slot_start_time = $not_lective_time_slot['time_slot_start_time'];
                
                $lesson_data = new stdClass;
                
                $lesson_data->time_slot_order = $not_lective_time_slot['time_slot_order'];
                $lesson_data->time_slot_lective = true;
                $lesson_data->group_shortName ="";
                $lesson_data->group_code = "";
                $lesson_data->location_code="";
                
                if ($time_slot_start_time == "14:30") {
                    $lesson_data->study_module_shortname= strtoupper(lang("lunch_break"));
                    $lesson_data->study_module_name= strtoupper(lang("lunch_break"));
                } else {
                    $lesson_data->study_module_shortname= strtoupper(lang("patio_break"));
                    $lesson_data->study_module_name= strtoupper(lang("patio_break"));    
                }
                
                $lesson_data->duration= 1;

                $day_lessons[$time_slot_start_time] = $lesson_data;
            }

            ksort ($day_lessons);

            $lessonsfortimetablebyteacherid[$day_number]->lesson_by_day = $day_lessons;
        }
        
        return $lessonsfortimetablebyteacherid;
    }
	
	public function index() {
		$this->mytimetables();
	}
	
	
}
