<!-- Date Picker -->
<script>
$(function() {
$( "#data_inicial" ).datepicker({ dateFormat: 'dd-mm-yy' });
$( "#data_final" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>


<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_educational_center_reports_incidents_by_date'); ?></h2>
	</div> 

	<!-- FORM -->    
	<div style="width:40%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_inicial">Write the initial Date:</label></td>
						<td><input class="form-control" id="data_inicial" type="text" name="data" value="<?php echo date("d/m/Y")?>"/></td>
					</tr>
				</div>		

				<div class="form-group">
					<tr>
						<td><label for="data_final">Write the end Date:</label></td>
						<td><input class="form-control" id="data_final" type="text" name="data" value="<?php echo date("d/m/Y")?>"/></td>
					</tr>
				</div>

				<div class="form-group">
					<tr>
						<td valign="top"><label for="incident">Select the type of incident:</label></td>
						<td>
							<input type="checkbox" name="F" value="1" checked> F</input><br />
							<input type="checkbox" name="FJ" value="2" checked> FJ</input><br />
							<input type="checkbox" name="R" value="3" checked> R</input><br />
							<input type="checkbox" name="RJ" value="4" checked> RJ</input><br />
							<input type="checkbox" name="E" value="5" checked> E</input>
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>
	</div>	