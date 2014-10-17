<?php
/**
 * Attendance_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class attendance_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
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

	function is_user_a_teacher ($person_id) {

		$this->db->select('teacher_id');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_person_id',$person_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		}			
		return false;
	}

	function get_teacher_code_by_personid($person_id) {

		$get_current_academic_period = $this->get_current_academic_period_id();
		/*
		SELECT teacher_academic_periods_code
		FROM teacher_academic_periods 
		INNER JOIN teacher ON teacher.teacher_id =  teacher_academic_periods.teacher_academic_periods_teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE teacher_academic_periods_academic_period_id=5 AND person_id= 56
		*/
		
		$this->db->select('teacher_academic_periods_code');
		$this->db->from('teacher_academic_periods');
		$this->db->join('teacher','teacher.teacher_id =  teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person','person.person_id = teacher.teacher_person_id');
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$get_current_academic_period);
		$this->db->where('person.person_id',$person_id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";


		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_academic_periods_code;
		}			
		return false;
	}

	function get_academic_period_id_by_period($period_shortname) {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_shortname',$period_shortname);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_id;
		}	
		else
			return false;
	}

	function get_academic_period_name_by_period_id($academic_period_id) {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_shortname');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_id',$academic_period_id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_shortname;
		}	
		else
			return false;
	}

	function getAllGroupStudentsInfo($class_group_id,$academic_period_id=null) {
		
		if ($academic_period_id==null) {
			$academic_period = $this->get_current_academic_period()->shortname;
		} else {
			$academic_period = $this->get_academic_period_name_by_period_id($academic_period_id);
		}

		/*
		EXAMPLE
		SELECT person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.username, person.person_secondary_email
		FROM person
		INNER JOIN users ON person.person_id = users.person_id
		INNER JOIN enrollment ON users.person_id = enrollment.enrollment_personid
		WHERE enrollment.enrollment_group_id =26 AND enrollment_periodid="2014-15"
		*/


		$this->db->select('person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.id ,users.username, person.person_secondary_email, person.person_photo, person.person_official_id');
		$this->db->from('person');
		$this->db->join('users','person.person_id = users.person_id');
		$this->db->join('enrollment','users.person_id = enrollment.enrollment_personid');		
		$this->db->where('enrollment.enrollment_group_id',$class_group_id);
		$this->db->where('enrollment.enrollment_periodid',$academic_period);
		
		$this->db->order_by('person.person_sn1');
		$this->db->order_by('person.person_sn2');
		$this->db->order_by('person.person_givenName');
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0) {
			$student_info_array = array();

			foreach ($query->result_array() as $row)	{

				//$student_info_array[] = $row;
   				$student = new stdClass();
				
				$student->person_id = $row['person_id'];
				$student->sn1 = $row['person_sn1'];
				$student->sn2 = $row['person_sn2'];
				$student->givenName = $row['person_givenName'];
				$student->username = $row['username'];
				$student->userid = $row['id'];
				$student->email = $row['person_secondary_email'];
				$student->photo_url = $row['person_photo'];
				$student->person_official_id = $row['person_official_id'];
				
				//echo "person_photo (user: " . $student->sn1 . " " . $student->sn2 . ", " . $student->givenName . "): " . $row['person_photo'] . "<br/>" ;
				
				$student_info_array[$student->person_id] = $student;

			}

			return $student_info_array;
		}			
		else {
			return array();
		}
			

	}

	function getAllIncidentsGroupByDate($group,$start_date,$end_date = false) {
		$this->db->select('person.person_id, student.student_id, person.person_givenName, person.person_sn1, person.person_sn2, 
			attendance_incident.attendance_incident_day, 
			attendance_incident.data_incidencia, classroom_group.classroom_group_code, attendance_incident.attendance_incident_type');
		$this->db->from('student');
		$this->db->join('person','student.student_person_id = person.person_id');
		$this->db->join('attendance_incident','attendance_incident.attendance_incident_student_id = student.student_id');
		$this->db->join('enrollment_class_group','enrollment_class_group_personid = person.person_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment_class_group.enrollment_class_group_group_id');
		$this->db->where('enrollment_class_group.enrollment_class_group_group_id = ', $group);
		
		if($end_date == false){
			$this->db->where('attendance_incident.data_incidencia =', $start_date);
		} else {
			$this->db->where('attendance_incident.data_incidencia >=', $start_date);
			$this->db->where('attendance_incident.data_incidencia <=', $end_date);
		}
		
		$this->db->order_by('person.person_sn1');
		$this->db->order_by('person.person_sn2');
		$this->db->order_by('person.person_givenName');
		$this->db->order_by('attendance_incident.data_incidencia');
		$this->db->distinct();
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$student_incident_array = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				
				//$incident->person_id = $row['person_id'];
				$incident->student_id = $row['student_id'];
				$incident->sn1 = $row['person_sn1'];
				$incident->sn2 = $row['person_sn2'];
				$incident->givenName = $row['person_givenName'];
				$incident->incident_type = $row['attendance_incident_type'];
				$incident->incident_date = $row['data_incidencia'];				
				
				$student_incident_array[] = $incident;

			}

			return $student_incident_array;
		}			
		else
			return false;

	}

	function getAllIncidentsGroupByMonth($group,$month,$year) {
		$this->db->select('person.person_id, student.student_id, person.person_givenName, person.person_sn1, person.person_sn2, 
			attendance_incident.attendance_incident_day, 
			attendance_incident.data_incidencia, classroom_group.classroom_group_code, attendance_incident.attendance_incident_type');
		$this->db->from('student');
		$this->db->join('person','student.student_person_id = person.person_id');
		$this->db->join('attendance_incident','attendance_incident.attendance_incident_student_id = student.student_id');
		$this->db->join('enrollment_class_group','enrollment_class_group_personid = person.person_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment_class_group.enrollment_class_group_group_id');
		$this->db->where('enrollment_class_group.enrollment_class_group_group_id = ', $group);
		
		$this->db->where('month(attendance_incident.data_incidencia)', $month);
		$this->db->where('year(attendance_incident.data_incidencia)', $year);
		
		$this->db->order_by('attendance_incident.data_incidencia');		

		$this->db->distinct();
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$student_incident_array = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				
				//$incident->person_id = $row['person_id'];
				$incident->student_id = $row['student_id'];
				$incident->sn1 = $row['person_sn1'];
				$incident->sn2 = $row['person_sn2'];
				$incident->givenName = $row['person_givenName'];
				$incident->incident_type = $row['attendance_incident_type'];
				$incident->incident_date = $row['data_incidencia'];				
				
				$student_incident_array[] = $incident;

			}

			return $student_incident_array;
		}			
		else
			return false;

	}



	function getAllStudentsMail($academic_period_id=null){

		if ($academic_period_id==null) {
			$academic_period = $this->get_current_academic_period()->shortname;
		} else {
			$academic_period = $this->get_academic_period_name_by_period_id;
		}
		/*
		SELECT person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.username, person.person_secondary_email
		FROM person
		INNER JOIN users ON person.person_id = users.person_id
		INNER JOIN enrollment ON users.person_id = enrollment.enrollment_personid
		WHERE enrollment_periodid="2014-15"
		*/

		$this->db->select('person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.username, person.person_email, person.person_secondary_email');
		$this->db->from('person');
		$this->db->join('users','person.person_id = users.person_id');
		$this->db->join('enrollment','users.person_id = enrollment.enrollment_personid');
		$this->db->where('enrollment_periodid',$academic_period);
		
		$this->db->order_by('person.person_sn1');
		$this->db->order_by('person.person_sn2');
		$this->db->order_by('person.person_givenName');
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$student_info_array = array();

			foreach ($query->result_array() as $row)	{

				//$student_info_array[] = $row;
   				$student = new stdClass();
				
				//$student->id = $row['student_id'];
				$student->person_id = $row['person_id'];
				$student->sn1 = $row['person_sn1'];
				$student->sn2 = $row['person_sn2'];
				$student->givenName = $row['person_givenName'];
//				$student->username = $row['username'];
				$student->email = $row['person_email'];
				$student->secondary_email = $row['person_secondary_email'];
				$student_info_array[$student->person_id] = $student;

			}

			return $student_info_array;
		}			
		else
			return false;

	}

	function getGroupInfoByGroupId($group_id) {
		$this->db->select('classroom_group_id,classroom_group_name,classroom_group_shortName,classroom_group_code');
		$this->db->from('classroom_group');
		
		$this->db->where('classroom_group.classroom_group_id',$group_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array('id' => $row->classroom_group_id, 'name' => $row->classroom_group_name, 'shortname' => $row->classroom_group_shortName, 'code' => $row->classroom_group_code);
		}			
		else {
			return "";
		}
	}

	function getStudyModuleInfoByModuleId($study_module_id) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT study_module_academic_periods_study_module_id, study_module_academic_periods_external_code, study_module.study_module_shortname, 
		study_module.study_module_name 
		FROM (study_module) 
		JOIN study_module_academic_periods ON study_module_academic_periods_study_module_id = study_module_id 
		WHERE study_module_academic_periods.study_module_academic_periods_study_module_id = '244' AND study_module_academic_periods.study_module_academic_periods_academic_period_id = '5'
		*/

		$this->db->select('study_module_academic_periods_study_module_id,study_module_academic_periods_external_code,study_module.study_module_shortname,study_module.study_module_name');
		$this->db->from('study_module');
		$this->db->join('study_module_academic_periods','study_module_academic_periods_study_module_id = study_module_id');
		$this->db->where('study_module_academic_periods.study_module_academic_periods_study_module_id',$study_module_id);
		$this->db->where('study_module_academic_periods.study_module_academic_periods_academic_period_id',$current_academic_period_id);		
		
		$query = $this->db->get();
		//echo "query:" . $this->db->last_query();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array('name' => $row->study_module_name, 'shortname' => $row->study_module_shortname, 'code' => $row->study_module_academic_periods_external_code);
		}			
		else {
			return "";
		}
	}

	public function getStudy_module_info($day,$time_lot,$classgroup_id) {
		
		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
			SELECT lesson_study_module_id, study_module_shortname, study_module_name, lesson_teacher_id, teacher_academic_periods_code, 
			person_givenName, person_sn1, person_sn2 
			FROM (lesson) 
			JOIN study_module ON lesson.lesson_study_module_id = study_module.study_module_id 
			JOIN study_module_academic_periods ON study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id 
			JOIN teacher ON lesson.lesson_teacher_id = teacher.teacher_id 
			JOIN teacher_academic_periods ON teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id 
			JOIN person ON teacher.teacher_person_id = person.person_id 
			WHERE lesson.lesson_day = '3' AND lesson.lesson_time_slot_id = '1' AND lesson.lesson_classroom_group_id = '39' AND teacher_academic_periods_academic_period_id = '5' AND study_module_academic_periods_academic_period_id = '5' AND lesson_academic_period_id = '5' 

		*/

		$this->db->select("lesson_study_module_id, study_module_shortname, study_module_name, lesson_teacher_id, teacher_academic_periods_code , person_givenName, person_sn1, person_sn2");
		$this->db->from('lesson');
		$this->db->join('study_module','lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('study_module_academic_periods',' study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id');
		$this->db->join('teacher','lesson.lesson_teacher_id = teacher.teacher_id');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person','teacher.teacher_person_id = person.person_id');
		$this->db->where('lesson.lesson_day',$day);
		$this->db->where('lesson.lesson_time_slot_id',$time_lot);
		$this->db->where('lesson.lesson_classroom_group_id',$classgroup_id);
		$this->db->where('teacher_academic_periods_academic_period_id', $current_academic_period_id);
		$this->db->where('study_module_academic_periods_academic_period_id', $current_academic_period_id);		
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);
		
		$query = $this->db->get();
		//echo "query:" . $this->db->last_query();


		if ($query->num_rows() > 0) { 

			$study_module_info = array();

			$row = $query->row();

			$study_module_info['id'] = $row->lesson_study_module_id;
			$study_module_info['shortname'] = $row->study_module_shortname;
			$study_module_info['name'] = $row->study_module_name;

			$study_module_info['teacher_id'] = $row->lesson_teacher_id;
			$study_module_info['teacher_code'] = $row->teacher_academic_periods_code;
			$study_module_info['teacher_givenName'] = $row->person_givenName;
			$study_module_info['teacher_sn1'] = $row->person_sn1;
			$study_module_info['teacher_sn2'] = $row->person_sn2;
				
			return $study_module_info;

		}			
		else {
			return false;
		}
	}

	public function getTimeSlotsByClassgroupId($classgroup_id,$day) {
		/*
		SELECT DISTINCT time_slot_id , time_slot_start_time , time_slot_end_time , time_slot_lective, time_slot_order
		FROM time_slot
		INNER JOIN lesson ON time_slot.time_slot_id = lesson.lesson_time_slot_id
		WHERE time_slot_lective =1
		AND lesson.lesson_classroom_group_id = 25
		ORDER BY time_slot_order
		*/

		$this->db->select("time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective, time_slot_order");
		$this->db->from('time_slot');
		$this->db->join('lesson','time_slot.time_slot_id = lesson.lesson_time_slot_id');
		
		$this->db->where('time_slot.time_slot_lective',1);
		$this->db->where('lesson.lesson_classroom_group_id',$classgroup_id);
		$this->db->order_by('time_slot_order');

		$this->db->distinct();

		$query = $this->db->get();

		//echo "query:" . $this->db->last_query();
		
		if ($query->num_rows() > 0) {
			
			$time_slots = array();

			$i=1;
			$results_array = $query->result_array();
			if ( is_array($results_array) ) {
				foreach ( $results_array as $row)	{
					$time_slot = new stdClass();

					$time_slot->id = $row['time_slot_id'];
					$time_slot->hour = $row['time_slot_start_time'];
					$time_slot->range = $row['time_slot_start_time'] . " - " . $row['time_slot_end_time'];

					$study_module_info = $this->getStudy_module_info ($day, $time_slot->id, $classgroup_id);

					$time_slot->study_module_id = $study_module_info['id'];
					$time_slot->study_module_shortname = $study_module_info['shortname'];
					$time_slot->study_module_name = $study_module_info['name'];

					$study_submodules = $this->getStudySubModulesFromStudyModuleId( $time_slot->study_module_id );

					$time_slot->study_submodules = $study_submodules;

					$time_slot->teacher_id = $study_module_info['teacher_id'];
					$time_slot->teacher_code = $study_module_info['teacher_code'];
					$time_slot->teacher_name = $study_module_info['teacher_sn1'] . " " . $study_module_info['teacher_sn2'] . ", " . $study_module_info['teacher_givenName'];

					$time_slots[$i] = $time_slot;
					$i++;
				}	
			}
			
			return $time_slots;
		}			
		else {
			return false;
		}
	}

	public function getStudySubModulesFromStudyModuleId( $study_module_id, $orderby = "ASC" ) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT study_submodules_id, study_submodules_shortname, study_submodules_name, study_submodules_initialDate, study_submodules_endDate, study_submodules_totalHours
		FROM study_submodules 
		INNER JOIN study_module
		ON study_module_id = study_submodules_study_module_id
		WHERE study_module_id=273
		*/

		$this->db->select("study_submodules_id, study_submodules_shortname, study_submodules_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours");
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_module_id = study_submodules_study_module_id');
		$this->db->join('study_submodules_academic_periods','study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id = study_submodules.study_submodules_id');
		
		$this->db->where('study_module.study_module_id', $study_module_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $current_academic_period_id);

		$this->db->order_by('study_submodules_order',$orderby);
		$this->db->order_by('study_submodules_shortname',$orderby);

		$this->db->distinct();
		$query = $this->db->get();
		//echo "query:" . $this->db->last_query();
		
		if ($query->num_rows() > 0) {
			
			$study_submodules = array();

			$results_array = $query->result_array();
			if ( is_array($results_array) ) {
				foreach ( $results_array as $row)	{
					$study_submodule = new stdClass();

					$study_submodule->shortname = $row['study_submodules_shortname'];
					$study_submodule->name = $row['study_submodules_name'];

					$startdate = date_format(new DateTime($row['study_submodules_academic_periods_initialDate']),"d/m/Y");
					$finaldate = date_format(new DateTime($row['study_submodules_academic_periods_endDate']),"d/m/Y");

					$study_submodule->id = $row['study_submodules_id'];
					$study_submodule->startdate = $startdate;
					$study_submodule->finaldate = $finaldate;
					$study_submodule->totalHours = $row['study_submodules_academic_periods_totalHours'];

					$study_submodule->active = $this->check_in_range($row['study_submodules_academic_periods_initialDate'], $row['study_submodules_academic_periods_endDate'], now());

					$study_submodules[$row['study_submodules_id']] = $study_submodule;
				}	
			}
			
			//check at least one study submodule is active!
			if ( ! $this->_check_if_at_least_one_study_submodule_is_active($study_submodules)) {
				list($key, $first_study_submodule) = each($study_submodules);
				$first_study_submodule->active = true;
				$study_submodules[$first_study_submodule->id] = $first_study_submodule;
			}
			
			return $study_submodules;
		}			
		else {
			return false;
		}
	}

	private function _check_if_at_least_one_study_submodule_is_active($study_submodules) {

		//check at least one study submodule is active!
		foreach ($study_submodules as $key => $study_submodule) {
			if ( $study_submodule->active ) {
				return true;
			}
		}		

		return false;
	}

	private function check_in_range($start_date, $end_date, $date_from_user) {

		// Convert to timestamp
  		$start_ts = strtotime($start_date);
  		$end_ts = strtotime($end_date);
  		$user_ts = $date_from_user;

  		// Check that user date is between start & end
  		return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

	public function getTimeSlotsByStudyModuleId($classgroup_id) {
		/*
		SELECT DISTINCT time_slot_id , time_slot_start_time , time_slot_end_time , time_slot_lective, time_slot_order
		FROM time_slot
		INNER JOIN lesson ON time_slot.time_slot_id = lesson.lesson_time_slot_id
		WHERE time_slot_lective =1
		AND lesson.lesson_classroom_group_id = 25
		ORDER BY time_slot_order
		*/

		// ******* TODO 

		$this->db->select('time_slot_id, time_slot_start_time , time_slot_end_time , time_slot_lective , time_slot_order');
		$this->db->from('time_slot');
		$this->db->join('lesson','time_slot.time_slot_id = lesson.lesson_time_slot_id');
		$this->db->where('time_slot.time_slot_lective',1);
		$this->db->where('lesson.lesson_classroom_group_id',$classgroup_id);
		
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}			
		else {
			return false;
		}
			
	}
			



