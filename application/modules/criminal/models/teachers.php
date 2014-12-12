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
          /*foreach ($data->result() as $row){
              $teachers= array(
              "person_oficcialid"=>$row->person_oficcialid,
              "teacher_creationUserId"=>$row->teacher_creationUserId,
              "teacher_entryDate"=>$row->teacher_entryDate,
              "teacher_id"=>$row->teacher_id,
              "teacher_last_update"=>$row->teacher_last_update,
              "teacher_markedForDeletionDate"=>$row->teacher_markedForDeletionDate,
              "teacher_markedFordeletionDate"=>$row->teacher_marked,
              "teacher_person_id"=>$row->teacher_person_id,
              "teacher_user_id"=>$row->teacher_user_id);*/
              

               return $data;
             
          }else{
               
          return FALSE;
          }
     }





}



?>