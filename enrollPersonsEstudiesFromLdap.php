<?php

/*
PREREQUISITES:
Set basedn to base correct base dn period enrollment. P.e.  
 Uncomment temporarily in first line of file /usr/share/ebre-escool/application/config/auth_ldap.php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 Uncomment the same at file /usr/share/ebre-escool/application/config/database.php
*/

#IMPORTANT: no poseu les paraules de pas a aquest fitxer:
include "/usr/share/ebre-escool/application/config/auth_ldap.php";
include "/usr/share/ebre-escool/application/config/database.php";

$PERIOD="2010-11";

//DATABASE:

$con=mysqli_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM person");

$persons = array();
$persons_dni = array();
while($row = mysqli_fetch_array($result)) {
	$person = new stdClass;
	$person->id = $row['person_id'];

	$persons[$row['username']] = $person;
	$persons_dni[$row['person_official_id']] = $person;
  
}

//print_r($persons);

//LDAP
$ldapconfig['host'] = $config['hosts'][0];
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = NULL;
$ldapconfig['basedn'] = $config['basedn'];

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=$config['proxy_pass'];
$dn=$config['proxy_user'];

$basedn="ou=Alumnes,ou=All,ou=201011,dc=iesebre,dc=com";

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct\n");
} else {
  # Error
}

//Obtain all studies from Ldap

$result = mysqli_query($con,"SELECT * FROM studies");


$studies = array();

$enrolled_persons=0;

while($row = mysqli_fetch_array($result)) {

	$study = new stdClass;
	$study->id = $row['studies_id'];
	$study->shortname = $row['studies_shortname'];
	$studies[$study->shortname] = $study;
	
	//Search al Accounts with jpegPhotos
	$filter="(destinationIndicator=" . $study->shortname . ")";
	
	echo "Searching Study: " . $study->shortname . " " . $filter . " ";

	$sr=ldap_search($ds,$basedn, $filter);   

	$totalStudiesFound=ldap_count_entries($ds,$sr); 

	if ($totalStudiesFound != 1) {
		echo "Error: $totalStudiesFound found entries!\n";
		continue;
	}

	$info = ldap_get_entries($ds, $sr); 
	$dn = $info[0]["dn"];
	echo "FOUND! dn: " . $dn . "\n";

	echo " Searching students.... ";

	//Search al Accounts with jpegPhotos
	$filter="(objectClass=inetOrgperson)";
	$sr=ldap_search($ds,$dn,$filter); 

	$totalStudentsFound=ldap_count_entries($ds,$sr); 

	echo " found $totalStudentsFound\n";

	if ($totalStudentsFound > 0) {
		$info = ldap_get_entries($ds, $sr);
		for ($i=0; $i<$info["count"]; $i++  ) { 

			//print_r($info[$i]);
			
			$uid= $info[$i]["uid"][0];	

			$irispersonaluniqueid="";
			if (array_key_exists ( "irispersonaluniqueid" , $info[$i] )) {
				$irispersonaluniqueid=$info[$i]["irispersonaluniqueid"][0];	
			} 


			if (array_key_exists ( $uid , $persons )) {
				echo " i FOUND!: " . $i . "| dni:" . $irispersonaluniqueid . "| uid: " . $uid . "| database id: " . $persons[$uid]->id  . "\n"; 

				if (!mysqli_query($con,"INSERT INTO enrollment_studies (enrollment_studies_periodid,enrollment_studies_personid,enrollment_studies_study_id) VALUES ('" . $PERIOD . "','" . $persons[$uid]->id .  "','" . $study->id ."')")) {
					//die('Error: ' . mysqli_error($con));
					echo " ERROR! " . mysqli_error($con) . "\n";
				} else {
					$enrolled_persons++;	
					echo " ENROLLED!\n";
				}

			
			}	else {
				if ($irispersonaluniqueid != ""){ 
					if (array_key_exists ( $irispersonaluniqueid , $persons_dni )) {
						echo " i FOUND!: " . $i . "| dni:" . $irispersonaluniqueid . "| uid: " . $uid . "| database id: " . $persons_dni[$irispersonaluniqueid]->id; 
						if (!mysqli_query($con,"INSERT INTO  enrollment_studies (enrollment_studies_periodid,enrollment_studies_personid,enrollment_studies_study_id) VALUES ('" . $PERIOD . "','" . $persons_dni[$irispersonaluniqueid]->id . "','". $study->id ."')")) {
							//die('Error: ' . mysqli_error($con));
							echo " ERROR! " . mysqli_error($con) . "\n";

						} else {
							$enrolled_persons++;	
							echo " ENROLLED!\n";
						}
						
					}
					else {
						echo " i NOT FOUND!: " . $i . "| dni:" . $irispersonaluniqueid . "| uid: " . $uid . "\n"; 
					}
				}
			}	










		}

	} else {
		echo "Error: $totalStudentsFound found entries!\n";
		continue;
	}

}


mysqli_close($con);


?>