/* Get All Group Students Info 

	public function getAllGroupStudentsInfo($groupdn) {
		$allGroupStudentsInfo=array();

		// Imatge Genèrica
		$img_file = APPPATH.'third_party/skeleton/assets/img/foto.png';
		$imgData = file_get_contents($img_file);
		$src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;


		if ($this->_bind()) {
			$filter = '(&  (objectClass=posixAccount)(!(objectClass=gosaUserTemplate)))';		
			$required_attributes= array("irisPersonalUniqueID","irisPersonalUniqueIDType","highSchoolTSI","highSchoolUserId","employeeNumber","sn","sn1","sn2",
										"givenName","gender","homePostalAddress","l","postalCode","st","mobile","homePhone","dateOfBirth","uid","uidnumber","highSchoolPersonalEmail",
										"jpegPhoto","gidNumber","homeDirectory","loginShell","sambaDomainName","sambaHomeDrive","sambaHomePath","sambaLogonScript","sambaSID","sambaPrimaryGroupSID");
			$search = @ldap_search($this->ldapconn, $groupdn, $filter,$required_attributes);
        	$allGroupStudentsDNsentries = @ldap_get_entries($this->ldapconn, $search);
      		$this->ldap_multi_sort($allGroupStudentsDNsentries, array("sn","givenname"));
      		
      		$students = array();
			$i=0;
			
			$this->init_all_groups();
			
			if (count($allGroupStudentsDNsentries) != 0) {
				foreach ($allGroupStudentsDNsentries as $studententry){		
					if ($i == 0) {
						$i++;
						continue;
					}
					$student = new stdClass;
					
					$dn=$studententry['dn'];
					
					$group_dn=$this->obtainGroupDNfromUserDN($dn);
					
					$group_name = $this->extractGroupNameFromDN($group_dn);
					$group_code = $this->extractGroupCodeFromDN($group_dn);
					
					$student->dn = $dn;		
					$student->group_code = $group_code;
					$student->group_name = $group_name;
					$student->irisPersonalUniqueID = (isset($studententry['irispersonaluniqueid'])) ? $studententry['irispersonaluniqueid'][0] : "";	
					$student->irisPersonalUniqueIDType = (isset($studententry['irispersonaluniqueidtype'])) ? $studententry['irispersonaluniqueidtype'][0] : "";
					$student->highSchoolTSI = (isset($studententry['highschooltsi'])) ? $studententry['highschooltsi'][0] : "";
					$student->highSchoolUserId = (isset($studententry['highschooluserid'])) ? $studententry['highschooluserid'][0] : "";
					$student->employeeNumber = (isset($studententry['employeenumber'])) ? $studententry['employeenumber'][0] : "";
					$student->sn = (isset($studententry['sn'])) ? $studententry['sn'][0] : "";
					$student->sn1 = (isset($studententry['sn1'])) ? $studententry['sn1'][0] : "";
					$student->sn2 = (isset($studententry['sn2'])) ? $studententry['sn2'][0] : "";
					$student->givenName = (isset($studententry['givenname'])) ? $studententry['givenname'][0] : "";
					$student->gender = (isset($studententry['gender'])) ? $studententry['gender'][0] : "";
					$student->homePostalAddress = (isset($studententry['homepostaladdress'])) ? $studententry['homepostaladdress'][0] : "";
					$student->location = (isset($studententry['l'])) ? $studententry['l'][0] : "";
					$student->postalCode = (isset($studententry['postalcode'])) ? $studententry['postalcode'][0] : "";
					$student->st = (isset($studententry['st'])) ? $studententry['st'][0] : "";
					$student->state = (isset($studententry['st'])) ? $studententry['st'][0] : "";
					$student->mobile = (isset($studententry['mobile'])) ? $studententry['mobile'][0] : "";
					$student->homePhone = (isset($studententry['homephone'])) ? $studententry['homephone'][0] : "";
					$student->dateOfBirth = (isset($studententry['dateofbirth'])) ? $studententry['dateofbirth'][0] : "";
					$student->uid = (isset($studententry['uid'])) ? $studententry['uid'][0] : "";
					$student->uidnumber = (isset($studententry['uidnumber'])) ? $studententry['uidnumber'][0] : "";
					$student->highSchoolPersonalEmail = (isset($studententry['highschoolpersonalemail'])) ? $studententry['highschoolpersonalemail'][0] : "";
					//$student->jpegPhoto = (isset($studententry['jpegphoto'])) ? $studententry['jpegphoto'][0] : "";
					$student->jpegPhoto = (isset($studententry['jpegphoto'])) ? $studententry['jpegphoto'][0] : $imgData;

					$student->gidNumber = (isset($studententry['gidnumber'])) ? $studententry['gidnumber'][0] : "";
					$student->homeDirectory = (isset($studententry['homedirectory'])) ? $studententry['homedirectory'][0] : "";
					$student->loginShell = (isset($studententry['loginshell'])) ? $studententry['loginshell'][0] : "";
					$student->sambaDomainName = (isset($studententry['sambadomainname'])) ? $studententry['sambadomainname'][0] : "";
					$student->sambaHomeDrive = (isset($studententry['sambahomedrive'])) ? $studententry['sambahomedrive'][0] : "";
					$student->sambaHomePath = (isset($studententry['sambahomepath'])) ? $studententry['sambahomepath'][0] : "";
					$student->sambaLogonScript = (isset($studententry['sambalogonscript'])) ? $studententry['sambalogonscript'][0] : "";
					$student->sambaSID = (isset($studententry['sambasid'])) ? $studententry['sambasid'][0] : "";
					$student->sambaPrimaryGroupSID = (isset($studententry['sambaprimarygroupsid'])) ? $studententry['sambaprimarygroupsid'][0] : "";
		
					array_push($allGroupStudentsInfo,$student);
				}
			}
		}
		return $allGroupStudentsInfo;
	}
*/

