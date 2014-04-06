PERSONS TO USERS
----------------

- Afegeixo un camp temporal username a la taula persons. Camp username VARCHAR 255
- Escollir el username a partir del correu electrònic: SELECT left(`person_secondary_email`,locate('@',`person_secondary_email`)-1) FROM `person`
- Actualitzar: UPDATE `person` SET `username` = left(`person_secondary_email`,locate('@',`person_secondary_email`)-1)

Ara per afegir usuaris a la base de dades:

SELECT `person_id` , `username` , '9f593445ded75866e06045a6efb51d3ff10787010'
FROM `person`

ON 9f593445ded75866e06045a6efb51d3ff10787010 és una password predefinida xifrada

Ara si feu clic a exporta de phpmyadmin tindrem un mysql que podem aprofitar:

INSERT INTO `person` (`person_id`, `username`, `9f593445ded758664560ea6efb51d3ff10787010`) VALUES
(4, 'aaznar', '9f593445ded75866e060ea6e45b51d3ff10787010'),
...

Canviantlo a:

INSERT INTO `users` (`person_id`, `username`, `password`) VALUES
(4, 'aaznar', '9f593445ded75866e060ea45fb51d3ff10787010'),


 Actualitzar la foto:

 Es poden baixar totes les fotos utilitzant:

 https://github.com/acacha/consultesLdap

 script: https://github.com/acacha/consultesLdap/blob/master/downloadPhotos.php

 Les possem a /usr/share/ebre-escool/uploads/person_photos

 i per actualitzar la base de dades:

 UPDATE `person` 
SET `person_photo`= CONCAT(`username`, '.jpg') 

OCO! vigileu que el camp person_photo sigui un VARCHAR i no pas INT 11