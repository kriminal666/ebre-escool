<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class HellClient extends skeleton_main {

	//URL's
	public $getTeacher_Url = 'criminal/api/hell/teacher/';
	public $getAllTeacher_Url = 'criminal/api/hell/teachers/';


	function __construct()
    {
        parent::__construct();
        $this->load->library('rest', array(
           'server' => 'http://localhost/ebre-escool/index.php/'));
        //We can add:
        // 'http_user' => 'admin',
        // 'http_pass' => '1234',
        // 'http_auth' => 'basic' // or 'digest'
        // Load the rest client spark
        $this->load->library('curl');
    }

    

     //Get one or all teacher 
     function getTeacher($id = null){
     	//If not null get just one teacher by 'id'
     	if ($id != null){
            // We call the function teacher_get of hell controller
     		$this->rest->get('criminal/api/hell/teacher',array('id' => $id));

     	}else{
     		//we want to get all teachers from database
     		$this->rest->get($getAllTeacher_Url,null);
     	}

     }
 }

 ?>
        
        
        
