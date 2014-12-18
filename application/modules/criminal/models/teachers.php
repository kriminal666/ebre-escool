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
    //Delete teacher using id
    function deleteTeacher($data) {
      if ($data) {
          $this->db->where('teacher_id',$data);
          $this->db->delete('teacher');
          return true;
      }else{
          return false;
      }
      }
        //update teacher
      function updateTeacher($data){
          if ($data['teacher_id']){
            $this->db->where('teacher_id',$data['teacher_id']);
            $this->db->update('teacher',$data);
            return true;
          }else{
            return false;
          }

      }

       function insertTeacher($data){
          if ($data['teacher_id']){
          $this->db->insert('teacher',$data);
          return true;
          } else{
            return false;
          }   
      }



}






?>