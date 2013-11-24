<!-- Date Picker -->
<script>
$(function() {
$( "#data_inicial" ).datepicker({ dateFormat: 'dd-mm-yy' });
$( "#data_final" ).datepicker({ dateFormat: 'dd-mm-yy' });
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
						"sTitle": "<?php echo lang('reports_educational_center_reports_incidents_by_date');?>",
						"sExtends": "csv",
						"sButtonText": "CSV"
					},
					{
						"sTitle": "<?php echo lang('reports_educational_center_reports_incidents_by_date');?>",
						"sExtends": "xls",
						"sButtonText": "XLS"
					},
					{
						"sTitle": "<?php echo lang('reports_educational_center_reports_incidents_by_date');?>",
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
<?php 
	if(isset($_POST['data_inicial'])){
		$data_ini=$_POST['data_inicial'];
	}
	if(isset($_POST['data_final'])){
		$data_fi=$_POST['data_final'];
	}	
?>


<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_educational_center_reports_incidents_by_date'); ?></h2>
	</div> 

	<!-- FORM -->    
	<div style="width:50%; margin:0px auto;">
		<form method="post" action="informe_centre_di_df_1" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_inicial">Write the initial Date:</label></td>
						<td><input class="form-control" id="data_inicial" type="text" name="data_inicial" value="<?php if(isset($data_ini)){ echo $data_ini; } else { echo date('d/m/Y'); } ?>"/></td>
					</tr>
				</div>		

				<div class="form-group">
					<tr>
						<td><label for="data_final">Write the end Date:</label></td>
						<td><input class="form-control" id="data_final" type="text" name="data_final" value="<?php if(isset($data_fi)){ echo $data_fi; } else { echo date('d/m/Y'); } ?>"/></td>
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
    <td colspan="3" style="text-align: center;"> <h4><?php echo $informe_centre_di_df_1?></h4></td>
  </tr>
  <tr>
     <th>Data Inicial</th>
     <th>Data Final</th>
     <th>Faltes</th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($teacher_groups_current_day as $key => $teacher_group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $teacher_group->data_ini;?></td>
     <td><?php echo $teacher_group->data_fi;?></td>
     <td><?php echo $teacher_group->faltes;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>

<!-- Fi proves datatable -->


	</div>	