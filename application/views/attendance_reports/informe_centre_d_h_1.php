<!-- Date Picker -->
<script>
$(function() {

	$( "#data_informe" ).datepicker({ dateFormat: 'dd-mm-yy' });

});

</script>
<!-- Data Table -->
<script>
$(document).ready( function () {

	$('#groups_by_teacher_an_date').dataTable( {
		"bFilter": false,
		"bInfo": false,
		"sDom": 'T<"clear">lfrtip',
		"aLengthMenu": [[10, 25, 50,100,200,500,1000,-1], [10, 25, 50,100,200,500,1000, "All"]],		
		"oTableTools": {
			"sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
				"aButtons": [
					{
						"sExtends": "copy",
						"sButtonText": "<?php echo lang("Copy");?>"
					},
					{
						"sTitle": "<?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour');?>",
						"sExtends": "csv",
						"sButtonText": "CSV"
					},
					{
						"sTitle": "<?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour');?>",
						"sExtends": "xls",
						"sButtonText": "XLS"
					},
					{
						"sTitle": "<?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour');?>",
						"sExtends": "pdf",
						"sPdfOrientation": "landscape",
						"sButtonText": "PDF"
					},
					{
						"sExtends": "print",
						"sButtonText": "<?php echo lang("Print");?>"
					},
				]
},
        "iDisplayLength": 50,
        "aaSorting": [[ 5, "asc" ],[ 6, "asc" ],[ 7, "asc" ]],
		"oLanguage": {
			"sProcessing":   "Processant...",
			"sLengthMenu":   "Mostra _MENU_ registres",
			"sZeroRecords":  "No s'han trobat registres.",
			"sInfo":         "Mostrant de _START_ a _END_ de _TOTAL_ registres",
			"sInfoEmpty":    "Mostrant de 0 a 0 de 0 registres",
			"sInfoFiltered": "(filtrat de _MAX_ total registres)",
			"sInfoPostFix":  "",
			"sSearch":       "Filtrar:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Primer",
				"sPrevious": "Anterior",
				"sNext":     "Següent",
				"sLast":     "Últim"
			}
	    }
		
	});
} );

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
	<div style="width:50%; margin:0px auto;">
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
								<option value="<?php echo $value ?>" <?php if(isset($_POST['hora']) && $value == $_POST['hora']){ ?> selected <?php } else {if($key==1){?> selected <?php }} ?> ><?php echo $value ?></option>
							<?php } ?>
							</select>		
						</td>
					</tr>	
				</div>
				<div class="form-group">
					<tr>
						<td valign="top"><label for="incident">Select the type of incident:</label></td>
						<td>
							<input type="checkbox" name="F" value="1" <?php if(isset($_POST['F'])){ ?>checked <?php } ?> > F</input><br />
							<input type="checkbox" name="FJ" value="2" <?php if(isset($_POST['FJ'])){ ?>checked <?php } ?> > FJ</input><br />
							<input type="checkbox" name="R" value="3" <?php if(isset($_POST['R'])){ ?>checked <?php } ?> > R</input><br />
							<input type="checkbox" name="RJ" value="4" <?php if(isset($_POST['RJ'])){ ?>checked <?php } ?> > RJ</input><br />
							<input type="checkbox" name="E" value="5" <?php if(isset($_POST['E'])){ ?>checked <?php } ?> > E</input>
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>
<!-- Proves datatables -->

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
     <td><?php echo $teacher_group->data;?></td>
     <td><?php echo $teacher_group->hora;?></td>
     <td><?php echo $teacher_group->faltes;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>

<!-- Fi proves datatable -->
	</div>