function getAllGroupStudentInfo($group){

/* 
SELECT distinct(classroom_group_code), person_givenName, person_sn1, person_sn2 
FROM enrollment_modules 
JOIN person ON person.person_id = enrollment_modules.enrollment_modules_personid 
JOIN classroom_group ON enrollment_modules.enrollment_modules_group_id = classroom_group.classroom_group_id 
WHERE classroom_group.classroom_group_id = 3 
ORDER BY person.person_sn1
*/

		$this->db->select('classroom_group_id,person_givenName,person_sn1,person_sn2,person_official_id,person_photo');
		$this->db->from('enrollment_modules');
		$this->db->join('person','person.person_id = enrollment_modules.enrollment_modules_personid');
		$this->db->join('classroom_group','enrollment_modules.enrollment_modules_group_id = classroom_group.classroom_group_id');
		$this->db->where('classroom_group.classroom_group_id',$group);
		$this->db->order_by('person_sn1');
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$student_info_array = array();

			foreach ($query->result_array() as $row)	{

				//$student_info_array[] = $row;
   				$student = new stdClass();
				$student->givenName = $row['person_givenName'];
				$student->sn1 = $row['person_sn1'];
				$student->sn2 = $row['person_sn2'];
				$student->irisPersonalUniqueID = $row['person_official_id'];
				$student->jpegPhoto = $row['person_photo'];
				$student_info_array[] = $student;

			}

			return $student_info_array;
		}			
		else
			return false;


}

	function get_all_groups_by_academic_period($academic_period,$orderby="asc") {
		/*
		SELECT classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name 
		FROM classroom_group_academic_periods 
		INNER JOIN classroom_group ON classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id
		WHERE classroom_group_academic_periods_academic_period_id=5
		ORDER BY classroom_group_code asc 
		*/
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->from('classroom_group_academic_periods');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period);

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();

    	//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . "( " . $row['classroom_group_shortName'] . " )";
   				//$groups_array[$row['classroom_group_code']] = $row['classroom_group_code'] . " - " . $row['classroom_group_shortName'];
			}
			return $groups_array;
		}			
		else
			return false;
}

