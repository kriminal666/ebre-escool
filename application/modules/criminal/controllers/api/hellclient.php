<?php defined('BASEPATH') OR exit('No direct script access allowed');


class HellClient extends CI_Controller{


	function __construct()
    {
       parent::__construct();
        $this->load->library('Rest');
        $config = array('server' =>'http://localhost/ebre-escool/index.php/');
        $this->rest->initialize($config);
    
        //We can add:
        // 'http_user' => 'admin',
        // 'http_pass' => '1234',
        // 'http_auth' => 'basic' // or 'digest'
        // Load the rest client spark
        $this->load->library('Curl');
    }

    

     //Get one or all teacher 
     function getTeacher($id = null){
        
       
       $getTeacher_Url = 'criminal/api/hell/teacher/id/';
       $getAllTeacher_Url = 'criminal/api/hell/teachers/';

     	//If not null get just one teacher by 'id'
     	if($id!=null){
            // We call the function teacher_get of hell controller
     		$teacher = $this->rest->get($getTeacher_Url,array('id'=>$id));
        }else{
            //we want to get all teachers from database
     		$teacher = $this->rest->get($getAllTeacher_Url,null);
        }
        echo json_encode($teacher);
    }

    function updateTeacher(){
            $updateTeacher_Url = 'criminal/api/hell/teacher/';
            //EXAMPLE UPDATE WITHOUT FORM
             $id = 41;
             $column = 'person_officialid';
             $officialId = '66666666L';
             $data = array(
                'id'=>$id,
                 $column=>$officialId);
             
             $updateResponse = $this->rest->post($updateTeacher_Url,$data);
             echo json_encode($updateResponse);
  }


 }

 ?>
        
        
        
