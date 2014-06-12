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
class enrollment_model  extends CI_Model  {
	
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

	/* Enrollment Wizard */

	/* Alumnes */
	public function get_students($orderby="asc") {

        $this->db->select('person_id,person_givenName,person_sn1,person_sn2,person_official_id');
		$this->db->from('person');
		$this->db->order_by('person_official_id', $orderby);
		       
        $query = $this->db->get();

		if ($query->num_rows() > 0) {

			$student_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
				if ($row['person_official_id'] == "") {
					continue;
				}
   				$student_array[$i]['student_name'] = $row['person_givenName'];
   				$student_array[$i]['student_surname1'] = $row['person_sn1'];
   				$student_array[$i]['student_surname2'] = $row['person_sn2'];
   				$student_array[$i]['student_fullName'] = $row['person_givenName'] .' '.$row['person_sn1'].' '.$row['person_sn2'] ;
   				$student_array[$i]['student_person_id'] = $row['person_id'];
   				$student_array[$i]['person_official_id'] = $row['person_official_id'];
   				$i++;
			}
			return $student_array;
		}			
		else
			return false;
	}	

	public function get_student_by_username($username, $orderby="asc") {

        $this->db->select('username');
		$this->db->from('person');
		$this->db->where('username',$username);
		       
        $query = $this->db->get();
        //echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			return true;
		}			
		else
			return false;
	}

	public function get_all_person_official_ids($orderby = "ASC") {

		/*
		SELECT `person_official_id` FROM `person` WHERE 1
		*/

        $this->db->select('person_official_id');
		$this->db->from('person');
		$this->db->order_by('person_official_id', $orderby);
		       
        $query = $this->db->get();
		$this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$person_official_ids = array();
			foreach ($query->result_array() as $row)	{
				if ($row['person_official_id']!="")
   					$person_official_ids[] = trim($row['person_official_id']);
   			}
			return $person_official_ids;
		}			
		else
			return false;
	}


	/* Studies */
	public function get_enrollment_studies($orderby="asc") {

        $this->db->select('studies_id,studies_shortname,studies_name');
		$this->db->from('studies');
		$this->db->order_by('studies_id', $orderby);
		       
        $query = $this->db->get();
		$this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$studies_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$studies_array[$i]['studies_id'] = $row['studies_id'];
   				$studies_array[$i]['studies_shortname'] = $row['studies_shortname'];
   				$studies_array[$i]['studies_name'] = $row['studies_name'];
   				$i++;
			}
			return $studies_array;
		}			
		else
			return false;
	}	

	/* Cursos */
	public function get_enrollment_courses($study=false,$orderby="asc") {

		if(!$study){
			$study=2;	//	"ASIX-DAM"
		}

		$this->db->select('course_id, course_shortname, course_name');
		$this->db->from('course');
		$this->db->join('studies','course_study_id=studies_id');
		$this->db->where('studies_id',$study);
		
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$courses_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$courses_array[$i]['course_id'] = $row['course_id'];
   				$courses_array[$i]['course_name'] = $row['course_name'];
   				$courses_array[$i]['course_shortname'] = $row['course_shortname'];
   				$i++;
			}
			return $courses_array;
		}			
		else
			return false;
	}	

	/* Grups de classe */
	public function get_enrollment_classroom_groups($study=false,$course_id=false,$orderby="asc") {

		if(!$study){
			$study=2;	//	"ASIX-DAM"
		}

		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,course_shortname,course_name,studies_shortname,studies_name');
		$this->db->from('classroom_group');
		$this->db->join('course','classroom_group_course_id=course_id');
		$this->db->join('studies','course_study_id=studies_id');
		$this->db->where('studies_id',$study);
		$this->db->where('course_id',$course_id);
		$this->db->order_by('classroom_group_id', $orderby);
		
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$classroom_group_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$classroom_group_array[$i]['classroom_group_id'] = $row['classroom_group_id'];
   				$classroom_group_array[$i]['classroom_group_code'] = $row['classroom_group_code'];
   				$classroom_group_array[$i]['classroom_group_shortName'] = $row['classroom_group_shortName'];
   				$classroom_group_array[$i]['classroom_group_name'] = $row['classroom_group_name'];
   				$i++;
			}
			return $classroom_group_array;
		}			
		else
			return false;
	}	

	/* Classroom Groups Names from Classroom Groups ID */
	public function get_enrollment_classroom_groups_from_id($groups_id,$orderby="asc") {

		$this->db->select('classroom_group_code,classroom_group_shortName,classroom_group_name');
		$this->db->from('classroom_group');
		$this->db->where_in('classroom_group_id',$groups_id);
		$this->db->order_by('classroom_group_id', $orderby);
		
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$classroom_group_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$classroom_group_array[$i]['classroom_group_code'] = $row['classroom_group_code'];
   				$classroom_group_array[$i]['classroom_group_shortName'] = $row['classroom_group_shortName'];
   				$classroom_group_array[$i]['classroom_group_name'] = $row['classroom_group_name'];
   				$i++;
			}
			return $classroom_group_array;
		}			
		else
			return false;
	}	


	/* Mòduls */
	public function get_enrollment_study_modules($courses=false,$course_id=false,$orderby="asc",$order_field = "") {
		
		if(!$courses){
			//$course_id=3;	//	"1ASIX-DAM"
		}		
		//echo $course_id."<br />";
        $this->db->select('study_module_id,study_module_shortname,study_module_name,study_module_courseid,course.course_shortname,course.course_name');
		$this->db->from('study_module');
		$this->db->join('course','course.course_id = study_module.study_module_courseid');
		$this->db->where_in('course.course_id', $courses);
		$this->db->order_by('course.course_id', $orderby);
		if ($order_field != "") {
			if ($order_field == "order") {
				$this->db->order_by('study_module_order', $orderby);
			}
		} else {
			$this->db->order_by('study_module_shortname', $orderby);	
		}
		
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$study_module_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$study_module_array[$i]['study_module_id'] = $row['study_module_id'];
   				$study_module_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
   				$study_module_array[$i]['study_module_name'] = $row['study_module_name'];
   				$study_module_array[$i]['study_module_courseid'] = $row['study_module_courseid'];
   				$study_module_array[$i]['course_shortname'] = $row['course_shortname'];
   				$study_module_array[$i]['course_name'] = $row['course_name'];
   				
   				if($row['study_module_courseid'] == $course_id){
   					$study_module_array[$i]['selected_course'] = 'yes';
   				} else {
					$study_module_array[$i]['selected_course'] = 'no';
   				}

   				$i++;
			}
			return $study_module_array;
		}			
		else
			return false;
	}	

	/* Unitats formatives */
	public function get_enrollment_study_submodules($study_modules=false,$classroom_group=false,$orderby="asc",$order_field="") {

		if(!$study_modules){
			//$study_modules[]=282;	//	"M1"
			//$study_modules[]=268;	//	"M2"
		}	

        $this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_module_shortname,study_module_order,study_submodules_study_module_id,classroom_group_code');
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_submodules_study_module_id=study_module_id');
		$this->db->join('course','course.course_id = study_module.study_module_courseid');
		$this->db->join('classroom_group','classroom_group.classroom_group_course_id=course.course_id');
		$this->db->where_in('study_submodules_study_module_id',$study_modules);
		if ( $order_field != "") {
			if ( $order_field == "order") {
				$this->db->order_by('study_module_order', $orderby);
				$this->db->order_by('study_submodules_order', $orderby);				
			}
		} else {
			$this->db->order_by ('study_submodules_id', $orderby);
		}

		
		       
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$study_submodules_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
				$study_submodules_array[$i]['study_module_classroom_group_code'] = $row['classroom_group_code'];
				$study_submodules_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
   				$study_submodules_array[$i]['study_submodules_id'] = $row['study_submodules_id'];
   				$study_submodules_array[$i]['study_submodules_shortname'] = $row['study_submodules_shortname'];
   				$study_submodules_array[$i]['study_submodules_name'] = $row['study_submodules_name'];
   				$study_submodules_array[$i]['study_submodules_study_module_id'] = $row['study_submodules_study_module_id'];   				
   				$i++;
			}
			return $study_submodules_array;
		}			
		else
			return false;
	}	

	/* Student Data */
	public function get_student_data($official_id) {
        $this->db->select('person_id, person_photo, person_secondary_official_id, person_givenName, person_sn1, person_sn2, person_email, person_date_of_birth, person_gender, person_homePostalAddress, person_locality_name, person_telephoneNumber, person_mobile, username');
		$this->db->from('person');
		$this->db->where('person_official_id',$official_id);
		$this->db->limit(1);		       
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			return $query->row();
		}			
		else
			return false;
	}	

	/* Update Student Data */
	public function update_student_data($person_id,$student) {


        $this->db->where('person_id', $person_id);
		$this->db->update('person', $student); 
		echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {

			return true;
		}			
		else
			return false;
	}	

	/* Insert Student Data */
	public function insert_student_data($student) {


        $this->db->insert('person', $student); 
		//echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {

			return true;
		}			
		else
			return false;
	}	

	/* ENROLLMENT */

	/* Enrollment */
	public function insert_enrollment($period_id=false,$person_id=false) {

        $data = array(
        	'enrollment_periodid' => $period_id,
        	'enrollment_personid' => $person_id 
        );

        $this->db->insert('enrollment',$data);
		       
		echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	

	/* Enrollment Studies */
	public function insert_enrollment_studies($period_id=false,$person_id=false,$study_id=false) {

        $data = array(
        	'enrollment_studies_periodid' => $period_id,
        	'enrollment_studies_personid' => $person_id,
        	'enrollment_studies_study_id' => $study_id
        );

        $this->db->insert('enrollment_studies',$data);
		       
		echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	

	/* Enrollment Classroom Group */
	public function insert_enrollment_class_group($period_id=false,$person_id=false,$study_id=false,$class_group_id=false) {

        $data = array(
        	'enrollment_class_group_periodid' => $period_id,
        	'enrollment_class_group_personid' => $person_id,
        	'enrollment_class_group_study_id' => $study_id,
        	'enrollment_class_group_group_id' => $class_group_id
        );

        $this->db->insert('enrollment_class_group',$data);
		       
		echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	

	/* Enrollment Modules */
	public function insert_enrollment_modules($period_id=false,$person_id=false,$study_id=false,$class_group_id=false,$modules_id=false) {

	$affected_rows = 0;

		foreach($modules_id as $module){

        	$data = array(
        		'enrollment_modules_periodid' => $period_id,
        		'enrollment_modules_personid' => $person_id,
        		'enrollment_modules_study_id' => $study_id,
        		'enrollment_modules_group_id' => $class_group_id,
        		'enrollment_modules_moduleid' => $module
        	);

        $this->db->insert('enrollment_modules',$data);
		
        $affected_rows += $this->db->affected_rows();

		}       
		//echo $this->db->last_query();
		return $affected_rows;
		//if ($this->db->affected_rows() > 0) {

		//	return $this->db->affected_rows();
		//}			
		//else
		//	return false;
	}	

	/* Enrollment Submodules */
	public function insert_enrollment_submodules($period_id=false,$person_id=false,$study_id=false,$class_group_id=false,$modules_id=false,$submodules_id=false) {

	$modules = array();
	$submodules = array();

	$affected_rows = 0;

	foreach($submodules_id as $elements){

		$submodules_id = explode('#',$elements);

		//$modules[] = $submodules_id[0];
		//$submodules[] = $submodules_id[1];

	    $data = array(
        	'enrollment_submodules_periodid' => $period_id,
        	'enrollment_submodules_personid' => $person_id,
        	'enrollment_submodules_study_id' => $study_id,
        	'enrollment_submodules_group_id' => $class_group_id,
        	'enrollment_submodules_moduleid' => $submodules_id[0],
        	'enrollment_submodules_submoduleid' => $submodules_id[1]
        );

        $this->db->insert('enrollment_submodules',$data);
		       
		//echo $this->db->last_query();
		$affected_rows += $this->db->affected_rows();

	}

}
}