function get_current_academic_period() {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_current',1);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$academic_period = new stdClass;
			$row = $query->row();
				
			$academic_period->id = $row->academic_periods_id;
			$academic_period->shortname = $row->academic_periods_shortname;
			$academic_period->name = $row->academic_periods_name;
			$academic_period->alt_name = $row->academic_periods_alt_name;
			$academic_period->current = $row->academic_periods_current;

			return $academic_period;
		}	
		else
			return false;
	}

	function get_all_academic_periods($orderby="desc") {
		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE 1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
	

		$this->db->order_by('academic_periods_id', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_academic_periods = array();
			foreach($query->result() as $row){
				$academic_period = new stdClass;
				
				$academic_period->id = $row->academic_periods_id;
				$academic_period->shortname = $row->academic_periods_shortname;
				$academic_period->name = $row->academic_periods_name;
				$academic_period->alt_name = $row->academic_periods_alt_name;
				$academic_period->current = $row->academic_periods_current;

				$all_academic_periods[$academic_period->id] = $academic_period;
			}
			return $all_academic_periods;
		}	
		else
			return false;
	}

	function get_current_academic_period_id() {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_current',1);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_id;
		}	
		else
			return false;
	}


	function get_all_groups($orderby="asc") {


		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();

    	//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . "( " . $row['classroom_group_shortName'] . " )";
   				//$groups_array[$row['classroom_group_code']] = $row['classroom_group_code'] . " - " . $row['classroom_group_shortName'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	


	function get_teacher_departmentInfo($teacherId,$orderby="asc") {

		$academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT department_id, department_shortName, department_name 
		FROM (department) 
		JOIN teacher_academic_periods ON teacher_academic_periods.teacher_academic_periods_department_id = department.department_id 
		WHERE teacher_academic_periods_teacher_id = '17' AND teacher_academic_periods_academic_period_id = '5' 
		ORDER BY department_shortName asc
		*/
		$this->db->select('department_id,department_shortName,department_name');
		$this->db->from('department');        
   		$this->db->join('teacher_academic_periods', 'teacher_academic_periods.teacher_academic_periods_department_id = department.department_id');
		$this->db->where('teacher_academic_periods_teacher_id', $teacherId);
		$this->db->where('teacher_academic_periods_academic_period_id', $academic_period_id);
		$this->db->order_by('department_shortName', $orderby);
		       
        $query = $this->db->get();
        //echo $this->db->last_query(). "<br/>";
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array ( "id" => $row->department_id, "name" => $row->department_shortName);
		}			
		else
			return false;
	}
	 

	function get_teacher_departmentName($teacherId,$orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');
   		$this->db->join('teacher', 'department.department_id = teacher.teacher_department_id');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('teacher_id', $teacherId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->department_shortName;
		}			
		else
			return false;
	}
	

	function get_teacher_departments($teacherId,$orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');
   		$this->db->join('teacher', 'department.department_id = teacher.teacher_department_id');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('teacher_id', $teacherId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$departments_array = array();

			foreach ($query->result_array() as $row)	{
   				$departments_array[$row['department_id']] = $row['department_shortName'];
			}
			return $departments_array;
		}			
		else
			return false;
	}

	function get_department($departmentId,$orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('department_id', $departmentId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$departments_array = array();

			foreach ($query->result_array() as $row)	{
   				$departments_array[$row['department_id']] = $row['department_shortName'];
			}
			return $departments_array;
		}			
		else
			return false;
	}

	function get_all_departments($orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');

		$this->db->order_by('department_shortName', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$departments_array = array();

			foreach ($query->result_array() as $row)	{
   				$departments_array[$row['department_id']] = $row['department_shortName'];
			}
			return $departments_array;
		}			
		else
			return false;
	}

	function get_all_groupscodenameByTeacher($teacherId,$orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code');
        $this->db->join('lesson', 'classroom_group.classroom_group_id = lesson.lesson_classroom_group_id');
        $this->db->distinct();
		$this->db->order_by('classroom_group_code', $orderby);

		$this->db->where('lesson.lesson_teacher_id', $teacherId);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	

	function get_all_groupscodenameByDeparment($departmentId,$orderby="asc") {
		/*
		SELECT DISTINCT classroom_group_code,studies_shortname,department_name,department.department_id
		FROM classroom_group 
		INNER JOIN course
		ON classroom_group.classroom_group_course_id = course.course_id
		INNER JOIN studies
		ON course.course_estudies_id = studies.studies_id
		INNER JOIN study_department
		ON studies.studies_id = study_department.study_id
		INNER JOIN department
		ON study_department.study_id = department.department_id
		WHERE department.department_id = 2
		*/
		$this->db->select('classroom_group_id,classroom_group_code, studies_shortname, department_name, department.department_id');
		$this->db->from('classroom_group');        

		$this->db->join('course', 'classroom_group.classroom_group_course_id = course.course_id');
		$this->db->join('studies', 'course.course_study_id = studies.studies_id');
		$this->db->join('study_department', 'studies.studies_id = study_department.study_id');
		$this->db->join('department', 'study_department.study_id = department.department_id');
        

		$this->db->where('department.department_id', $departmentId);
		$this->db->order_by('classroom_group_code', $orderby);
		       
		$this->db->distinct();       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	

	function get_all_groupscodename($orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	



	function get_teacher_ids_and_names($teacher_id,$orderby="asc") {

		$this->db->from('teacher');
        $this->db->select('teacher_code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		//$this->db->order_by('lesson_code', $orderby);
		
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		$this->db->where('teacher_id', $teacher_id);
        
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

	function get_all_teachers_ids_and_names($orderby="ASC") {

		$get_current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id
		FROM teacher_academic_periods
		INNER JOIN teacher ON teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE teacher_academic_periods_academic_period_id=5

		*/
		$this->db->select('teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id');
		$this->db->from('teacher_academic_periods');        
		$this->db->join('teacher', 'teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		$this->db->order_by('teacher_academic_periods_code', $orderby);

        $query = $this->db->get();
        //echo $this->db->last_query(). "<br/>";
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_academic_periods_code']] = $row['teacher_academic_periods_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
			}
			return $teachers_array;
		}			
		else
			return false;
	}

	function get_group_shift($classroom_group_id) {

		$this->db->select('classroom_group_academic_periods_shift');
		$this->db->from('classroom_group');
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			if ($row->classroom_group_academic_periods_shift!=0)
				return $row->classroom_group_academic_periods_shift;
			else {
				$mintimeslotorder = $this->getMinTimeSlotOrderForGroup($classroom_group_id);
				if ($mintimeslotorder > 6)
					return 2;
				else
					return 1;
			}
		}
		else
			return false;
	}

	function getMinTimeSlotOrderForGroup($classroom_group_id) {

		/*
		SELECT min( time_slot_order )
		FROM lesson
		INNER JOIN classroom_group ON classroom_group.classroom_group_id = lesson.lesson_classroom_group_id
		INNER JOIN time_slot ON time_slot.time_slot_id = lesson.lesson_time_slot_id
		WHERE classroom_group.classroom_group_id =25
		*/
	
		$this->db->select_min('time_slot_order','min_time_slot_order');
		$this->db->from('lesson');
		$this->db->join('classroom_group', 'classroom_group.classroom_group_id = lesson.lesson_classroom_group_id');
		$this->db->join('time_slot', 'time_slot.time_slot_id = lesson.lesson_time_slot_id');
		
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->min_time_slot_order;
   		}
   		else
			return false;
	}

	function getTimeSlots($orderby="asc",$min_time_slot_order=1,$max_time_slot_order=15) {

		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,time_slot_order');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where('time_slot_order >=',$min_time_slot_order);
		$this->db->where('time_slot_order <=',$max_time_slot_order);		

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getMaxTimeSlotOrderForGroup($classroom_group_id) {

		$this->db->select_min('time_slot_order','max_time_slot_order');
		$this->db->from('lesson');
		$this->db->join('classroom_group', 'classroom_group.classroom_group_id = lesson.lesson_classroom_group_id');
		$this->db->join('time_slot', 'time_slot.time_slot_id = lesson.lesson_time_slot_id');
		
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->max_time_slot_order;
   		}
   		else
			return false;
	}

	public function get_time_slots_byShift($shift = 1) {   

       	switch ($shift) {
       		//Morning
    		case 1:
	        	return $this->getTimeSlots("asc",1,7);
	        	break;
	       	//Afternoon
    		case 2:
        		return $this->getTimeSlots("asc",9,15);
        		break;
    	} 
    }

	/*
	function getAllLessonsWithGroupCodeShortNames($orderby="asc") {
		$all_lessons=$this->getAllLessons();
		
		foreach ($all_lessons as $lesson_key => $lesson) {
			$lesson->classroom_group_shortname="PROVA";
		}
		
		return $all_lessons;
	}*/



	function getAllTimeSlots($orderby="asc") {
		/*
		SELECT time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective FROM (time_slot) ORDER BY time_slot_order asc
		*/
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$query = $this->db->get();
		//echo $this->db->last_query(). "<br/>";


		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	private function _get_found_lesson_ids_by_time_slot_id($all_lessons_by_teacherid_and_day, $time_slot_id) {

		$found_lesson_ids_by_time_slot_id = array();

		if (is_array($all_lessons_by_teacherid_and_day)) {
			foreach ($all_lessons_by_teacherid_and_day as $lesson_key => $lesson) {
				# code...
				if ( $lesson->time_slot_id == $time_slot_id) {
					$found_lesson_ids_by_time_slot_id[] = $lesson->lesson_id;				
				}
			}	
		}
		
		return $found_lesson_ids_by_time_slot_id;
	}

	function get_all_time_slots_with_all_lessons_by_teacherid_and_day($all_lessons_by_teacherid_and_day,$orderby="asc") {
		/*
		SELECT time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective FROM (time_slot) ORDER BY time_slot_order asc
		*/
		$this->db->select('time_slot_order,time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$query = $this->db->get();
		//echo $this->db->last_query(). "<br/>";


		if ($query->num_rows() > 0) {
			$time_slots_array = array();
			foreach ($query->result_array() as $row)	{

				$found_lesson_ids_by_time_slot_id = $this->_get_found_lesson_ids_by_time_slot_id($all_lessons_by_teacherid_and_day,$row['time_slot_id']);
				$count = count($found_lesson_ids_by_time_slot_id);

				if ( $count >0) {
					foreach ($found_lesson_ids_by_time_slot_id as $lesson_id_key => $lesson_id) {
						$time_slot = new stdClass();

						$time_slot->time_slot_id = $row['time_slot_id'];
						$time_slot->time_slot_start_time = $row['time_slot_start_time'];
						$time_slot->time_slot_end_time = $row['time_slot_end_time'];
						$time_slot->time_slot_lective = $row['time_slot_lective'];
						$time_slot->time_slot_order = $row['time_slot_order'];	

						$time_slot->group_id = $all_lessons_by_teacherid_and_day[$lesson_id]->group_id;
						$time_slot->group_code = $all_lessons_by_teacherid_and_day[$lesson_id]->group_code;
						$time_slot->group_shortname = $all_lessons_by_teacherid_and_day[$lesson_id]->group_shortname;
						$time_slot->group_name = $all_lessons_by_teacherid_and_day[$lesson_id]->group_name;
						$time_slot->study_module_id = $all_lessons_by_teacherid_and_day[$lesson_id]->study_module_id;
						$time_slot->classroom_group_code = $all_lessons_by_teacherid_and_day[$lesson_id]->classroom_group_code;
						
						$time_slot->lesson_id = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_id;
						$time_slot->lesson_code = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_code;
						$time_slot->lesson_shortname = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_shortname;
						$time_slot->lesson_name = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_name;
						$time_slot->lesson_location = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_location;
						$time_slot->lesson_location_id = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_location_id;
						$time_slot->classroom_group_location_id = $all_lessons_by_teacherid_and_day[$lesson_id]->classroom_group_location_id;
						$time_slot->study_module_id = $all_lessons_by_teacherid_and_day[$lesson_id]->study_module_id;
						
						$time_slots_array[] = $time_slot;	

					}	
				} else {
					$time_slot = new stdClass();

					$time_slot->time_slot_id = $row['time_slot_id'];
					$time_slot->time_slot_start_time = $row['time_slot_start_time'];
					$time_slot->time_slot_end_time = $row['time_slot_end_time'];
					$time_slot->time_slot_lective = $row['time_slot_lective'];
					$time_slot->time_slot_order = $row['time_slot_order'];	
					$time_slot->group_id = "";
					$time_slot->group_code = "";
					$time_slot->group_shortname = "";
					$time_slot->group_name = "";
					$time_slot->study_module_id = "";
					$time_slot->classroom_group_code = "";
					
					$time_slot->lesson_id = "";
					$time_slot->lesson_code = "";
					$time_slot->lesson_shortname = "";
					$time_slot->lesson_name = "";
					$time_slot->lesson_location = "";
					$time_slot->lesson_location_id = "";
					$time_slot->classroom_group_location_id = "";
					$time_slot->study_module_id = "";

					$time_slots_array[] = $time_slot;	

				}
					   				
			}
   			return $time_slots_array;
		} else {
			return false;
		}
	}

	function get_teacher_info_from_teacher_code($teacher_code) {
		
		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT teacher_id, teacher_person_id, teacher_academic_periods_code , person_givenName, person_sn1, person_sn2
		FROM teacher_academic_periods
		INNER JOIN teacher ON teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE teacher_academic_periods_academic_period_id = 5 AND teacher_academic_periods_code=40
		*/

		$this->db->select('teacher_id, teacher_person_id, teacher_academic_periods_code , person_givenName, person_sn1, person_sn2');
		$this->db->from('teacher_academic_periods');
		$this->db->join('teacher', 'teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		
		$this->db->where('teacher_academic_periods.teacher_academic_periods_code',$teacher_code);
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$current_academic_period_id);


		$query = $this->db->get();
		//echo $this->db->last_query(). "<br/>";

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array ( "teacher_id" => $row->teacher_id , "teacher_code" => $row->teacher_academic_periods_code ,  
				"givenName" => $row->person_givenName , "sn1" => $row->person_sn1 , "sn2" => $row->person_sn2);
		}
		else
			return false;
	}

	function get_teacher_code_from_teacher_id($teacher_id) {
		$this->db->select('teacher_code');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_id',$teacher_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_code;
		}
		else
			return false;
	}


	function get_teacher_id_from_teacher_code($teacher_code) {

		$this->db->select('teacher_id');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_code',$teacher_code);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_id;
		}
		else
			return false;
	}

	function get_all_lessons_by_teacherid_and_day ($teacher_id, $day,$orderby = "asc") {
		
		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT time_slot_order, time_slot_id, lesson_id, lesson_code, classroom_group_id, classroom_group_code, classroom_group_shortName, 
		classroom_group_name, study_module_id, study_module_shortname, study_module_name, location_shortName, lesson_classroom_group_id 
		FROM (lesson) 
		JOIN time_slot ON lesson.lesson_time_slot_id = time_slot.time_slot_id 
		JOIN classroom_group ON lesson.lesson_classroom_group_id = classroom_group.classroom_group_id 
		JOIN study_module ON lesson.lesson_study_module_id = study_module.study_module_id 
		LEFT JOIN location ON lesson.lesson_location_id = location.location_id 
		WHERE lesson_day = '3' AND lesson_teacher_id = '9' AND lesson_academic_period_id = '5' 
		ORDER BY time_slot_order asc
		*/
		$this->db->select('');
		$this->db->select('time_slot_order,time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,lesson_id,lesson_code,classroom_group_id,classroom_group_code,classroom_group_shortName,
						  classroom_group_name,study_module_id,study_module_shortname,study_module_name,lesson_location_id,location_shortName, lesson_classroom_group_id');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('location', 'lesson.lesson_location_id = location.location_id','left');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$this->db->where('lesson_teacher_id', $teacher_id);
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);


		$query = $this->db->get();
		//echo $this->db->last_query(). "<br/>";

		if ($query->num_rows() > 0)	{
			
			$lessons_array = array();

			foreach ($query->result_array() as $row)	{

				$lesson = new stdClass();
				$lesson->group_id = $row['classroom_group_id'];
				$lesson->group_code = $row['classroom_group_code'];
				$lesson->group_shortname = $row['classroom_group_shortName'];
				$lesson->group_name = $row['classroom_group_name'];
				$lesson->study_module_id = $row['study_module_id'];
				$lesson->classroom_group_code = $row['classroom_group_code'];				
				$lesson->time_slot_id = $row['time_slot_id'];
				$lesson->time_slot_order = $row['time_slot_order'];				
				$lesson->time_slot_start_time = $row['time_slot_start_time'];
				$lesson->time_slot_end_time = $row['time_slot_end_time'];
				$lesson->time_slot_lective = $row['time_slot_lective'];
				$lesson->lesson_id = $row['lesson_id'];
				$lesson->lesson_code = $row['lesson_code'];
				$lesson->lesson_shortname = $row['study_module_shortname'];
				$lesson->lesson_name = $row['study_module_name'];
				$lesson->lesson_location = $row['location_shortName'];
				$lesson->lesson_location_id = $row['lesson_location_id'];
				$lesson->classroom_group_location_id = $row['lesson_classroom_group_id'];

   				$lessons_array[$row['lesson_id']] = $lesson;

			}
			return $lessons_array;
		}
		else
			return false;
	}

	function getTimeSlotKeyFromLessonId ( $lesson_id) {
		$current_academic_period_id = $this->get_current_academic_period_id();

		//SELECT lesson_time_slot_id FROM lesson WHERE lesson_id=971
		$this->db->select('lesson_time_slot_id');
		$this->db->from('lesson');
		$this->db->where('lesson_id', $lesson_id);
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1)	{
			$row = $query->row(); 
			return $row->lesson_time_slot_id;
		}
		else
			return 0;
	}

	


