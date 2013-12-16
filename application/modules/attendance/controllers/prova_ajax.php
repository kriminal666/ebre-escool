<?php 
	//require('/usr/share/ebre-escool/application/models/attendance_model.php');
	include('/usr/share/ebre-escool/application/third_party/skeleton/application/controllers/skeleton_main.php');
class prova_ajax extends skeleton_main {

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('attendance_model');
	}

	public function index(){

		if($_POST['is_ajax']=='true') {
			$prova = suma(7,3);
				
			$resultat= 
				array(
					'element1' => 'valor1',
					'element2' => 'valor2',
					'element3' => 'valor3',
					'element4' => $prova
				);
				echo json_encode($resultat);

		} else {
			echo "Error";
		}
	}

	function suma($a, $b) {
		return ($a+$b);
	}

	public function consulta(){

		$query = $this->db->get('course');
		$resultat = array();

		foreach ($query->result() as $row)
		{
		    $resultat[] = $row->course_shortname;
		}
		print_r(json_encode($resultat));
	}
}

?>