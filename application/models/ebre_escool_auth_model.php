<?php
/**
 * ebre_escool_auth_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class ebre_escool_auth_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->library('ebre_escool');
    }

    function is_user_a_student ($person_id) {

      //STUDENTS ARE ENROLLED USER IN ANY ACADEMIC PERIOD
      //SELECT `enrollment_id` FROM `enrollment` WHERE `enrollment_personid` = 4270

      $this->db->select('enrollment_id');
      $this->db->from('enrollment');
      $this->db->where('enrollment.enrollment_personid',$person_id);

      $query = $this->db->get();

      if ($query->num_rows() > 0) {
        return true;
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

    public function is_set_force_change_password ($username) {
      /*
      SELECT `force_change_password_next_login`
      FROM `users`
      WHERE `username` = "sergitur"
      */

      $this->db->select('force_change_password_next_login');
      $this->db->from('users');      
      $this->db->where('users.username',$username);
      $this->db->limit(1);
       
      $query = $this->db->get();

      //echo $this->db->last_query()."<br/>";
    
      if ($query->num_rows() == 1) {
        $row = $query->row();
        $force_change_password_next_login = $row->force_change_password_next_login;
        if ( $force_change_password_next_login  == 'y') {
          return true;
        }
      }

      return false;
    }
  
    public function getSessionData($username) {

    	$this->db->from('users');
      $this->db->select('id,users.username,mainOrganizationaUnitId,person_email,person_secondary_email,person.person_terciary_email ,users.person_id,mainOrganizationaUnitId,
        	person.person_id,person_givenName,person_sn1,person_sn2,person_photo,person.person_official_id,person.person_official_id_type,person.person_date_of_birth,person.person_gender,
          person.person_secondary_official_id,person.person_secondary_official_id_type,person.person_homePostalAddress,person.person_locality_id,person.person_telephoneNumber,person.person_mobile,
          person.person_notes,locality.locality_name,person.person_entryDate,teacher.teacher_id,teacher.teacher_code,teacher.teacher_department_id,department.department_shortname');

      // 	first_name 	last_name and others from table person: person table (person_id)	
		  $this->db->join('person', 'users.person_id = person.person_id','left');
      $this->db->join('locality', 'person.person_locality_id = locality.locality_id','left');
      $this->db->join('teacher', 'person.person_id = teacher.teacher_person_id','left');
      $this->db->join('department', 'teacher.teacher_department_id = department.department_id','left');

		  $this->db->where('users.username',$username);
       
      $query = $this->db->get();

      //echo $this->db->last_query()."<br/>";

      $sessiondata = array();
		
		if ($query->num_rows() > 0)	{
			$row = $query->row();

			$sessiondata = array(
                   'id'  				=> $row->id,
                   'username'  			=> $row->username,
                   'email'     			=> $row->person_email,
                   'secondary_email'    => $row->person_secondary_email ,
                   'terciary_email'    => $row->person_terciary_email,
                   'person_id'   		=> $row->person_id,
                   'mainOrganizationaUnitId' => $row->mainOrganizationaUnitId,    
                   'person_id' => $row->person_id,
                   'givenName' => $row->person_givenName,
                   'sn1' => $row->person_sn1,
                   'sn2' => $row->person_sn2,
                   'fullname'  => $row->person_givenName . " " . $row->person_sn1 . " " .  $row->person_sn2,
                   'alt_fullname'  => $row->person_sn1 . " " . $row->person_sn2 . ", " . $row->person_givenName,
                   'person_official_id' => $row->person_official_id,
                   'person_official_id_type' => $row->person_official_id_type,
                   'person_date_of_birth' => $row->person_date_of_birth,
                   'person_gender' => $row->person_gender,
                   'person_secondary_official_id' => $row->person_secondary_official_id,
                   'person_secondary_official_id_type' => $row->person_secondary_official_id_type ,
                   'person_homePostalAddress' => $row->person_homePostalAddress,
                   'person_locality_id' => $row->person_locality_id,
                   'locality_name' => $row->locality_name,
                   'person_entryDate' => $row->person_entryDate,                                      
                   'person_telephoneNumber' => $row->person_telephoneNumber,
                   'person_mobile' => $row->person_mobile,
                   'person_notes' => $row->person_notes,
                   'photo'  => $row->person_photo,
                   'logged_in' => TRUE,
                   'is_admin' => $this->ebre_escool->user_is_admin(),
                   'is_teacher' => $this->is_user_a_teacher($row->person_id),
                   'is_student' => $this->is_user_a_student($row->person_id),
                   'teacher_code' => $row->teacher_code,
                   'teacher_id' => $row->teacher_id,
                   'teacher_department_id' => $row->teacher_department_id,
                   'department_shortname' => $row->department_shortname,
                   
               );
		}
   		else {
			return false;
		}

    	return $sessiondata;
    }
	
	
}
