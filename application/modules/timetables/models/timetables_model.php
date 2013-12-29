<?php
/**
 * timetables_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class timetables_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language','skeleton_auth');
        }
        
        $this->lang->load('timetables', $current_language);
    }
    
    function get_primary_key($table_name) {
		$fields = $this->db->field_data($table_name);
		
		foreach ($fields as $field)	{
			if ($field->primary_key) {
					return $field->name;
			}
		} 	
		return false;
	}

	function get_all_teacher_study_modules($teacher_id) {
		$this->db->from('study_module');
        $this->db->select('study_module_id,study_module_shortname,study_module_name,study_module_hoursPerWeek');

		$this->db->where('study_module_teacher_id',$teacher_id);
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query;
		}			
		else
			return false;
	}

	function get_all_lessonsfortimetablebyteacherid($teacher_id) {

		$this->db->from('lesson');
        $this->db->select('lesson_id,lesson_code,lesson_day,time_slot_start_time,time_slot_order,study_module_id,study_module_shortname,study_module_name,
        	group_code,group_shortName,group_name');

		$this->db->order_by('lesson_day,time_slot_order', "asc");
		
		$this->db->join('teacher', 'lesson.lesson_teacher_id = teacher.teacher_id');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.group_id','left');

		$this->db->where('teacher.teacher_id',$teacher_id);
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$all_lessonsfortimetablebyteacherid = array();

			$previous_day=null;
			foreach ($query->result_array() as $row)	{
				
				$day=$row['lesson_day'];
				$time_slot_start_time = $row['time_slot_start_time'];
				$lesson_id = $row['lesson_id'];
				$lesson_code = $row['lesson_code'];
				$time_slot_order = $row['time_slot_order'];
				$study_module_id = $row['study_module_id'];
				$study_module_shortname = $row['study_module_shortname'];
				$study_module_name = $row['study_module_name'];
				$group_code = $row['group_code'];
				$group_shortName = $row['group_shortName'];
				$group_name = $row['group_name'];
			
				if ($previous_day == null || $day != $previous_day) {
					$day_lessons = new stdClass;	
					$lesson_by_day = array();
				}

				$lesson_data = new stdClass;

				$lesson_data->lesson_id= $lesson_id;
				$lesson_data->lesson_code= $lesson_code;
				$lesson_data->time_slot_order= $time_slot_order;
				$lesson_data->study_module_id= $study_module_id;
				$lesson_data->study_module_shortname= $study_module_shortname;
				$lesson_data->study_module_shortname= $study_module_shortname;
				$lesson_data->study_module_name= $study_module_name;
				$lesson_data->group_code= $group_code;
				$lesson_data->group_shortName= $group_shortName;
				$lesson_data->group_name= $group_name;
				$lesson_data->time_slot_lective=false;
				$lesson_data->location_code="20.2";
	
				$lesson_data->duration= 1;

				$lesson_by_day[$time_slot_start_time] = $lesson_data;

								
				$day_lessons->lesson_by_day = $lesson_by_day;

   				$all_lessonsfortimetablebyteacherid[$day] = $day_lessons;

   				$previous_day=$day;
			}
			return $all_lessonsfortimetablebyteacherid;
		}			
		else
			return false;


		/*SELECT `lesson_id` , `lesson_code` , `lesson_day` , time_slot.time_slot_start_time, time_slot_order, `lesson_code` , study_module_shortname, study_module_name,group_code, group_shortName,group_name
		FROM `lesson`
		INNER JOIN teacher ON lesson.`lesson_teacher_id` = teacher.teacher_id
		INNER JOIN time_slot ON lesson.lesson_time_slot_id = time_slot.time_slot_id
		LEFT JOIN study_module ON lesson.lesson_study_module_id = study_module.study_module_id
		LEFT JOIN classroom_group ON lesson.lesson_classroom_group_id =  classroom_group.group_id
		WHERE teacher.teacher_code =41
		ORDER BY `lesson_day`,time_slot_order ASC*/
	}



	function get_all_classroom_groups_ids_and_names($orderby= "asc") {

		$this->db->from('classroom_group');
        $this->db->select('group_id,group_code,group_shortName,group_name');

		$this->db->order_by('group_code', $orderby);
		
		//$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$classroom_groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$classroom_groups_array[$row['group_id']] = $row['group_code'] . " - " . $row['group_name'] . " ( " . $row['group_shortName'] . ")";
			}
			return $classroom_groups_array;
		}			
		else
			return false;
	}

	function getAllLectiveDays() {
		
		$monday = new stdClass;
        $monday->day_shortname = lang('monday_shortname'); 
        $monday->day_number = 1; 

        $tuesday = new stdClass;
        $tuesday->day_shortname = lang('tuesday_shortname');
        $tuesday->day_number = 2;

        $wednesday = new stdClass;
        $wednesday->day_shortname = lang('wednesday_shortname');
        $wednesday->day_number = 3;

        $thursday = new stdClass;
        $thursday->day_shortname = lang('thursday_shortname');
        $thursday->day_number = 4;

        $friday = new stdClass;
        $friday->day_shortname = lang('friday_shortname');
        $friday->day_number = 5;

        return array ($monday, $tuesday, $wednesday, $thursday, $friday );
    }



	function getAllTimeSlots($orderby="asc") {
		
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getNotLectiveTimeSlots($orderby="asc") {
		
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,time_slot_order');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$this->db->where('time_slot_lective', 0);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}	
	

	function get_all_teachers_ids_and_names($orderby="asc") {

		$this->db->from('teacher');
        $this->db->select('teacher_code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		$this->db->order_by('teacher_code', $orderby);
		
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_code']] = $row['teacher_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
			}
			return $teachers_array;
		}			
		else
			return false;
	}

	
	
}