//OSCAR: Obtenir les incidències d'una data i hora
	function getAllIncidentsByDateTime($data, $hora,$tipus_falta,$orderby = "asc") {
		
		$this->db->select('student_id,teacher_id,st.person_givenName as "student_name",st.person_sn1 as "student_sn1",st.person_sn2 as "student_sn2",
			teach.person_givenName as "teacher_name",teach.person_sn1 as "teacher_sn1",teach.person_sn2 as "teacher_sn2",
			data_incidencia,attendance_incident_timeslot_id,attendance_incident_lesson_id, attendance_incident_type,observacions,
			classroom_group_code,study_module_shortname');
		$this->db->from('attendance_incident');
		$this->db->join('student','attendance_incident_student_id=student_id');
		$this->db->join('person as st','student_person_id=st.person_id');
		$this->db->join('teacher','attendance_incident_teacher_id=teacher_id');
		$this->db->join('person as teach','teacher_person_id=teach.person_id');		
		$this->db->join('lesson','lesson_teacher_id=teacher_id');
		$this->db->join('classroom_group','lesson_classroom_group_id=classroom_group_id');
		$this->db->join('study_module','lesson_study_module_id=study_module_id');	

		$this->db->where('attendance_incident_timeslot_id',$hora);
		$this->db->where('data_incidencia',date("Y-m-d", strtotime($data)));
		if($tipus_falta!=''){
			$this->db->where_in('attendance_incident_type', $tipus_falta);
		} else {
			$this->db->where('attendance_incident_type','');
		}

		$this->db->distinct();
		$query = $this->db->get();

		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$incident = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				$incident->student_id = $row['student_id'];

				$incident->student_name = $row['student_name'];
				$incident->student_sn1 = $row['student_sn1'];
				$incident->student_sn2 = $row['student_sn2'];

				$incident->teacher_id = $row['teacher_id'];
				$incident->teacher_name = $row['teacher_name'];
				$incident->teacher_sn1 = $row['teacher_sn1'];
				$incident->teacher_sn2 = $row['teacher_sn2'];				

				$incident->group = $row['classroom_group_code'];
				$incident->study_module = $row['study_module_shortname'];				
				$incident->type = $row['attendance_incident_type'];
				$incident->timeslot = $row['attendance_incident_timeslot_id'];
				$incident->day = $row['data_incidencia'];
				
   				$incidents_array[] = $incident;

			}
			return $incidents_array;
		}
		else
			return false;
	}

