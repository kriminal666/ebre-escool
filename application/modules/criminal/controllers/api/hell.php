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
        	$this->response(NULL, 400);
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
            $this->response(array('error' => 'Teacher could not be found'), 404);
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
             $id = $this->input->get_post('id');
             $data = array(
             'person_officialid'=>$this->input->get_post('person_officialid'));
             //CALL TO MODEL
             $response = $this->teachers->updateTeacher($id,$data);
        }
        //$message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
       
        if($response){
          $message = array('id' => $id, 'message' => 'UPDATED!');
          $this->response($message, 200); // 200 being the HTTP response code
        }else{
            $message = array('id' =>$id, 'message' => 'ERROR UPDATING!');
            $this->response($message, 422); // 422 being the HTTP response code
        }
    }
 
 //Delete teacher using the id
    function teacher_delete(){
    //test if user sends the id
        if(!$this->get('id')){
        
            //Si no hay identificador se manda el código de respuesta
            $this->response(NULL, 400);
        }
        
    	$response = $this->teachers->deleteTeacher( $this->get('id') );

        if($response){
            $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
            $this->response($message, 200); // 200 being the HTTP response code
        }else{
        $message = array('id' => $this->get('id'), 'message' => 'ERROR DELETING!');
        
        $this->response($message, 422); // 422 being the HTTP response code
       } 
    }
    
    //get all teachers from data base
    function teachers_get()
    {
        //Get all teachers from teacher table
        $users = $this->teachers->getAllTeachers();
       /*$users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
		);*/
 
        if($users)
        {
            //Dont work with real database array
            $this->response($users, 200); // 200 being the HTTP response code
        }else{
           $this->response(array('error' => 'Couldn\'t find any users!'), 404);
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