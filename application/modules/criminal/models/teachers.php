<?php
/**
 * 
 *
 *
 * @package    	Ebre-escool
 * @author     	Criminal
 * @version    	1.0
 * @link		crimiwiki.esy.es
 */
class Teachers  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

//GET ALL TEACHERS
function getAllTeachers() {
          $data = $this->db->get('teacher');
          $teachers = array();
          if ($data->num_rows() > 0) {

               return $data;
             
          }else{
               
          return FALSE;
          }
     }
     //Get just one teacher by id
     function getOneTeacher($id){
       $this->db->where('teacher_id',$id);
       $data = $this->db->get('teacher');
       //Test if we have row
       if ($data->num_rows() > 0){
        return $data;
      }else{
        return false;
      }
    }
    /*
         function deleteTeacher($del) {
      if ($del) {
          $this->db->where('name',$del);
          $this->db->delete('users');
          echo "usuario borrado";
      }else{
          echo "usuario no existe";
      }
      }*/



}






?>