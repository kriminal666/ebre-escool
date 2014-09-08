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
class managment_model  extends CI_Model  {
	
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

	function get_all_enrollment_academic_periods() {

		//enrollments
		$this->db->select('enrollment_periodid,count(enrollment_personid) as total_number_of_enrolled_persons');
		$this->db->from('enrollment');
		$this->db->group_by('enrollment_periodid');

		$query = $this->db->get();

		$academic_periods = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$academic_period = new stdClass;
				$academic_period->academic_period = $row->enrollment_periodid;
				$academic_period->total_number_of_enrolled_persons = $row->total_number_of_enrolled_persons;
				$academic_periods[$row->enrollment_periodid] = $academic_period;
			}
		}

		return $academic_periods;	

	}

	
	function get_enrollment_reports_all_enrolled_persons_by_academic_period () {

		/*
		SELECT person_id, person_sn1, person_sn2, person_givenName, person_official_id, enrollment_studies_id, enrollment_studies_periodid, enrollment_studies_personid, enrollment_studies_study_id, studies_shortname , studies_name
		FROM enrollment_studies
		JOIN studies ON studies.studies_id = enrollment_studies.enrollment_studies_study_id
		JOIN person ON person.person_id = enrollment_studies.enrollment_studies_personid
		ORDER BY person_sn1, person_sn2, person_givenName
		LIMIT 0 , 30
		*/

		//enrollments
		$this->db->select('person_id, person_sn1, person_sn2, person_givenName, person_official_id, enrollment_studies_id, 
				           enrollment_studies_periodid, enrollment_studies_personid, enrollment_studies_study_id, 
				           studies_shortname , studies_name');
		$this->db->from('enrollment_studies');
		$this->db->join('studies','studies.studies_id = enrollment_studies.enrollment_studies_study_id');	
		$this->db->join('person','person.person_id = enrollment_studies.enrollment_studies_personid');
		//$this->db->order_by('studies_shortname', $orderby);


		$query = $this->db->get();

		$all_enrollment_academic_periods = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$enrollment = new stdClass;
				
				$enrollment->person_id = $row->person_id;
				$enrollment->person_sn1 = $row->person_sn1;
				$enrollment->person_sn2 = $row->person_sn2;
				$enrollment->person_givenName = $row->person_givenName;
				$enrollment->person_official_id = $row->person_official_id;
				$enrollment->enrollment_studies_id = $row->enrollment_studies_id;
				$enrollment->enrollment_studies_periodid = $row->enrollment_studies_periodid;
				$enrollment->enrollment_studies_personid = $row->enrollment_studies_personid;
				$enrollment->enrollment_studies_personid = $row->enrollment_studies_personid;
				$enrollment->enrollment_studies_personid = $row->enrollment_studies_personid;

				$all_enrollment_academic_periods[$row->enrollment_studies_id] = $enrollment;
			}
		}

		return $all_enrollment_academic_periods;	
		
		/*
		$academic_periods = array ();

		$academic_period1 = new stdClass;
		$academic_period1->academic_period = "2010-11";
		$academic_period1->total_number_of_enrolled_persons = 58;
		$academic_period2 = new stdClass;
		$academic_period2->academic_period = "2011-12";
		$academic_period2->total_number_of_enrolled_persons = 86;
		$academic_period3 = new stdClass;
		$academic_period3->academic_period = "2012-13";
		$academic_period3->total_number_of_enrolled_persons = 91;
		$academic_period4 = new stdClass;
		$academic_period4->academic_period = "2013-14";
		$academic_period4->total_number_of_enrolled_persons = 54;

		$academic_periods[0] = $academic_period1;
		$academic_periods[1] = $academic_period2;
		$academic_periods[2] = $academic_period3;
		$academic_periods[3] = $academic_period4;

		return $academic_periods; */

	}

	function get_studymodules_by_study($withtotal = true) {
		/* studymodules by study
		SELECT course_study_id, count(`study_module_id`) 
		FROM study_module 
		LEFT JOIN course ON study_module.study_module_courseid = course.course_id
		GROUP BY course_study_id
		 */

		//courses
		$this->db->select('course_study_id,count(study_module_id) as total');
		$this->db->from('study_module');
		$this->db->join('course','study_module.study_module_courseid = course.course_id', 'left');	
		$this->db->group_by('course_study_id');
		$query = $this->db->get();

		$studymodules_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$studymodules_ids = array();
				//study_modules
				$this->db->select('study_module_id');
				$this->db->from('study_module');
				$this->db->join('course','study_module.study_module_courseid = course.course_id', 'left');
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$studymodules_ids[]=$row1->study_module_id;
					}
				}
				$deposit->studymodules_ids =  $studymodules_ids;
				
				if ($withtotal) {
					$studymodules_by_study[$row->course_study_id] = $deposit;
				}	else {
					$studymodules_by_study[$row->course_study_id] = $studymodules_ids;
				}
				
			}
		}

		return $studymodules_by_study;
	}

	function get_enrollmentdata_by_study ($withtotal = true) {

		/* studysubmodules by study
		SELECT enrollment_study_id,studies_shortname,studies_name,count(enrollment_id) as total 
		FROM enrollment 
		INNER JOIN studies ON studies.`studies_id` = enrollment.enrollment_study_id
		WHERE enrollment_periodid="2014-15"
		GROUP BY enrollment_study_id,studies_shortname,studies_name
		 */

		//
		$this->db->select('enrollment_study_id,studies_shortname,studies_name,count(enrollment_id) as total ');
		$this->db->from('enrollment');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		$this->db->group_by('enrollment_study_id,studies_shortname,studies_name');
		$this->db->where('enrollment_periodid','2014-15');
		$query = $this->db->get();

		$enrollment_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$enrollment_ids = array();
				//study_modules
				$this->db->select('enrollment_id');
				$this->db->from('enrollment');
				$this->db->where('enrollment_study_id',$row->enrollment_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$enrollment_ids[]=$row1->enrollment_id;
					}
				}
				$deposit->enrollment_ids =  $enrollment_ids;

				if ($withtotal) {
					$enrollment_by_study[$row->enrollment_study_id] = $deposit;
				} else {
					$enrollment_by_study[$row->enrollment_study_id] = $enrollment_ids;
				}
				
			}
		}

		return $enrollment_by_study;
	}
		

	function get_studysubmodules_by_study( $withtotal = true) {

		/* studysubmodules by study
		SELECT course_study_id, count(`study_module_id`) 
		FROM study_submodules
		JOIN study_module ON study_submodules.study_submodules_study_module_id=study_module.study_module_id
		LEFT JOIN course ON study_module.study_module_courseid = course.course_id
		GROUP BY course_study_id
		 */

		//courses
		$this->db->select('course_study_id,count(study_module_id) as total');
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_submodules.study_submodules_study_module_id = study_module.study_module_id', 'left');
		$this->db->join('course','study_module.study_module_courseid = course.course_id', 'left');
		$this->db->group_by('course_study_id');
		$query = $this->db->get();

		$studysubmodules_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$studysubmodules_ids = array();
				//study_modules
				$this->db->select('study_submodules_id');
				$this->db->from('study_submodules');
				$this->db->join('study_module','study_submodules.study_submodules_study_module_id = study_module.study_module_id', 'left');
				$this->db->join('course','study_module.study_module_courseid = course.course_id', 'left');
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$studysubmodules_ids[]=$row1->study_submodules_id;
					}
				}
				$deposit->studysubmodules_ids =  $studysubmodules_ids;

				if ($withtotal) {
					$studysubmodules_by_study[$row->course_study_id] = $deposit;
				} else {
					$studysubmodules_by_study[$row->course_study_id] = $studysubmodules_ids;
				}
				
			}
		}

		return $studysubmodules_by_study;
	}

	function get_classroomgroups_by_study( $withtotal = true ) {
		/* classroomgroups by study
		SELECT course_study_id, count(classroom_group_id) 
		FROM classroom_group 
		LEFT JOIN course ON classroom_group.`classroom_group_course_id`=course.course_id
		GROUP BY course_study_id
		 */

		//courses
		$this->db->select('course_study_id,count(classroom_group_id) as total');
		$this->db->from('classroom_group');
		$this->db->join('course','classroom_group.classroom_group_course_id = course.course_id', 'left');
		$this->db->group_by('course_study_id');
		$query = $this->db->get();

		$classroomgroups_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$classroomgroups_ids = array();
				//classroomgroups
				$this->db->select('classroom_group_id');
				$this->db->from('classroom_group');
				$this->db->join('course','classroom_group.classroom_group_course_id = course.course_id', 'left');
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$classroomgroups_ids[]=$row1->classroom_group_id;
					}
				}
				$deposit->classroomgroups_ids =  $classroomgroups_ids;

				if ($withtotal) {
					$classroomgroups_by_study[$row->course_study_id] = $deposit;
				} else {
					$classroomgroups_by_study[$row->course_study_id] = $classroomgroups_ids;
				}
					
			}
		}

		return $classroomgroups_by_study;
	}


	function get_courses_by_study( $withtotal = true ) {
		/* courses by study
		SELECT course_study_id, count(`course_id`) 
		FROM course 
		GROUP BY course_study_id
		 */

		//courses
		$this->db->select('course_study_id,count(course_id) as total');
		$this->db->from('course');
		$this->db->group_by('course_study_id');
		$query = $this->db->get();

		$courses_by_study = array();
		if ($query->num_rows() > 0)	{
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$courses_ids = array();
				//courses
				$this->db->select('course_id');
				$this->db->from('course');
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$courses_ids[]=$row1->course_id;
					}
				}
				$deposit->courses_ids =  $courses_ids;

				if ($withtotal) {
					$courses_by_study[$row->course_study_id] = $deposit;
				} else {
					$courses_by_study[$row->course_study_id] = $courses_ids;	
				}
				
			}
		}

		return $courses_by_study;
	}

	function get_teachers_by_department( $withtotal = true) {
		/* teachers by department
		SELECT `teacher_department_id`, count(`teacher_id`) 
		FROM `teacher` 
		GROUP BY teacher_department_id */

		//deparments
		$this->db->select('teacher_department_id,count(teacher_id) as total');
		$this->db->from('teacher');
		$this->db->group_by('teacher_department_id');
		$query = $this->db->get();

		$teachers_by_department = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$teachers_ids = array();
				//deparments
				$this->db->select('teacher_department_id,teacher_id');
				$this->db->from('teacher');
				$this->db->where('teacher_department_id',$row->teacher_department_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$teachers_ids[]=$row1->teacher_id;
					}
				}
				$deposit->teachers_ids =  $teachers_ids;
				if ($withtotal) {
					$teachers_by_department[$row->teacher_department_id] = $deposit;
				} else {
					$teachers_by_department[$row->teacher_department_id] = $teachers_ids;
				}
			}
		}

		return $teachers_by_department;
	}

	function get_studies_by_department( $withtotal = true ) {
		/* studies by department
		SELECT `department_id`,count(`study_id`) as total
		FROM `study_department` 
		GROUP BY department_id */

		//deparments
		$this->db->select('department_id,count(study_id) as total');
		$this->db->from('study_department');
		$this->db->group_by('department_id');
		$query = $this->db->get();

		$studies_by_department = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$studies_ids = array();
				//studies
				$this->db->select('department_id,study_id');
				$this->db->from('study_department');
				$this->db->where('department_id',$row->department_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$studies_ids[]=$row1->study_id;
					}
				}

				$deposit->studies_ids = $studies_ids;
				if ($withtotal) {
					$studies_by_department[$row->department_id] = $deposit;
				} else {
					$studies_by_department[$row->department_id] = $studies_ids;
				}
				
				
			}
		}

		return $studies_by_department;
	}

	
	function get_all_studies_report_info($orderby = "DESC") {
		/*
		SELECT studies_id,studies_shortname,studies_name,studies_studies_organizational_unit_id, study_department.department_id, department_shortname
		FROM studies
		LEFT JOIN study_department ON studies.studies_studies_organizational_unit_id = study_department.study_id
		LEFT JOIN department ON study_department.department_id = department.department_id
		WHERE 1
		*/
		/*
		SELECT studies_id, studies_shortname, studies_name, studies_studies_organizational_unit_id,studies_organizational_unit_shortname
		FROM studies
		LEFT JOIN studies_organizational_unit ON studies.studies_studies_organizational_unit_id = studies_organizational_unit.studies_organizational_unit_id
		WHERE 1
		*/

		$courses_by_study = $this->get_courses_by_study();
		$classroomgroups_by_study = $this->get_classroomgroups_by_study();
		$studymodules_by_study = $this->get_studymodules_by_study();
		$studysubmodules_by_study = $this->get_studysubmodules_by_study();
		$enrollmentdata_by_study = $this->get_enrollmentdata_by_study();

		//deparments
		$this->db->select('studies_id,studies_shortname,studies_name,studies_studies_organizational_unit_id,studies_organizational_unit_shortname,
						  studies_law_id,studies_law_shortname,');
		$this->db->from('studies');
		$this->db->join('studies_organizational_unit','studies.studies_studies_organizational_unit_id = studies_organizational_unit.studies_organizational_unit_id', 'left');
		$this->db->join('studies_law','studies.studies_studies_law_id = studies_law.studies_law_id', 'left');
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_studies = array();
			foreach($query->result() as $row){
				$study = new stdClass;
				
				$study->id = $row->studies_id;
				$study->shortname = $row->studies_shortname;
				$study->name = $row->studies_name;
				$study->studies_studies_organizational_unit_id = $row->studies_studies_organizational_unit_id;
				$study->studies_organizational_unit_shortname = $row->studies_organizational_unit_shortname;
				$study->studies_studies_law_id = $row->studies_law_id;
				$study->studies_studies_law_shortname = $row->studies_law_shortname;

				//get courses info
				if ( array_key_exists ( $row->studies_id , $courses_by_study )) {					
					$study->numberOfCourses = $courses_by_study[$row->studies_id]->total;
					$study->courses_ids = $courses_by_study[$row->studies_id]->courses_ids;

				}	else {
					$study->numberOfCourses = "";
					$study->courses_ids = "";
				}

				//get classroomgroups info
				if ( array_key_exists ( $row->studies_id , $classroomgroups_by_study )) {					
					$study->numberOfClassroomgroups = $classroomgroups_by_study[$row->studies_id]->total;
					$study->classroomgroups_ids = $classroomgroups_by_study[$row->studies_id]->classroomgroups_ids;

				}	else {
					$study->numberOfClassroomgroups = "";
					$study->classroomgroups_ids = "";
				}	

				//get studymodules info
				if ( array_key_exists ( $row->studies_id , $studymodules_by_study )) {					
					$study->numberOfStudyModules = $studymodules_by_study[$row->studies_id]->total;
					$study->studymodules_ids = $studymodules_by_study[$row->studies_id]->studymodules_ids;

				}	else {
					$study->numberOfStudyModules = "";
					$study->studymodules_ids = "";
				}		

				//get studysubmodules info
				if ( array_key_exists ( $row->studies_id , $studysubmodules_by_study )) {					
					$study->numberOfStudySubModules = $studysubmodules_by_study[$row->studies_id]->total;
					$study->studysubmodules_ids = $studysubmodules_by_study[$row->studies_id]->studysubmodules_ids;

				}	else {
					$study->numberOfStudySubModules = "";
					$study->studysubmodules_ids = "";
				}	


				//get ENROLLMENT INFO
				if ( array_key_exists ( $row->studies_id , $enrollmentdata_by_study )) {					
					$study->numberOfEnrolledStudies = $enrollmentdata_by_study[$row->studies_id]->total;
					//$study->studysubmodules_ids = $studysubmodules_by_study[$row->studies_id]->studysubmodules_ids;

				}	else {
					$study->numberOfEnrolledStudies = "";
					//$study->studysubmodules_ids = "";
				}		
				

				/*
				$teacher_fullname = $row->person_sn1 . " " . $row->person_sn1 . ", " . $row->person_givenName;
				$study->head_personid = $row->person_id;
				$study->head = "( " . $row->teacher_code . " ) " . $teacher_fullname;
				$study->head_fullname = $teacher_fullname;
				$study->head_code = $row->teacher_code;
				$study->head_id = $row->study_head;
				$study->parentstudy = $row->study_parent_study_id;
				$study->organizational_unit = $row->organizational_unit_name;
				$study->organizational_unit_id = $row->organizational_unit_id;
				$study->location = $row->location_name;
				$study->location_id = $row->study_location_id;				*/

				//get number of teacher Deparments
				/*if ( array_key_exists ( $row->study_id , $teachers_by_study )) {					
					$study->numberOfTeachers = $teachers_by_study[$row->study_id]->total;
					$study->teacher_ids = $teachers_by_study[$row->study_id]->teachers_ids;

				}	else {
					$study->numberOfTeachers = "";
					$study->teacher_ids = "";
				}

				//get number of teacher Studies
				if ( array_key_exists ( $row->study_id , $studies_by_study )) {					
					$study->numberOfStudies = $studies_by_study[$row->study_id]->total;
					$study->studies_ids = $studies_by_study[$row->study_id]->studies_ids;
				}	else {
					$study->numberOfStudies = "";
					$study->studies_ids = "";
				}*/
				
				$all_studies[$row->studies_id] = $study;
			}
			return $all_studies;
		}	
		else
			return false;
		

		/*$all_studies = array();

		$study1 = new stdClass;

		$study1->shortname = "Elèctrics";
		$study1->name = "Departament d'electrics";
		$study1->head = "Richard Stallman";
		$study1->location = "Aula 45";
		$study1->numberOfTeachers = 7;
		$study1->numberOfStudies = 2;

		$study2 = new stdClass;

		$study2->shortname = "Informàtica";
		$study2->name = "Departament d'informàtica";
		$study2->head = "Linus Torvalds";
		$study2->location = "Espai";
		$study2->numberOfTeachers = 6;
		$study2->numberOfStudies = 3;

		$all_studies[] = $study1;
		$all_studies[] = $study2;

		return $all_studies;*/
	}

	function get_all_studymodules_report_info($academic_period,$orderby = "DESC") {



		//classgroups
		//Example SQL:
		/*
		SELECT study_module_id, study_module_external_code, study_module_shortname, study_module_name, study_module_courseid, course_shortname, course_name, course_study_id, studies_shortname , 
		       studies_name, studies_studies_law_id, studies_law_shortname , studies_law_name ,study_module_hoursPerWeek, study_module_order, study_module_academic_periods_initialDate, study_module_academic_periods_endDate, 
		       study_module_type, study_module_subtype, study_module_description
		FROM study_module_academic_periods
		LEFT JOIN study_module ON study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id
		LEFT JOIN course ON course.course_id = study_module_courseid
		LEFT JOIN studies ON studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE study_module_academic_periods_academic_period_id = 5
		*/

		$this->db->select('study_module_id, study_module_external_code, study_module_shortname, study_module_name, study_module_courseid, course_shortname, course_name, course_study_id, 
			               studies_shortname , studies_name, studies_studies_law_id, studies_law_shortname , studies_law_name ,study_module_hoursPerWeek, study_module_order, 
			               study_module_academic_periods_initialDate, study_module_academic_periods_endDate, study_module_type, study_module_subtype, study_module_description');
		$this->db->from('study_module_academic_periods');
		$this->db->join('study_module','study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id', 'left');
		$this->db->join('course','course.course_id = study_module_courseid', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->where('study_module_academic_periods_academic_period_id',$academic_period);
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_study_modules = array();
			foreach($query->result() as $row){
				$study_module = new stdClass;
				
				$study_module->id = $row->study_module_id;
				$study_module->code = $row->study_module_external_code;
				$study_module->shortname = $row->study_module_shortname;
				$study_module->name = $row->study_module_name;
				$study_module->description = $row->study_module_description;

				$study_module->course_id = $row->study_module_courseid;
				$study_module->course_shortname = $row->course_shortname;
				$study_module->course_name = $row->course_name;

				$study_module->study_id = $row->course_study_id;
				$study_module->study_shortname = $row->studies_shortname;
				$study_module->study_name = $row->studies_name;
				$study_module->study_law_id = $row->studies_studies_law_id;
				$study_module->study_law_name = $row->studies_law_shortname;
				$study_module->study_law_shortname = $row->studies_law_name;

				$study_module->study_module_hoursPerWeek = $row->study_module_hoursPerWeek;
				$study_module->study_module_order = $row->study_module_order;
				$study_module->study_module_initialDate = $row->study_module_academic_periods_initialDate;
				$study_module->study_module_endDate = $row->study_module_academic_periods_endDate;
				$study_module->study_module_type = $row->study_module_type;
				$study_module->study_module_subtype = $row->study_module_subtype;


				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_modules[$row->study_module_id] = $study_module;
			}
			return $all_study_modules;
		}	
		else
			return false;

	}

	function get_all_lessons_report_info($academic_period,$orderby = "DESC") {

		//classgroups
		//Example SQL:
		/*
		SELECT lesson_id,lesson_academic_period_id, academic_periods.academic_periods_shortname,lesson_code, course_id, course_shortname, course_name, course_study_id ,studies_shortname, studies_name ,lesson_classroom_group_id, classroom_group_code, classroom_group_shortName,classroom_group_name,lesson_teacher_id, teacher_code, teacher_person_id, person_givenName, person_sn1, person_sn2, lesson_study_module_id, study_module_shortname, 
			   study_module_name, lesson_location_id, location_name, location_shortName, lesson_day, lesson_time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective , time_slot_order
		FROM `lesson` 
		LEFT JOIN academic_periods ON academic_periods.academic_periods_id = lesson.lesson_academic_period_id
		LEFT JOIN classroom_group ON classroom_group.classroom_group_id = lesson.lesson_classroom_group_id
        LEFT JOIN course ON course.course_id = classroom_group.classroom_group_course_id
		LEFT JOIN studies ON studies.studies_id = course.course_study_id
		LEFT JOIN teacher ON teacher.teacher_id = lesson.lesson_teacher_id
		LEFT JOIN person ON person.person_id = lesson.lesson_teacher_id
		LEFT JOIN study_module ON study_module.study_module_id = lesson.lesson_study_module_id
		LEFT JOIN location ON location.location_id = lesson.lesson_location_id
		LEFT JOIN time_slot ON time_slot.time_slot_id = lesson.lesson_time_slot_id
		WHERE lesson_academic_period_id=4
		*/

		$this->db->select('lesson_id,lesson_academic_period_id,academic_periods.academic_periods_shortname,lesson_code, course_id, course_shortname, course_name, course_study_id ,studies_shortname, studies_name, lesson_classroom_group_id, classroom_group_code, classroom_group_shortName,
			   classroom_group_name,lesson_teacher_id, teacher_code, teacher_person_id, person_givenName, person_sn1, person_sn2, lesson_study_module_id, study_module_shortname, 
			   study_module_name, lesson_location_id, location_name, location_shortName, lesson_day, lesson_time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective , time_slot_order');
		$this->db->from('lesson');
		$this->db->join('academic_periods','academic_periods.academic_periods_id = lesson.lesson_academic_period_id', 'left');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = lesson.lesson_classroom_group_id', 'left');
		$this->db->join('course','course.course_id = classroom_group.classroom_group_course_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('teacher','teacher.teacher_id = lesson.lesson_teacher_id', 'left');
		$this->db->join('person','person.person_id = lesson.lesson_teacher_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = lesson.lesson_study_module_id', 'left');
		$this->db->join('location','location.location_id = lesson.lesson_location_id', 'left');
		$this->db->join('time_slot','time_slot.time_slot_id = lesson.lesson_time_slot_id', 'left');
		$this->db->where('lesson_academic_period_id',$academic_period);
		
		//$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_lessons = array();
			foreach($query->result() as $row){
				$lesson = new stdClass;
				
				$lesson->id = $row->lesson_id;
				$lesson->academic_period = $row->lesson_academic_period_id;
				$lesson->academic_period_shortname = $row->academic_periods_shortname;				
				$lesson->code = $row->lesson_code;

				$lesson->course_id = $row->course_id;
				$lesson->course_shortname = $row->course_shortname;
				$lesson->course_name = $row->course_name;

				$lesson->studies_id = $row->course_study_id;
				$lesson->studies_shortname = $row->studies_shortname;
				$lesson->studies_name = $row->studies_name;

				$lesson->classroom_group_id = $row->lesson_classroom_group_id;
				$lesson->classroom_group_code = $row->classroom_group_code;
				$lesson->classroom_group_shortName = $row->classroom_group_shortName;
				$lesson->classroom_group_name = $row->classroom_group_name;

				$lesson->teacher_id = $row->lesson_teacher_id;
				$lesson->teacher_code = $row->teacher_code;
				$lesson->givenName = $row->person_givenName;
				$lesson->sn1 = $row->person_sn1;
				$lesson->sn2 = $row->person_sn2;

				$lesson->study_module_id = $row->lesson_study_module_id;
				$lesson->study_module_shortname = $row->study_module_shortname;
				$lesson->study_module_name = $row->study_module_name;
	

				$lesson->location_id = $row->lesson_location_id;
				$lesson->location_name = $row->location_name;
				$lesson->location_shortName = $row->location_shortName;

				$lesson->day = $row->lesson_day;
				$lesson->time_slot_id = $row->lesson_time_slot_id;
				$lesson->start_time = $row->time_slot_start_time;
				$lesson->end_time = $row->time_slot_end_time;
				$lesson->lective = $row->time_slot_lective;
				$lesson->order = $row->time_slot_order;
				
				$all_lessons[$row->lesson_id] = $lesson;
			}
			return $all_lessons;
		}	
		else
			return false;

	}


	function get_all_study_submodules_report_info($academic_period,$orderby = "DESC") {

		//classgroups
		//Example SQL:
		/*
		SELECT study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_external_code, study_module_shortname, 
		study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
		studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,study_submodules_order,study_submodules_description
		FROM study_submodules_academic_periods 
		LEFT JOIN study_submodules ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		LEFT JOIN study_module ON study_module.study_module_id = study_submodules.study_submodules_study_module_id
		LEFT JOIN course ON  course.course_id = study_submodules.study_submodules_courseid
		LEFT JOIN studies ON  studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON  studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE study_submodules_academic_periods_academic_period_id = 5
		*/

		$this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_external_code, study_module_shortname, 
							study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
							studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,
							study_submodules_order,study_submodules_description');
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = study_submodules.study_submodules_study_module_id', 'left');
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period);
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_study_submodules = array();
			foreach($query->result() as $row){
				$study_submodule = new stdClass;
				
				$study_submodule->id = $row->study_submodules_id;
				$study_submodule->shortname = $row->study_submodules_shortname;
				$study_submodule->name = $row->study_submodules_name;
				$study_submodule->description = $row->study_submodules_description;

				$study_submodule->course_id = $row->study_submodules_courseid;
				$study_submodule->course_shortname = $row->course_shortname;
				$study_submodule->course_name = $row->course_name;

				$study_submodule->study_id = $row->course_study_id;
				$study_submodule->study_shortname = $row->studies_shortname;
				$study_submodule->study_name = $row->studies_name;
				$study_submodule->study_law_id = $row->studies_studies_law_id;
				$study_submodule->study_law_name = $row->studies_law_shortname;
				$study_submodule->study_law_shortname = $row->studies_law_name;

				$study_submodule->study_submodules_totalHours = $row->study_submodules_academic_periods_totalHours;
				$study_submodule->study_submodules_order = $row->study_submodules_order;
				$study_submodule->study_submodule_initialDate = $row->study_submodules_academic_periods_initialDate;
				$study_submodule->study_submodule_endDate = $row->study_submodules_academic_periods_endDate;
				
				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_submodules[$row->study_submodules_id] = $study_submodule;
			}
			return $all_study_submodules;
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

	function get_all_classgroups_report_info($academic_period,$orderby = "DESC") {

		/* SQL SCRIPT FOR MIGRATION
		UPDATE  classroom_group_academic_periods AS cgap 
		INNER JOIN classroom_group AS cg ON cg.classroom_group_id 	 = cgap.classroom_group_academic_periods_classroom_group_id
		SET cgap.classroom_group_academic_periods_mentorId = cg.classroom_group_mentorId, cgap.classroom_group_academic_periods_description = cg.classroom_group_description, cgap.classroom_group_academic_periods_shift = cg.classroom_group_shift,  cgap.classroom_group_academic_periods_location = cg.classroom_group_location_id
		WHERE classroom_group_academic_periods_academic_period_id = 5
		*/

		//classgroups
		//Example SQL:
		/*
		SELECT classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_course_id, classroom_group_academic_periods_description, classroom_group_academic_periods_mentorId, classroom_group_academic_periods_shift, 
		classroom_group_academic_periods_location, course_shortname, course_name, course_study_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname, 
		studies_law_name, teacher_person_id, teacher_code,teacher_department_id, person_givenName, person_sn1, person_sn2,shift_name,location_name, location_shortName
		FROM classroom_group_academic_periods
		LEFT JOIN  classroom_group ON  classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id
		LEFT JOIN  course ON  course.course_id = classroom_group.classroom_group_course_id
		LEFT JOIN  studies ON   studies.studies_id = course.course_study_id
		LEFT JOIN  studies_law ON   studies_law.studies_law_id = studies.studies_studies_law_id
		LEFT JOIN  teacher ON teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId
		LEFT JOIN  person ON person.person_id = teacher. teacher_person_id
		LEFT JOIN  shift ON shift.shift_id = classroom_group_academic_periods.classroom_group_academic_periods_shift
		LEFT JOIN  location ON location.location_id = classroom_group_academic_periods.classroom_group_academic_periods_location
		WHERE classroom_group_academic_periods_academic_period_id= 5
		*/

		$this->db->select('classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_course_id, classroom_group_academic_periods_description, classroom_group_academic_periods_mentorId, classroom_group_academic_periods_shift, 
		classroom_group_academic_periods_location, course_shortname, course_name, course_study_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname, 
		studies_law_name, teacher_person_id, teacher_code,teacher_department_id, person_givenName, person_sn1, person_sn2,shift_name,location_name, location_shortName');
		$this->db->from('classroom_group_academic_periods');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id', 'left');
		$this->db->join('course','course.course_id = classroom_group.classroom_group_course_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->join('teacher','teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId', 'left');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('shift','shift.shift_id = classroom_group_academic_periods.classroom_group_academic_periods_shift', 'left');
		$this->db->join('location','location.location_id = classroom_group_academic_periods.classroom_group_academic_periods_location', 'left');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period);

		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_classroom_groups = array();
			foreach($query->result() as $row){
				$classroom_group = new stdClass;
				
				$classroom_group->id = $row->classroom_group_id;
				$classroom_group->code = $row->classroom_group_code;
				$classroom_group->shortname = $row->classroom_group_shortName;
				$classroom_group->name = $row->classroom_group_name;
				$classroom_group->description = $row->classroom_group_academic_periods_description;

				$classroom_group->course_id = $row->classroom_group_course_id;
				$classroom_group->course_shortname = $row->course_shortname;
				$classroom_group->course_name = $row->course_name;

				$classroom_group->study_id = $row->course_study_id;
				$classroom_group->study_shortname = $row->studies_shortname;
				$classroom_group->study_name = $row->studies_name;
				$classroom_group->study_ou_id = $row->studies_studies_organizational_unit_id;
				$classroom_group->study_law_id = $row->studies_studies_law_id;
				$classroom_group->study_law_name = $row->studies_law_shortname;
				$classroom_group->study_law_shortname = $row->studies_law_name;
				
				$classroom_group->mentor_id = $row->classroom_group_academic_periods_mentorId;
				$classroom_group->mentor_person_id = $row->teacher_person_id;
				$classroom_group->mentor_code = $row->teacher_code;
				$classroom_group->mentor_department_id = $row->teacher_department_id;
				$classroom_group->mentor_givenname = $row->person_givenName;
				$classroom_group->mentor_sn1 = $row->person_sn1;
				$classroom_group->mentor_sn2 = $row->person_sn2;

				$classroom_group->shift_id = $row->classroom_group_academic_periods_shift;
				$classroom_group->shift_name = $row->shift_name;

				$classroom_group->location_id = $row->classroom_group_academic_periods_location;
				$classroom_group->location_name = $row->location_name;
				$classroom_group->location_shortname = $row->location_shortName;

				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_classroom_groups[$row->classroom_group_id] = $classroom_group;
			}
			return $all_classroom_groups;
		}	
		else
			return false;

	}
	

	function get_all_courses_report_info($orderby = "DESC") {

			
		//$teachers_by_department = $this->get_teachers_by_department();
		//$studies_by_department = $this->get_studies_by_department();


		//courses
		//Example SQL:
		/*
		SELECT course_id, course_shortname, course_name, course_number course_cycle_id, course_study_id, cycle_id, cycle_shortname, cycle_name, studies_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname, studies_law_name
		FROM `course` 
		LEFT JOIN cycle ON cycle.cycle_id = course.course_cycle_id
		LEFT JOIN studies ON studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE 1
		*/

		$this->db->select('course_id, course_shortname, course_name, course_number, course_cycle_id, course_study_id, cycle_shortname, cycle_name,  
			               studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id,
			               studies_law_shortname, studies_law_name');
		$this->db->from('course');
		$this->db->join('cycle','cycle.cycle_id = course.course_cycle_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_courses = array();
			foreach($query->result() as $row){
				$course = new stdClass;
				
				$course->id = $row->course_id;
				$course->shortname = $row->course_shortname;
				$course->name = $row->course_name;
				$course->course_number = $row->course_number;
				$course->course_cycle_id = $row->course_cycle_id;
				$course->course_study_id = $row->course_study_id;
				$course->cycle_shortname = $row->cycle_shortname;
				$course->cycle_name = $row->cycle_name;
				$course->studies_shortname = $row->studies_shortname;
				$course->studies_name = $row->studies_name;
				$course->studies_studies_organizational_unit_id = $row->studies_studies_organizational_unit_id;
				$course->studies_studies_law_id = $row->studies_studies_law_id;
				$course->studies_law_shortname = $row->studies_law_shortname;
				$course->studies_law_name = $row->studies_law_name;
				

				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}

				//get number of teacher Studies
				if ( array_key_exists ( $row->course_id , $studies_by_course )) {					
					$course->numberOfStudies = $studies_by_course[$row->course_id]->total;
					$course->studies_ids = $studies_by_course[$row->course_id]->studies_ids;
				}	else {
					$course->numberOfStudies = "";
					$course->studies_ids = "";
				}*/
				
				$all_courses[$row->course_id] = $course;
			}
			return $all_courses;
		}	
		else
			return false;

	}


	function get_all_departments_report_info($orderby = "DESC") {

			
		$teachers_by_department = $this->get_teachers_by_department();
		$studies_by_department = $this->get_studies_by_department();


		//deparments
		$this->db->select('department_id,department_shortname,department_name,department_head,department_parent_department_id,
						   department_organizational_unit_id,department_location_id,
						   teacher_code,person_id,person_sn1,person_sn2,person_givenName,organizational_unit_id,organizational_unit_name,location_name');
		$this->db->from('department');
		$this->db->join('teacher','teacher.teacher_id = department.department_head', 'left');
		$this->db->join('person','teacher.teacher_person_id = person.person_id', 'left');
		$this->db->join('organizational_unit','department.department_organizational_unit_id = organizational_unit.organizational_unit_id', 'left');
		$this->db->join('location','department.department_location_id = location.location_id', 'left');
		$this->db->order_by('department_name', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_departments = array();
			foreach($query->result() as $row){
				$department = new stdClass;
				
				$department->id = $row->department_id;
				$department->shortname = $row->department_shortname;
				$department->name = $row->department_name;
				$teacher_fullname = $row->person_sn1 . " " . $row->person_sn1 . ", " . $row->person_givenName;
				$department->head_personid = $row->person_id;
				$department->head = "( " . $row->teacher_code . " ) " . $teacher_fullname;
				$department->head_fullname = $teacher_fullname;
				$department->head_code = $row->teacher_code;
				$department->head_id = $row->department_head;
				$department->parentDepartment = $row->department_parent_department_id;
				$department->organizational_unit = $row->organizational_unit_name;
				$department->organizational_unit_id = $row->organizational_unit_id;
				$department->location = $row->location_name;
				$department->location_id = $row->department_location_id;				

				//get number of teacher Deparments
				if ( array_key_exists ( $row->department_id , $teachers_by_department )) {					
					$department->numberOfTeachers = $teachers_by_department[$row->department_id]->total;
					$department->teacher_ids = $teachers_by_department[$row->department_id]->teachers_ids;

				}	else {
					$department->numberOfTeachers = "";
					$department->teacher_ids = "";
				}

				//get number of teacher Studies
				if ( array_key_exists ( $row->department_id , $studies_by_department )) {					
					$department->numberOfStudies = $studies_by_department[$row->department_id]->total;
					$department->studies_ids = $studies_by_department[$row->department_id]->studies_ids;
				}	else {
					$department->numberOfStudies = "";
					$department->studies_ids = "";
				}
				
				$all_departments[$row->department_id] = $department;
			}
			return $all_departments;
		}	
		else
			return false;
		

		/*$all_departments = array();

		$department1 = new stdClass;

		$department1->shortname = "Elèctrics";
		$department1->name = "Departament d'electrics";
		$department1->head = "Richard Stallman";
		$department1->location = "Aula 45";
		$department1->numberOfTeachers = 7;
		$department1->numberOfStudies = 2;

		$department2 = new stdClass;

		$department2->shortname = "Informàtica";
		$department2->name = "Departament d'informàtica";
		$department2->head = "Linus Torvalds";
		$department2->location = "Espai";
		$department2->numberOfTeachers = 6;
		$department2->numberOfStudies = 3;

		$all_departments[] = $department1;
		$all_departments[] = $department2;

		return $all_departments;*/
	}


	function get_all_classroom_groups($orderby='asc') {
		//classroom_group
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_educationalLevelId,classroom_group_mentorId');
		$this->db->from('classroom_group');
		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$groups_array = array();
			foreach($query->result() as $row){
				$groups_array[$row->classroom_group_code] = $row->classroom_group_name;
			}
			return $groups_array;
		}	
		else
			return false;
	}

	function getGroupNamesByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name,classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		$this->db->count_all_results();
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return array($row->classroom_group_shortName,$row->classroom_group_name);
		}
		else
			return false;
	}
	
	function getGroupTotals($group_code) {
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

function getAllGroupStudentsInfo($group){

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
		$this->db->where('classroom_group.classroom_group_code',$group);
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

    function get_all_teachers() {

		$this->db->select('teacher_id, person_givenName, person_sn1, person_sn2, person_photo');
		$this->db->from('teacher');
		$this->db->join('person','teacher_person_id = person_id');
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {
		
		//$teacher = new stdClass();

		foreach ($query->result_array() as $row)	{

				$teacher = new stdClass();
				
				$teacher->teacher_id = $row['teacher_id'];
				$teacher->givenName = $row['person_givenName'];
				$teacher->sn1 = $row['person_sn1'];
				$teacher->sn2 = $row['person_sn2'];
				$teacher->photo_url = $row['person_photo'];
				
				$all_teachers[] = $teacher;

			}
			return $all_teachers;
			//print_r($all_teachers);
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
/*
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
/*
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
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_educationalLevelId,classroom_group_mentorId');
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
/*
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
*/	
}
