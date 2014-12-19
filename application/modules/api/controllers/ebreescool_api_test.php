<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Persons API
 *
 * @package     Ebre-escool
 * @subpackage  API
 * @category    Controller
 * @author         Sergi Tur Badenas
 * @link        http://acacha.org/meidawiki/index.php/ebre-escool
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class ebreescool_api_test extends REST_Controller
{
    function __construct()
    {

        parent::__construct();

        // Load the rest client spark
        $this->load->library('curl');

        // Load the library
        $this->load->library('REST');

        // Set config options (only 'server' is required to work)

        //http://localhost/ebre-escool/index.php/api/ebreescool/person/id/1
        $config = array('server'            => 'http://localhost/ebre-escool/index.php/api/ebreescool/',
                        //'api_key'         => 'Setec_Astronomy'
                        //'api_name'        => 'X-API-KEY'
                        //'http_user'       => 'username',
                        //'http_pass'       => 'password',
                        //'http_auth'       => 'basic',
                        //'ssl_verify_peer' => TRUE,
                        //'ssl_cainfo'      => '/certs/cert.pem'
                        );

        // Run some setup
        $this->rest->initialize($config);

    }

    public function index(){
        // Pull in an array of tweets
        echo "Hola!";
        $person = $this->rest->get('person/id/1');

        echo $person;
    }
    
}