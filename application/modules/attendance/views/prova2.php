<?php
if($_POST['is_ajax']=='true') {
	$resultat= 
		array(
			'element1' => 'valor1',
			'element2' => 'valor2',
			'element3' => 'valor3'
		);
	echo json_encode($resultat);
} else {
	echo "Error";
}
?>
