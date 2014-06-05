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

//Obtain all users

//Search al Accounts with jpegPhotos
$filter="(objectClass=inetOrgPerson)";
$sr=ldap_search($ds,$basedn, $filter);   

$totalUsers=ldap_count_entries($ds,$sr); 

echo "Alumnes potencials a matrícular:".$totalUsers."\n";

$info = ldap_get_entries($ds, $sr); 

echo "Data for ".$info["count"]." items returned:\n"; 

$enrolled_persons=0;

for ($i=0; $i<$info["count"]; $i++  ) { 
	
	$uid= $info[$i]["uid"][0];	
	$irispersonaluniqueid="";
	if (array_key_exists ( "irispersonaluniqueid" , $info[$i] )) {
		$irispersonaluniqueid=$info[$i]["irispersonaluniqueid"][0];	
	} 

	if (array_key_exists ( $uid , $persons )) {
		echo "i FOUND!: " . $i . "| dni:" . $irispersonaluniqueid . "| uid: " . $uid . "| database id: " . $persons[$uid]->id  . "\n"; 

		if (!mysqli_query($con,"INSERT INTO  enrollment (enrollment_periodid,enrollment_personid) VALUES ('" . $PERIOD "','" . $persons[$uid]->id .  "')")) {
			//die('Error: ' . mysqli_error($con));
			echo " ERROR! " . mysqli_error($con) . "\n";
		} else {
			$enrolled_persons++;	
			echo " ENROLLED!\n";
		}

		
	}	else {
		if ($irispersonaluniqueid != ""){ 
			if (array_key_exists ( $irispersonaluniqueid , $persons_dni )) {
				echo "i FOUND!: " . $i . "| dni:" . $irispersonaluniqueid . "| uid: " . $uid . "| database id: " . $persons_dni[$irispersonaluniqueid]->id; 
				if (!mysqli_query($con,"INSERT INTO  enrollment (enrollment_periodid,enrollment_personid) VALUES ('2010-11','" . $persons_dni[$irispersonaluniqueid]->id .  "')")) {
					//die('Error: ' . mysqli_error($con));
					echo " ERROR! " . mysqli_error($con) . "\n";

				} else {
					$enrolled_persons++;	
					echo " ENROLLED!\n";
				}
				
			}
			else {
				echo "i NOT FOUND!: " . $i . "| dni:" . $irispersonaluniqueid . "| uid: " . $uid . "\n"; 
			}
		}
	}

	//search person_id at database
	//$givenname= $info[$i]["givenname"][0];
	

	//print_r($info[$i]);


} 

echo "Alumnes matrículats:".$enrolled_persons."\n";

mysqli_close($con);

/*
$USERDN="cn=Tur AsAdmin Sergi,ou=people,ou=maninfo,ou=Personal,ou=All,dc=iesebre,dc=com";

$attrs=array();

if(class_exists('Imagick')){

	$im = new Imagick('/home/sergi/Escriptori/SergiTurGosa.jpeg');
	$im->setImageOpacity(1.0);
	//$im->resizeImage(147,200,Imagick::FILTER_UNDEFINED,0.5,TRUE);
	//$im->setCompressionQuality(90);
	$im->setImageFormat('jpeg'); 
	$attrs['jpegphoto']=$im->getImageBlob();

} else {
	echo "ERROR!";
}
$ret1=ldap_mod_add($ds,$USERDN,$attrs);	
	
if (!$ret1) {
	echo "Error at ldap_mod_add: $ret1\n";
}*/

?>