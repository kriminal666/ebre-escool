<?php
/**
 * Reports_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class teachers_model  extends CI_Model  {
	
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

    function get_all_teachers() {

		$this->db->select('teacher_id,teacher_code,teacher_charge_short, teacher_charge_full, person_givenName, person_sn1, person_sn2, person_photo,teacher_charge_sheet_line1,
						teacher_charge_sheet_line2,teacher_charge_sheet_line3,teacher_charge_sheet_line4');
		$this->db->from('teacher');
		$this->db->join('person','teacher_person_id = person_id');
		$this->db->order_by("teacher_code", "asc"); 
		$query = $this->db->get();

		//echo $this->db->last_query()."<br/>";
		
		if ($query->num_rows() > 0) {
		
		//$teacher = new stdClass();

		foreach ($query->result_array() as $row)	{

				$teacher = new stdClass();
				
				$teacher->teacher_id = $row['teacher_id'];
				$teacher->teacher_code = $row['teacher_code'];
				$teacher->teacher_charge_short = $row['teacher_charge_short'];
				$teacher->teacher_charge_full = $row['teacher_charge_full'];		
				$teacher->teacher_charge_sheet_line1 = $row['teacher_charge_sheet_line1'];
				$teacher->teacher_charge_sheet_line2 = $row['teacher_charge_sheet_line2'];
				$teacher->teacher_charge_sheet_line3 = $row['teacher_charge_sheet_line3'];
				$teacher->teacher_charge_sheet_line4 = $row['teacher_charge_sheet_line4'];
										
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

}
