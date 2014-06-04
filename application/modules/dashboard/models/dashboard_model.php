<?php
/**
 * dashboard_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class dashboard_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getPersonsStatistics() {

    	$person_statistics = array();

    	//All persons
    	$this->db->from('person');
        //$this->db->select('organizational_unit_name');
        //$this->db->where('organizational_unit_Id',$ou_id);
	       
        $query = $this->db->get();

        $person_statistics['total_number_of_persons'] = $query->num_rows();
		
		//All persons without person_official_id (DNI p.ex.) duplciates!
		$this->db->from('person');
		$this->db->select('person_official_id');
        $this->db->distinct();
        	       
        $query = $this->db->get();

        $person_statistics['total_number_of_distinct_persons'] = $query->num_rows();

        $person_statistics['total_number_of_duplicated_persons'] = $person_statistics['total_number_of_persons'] - $person_statistics['total_number_of_distinct_persons'];

        $duplicated_person_ids = array();

        //Get Duplicated ids
		/*
        SELECT `person_official_id` 
		FROM person
		GROUP BY `person_official_id`
		HAVING count( * ) >1
		*/

		//All persons without person_official_id (DNI p.ex.) duplicates!
		$this->db->from('person');
		$this->db->select('person_official_id');
        $this->db->group_by("person_official_id"); 
        $this->db->having('count( * ) > 1'); 
        	       
        $query = $this->db->get();
        $duplicated_person_ids = array();

        if ($query->num_rows() > 0)	{
   			foreach ($query->result() as $row)	{
      			$duplicated_person_ids[] = $row->person_official_id;
   			}
		} 	

        $person_statistics['duplicated_person_ids'] = $duplicated_person_ids;

        /*
        /* SELECT `person_gender`,count(`person_id`) FROM `person` GROUP BY  `person_gender` 
        /* 
        */

        $this->db->from('person');
        $this->db->select('person_gender,count(person_id) as total');
        $this->db->group_by("person_gender"); 
                   
        $query = $this->db->get();

        $male_persons = 0;
        $female_persons = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                if ($row->person_gender == "M")
                    $male_persons = $row->total;
                if ($row->person_gender == "F")
                    $female_persons  = $row->total;
            }
        }   

        $person_statistics['male_persons'] = $male_persons;
        $person_statistics['female_persons'] = $female_persons;
        $person_statistics['not_gender_defined_persons'] = $person_statistics['total_number_of_persons'] - $female_persons - $male_persons;

        //emails
        //SELECT `person_email`,count(`person_id`) as total FROM `person` GROUP BY  `person_email`HAVING total > 1 ORDER BY total DESC 

        $this->db->from('person');
        $this->db->select('person_email,count(person_id) as total');
        $this->db->group_by("person_email"); 
        $this->db->having('total > 1'); 
                   
        $query = $this->db->get();

        $male_persons = 0;
        $female_persons = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                if ($row->person_email == "") {
                    $undefined_emails = $row->total;
                }
            }
        }   

        $person_statistics['undefined_emails'] = $undefined_emails;
        $person_statistics['duplicated_emails'] = $query->num_rows() -1;

        //PHOTOS
        $person_statistics['without_photo_persons'] = 89;

		return $person_statistics;
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

	
	
}
