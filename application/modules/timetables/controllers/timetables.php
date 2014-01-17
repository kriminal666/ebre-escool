<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class timetables extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;

    public $body_header_lang_file ='ebre_escool_body_header' ;

	function __construct()
    {
        parent::__construct();

        $this->load->model('timetables_model');
        $this->config->load('config');

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language','skeleton_auth');
        }
        $this->grocery_crud->set_language($current_language);
        $this->lang->load('skeleton', $current_language);          
        
        $this->lang->load('timetables', $current_language);

        $this->load->helper('language');


	}

    public function allteacherstimetables($teacher_code = null,$compact = "") {

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();

            //TODO: select current user (sessions user as default teacher)
            if ($teacher_code == null) {
                $teacher_code = 41;
            }

            $teacher_id=$this->timetables_model->get_teacher_id_from_teacher_code($teacher_code);//;

            $data["teacher_code"] = $teacher_code;
            $data["teacher_id"] = $teacher_id;

            //$teacher_id=39;
        
            //Load teachers from Model
            $teachers_array = $this->timetables_model->get_all_teachers_ids_and_names();

            $data['teachers'] = $teachers_array;

            //TODO: select current user (sessions user as default teacher)
            $data['default_teacher'] = $teacher_code;                           

            /* Get Timeslots */            
            $timeslots = $this->get_time_slots($compact,$teacher_id);
            foreach($timeslots as $key => $value){
                $data[$key] = $value;
            }

            /* Get All Lective Days */
            $days = $this->timetables_model->getAllLectiveDays();
            $data['days']=$days;

            /* Get All Timetable Lessons For Teacher*/
            $lessonsfortimetablebyteacherid = $this->timetables_model->get_all_lessonsfortimetablebyteacherid($teacher_id);
            $lessonsfortimetablebyteacherid = $this->add_breaks($lessonsfortimetablebyteacherid,$data['first_time_slot_order'],$data['last_time_slot_order']);
            $data['lessonsfortimetablebyteacherid']= $lessonsfortimetablebyteacherid;

            $all_teacher_study_modules = $this->timetables_model->get_all_teacher_study_modules($teacher_id)->result();
            $data['all_teacher_study_modules']= $all_teacher_study_modules;

            for($i=0;$i<count($all_teacher_study_modules);$i++)
            {
                $study_module_id = $all_teacher_study_modules[$i]->study_module_id;
                $group_by_study_modules[$study_module_id] = $this->timetables_model->get_all_group_by_study_module($study_module_id,$teacher_id);                       
            }

            $data['group_by_study_modules'] = $group_by_study_modules;

            $total_week_hours = 0;
            foreach($all_teacher_study_modules as $module){
                $hours[] = $this->timetables_model->get_module_hours_per_week($module->study_module_id);
                $total_week_hours += $this->timetables_model->get_module_hours_per_week($module->study_module_id);
            }

            $data['all_teacher_study_modules_hours_per_week'] = $hours;

            $study_modules_colours = $this->_assign_colours_to_study_modules($all_teacher_study_modules);

            $data['study_modules_colours']= $study_modules_colours;

            $data['compact']= $compact;

            $all_teacher_groups = $this->timetables_model->get_all_groups_byteacherid($teacher_id);

            $data['all_teacher_groups']= $all_teacher_groups;

            $array_all_teacher_groups_time_slots = array();
            $lessonsfortimetablebygroupid = array();
            $first_time_slot_orderbygroupid = array();
            foreach ($all_teacher_groups as $teacher_group) {
                # code...
                $classroom_group_id = $teacher_group['classroom_group_id'];
                $shift = $this->timetables_model->get_group_shift($classroom_group_id);
                $array_all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

                //TODO: Pametritzar time slot orders defineixen mati tarda
                $time_slot_order = $this->time_slot_order($shift);
                $shift_first_time_slot_order = $time_slot_order['first'];
                $shift_last_time_slot_order = $time_slot_order['last'];

                $temp = $this->timetables_model->get_all_lessonsfortimetablebygroupid($classroom_group_id);

                $lessonsfortimetablebygroupid[$classroom_group_id] = $this->add_breaks($temp,$shift_first_time_slot_order,$shift_last_time_slot_order);
                $first_time_slot_orderbygroupid[$classroom_group_id] = $shift_first_time_slot_order;
            }

            $data['array_all_teacher_groups_time_slots'] = $array_all_teacher_groups_time_slots;
            $data['lessonsfortimetablebygroupid'] = $lessonsfortimetablebygroupid;
            $data['first_time_slot_orderbygroupid'] = $first_time_slot_orderbygroupid;

            $all_teacher_groups_list = $this->get_teacher_group_list($all_teacher_groups);
            $data['all_teacher_groups_list']= $all_teacher_groups_list;
            $data['all_teacher_groups_count']= count($all_teacher_groups);

            //$total_week_hours = 15;

            $data['total_week_hours'] = $total_week_hours;

            //$all_teacher_study_modules_count = 11;
            $all_teacher_study_modules_count = count($all_teacher_study_modules);

            $total_morning_week_hours = "TODO";
            $total_afternoon_week_hours = "TODO";

            $data['total_morning_week_hours']= $total_morning_week_hours;
            $data['total_afternoon_week_hours']= $total_afternoon_week_hours;

            $data['all_teacher_study_modules_count'] = $all_teacher_study_modules_count;

            $teacher_study_modules_list = $this->timetables_model->get_all_teacher_study_modules($teacher_code)->result_array();
            $all_teacher_study_modules_list = $this->get_teacher_study_modules_list($teacher_study_modules_list);
            $data['all_teacher_study_modules_list'] = $all_teacher_study_modules_list;

            $this->load->view('timetables/allteacherstimetables',$data);
            
            $this->_load_body_footer();
    }

    public function allgroupstimetables($classroom_group_id = null) {
        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

            $header_data = $this->load_header_data();            
            $this->_load_html_header($header_data);
            $this->_load_body_header();

            //Load classroom_groups from Model
            $classroom_groups_array = $this->timetables_model->get_all_classroom_groups_ids_and_names();

            $data['classroom_groups'] = $classroom_groups_array;

            //TODO: Get default group id by User Session? or by config file?
            if ($classroom_group_id == null)
                $classroom_group_id = 4;
            
            $time_slots_array = array();
            $data['default_classroom_group'] = $classroom_group_id;                           
            
            $shift = $this->timetables_model->get_group_shift($classroom_group_id);
            $time_slots_array = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

            $all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

            //TODO: Pametritzar time slot orders defineixen mati tarda
                $time_slot_order = $this->time_slot_order($shift);
                $shift_first_time_slot_order = $time_slot_order['first'];
                $shift_last_time_slot_order = $time_slot_order['last'];            
            
            //Get last time slot order

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
            $data['first_time_slot_order']=$shift_first_time_slot_order;
            $data['last_time_slot_order']=$shift_last_time_slot_order;

            $days = $this->timetables_model->getAllLectiveDays();

            $data['days']=$days;

            $temp = $this->timetables_model->get_all_lessonsfortimetablebygroupid($classroom_group_id);

            $lessonsfortimetablebygroupid = $this->add_breaks($temp,$shift_first_time_slot_order,$shift_last_time_slot_order);

            //print_r($lessonsfortimetablebygroupid);                                  

            $data['lessonsfortimetablebygroupid']= $lessonsfortimetablebygroupid;
//echo $classroom_group_id;
            
            /* EL CAMP study_module_classroom_group_id DE LA BASE DE DADES NO CONTÉ VALORS */
            /*
            $all_group_study_modules = $this->timetables_model->get_all_group_study_modules($classroom_group_id)->result();
                //print_r($all_group_study_modules);
            $data['all_group_study_modules']= $all_group_study_modules;
            $study_modules_colours = $this->_assign_colours_to_study_modules($all_group_study_modules);
                //print_r($study_modules_colours);
            $data['study_modules_colours']= $study_modules_colours;
            */
            $days = $this->timetables_model->getAllLectiveDays();
//            $data['days']=$days;

            $this->load->view('timetables/allgroupstimetables',$data);
            
            $this->_load_body_footer();   
    }
	
	public function mytimetables($compact = "") {

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

            //No s'utilitza el select2, es podria evitar que cargués
            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();

            //TODO: set teacher id by session values (current session user)
            $teacher_id=40;

            $teacher_code = $this->timetables_model->get_teacher_code_from_teacher_id($teacher_id);            
            $teacher_full_name = $this->timetables_model->get_teacher_fullname_from_teacher_id($teacher_id);
            $data["teacher_code"] = $teacher_code;
            $data["teacher_id"] = $teacher_id;
            $data["teacher_full_name"] = $teacher_full_name;

            //echo "Teacher code: $teacher_code | teacher_id: $teacher_id | teacher_full_name: $teacher_full_name";

            /* Get Timeslots */            
            $timeslots = $this->get_time_slots($compact,$teacher_id);
            foreach($timeslots as $key => $value){
                $data[$key] = $value;
            }

            /* Get All Lective Days */
            $days = $this->timetables_model->getAllLectiveDays();
            $data['days']=$days;

            /* Get All Timetable Lessons For Teacher*/
            $lessonsfortimetablebyteacherid = $this->timetables_model->get_all_lessonsfortimetablebyteacherid($teacher_id);
            $lessonsfortimetablebyteacherid = $this->add_breaks($lessonsfortimetablebyteacherid,$data['first_time_slot_order'],$data['last_time_slot_order']);
            $data['lessonsfortimetablebyteacherid']= $lessonsfortimetablebyteacherid;

            $all_teacher_study_modules = $this->timetables_model->get_all_teacher_study_modules($teacher_id)->result();
            $data['all_teacher_study_modules']= $all_teacher_study_modules;

            for($i=0;$i<count($all_teacher_study_modules);$i++)
            {
                $study_module_id = $all_teacher_study_modules[$i]->study_module_id;
                $group_by_study_modules[$study_module_id] = $this->timetables_model->get_all_group_by_study_module($study_module_id,$teacher_id);                       
            }
            $data['group_by_study_modules'] = $group_by_study_modules;

            $total_week_hours = 0;
            foreach($all_teacher_study_modules as $module){
                $hours[] = $this->timetables_model->get_module_hours_per_week($module->study_module_id);
                $total_week_hours += $this->timetables_model->get_module_hours_per_week($module->study_module_id);
            }

            $data['all_teacher_study_modules_hours_per_week'] = $hours;

            $study_modules_colours = $this->_assign_colours_to_study_modules($all_teacher_study_modules);

            $data['study_modules_colours']= $study_modules_colours;

            $data['compact']= $compact;

            $all_teacher_groups = $this->timetables_model->get_all_groups_byteacherid($teacher_id);

            $data['all_teacher_groups']= $all_teacher_groups;

            $array_all_teacher_groups_time_slots = array();
            $lessonsfortimetablebygroupid = array();
            $first_time_slot_orderbygroupid = array();
            foreach ($all_teacher_groups as $teacher_group) {
                # code...
                $classroom_group_id = $teacher_group['classroom_group_id'];
                $shift = $this->timetables_model->get_group_shift($classroom_group_id);
                $array_all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

                //TODO: Pametritzar time slot orders defineixen mati tarda
                $time_slot_order = $this->time_slot_order($shift);
                $shift_first_time_slot_order = $time_slot_order['first'];
                $shift_last_time_slot_order = $time_slot_order['last'];

                $temp = $this->timetables_model->get_all_lessonsfortimetablebygroupid($classroom_group_id);

                $lessonsfortimetablebygroupid[$classroom_group_id] = $this->add_breaks($temp,$shift_first_time_slot_order,$shift_last_time_slot_order);
                $first_time_slot_orderbygroupid[$classroom_group_id] = $shift_first_time_slot_order;
            }

            $data['array_all_teacher_groups_time_slots'] = $array_all_teacher_groups_time_slots;
            $data['lessonsfortimetablebygroupid'] = $lessonsfortimetablebygroupid;
            $data['first_time_slot_orderbygroupid'] = $first_time_slot_orderbygroupid;

            $all_teacher_groups_list = $this->get_teacher_group_list($all_teacher_groups);
            $data['all_teacher_groups_list']= $all_teacher_groups_list;
            $data['all_teacher_groups_count']= count($all_teacher_groups);

            //$total_week_hours = 15;

            $data['total_week_hours'] = $total_week_hours;

            //$all_teacher_study_modules_count = 11;
            $all_teacher_study_modules_count = count($all_teacher_study_modules);

            $total_morning_week_hours = "TODO";
            $total_afternoon_week_hours = "TODO";

            $data['total_morning_week_hours']= $total_morning_week_hours;
            $data['total_afternoon_week_hours']= $total_afternoon_week_hours;

            $data['all_teacher_study_modules_count'] = $all_teacher_study_modules_count;

            $teacher_study_modules_list = $this->timetables_model->get_all_teacher_study_modules($teacher_code)->result_array();
            $all_teacher_study_modules_list = $this->get_teacher_study_modules_list($teacher_study_modules_list);
            $data['all_teacher_study_modules_list'] = $all_teacher_study_modules_list;

            $this->load->view('timetables/mytimetables',$data);

            $this->_load_body_footer();
    }

    protected function _assign_colours_to_study_modules($study_modules) {
        $study_modules_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info"    ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger"  ,
                   6 => "btn-sadlebrown" ,
                   7 => "btn-purple" ,
                   8 => "btn-gold" ,
                   9 => "btn-palegreen" ,
                   10 => "btn-lightgray" ,
                   11 => "btn-yellow" ,
                   12 => "btn-chocolate",
                   13 => "btn-coral",
                   14 => "btn-olivedrab",
                   15 => "btn-yellowgreen",
                   16 => "btn-mignightblue",
                   17 => "btn-darkred",
                   18 => "btn-crimson",
                   19 => "btn-default",
                   20 => "btn-darkslategray"
                   );
        $index=1;
        foreach ($study_modules as $study_module) {
            $study_modules_colours[$study_module->study_module_id] = $bootstrap_button_colours[$index];
            $index++;
        }
            
        return $study_modules_colours;
    }



    public function add_breaks($lessons,$first_time_slot_order,$last_time_slot_order) {
        
        $days = $this->timetables_model->getAllLectiveDays();

        //ADD BREAKS
        $not_lective_time_slots_array = $this->timetables_model->getNotLectiveTimeSlots()->result_array();

        //print_r($not_lective_time_slots_array);

        foreach ($days as $day) {
            $day_number = $day->day_number;
            //echo $day->day_shortname . " : " . print_r($lessons[$day_number]) . "<br/><br/>";

            if (!array_key_exists ( $day_number , $lessons ))    {
                $day_lessons = array();
            } else {
                $day_lessons = $lessons[$day_number]->lesson_by_day;    
            }
                

            foreach ($not_lective_time_slots_array as $not_lective_time_slot)   {
                $time_slot_start_time = $not_lective_time_slot['time_slot_start_time'];
                
                $lesson_data = new stdClass;
                
                $lesson_data->time_slot_order = $not_lective_time_slot['time_slot_order'];

                if ($first_time_slot_order >= $lesson_data->time_slot_order || $lesson_data->time_slot_order  >= $last_time_slot_order) {
                    continue;
                }

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

            $lessons[$day_number]->lesson_by_day = $day_lessons;
        }
        
        return $lessons;
    }
	
	public function index() {
		$this->mytimetables();
	}
	
    public function load_header_data(){

        $header_data= $this->add_css_to_html_header_data(
                $this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/tribal-timetable.css'));        
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"); 
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap-switch.min.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap.min.extracolours.css'));


            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
                    
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            //$header_data= $this->add_javascript_to_html_header_data(
            //        $header_data,
            //        "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
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
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

            return $header_data;
    }

    public function time_slot_order($shift){

        if ($shift == 2) {
            $shift_first_time_slot_order = $this->config->item('afternoon_first_time_slot');//9;
            $shift_last_time_slot_order = $this->config->item('afternoon_last_time_slot');//15;
        }
        else {
            $shift_first_time_slot_order = $this->config->item('morning_first_time_slot');//1;
            $shift_last_time_slot_order = $this->config->item('morning_last_time_slot');//7;
        }
        $time_slot_order['first'] = $shift_first_time_slot_order;
        $time_slot_order['last'] = $shift_last_time_slot_order;
        return $time_slot_order;
    }

    public function get_time_slots($compact,$teacher_id)
    {
            $complete_time_slots_array = $this->timetables_model->getAllTimeSlots()->result_array();
            $data['complete_time_slots_count'] = count($complete_time_slots_array);            

            //$time_slots_array = $this->get_time_slots_array($compact,$teacher_id);
            if ($compact) {
                $time_slots_array = $complete_time_slots_array;
            } else {
                $time_slots_array = $this->timetables_model->getCompactTimeSlotsForTeacher($teacher_id)->result_array();
            }

            $data['time_slots_array'] = $time_slots_array;

            //Get first and last time slot order
            $keys = array_keys($time_slots_array);
            $first_time_slot_order = $time_slots_array[$keys[0]]['time_slot_order'];
            $data['first_time_slot_order'] = $first_time_slot_order;            
            $last_time_slot_order = $time_slots_array[$keys[count($time_slots_array)-1]]['time_slot_order'];
            $data['last_time_slot_order'] = $last_time_slot_order;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time = $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval = $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];

                $time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }

            $data['time_slots'] = $time_slots;
            $data['time_slots_count'] = count($time_slots);

            return $data;
    }

    public function get_teacher_group_list($all_teacher_groups)
    {

            foreach($all_teacher_groups as $teacher_group_list){
                    $all_teacher_groups_list[] = $teacher_group_list['classroom_group_code'];
                }
            return $all_teacher_groups_list;
        /*
            $group_list_first=0;
            foreach($all_teacher_groups as $teacher_group_list){
                if($group_list_first==0)
                {
                    $all_teacher_groups_list = $teacher_group_list['classroom_group_code'];
                } else {
                    $all_teacher_groups_list .= ", ".$teacher_group_list['classroom_group_code'];
                }
                $group_list_first++;                
            }
            return $all_teacher_groups_list;
        */
    }

    public function get_teacher_study_modules_list($teacher_study_modules_list)
    {
            foreach ($teacher_study_modules_list as $mod_list){
                $module_list[] = $mod_list['study_module_shortname'];
            }
            $module_list = array_unique($module_list);

            foreach ($module_list as $study_module_list)
            {
                    $all_teacher_study_modules_list[] = $study_module_list;
            }
            return $all_teacher_study_modules_list;


/*
            $study_module_first=0;
            foreach ($module_list as $study_module_list)
            {
                if($study_module_first==0)
                {
                    $all_teacher_study_modules_list = $study_module_list;
                } else {
                    $all_teacher_study_modules_list .= ", ".$study_module_list;
                }
                $study_module_first++;
            }
            return $all_teacher_study_modules_list;
*/

    }
	
    public function classroom_group_info($id_group){

        if (!$this->skeleton_auth->logged_in())
            {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
            }
            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data['id_group'] = $id_group;

            $this->load->view('timetables/groupinfo',$data);

            $this->_load_body_footer();       

    }

    public function study_module_info($id_study_module){

        if (!$this->skeleton_auth->logged_in())
            {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
            }
            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data['id_study_module'] = $id_study_module;

            $this->load->view('timetables/studymoduleinfo',$data);

            $this->_load_body_footer();     

    }

    public function location_info($id_location){

        if (!$this->skeleton_auth->logged_in())
            {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
            }
            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data['id_location'] = $id_location;

            $this->load->view('timetables/locationinfo',$data);

            $this->_load_body_footer(); 

    }        

}
