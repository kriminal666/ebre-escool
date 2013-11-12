<!-- Date Picker -->
<script>
$(function() {

	$( "#data_informe" ).datepicker({ dateFormat: 'dd-mm-yy' });

});

</script>

<!-- ComboBox -->
 <style>
.custom-combobox {
position: relative;
display: inline-block;
}
.custom-combobox-toggle {
position: absolute;
top: 0;
bottom: 0;
margin-left: -1px;
padding: 0;
/* support: IE7 */
*height: 1.7em;
*top: 0.1em;
}
.custom-combobox-input {
margin: 0;
padding: 0.3em;
}
</style>


<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour'); ?></h2>
	</div>    

	<!-- FORM -->    
	<div style="width:40%; margin:0px auto;">
		<form method="post" action="informe_centre_d_h_1" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_informe">Write Date:</label></td>
						<td><input class="form-control" id="data_informe" type="text" name="data" value="<?php echo date("d/m/Y")?>"/></td>
					</tr>
				</div>		
				<div class="form-group">
					<tr>
						<td><laber for="hora_informe">Select the time:</label></td>
						<td><select class="chosen-select" id="hora_informe" name="hora">
							<?php foreach ($hores as $key => $value) { ?>
								<option value="<?php echo $value ?>" <?php if($key==1){?> selected <?php } ?> ><?php echo $value ?></option>
							<?php } ?>
							</select>		
						</td>
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
<!-- Proves datatables -->
		<?php if($_POST){
			//echo "<pre>";print_r($_POST);echo "</pre>";
		} ?>

<table class="table table-striped table-bordered table-hover table-condensed" id="groups_by_teacher_an_date">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="3" style="text-align: center;"> <h4><?php echo $informe_centre_d_h_1_table_title?></h4></td>
  </tr>
  <tr>
     <th>Día</th>
     <th>Hora</th>
     <th>Faltes</th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($teacher_groups_current_day as $key => $teacher_group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $teacher_group->time_interval;?></td>
     <td><a href="<?php echo $teacher_group->group_url;?> "><?php echo $teacher_group->group_name;?></a></td>
     <td><?php echo $teacher_group->group_code;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>



<!-- Fi proves datatable -->
	</div>