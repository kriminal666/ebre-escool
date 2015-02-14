<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
 //Cargar la librería 
require APPPATH.'libraries/REST_Controller.php';

class Hell extends REST_Controller
{
    //Cargar el controlador padre 
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        //limitar el numero de peticiones que hace el cliente por seguridad
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
        //Load model
        $this->load->model('teachers');
    }
  
    //get just one teacher with id
    function teacher_get()
    {
       
        //obtener el identificador que se le pasa en la url
        if(!$this->get('id'))
        {
            //Si no hay identificador se manda el código de respuesta
        	 $message = array('id'=>'','message'=>'YOU MUST SEND AN ID');
            $this->response($message, 400);
        }

        $teacher = $this->teachers->getOneTeacher( $this->get('id') );
    	/*$users = array(
			1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
			2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
		);*/
		//$user = @$users[$this->get('id')];

    	//If exists $teacher everything it's ok
        if($teacher)
        {
            $this->response($teacher, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('id' => $this->get('id'),'message' => 'TEACHER NOT EXISTS!'), 404);
        }
    }
   
    //Update teacher
    function teacher_post()
    {
        /*if(isset($_POST)){
        $message = array('id' => $this->input->get_post('id'), 'date' => $this->input->get_post('teacher_entryDate'));
        $this->response($message, 200);
        }*/
        if (isset($_POST)){
            //GET DATA FROM POST
            $postdata = file_get_contents("php://input");
            //log_message('debug',$postdata);
            $teacherObject = json_decode($postdata);

            $id = $teacherObject->{'id'};
             $data = array(
            'person_officialid'=>$teacherObject->{'DNI_NIF'},
            'teacher_creationUserid'=>$teacherObject->{'creator_id'},
            'teacher_entryDate'=>$teacherObject->{'entry_date'},
            'teacher_lastupdateUserId'=>$teacherObject->{'last_update_user_id'},
            'teacher_markedForDeletion'=>$teacherObject->{'marked_for_deletion'},
            'teacher_markedForDeletionDate'=>$teacherObject->{'marked_for_deletion_date'},
            'teacher_person_id'=>$teacherObject->{'person_id'},
            'teacher_user_id'=>$teacherObject->{'user_id'});
            //log_message('debug',"array ".var_dump($array));
             /*log_message('debug', $id);
             log_message('debug', $data['person_officialid']);
             log_message('debug', $data['teacher_creationUserid']);
             log_message('debug', $data['teacher_entryDate']);
             log_message('debug', $data['teacher_last_update']);
             log_message('debug', $data['teacher_markedForDeletion']);
             log_message('debug', $data['teacher_markedForDeletionDate']);
             log_message('debug', $data['teacher_person_id']);
             log_message('debug', $data['teacher_user_id']);*/

             
             //$data = array(
             //'person_officialid'=>$this->input->get_post('person_officialid'));
             //CALL TO MODEL
             $response = $this->teachers->updateTeacher($id,$data);
        }
        //$message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
       
        if($response){
          $message = array('id' => $id, 'message' => 'UPDATED!');
          $this->response($message, 200); // 200 being the HTTP response code
        }else{
            $message = array('id' =>$id, 'message' => 'ERROR UPDATING!');
            $this->response($message, 404); // 404 being the HTTP response code(Not Found)
        }
    }
 
 //Delete teacher using the id
    function teacher_delete(){
    //test if user sends the id
        if(!$this->get('id')){
        
            //Si no hay identificador se manda el código de respuesta
            $message = array('id'=>'','message'=>'YOU MUST SEND AN ID');
            $this->response($message, 400);
        }
        log_message('debug',"delete id: ".$this->get('id'));
        
    	$response = $this->teachers->deleteTeacher( $this->get('id') );
       
       if($response){
            $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
            $this->response($message, 200); // 200 being the HTTP response code
        }else{
        $message = array('id' => $this->get('id'), 'message' => 'ERROR DELETING!');
        
        $this->response($message, 404); // 400 being the HTTP response code(Not Found)
       }
    }
    
    //get all teachers from data base
    function teachers_get(){
        //Get all teachers from teacher table
        $teachers = $this->teachers->getAllTeachers();
       /*$users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
		);*/
 
        if($teachers)
        {
            //Don't work with real database array
            $this->response($teachers, 200); // 200 being the HTTP response code
        }else{
           $this->response(array('id' => $this->get('id'),'message' => 'Couldn\'t find any teachers!'), 404);
        }
    }

    //Insert teacher
    function teacher_put(){
   
        //Get the array we send from RestClient
        $data = array(
            'person_officialid'=>$this->put('DNI_NIF'),
            'teacher_creationUserid'=>$this->put('creator_id'),
            'teacher_entryDate'=>$this->put('entry_date'),
            'teacher_lastupdateUserId'=>$this->put('last_update_user_id'),
            'teacher_markedForDeletion'=>$this->put('marked_for_deletion'),
            'teacher_markedForDeletionDate'=>$this->put('marked_for_deletion_date'),
            'teacher_person_id'=>$this->put('person_id'),
            'teacher_user_id'=>$this->put('user_id'));

             /*log_message('debug', $data['person_officialid']);
             log_message('debug', $data['teacher_creationUserid']);
             log_message('debug', $data['teacher_entryDate']);
             log_message('debug', $data['teacher_markedForDeletion']);
             log_message('debug', $data['teacher_markedForDeletionDate']);
             log_message('debug', $data['teacher_person_id']);
             log_message('debug', $data['teacher_user_id']);*/
         //Call inset method in model
         $insertResponse = $this->teachers->insertTeacher($data);
         //echo $insertResponse['response']." ".$insertResponse['id'];
         
         //Response
         if($insertResponse['response']){
            $message = array('id' => $insertResponse['id'],'message' => 'NEW TEACHER INSERTED');
            $this->response($message,200);//200 being the HTTP response code

         }else{
            $message = array('id' => $insertResponse['id'], 'message' => 'ERROR INSERTING');
            $this->response($message, 422); // 422 being the HTTP response code
         }

        
    }

    
	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}