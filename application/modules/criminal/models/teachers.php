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
          $teachers = arrayObject();
          if ($data->num_rows() > 0) {
          foreach ($data->result() as $row){
              $aux= array(
              "personoficcialid"=>$row->person_officialid,
              "teachercreationuserid"=>$row->teacher_creationUserId,
              "teacherentrydate"=>$row->teacher_entryDate,
              "teacherid"=>$row->teacher_id,
              "teacherlastupdateuserid"=>$row->teacher_lastupdateUserId,
              "teacherlastupdate"=>$row->teacher_last_update,
              "teachermarkedfordeletion"=>$row->teacher_markedForDeletion,
              "teachermarkedfordeletiondate"=>$row->teacher_markedForDeletionDate,
              "teacherpersonid"=>$row->teacher_person_id,
              "teacheruserid"=>$row->teacher_user_id);

              array_push($teachers,$aux);
            }

               return $teachers;
             
          }else{
               
          return FALSE;
          }
     }





}



?>