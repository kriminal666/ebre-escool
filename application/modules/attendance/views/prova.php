<?php $url = base_url('application/modules/attendance/views/prova2.php');?>

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
			$("#resultat").html("");
			$.each(data, function(k,v)
			{
				$("#resultat").append(k + " - " + v + "<br />");
			});	
		}
	).fail(
		function() 
		{
			alert( "error" );
		});
</script>
<div id="resultat"></div>