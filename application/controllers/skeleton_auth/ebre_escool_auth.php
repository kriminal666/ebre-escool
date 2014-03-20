<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once "application/third_party/skeleton/application/controllers/skeleton_auth/auth.php";

class ebre_escool_auth extends Auth {

    public $login_page = "skeleton_auth/ebre_escool_auth/login";

	function __construct()
    {
		parent::__construct();

        $this->load->model('ebre_escool_auth_model');
	}
	

    //log the user in
    function login()
    {
        parent::login();
    }

    //VOID: implement it on child classes
    public function on_exit_login_hook($username="") {

        //TODO: define default session data?
        $default_sessiondata = array(
                   'username'  => 'sergitur',
                   'email'     => 'sergitur@ebretic.com',
                   'logged_in' => TRUE
               );

        if ($username == "") { 
            $sessiondata = $default_sessiondata;
        }   else {
            $sessiondata = $this->ebre_escool_auth_model->getSessionData($username);    
        }
        
        //Set session data:
        $this->session->set_userdata($sessiondata);
        
        return null;
    }

}