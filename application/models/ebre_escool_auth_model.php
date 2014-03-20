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
    }
    
    public function getSessionData($username) {

    	$this->db->from('users');
        $this->db->select('id,username,mainOrganizationaUnitId,email,secondary_email,users.person_id,mainOrganizationaUnitId,
        	person.person_id,person_givenName,person_sn1,person_sn2');

        // 	first_name 	last_name and others from table person: person table (person_id)	
		$this->db->join('person', 'users.person_id = person.person_id','left');

		$this->db->where('users.username',$username);
        
        $query = $this->db->get();

        $sessiondata = array();
		
		if ($query->num_rows() > 0)	{
			$row = $query->row();

			$sessiondata = array(
                   'id'  				=> $row->id,
                   'username'  			=> $row->username,
                   'email'     			=> $row->email,
                   'secondary_email'    => $row->secondary_email,
                   'person_id'   		=> $row->person_id,
                   'mainOrganizationaUnitId' => $row->mainOrganizationaUnitId,    
                   'person_id' => $row->person_id,
                   'givenName' => $row->person_givenName,
                   'sn1' => $row->person_sn1,
                   'sn2' => $row->person_sn2,
                   'fullname'  => $row->person_givenName . " " . $row->person_sn1 . " " .  $row->person_sn2,
                   'alt_fullname'  => $row->person_sn1 . " " . $row->person_sn2 . ", " . $row->person_givenName,
                   'logged_in' => TRUE
               );
		}
   		else {
			return false;
		}

    	return $sessiondata;
    }
	
	
}