//OSCAR: Obtenir les incidències entre 2 dates
	function getAllIncidentsBetweenDates($data_ini, $data_fi,$tipus_falta,$limit=false,$orderby = "asc") {
		
		$this->db->select('student_id,teacher_id,st.person_givenName as "student_name",st.person_sn1 as "student_sn1",st.person_sn2 as "student_sn2",
			teach.person_givenName as "teacher_name",teach.person_sn1 as "teacher_sn1",teach.person_sn2 as "teacher_sn2",
			data_incidencia,attendance_incident_timeslot_id,attendance_incident_lesson_id, attendance_incident_type,observacions,
			classroom_group_code,study_module_shortname');
		$this->db->from('attendance_incident');
		$this->db->join('student','attendance_incident_student_id=student_id');
		$this->db->join('person as st','student_person_id=st.person_id');
		$this->db->join('teacher','attendance_incident_teacher_id=teacher_id');
		$this->db->join('person as teach','teacher_person_id=teach.person_id');		
		$this->db->join('lesson','lesson_teacher_id=teacher_id');
		$this->db->join('classroom_group','lesson_classroom_group_id=classroom_group_id');
		$this->db->join('study_module','lesson_study_module_id=study_module_id');	

		$this->db->where('data_incidencia >=', date("Y-m-d", strtotime($data_ini)));
		$this->db->where('data_incidencia <=', date("Y-m-d", strtotime($data_fi)));
		if($tipus_falta!=''){
			$this->db->where_in('attendance_incident_type', $tipus_falta);
		} else {
			$this->db->where('attendance_incident_type','');
		}

		$this->db->distinct();
		if($limit){
			$this->db->limit($limit);
		}
		$query = $this->db->get();

		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$incident = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				$incident->student_id = $row['student_id'];
				$incident->student_name = $row['student_name'];
				$incident->student_sn1 = $row['student_sn1'];
				$incident->student_sn2 = $row['student_sn2'];

				$incident->teacher_id = $row['teacher_id'];
				$incident->teacher_name = $row['teacher_name'];
				$incident->teacher_sn1 = $row['teacher_sn1'];
				$incident->teacher_sn2 = $row['teacher_sn2'];				

				$incident->group = $row['classroom_group_code'];
				$incident->study_module = $row['study_module_shortname'];				
				$incident->type = $row['attendance_incident_type'];
				$incident->timeslot = $row['attendance_incident_timeslot_id'];
				$incident->day = $row['data_incidencia'];
				
   				$incidents_array[] = $incident;

			}
			return $incidents_array;
		}
		else
			return false;
	}



