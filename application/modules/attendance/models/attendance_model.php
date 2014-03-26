<?php
/**
 * Attendance_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
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

	function get_all_groups($orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . "( " . $row['classroom_group_shortName'] . " )";
			}
			return $groups_array;
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
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);

		$this->db->where('classroom_group_departmentid', $departmentId);
		       
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

	function get_all_teachers_ids_and_names() {

		$this->db->from('teacher');
        $this->db->select('teacher_code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		//$this->db->order_by('lesson_code', $orderby);
		
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

	/*
	function getAllLessonsWithGroupCodeShortNames($orderby="asc") {
		$all_lessons=$this->getAllLessons();
		
		foreach ($all_lessons as $lesson_key => $lesson) {
			$lesson->classroom_group_shortname="PROVA";
		}
		
		return $all_lessons;
	}*/

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

	function getAllTimeSlotsByTeacherCodeAndDay($teacher_id, $day,$orderby = "asc") {
		/*
		SELECT time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective
		FROM lesson
		INNER JOIN time_slot ON lesson.`lesson_time_slot_id`=time_slot.time_slot_id
		WHERE `lesson_day`=1 AND `lesson_teacher_id`=38
		*/
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective');
		$this->db->from('lesson');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$this->db->where('lesson_teacher_id', $teacher_id);
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getAllLessonsByTeacherCodeAndDay($teacher_id, $day,$orderby = "asc") {
		/*
		SELECT `lesson_id`,`lesson_code`,classroom_group_code,classroom_group_shortName,classroom_group_name
		FROM lesson
		INNER JOIN classroom_group ON lesson.`lesson_classroom_group_id`= classroom_group.classroom_group_id
		WHERE `lesson_day`=1 AND `lesson_teacher_id`=38
		*/
		
		$this->db->select('time_slot_order,time_slot_id,lesson_id,lesson_code,classroom_group_code,classroom_group_shortName,
						  classroom_group_name,study_module_id,study_module_shortname,study_module_name,location_shortName,classroom_group_location_id');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('location', 'lesson.lesson_location_id = location.location_id','left');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$this->db->where('lesson_teacher_id', $teacher_id);


		$query = $this->db->get();
		if ($query->num_rows() > 0)	{
			
			$lessons_array = array();

			foreach ($query->result_array() as $row)	{

				$lesson = new stdClass();
				$lesson->group_code = $row['classroom_group_code'];
				$lesson->base_url = base_url("index.php?/attendance/check_attendance/" . $row['classroom_group_code']);
				$lesson->group_shortname = $row['classroom_group_shortName'];
				$lesson->group_name = $row['classroom_group_name'];
				$lesson->study_module_id = $row['study_module_id'];
				$lesson->classroom_group_code = $row['classroom_group_code'];				
				$lesson->lesson_code = $row['lesson_code'];
				$lesson->lesson_shortname = $row['study_module_shortname'];
				$lesson->lesson_name = $row['study_module_name'];
				$lesson->lesson_location = $row['location_shortName'];
				$lesson->classroom_group_location_id = $row['classroom_group_location_id'];

   				$lessons_array[$row['time_slot_id']] = $lesson;

			}
			return $lessons_array;
		}
		else
			return false;
	}


//OSCAR: Obtenir les incidències d'un grup
	function getAllIncidentsByGroup_id($data, $hora, $classroom_group_id = false,$orderby = "asc") {
		
/*
SELECT `attendance_incident_id`, `student_id`, `teacher_id`,
a.`person_givenName` as "student_name", a.`person_sn1` as "student_sn1", a.`person_sn2` as "student_sn2",
b.`person_givenName` as "teacher_name", b.`person_sn1` as "teacher_sn1", b.`person_sn2` as "teacher_sn2", 
`data_incidencia`, `attendance_incident_timeslot_id`, `attendance_incident_lesson_id`, `attendance_incident_type`, `observacions` 
FROM (`attendance_incident`) 
JOIN `student` ON `attendance_incident_student_id`=`student_id` 
JOIN `person` a ON `student_person_id`= a.`person_id` 
JOIN `teacher` ON `attendance_incident_teacher_id`=`teacher_id` 
JOIN person b ON `teacher_person_id`= b.`person_id` 
WHERE `attendance_incident_timeslot_id` = '10' AND `data_incidencia` = '2013-09-16' 
*/
		$this->db->select('attendance_incident_id,student_id,teacher_id,st.person_givenName as "student_name",st.person_sn1 as "student_sn1",st.person_sn2 as "student_sn2",
			teach.person_givenName as "teacher_name",teach.person_sn1 as "teacher_sn1",teach.person_sn2 as "teacher_sn2",
			data_incidencia,attendance_incident_timeslot_id,attendance_incident_lesson_id, attendance_incident_type,observacions');
		$this->db->from('attendance_incident');
		$this->db->join('student','attendance_incident_student_id=student_id');
		$this->db->join('person as st','student_person_id=st.person_id');
		$this->db->join('teacher','attendance_incident_teacher_id=teacher_id');
		$this->db->join('person as teach','teacher_person_id=teach.person_id');		

			$this->db->where('attendance_incident_timeslot_id',$hora);
			$this->db->where('data_incidencia',date("Y-m-d", strtotime($data)));

		$query = $this->db->get();

		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$incident = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				$incident->student_id = $row['student_id'];
				$incident->teacher_id = $row['teacher_id'];
				$incident->student_name = $row['student_name'];
				$incident->student_sn1 = $row['student_sn1'];
				$incident->student_sn2 = $row['student_sn2'];

				$incident->teacher_name = $row['teacher_name'];
				$incident->teacher_sn1 = $row['teacher_sn1'];
				$incident->teacher_sn2 = $row['teacher_sn2'];				

				$incident->type = $row['attendance_incident_type'];
				$incident->timeslot = $row['attendance_incident_timeslot_id'];
				$incident->day = $row['data_incidencia'];
				
   				$incidents_array[] = $incident;

			}
			//print_r($incidents_array);
			return $incidents_array;
		}
		else
			return false;
	}














//OSCAR: Obtenir les lliçons d'un dia
	function getAllLessonsByDay($day,$classroom_group_id,$orderby = "asc") {
		/*
		SELECT `lesson_id`,`lesson_code`,classroom_group_code,classroom_group_shortName,classroom_group_name
		FROM lesson
		INNER JOIN classroom_group ON lesson.`lesson_classroom_group_id`= classroom_group.classroom_group_id
		WHERE `lesson_day`=1 AND `lesson_teacher_id`=38
		*/
		$this->db->select('time_slot_order,time_slot_id,lesson_id,lesson_code,classroom_group_code,classroom_group_shortName,
						  classroom_group_name,study_module_id,study_module_shortname,study_module_name,location_shortName,classroom_group_location_id');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('location', 'lesson.lesson_location_id = location.location_id','left');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$where = "classroom_group_id = '$classroom_group_id'";
		
		$this->db->where($where);

		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$lessons_array = array();

			foreach ($query->result_array() as $row)	{

				$lesson = new stdClass();
				$lesson->group_code = $row['classroom_group_code'];
				$lesson->base_url = base_url("index.php?/attendance/check_attendance/" . $row['classroom_group_code']);
				$lesson->group_shortname = $row['classroom_group_shortName'];
				$lesson->group_name = $row['classroom_group_name'];
				$lesson->study_module_id = $row['study_module_id'];
				$lesson->classroom_group_code = $row['classroom_group_code'];				
				$lesson->lesson_code = $row['lesson_code'];
				$lesson->lesson_shortname = $row['study_module_shortname'];
				$lesson->lesson_name = $row['study_module_name'];
				$lesson->lesson_location = $row['location_shortName'];
				$lesson->classroom_group_location_id = $row['classroom_group_location_id'];

   				$lessons_array[$row['time_slot_id']] = $lesson;

			}
			return $lessons_array;
		}
		else
			return false;
	}


	
	function getAllLessons($exists_assignatures_table=false,$orderby="asc") {
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
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
		
	}

	function get_all_classroom_groups($orderby='asc') {
		//classroom_group
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_mentorId');
		$this->db->from('classroom_group');
		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();
		
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

		if ($query->num_rows() == 1)	{
			$row = $query->row(); 
			return $row->groupName;
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
	
}
