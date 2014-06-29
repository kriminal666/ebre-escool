SELECT postalcode, person_locality_id ,person_locality_name, count( postalcode ) AS total
FROM person
GROUP BY postalcode, person_locality_id, person_locality_name
ORDER BY `total` DESC
LIMIT 0 , 300
