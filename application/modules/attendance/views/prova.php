<?php 
	$url = base_url('application/modules/attendance/controllers/prova_ajax.php/index');
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

jQuery.ajax({
	url:'<?php echo $url;?>',
	data: {
			is_ajax: 'true'
		},
		type: 'post',
		dataType: 'json'
	}).done(
		function (data) 
		{
			//$("#resultat").html("");
			$.each(data, function(k,v)
			{
				$("#resultat").append("<br />" + k + " - " + v);
			});	
		}
	).fail(
		function() 
		{
			//alert( "No s'ha pogut obtenir cap valor" );
		});
</script>
<div id="resultat">
<?php

	$query = $this->db->get('course');
	$resultat = array();

	foreach ($query->result() as $row)
	{
	    $resultat[] = $row->course_shortname;
	}
	print_r(json_encode($resultat));

?>
</div>