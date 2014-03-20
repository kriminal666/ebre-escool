<?php
/**
 * persons_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class persons_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getOrganizationalNameById($ou_id) {

    	$this->db->from('organizational_unit');
        $this->db->select('organizational_unit_name');
        $this->db->where('organizational_unit_Id',$ou_id);
	       
        $query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $row->organizational_unit_name;
		}			
		else {
			return "";
		}
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