//OSCAR: Obtenir les lliçons d'un dia
	function getAllLessonsByDay($day,$classroom_group_id,$orderby = "asc") {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT lesson_id,lesson_code,classroom_group_code,classroom_group_shortName,classroom_group_name
		FROM lesson
		INNER JOIN classroom_group ON lesson.lesson_classroom_group_id= classroom_group.classroom_group_id
		WHERE lesson_day=1 AND lesson_teacher_id=38
		*/
		$this->db->select('time_slot_order,time_slot_id,lesson_id,lesson_code,classroom_group_code,classroom_group_shortName,
						  classroom_group_name,study_module_id,study_module_shortname,study_module_name,location_shortName,lesson_location_id');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('location', 'lesson.lesson_location_id = location.location_id','left');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$where = "classroom_group_id = '$classroom_group_id'";
		
		$this->db->where($where);

		$this->db->where('lesson_academic_period_id', $current_academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$lessons_array = array();

			foreach ($query->result_array() as $row)	{

				$lesson = new stdClass();
				$lesson->group_code = $row['classroom_group_code'];
				$lesson->group_shortname = $row['classroom_group_shortName'];
				$lesson->group_name = $row['classroom_group_name'];
				$lesson->study_module_id = $row['study_module_id'];
				$lesson->classroom_group_code = $row['classroom_group_code'];				
				$lesson->lesson_code = $row['lesson_code'];
				$lesson->lesson_shortname = $row['study_module_shortname'];
				$lesson->lesson_name = $row['study_module_name'];
				$lesson->lesson_location = $row['location_shortName'];
				$lesson->lesson_location_id = $row['lesson_location_id'];

   				$lessons_array[$row['time_slot_id']] = $lesson;

			}
			return $lessons_array;
		}
		else
			return false;
	}


	
	function getAllLessons($exists_assignatures_table=false,$orderby="asc") {

		$current_academic_period_id = $this->get_current_academic_period_id();

		//classroom_group
        if (!$exists_assignatures_table) {
            $this->db->select('lesson_id,lesson_code,classroom_group.groupShortName,classroom_group_code,teacher_code,lesson_shortname,classrom_code,day_code,hour_code');
        }
        else {
            $this->db->select('lesson_id,lesson_code,classroom_group.groupShortName,classroom_group_code,teacher_code,lesson_shortname,assignatura.nom_assignatura,classrom_code,day_code,hour_code');
        }
                                                
		$this->db->from('lesson');
		$this->db->order_by('lesson_code', $orderby);
		$this->db->join('classroom_group', 'classroom_group.groupCode = lesson.classroom_group_code', 'left');
        if ($exists_assignatures_table) {
                $this->db->join('assignatura', 'lesson.lesson_shortname = assignatura.codi_assignatura', 'left');                                        
        }
        $this->db->where('lesson_academic_period_id', $current_academic_period_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
		
	}

	function get_all_classroom_groups($orderby='asc') {
		//classroom_group
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_academic_periods_mentorId');
		$this->db->from('classroom_group_academic_periods');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id', 'left');
		//TODO
		$this->db->where('classroom_group_academic_periods_academic_period_id',5);
		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}
	
	function getGroupNameByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() == 1)	{
			$row = $query->row(); 
			return $row->groupName;
		}
		else
			return false;
	}

	function getGroupCodeByGroupID($group_id) {
		//classroom_group
		$this->db->select('classroom_group_code');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_id', $group_id);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() == 1)	{
			$row = $query->row(); 
			return $row->classroom_group_code;
		}
		else
			return false;
	}

	function getGroupShortNameByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return $row->groupShortame;
		}
		else
			return false;
	}
	
	function getGroupNamesByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name,classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return array($row->classroom_group_shortName,$row->classroom_group_name);
		}
		else
			return false;
	}
  
	function get_group_by_teachercode_and_day($teacher_code,$day_code)	{
	/* 
        SELECT assignatura.nom_assignatura, grup.nom_grup, grup.codi_grup,
                   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
                   interval_horari.hora_inici, interval_horari.hora_final, optativa
        FROM assignatura
                 NATURAL JOIN classe NATURAL JOIN grup 
                 NATURAL JOIN interval_horari
        WHERE classe.codi_professor = '{$VALS['teacher_code']}'
                  AND  classe.codi_dia = '{$VALS['day_of_week']}'
                  ORDER BY classe.codi_hora, grup.nom_grup
	 */
		$this->db->select('assignatura.nom_assignatura, classroom_group.nom_grup, classroom_group.codi_grup,
                   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
                   interval_horari.hora_inici, interval_horari.hora_final, optativa');
		$this->db->from('assignatura');
		$this->db->join('classe', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->join('classroom_group', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->join('interval_horari', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->where('classe.codi_professor',$teacher_code);
		$this->db->where('classe.codi_dia',$day_code);
		$this->db->order_by('classe.codi_hora', 'asc');
		$this->db->order_by('classroom_group.nom_grup', 'asc'); 
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getAllTeachersFromClassgroupId ( $class_group_id ) {
		
		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT DISTINCT lesson_teacher_id, person_givenName, person_sn1, person_sn2 
		FROM (lesson) 
		JOIN teacher ON teacher.teacher_id = lesson.lesson_teacher_id 
		JOIN teacher_academic_periods ON teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id 
		JOIN person ON teacher.teacher_person_id = person.person_id 
		WHERE lesson.lesson_classroom_group_id = '3' AND lesson_academic_period_id = '5' AND teacher_academic_periods_academic_period_id = '5'
		*/

		$this->db->select('lesson_teacher_id, person_givenName, person_sn1, person_sn2');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('teacher', 'teacher.teacher_id = lesson.lesson_teacher_id');
		$this->db->join('teacher_academic_periods', 'teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person', 'teacher.teacher_person_id = person.person_id');
		
		//$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where("lesson.lesson_classroom_group_id", $class_group_id);
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);
		$this->db->where('teacher_academic_periods_academic_period_id', $current_academic_period_id);
		
		$query = $this->db->get();
		//echo $this->db->last_query() ."<br/>";

		if ($query->num_rows() > 0)	{
			
			$group_teachers = array();

			foreach ($query->result_array() as $row)	{

				$teacher = new stdClass();
				$teacher->id = $row['lesson_teacher_id'];
				$teacher->givenName = $row['person_givenName'];
				$teacher->sn1 = $row['person_sn1'];
				$teacher->sn2 = $row['person_sn2'];
				
   				$group_teachers[$row['lesson_teacher_id']] = $teacher;

			}
			return $group_teachers;
		}
		else
			return false;
	} 

	function getTutorFromClassgroupId ( $class_group_id ) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT DISTINCT teacher.teacher_id, classroom_group_academic_periods_mentorId, person_givenName, person_sn1, person_sn2 
		FROM (classroom_group) 
		JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id 
		JOIN teacher ON teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId 
		JOIN person ON teacher.teacher_id = person.person_id 
		WHERE classroom_group.classroom_group_id = '39' AND classroom_group_academic_periods.classroom_group_academic_periods_academic_period_id = '5'
		*/

		$this->db->select('teacher.teacher_id,classroom_group_academic_periods_mentorId, person_givenName, person_sn1, person_sn2');
		$this->db->distinct();
		$this->db->from('classroom_group');
		$this->db->join('classroom_group_academic_periods', 'classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('teacher', 'teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId');
		$this->db->join('person', 'teacher.teacher_id = person.person_id');
		
		//$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where("classroom_group.classroom_group_id", $class_group_id);
		$this->db->where("classroom_group_academic_periods.classroom_group_academic_periods_academic_period_id", $current_academic_period_id);

		$query = $this->db->get();
		//ºecho $this->db->last_query() ."<br/>";
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return $row->teacher_id;
		}
		else
			return "";
	} 

	function getAllGroupStudymodules ( $class_group_id, $orderby = "ASC" ) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT DISTINCT lesson_study_module_id, study_module_id, study_module_academic_periods.study_module_academic_periods_external_code, 
		study_module_shortname, study_module_name FROM (lesson) 
		JOIN study_module ON lesson.lesson_study_module_id = study_module.study_module_id 
		JOIN study_module_academic_periods ON study_module_academic_periods_study_module_id = study_module_id 
		WHERE lesson.lesson_classroom_group_id = '39' AND lesson_academic_period_id = '5' AND study_module_academic_periods.study_module_academic_periods_academic_period_id = '5' 
		ORDER BY study_module_shortname ASC
		*/

		$this->db->select('lesson_study_module_id,study_module_id, study_module_academic_periods.study_module_academic_periods_external_code ,study_module_shortname,study_module_name');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('study_module', "lesson.lesson_study_module_id = study_module.study_module_id");
		$this->db->join('study_module_academic_periods','study_module_academic_periods_study_module_id = study_module_id');

		$this->db->where("lesson.lesson_classroom_group_id", $class_group_id);
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);
		$this->db->where('study_module_academic_periods.study_module_academic_periods_academic_period_id',$current_academic_period_id);	
		$this->db->order_by('study_module_shortname', $orderby);
		

		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)	{
			
			$study_modules = array();

			foreach ($query->result_array() as $row)	{

				$study_module = new stdClass();
				$study_module->id = $row['study_module_id'];
				$study_module->shortname = $row['study_module_shortname'];				
				$study_module->name = $row['study_module_name'];
				$study_module->code = $row['study_module_academic_periods_external_code'];
				
   				$study_modules[$row['study_module_id']] = $study_module;

			}
			return $study_modules;
		}
		else
			return false;

	}

	function getAllIncident_types($orderby="ASC"){
		/*
		SELECT incident_type_id, incident_type_name, incident_type_shortName, incident_type_description, incident_type_code, 
		incident_type_order, incident_type_entryDate, incident_type_last_update, incident_type_creationUserId, 
		incident_type_lastupdateUserId, incident_type_markedForDeletion, incident_type_markedForDeletionDate 
		FROM incident_type 
		*/

		$this->db->select('incident_type_id, incident_type_name, incident_type_shortName, incident_type_description, 
				incident_type_code, incident_type_order, incident_type_entryDate, incident_type_last_update, 
				incident_type_creationUserId, incident_type_lastupdateUserId, incident_type_markedForDeletion, 
				incident_type_markedForDeletionDate');
		$this->db->from('incident_type');
		$this->db->order_by('incident_type_order', $orderby);

		$this->db->distinct();		
		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)	{			
			$incident_types = array();

			foreach ($query->result_array() as $row)	{

				$incident_type = new stdClass();

				$incident_type->id = $row['incident_type_id'];
				$incident_type->shortname = $row['incident_type_shortName'];				
				$incident_type->name = $row['incident_type_name'];
				$incident_type->description = $row['incident_type_description'];
				$incident_type->code = $row['incident_type_code'];
				$incident_type->order = $row['incident_type_order'];
				$incident_type->entryDate = $row['incident_type_entryDate'];
				$incident_type->last_update = $row['incident_type_last_update'];
				$incident_type->creationUserId = $row['incident_type_creationUserId'];
				$incident_type->lastupdateUserId = $row['incident_type_lastupdateUserId'];
				$incident_type->markedForDeletion = $row['incident_type_markedForDeletion'];
				$incident_type->markedForDeletionDate = $row['incident_type_markedForDeletionDate'];
				
   				$incident_types[$row['incident_type_id']] = $incident_type;

			}
			return $incident_types;
		}
		else
			return false;		

	}

	function getAllTeacherStudymodules ( $teacher_id , $orderby = "ASC") {
		
		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT DISTINCT lesson_study_module_id , study_module_external_code , study_module_shortname , study_module_name
		FROM lesson
		INNER JOIN study_module ON lesson.lesson_study_module_id = study_module.study_module_id
		WHERE lesson_teacher_id = 39
		ORDER BY study_module_order,study_module_shortname
		*/

		$this->db->select('lesson_study_module_id,study_module_id,study_module_external_code,study_module_shortname,study_module_name');
		$this->db->from('lesson');
		$this->db->join('study_module', "lesson.lesson_study_module_id = study_module.study_module_id");
		
	/*	$this->db->order_by('study_module_order', $orderby); */
		$this->db->order_by('study_module_shortname', $orderby);
		
		$this->db->where("lesson.lesson_teacher_id", $teacher_id);
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);

		$this->db->distinct();		
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)	{
			
			$study_modules = array();

			foreach ($query->result_array() as $row)	{

				$study_module = new stdClass();
				$study_module->id = $row['study_module_id'];
				$study_module->shortname = $row['study_module_shortname'];				
				$study_module->name = $row['study_module_name'];
				$study_module->code = $row['study_module_external_code'];
				
   				$study_modules[$row['study_module_id']] = $study_module;

			}
			return $study_modules;
		}
		else
			return false;

	}

	//$result = $this->attendance_model->crud_absence($person_id,$time_slot_id,$day,$study_submodule_id,$absence_type);	

	/*
	CREATE TABLE incident (
	  incident_id int(11) NOT NULL AUTO_INCREMENT,
	  incident_student_id int(11) NOT NULL,
	  incident_time_slot_id int(11) NOT NULL,
	  incident_day int(11) NOT NULL,
	  incident_study_submodule_id int(11) NOT NULL,
	  incident_type int(11) NOT NULL,
	  incident_notes text NOT NULL,
	  incident_last_update timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  incident_creationUserId int(11) DEFAULT NULL,
	  incident_lastupdateUserId int(11) DEFAULT NULL,
	  incident_markedForDeletion enum('n','y') NOT NULL DEFAULT 'n',
	  incident_markedForDeletionDate datetime NOT NULL,
	  PRIMARY KEY (incident_id),
	  UNIQUE KEY incident_student_id (incident_student_id,incident_time_slot_id,incident_day,incident_date)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
	*/

	function incidence_exists ($person_id,$time_slot_id,$day,$study_submodule_id,$absence_type) {
		/*
		SELECT incident_id,incident_type FROM incident 
		WHERE incident_student_id= AND incident_time_slot_id= AND incident_day AND incident_study_submodule_id = 
		*/

		$this->db->select('incident_id,incident_type');
		$this->db->from('incident');				
		$this->db->where('incident_student_id', $person_id);
		$this->db->where('incident_time_slot_id', $time_slot_id);
		$this->db->where('incident_day', $day);
		$this->db->where('incident_study_submodule_id', $study_submodule_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$result = new stdClass();
		
		if ($query->num_rows() > 0)	{
			//Incident already exists
			$row = $query->row();

			if ($absence_type == $row->incident_type) {
				$result->code = 3;
				$result->incident_id = $row->incident_id;
				return $result;
			} else {
				$result->code = 2;
				$result->incident_id = $row->incident_id;
				return $result;
			}
		} else {
			//Incident does not exist
			$result->code = 1;
			return $result;
		}		
	}

	function delete_incidence ($incidence_id) {

		$this->db->delete('incident', array('incident_id' => $incidence_id)); 

		if ($this->db->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}		

	}

	function update_incidence($incident_id, $absence_type) {

		$incident_type_id = $this->get_incident_type_id_by_incident_type_code($absence_type);

		if ($incident_type_id == false ) {
			return false;
		}

		/*
		UPDATE incident 
		incident_type= 2
		WHERE incident_id = 5
		*/
		$data = array(
		   'incident_type' => $incident_type_id ,
		);

		$this->db->where('incident_id', $incident_id);
		$this->db->update('incident', $data); 

		if ($this->db->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function get_incident_type_id_by_incident_type_code ($incident_type_code) {
		/*
		SELECT `incident_type_id` FROM incident_type WHERE `incident_type_code`=1
		*/

		$this->db->select('incident_type_id');
		$this->db->from('incident_type');				
		$this->db->where('incident_type_code', $incident_type_code);

		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->incident_type_id;
		} else {
			return false;
		}
	}

	function insert_incidence ($person_id,$time_slot_id,$day,$study_submodule_id,$absence_type) {

		$incident_type_id = $this->get_incident_type_id_by_incident_type_code($absence_type);

		if ($incident_type_id == false ) {
			return false;
		}

		/*
		INSERT INTO incident(incident_student_id, incident_time_slot_id, incident_day, incident_study_submodule_id, 
		incident_type, incident_notes, incident_entryDate, incident_creationUserId, incident_lastupdateUserId, 
		) VALUES (4,9,1,45,4)
		*/
		$data = array(
		   'incident_student_id' => $person_id ,
		   'incident_time_slot_id' => $time_slot_id ,
		   'incident_day' => $day,
		   'incident_study_submodule_id' => $study_submodule_id,
		   'incident_type' => $incident_type_id,
		   'incident_notes' => '',
		   'incident_entryDate' => date('Y-m-d H:i:s'),
           'incident_creationUserId' => $this->session->userdata("user_id"),
           'incident_lastupdateUserId' => $this->session->userdata("user_id"),
		);

		$this->db->insert('incident', $data);

		if ($this->db->affected_rows() == 1) {
			return $this->db->insert_id();
		} else {
			return false;
		}

	}

	function crud_incidence ($person_id,$time_slot_id,$day,$study_submodule_id,$absence_type) {

		$final_result = new stdClass();

		$result_incident_exists = $this->incidence_exists($person_id,$time_slot_id,$day,$study_submodule_id,$absence_type);

		if ($result_incident_exists->code == 1) {
			//Not exists. INSERT INCIDENT
			$result = $this->insert_incidence ($person_id,$time_slot_id,$day,$study_submodule_id,$absence_type);
			if ($result) {
				$final_result->result = true;
				$final_result->message = "Inserted new incidence (person_id: " . $person_id . ", time_slot_id: " . $time_slot_id . ", day: " . $day .", study_submodule_id: " . $study_submodule_id . " ,  absence_type: " . $absence_type ."  ) with incidence_id " . $result;
				return $final_result;
			} else {
				$final_result->result = false;
				$final_result->message = "Error inserting new incidence";
				return $final_result;
			}
			
		} else if ($result_incident_exists->code == 2) {
			//Already exists but different absence_type. 
			if ($absence_type == 0) {
				//DELETE INCIDENT
				$result = $this->delete_incidence($result_incident_exists->incident_id);
				if ($result) {
					$final_result->result = true;
					$final_result->message = "Deleted incidence with incidence_id " . $result_incident_exists->incident_id;
					return $final_result;
				} else {
					$final_result->result = false;
					$final_result->message = "Error deleting incidence with incidence_id " . $result_incident_exists->incident_id;
					return $final_result;
				}
			} else {
				//UPDATE INCIDENT
				$result = $this->update_incidence($result_incident_exists->incident_id,$absence_type);
				if ($result) {
					$final_result->result = true;
					$final_result->message = "Updated incidence with incidence_id " . $result_incident_exists->incident_id . " to absence_type: " . $absence_type;
					return $final_result;
				} else {
					$final_result->result = false;
					$final_result->message = "Error updating incidence with incidence_id " . $result_incident_exists->incident_id  . " to absence_type: " . $absence_type;
					return $final_result;
				}
			}

		} else { //Tipically 3: Incident already exists exactctly the same: Do nothing!
			//Nothig TODO: Maybe in future logging?
			$final_result->result = true;
			$final_result->message = "Nothing to do. The same exactly incident already exists on database!";
			return $final_result;
		}
	}

}
