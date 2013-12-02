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
						"sButtonText": "<?php echo lang("Copy");?>",
						"mColumns": "visible"
					},
					{
						"sTitle": "<?php echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final'];?>",
						"sExtends": "csv",
						"sButtonText": "CSV",
						"mColumns": "visible"
					},
					{
						"sTitle": "<?php echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final'];?>",
						"sExtends": "xls",
						"sButtonText": "XLS",
						"mColumns": "visible"
					},
					{
						"sTitle": "<?php echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final'];?>",
						"sExtends": "pdf",
						"sPdfOrientation": "portrait",
						"sButtonText": "PDF",
						"mColumns": "visible"
					},
					{
						"sExtends": "print",
						"sButtonText": "<?php echo lang("Print");?>",
						"mColumns": "visible"
					},
				]
},
        "iDisplayLength": 50,
        "aaSorting": [[ 4, "desc" ]],
	    "aoColumns": [
	    { "bVisible": false },
	    null,
	    null,
	    null,
	    null
	  ],        
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
	if(isset($_POST['top'])){
		$top=$_POST['top'];
	} else {
		$top = 10;
	}	

	$faltes = array(
	array(
	'data' => strtotime('10-11-2013'),
	'estudiant'  => 'Ramón Rodriguez Murillo',
	'grup' => '1GAD',
	'total' => 82,
	),
	array(
	'data' => strtotime('10-11-2013'),		
	'estudiant'  => 'Cristina Lizana Roche',
	'grup' => '1LDC',
	'total' => 80,
	),
	array(
	'data' => strtotime('11-11-2013'),		
	'estudiant'  => 'Cristina Oleinic',
	'grup' => '1DIE',
	'total' => 79,
	),	
	array(
	'data' => strtotime('8-10-2013'),		
	'estudiant'  => 'Monika Aleknaite',
	'grup' => '1DIE',
	'total' => 74,
	),
	array(
	'data' => strtotime('20-10-2013'),		
	'estudiant'  => 'Saboora Kabir',
	'grup' => '1FAR',
	'total' => 73,
	),
	array(
	'data' => strtotime('01-12-2013'),		
	'estudiant'  => 'Aycha Nafaa Rubio',
	'grup' => '1GAD',
	'total' => 67,
	),
	array(
	'data' => strtotime('10-11-2013'),		
	'estudiant'  => 'Sira Sowe',
	'grup' => '2DIE',
	'total' => 65,
	),
	array(
	'data' => strtotime('08-10-2012'),		
	'estudiant'  => 'Nerea Pellicer Montesó',
	'grup' => '1LDC',
	'total' => 63,
	),
	array(
	'data' => strtotime('5-11-2013'),		
	'estudiant'  => 'Aura Peris Aldea',
	'grup' => '1FAR',
	'total' => 63,
	),
	array(
	'data' => strtotime('30-11-2013'),		
	'estudiant'  => 'Venecia Sotillo Diaz',
	'grup' => '1AF',
	'total' => 63
	)
	);	

?>

<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_educational_center_reports_incidents_by_date_ranking'); ?></h2>
	</div>


	<!-- FORM -->    
	<div style="width:50%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
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
						<td><label for="top">Top:</label></td>
						<td><input class="form-control" id="top" type="text" name="top" value="<?php echo $top; ?>"/></td>
					</tr>
				</div>

				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>

<!-- Proves datatables -->
<h4><?php if($_POST){ echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final']; ?></h4>
<?php $posicio = 1; ?>
<table class="table table-striped table-bordered table-hover table-condensed" id="groups_by_teacher_an_date">
 <thead style="background-color: #d9edf7;">
  <tr>
  	 <th>Data</th>
     <th>Posició</th>
     <th>Alumne</th>
     <th>Grup</th>
     <th>Total faltes No Justificades</th>     
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($faltes as $falta) : ?>
  <?php if(/*($falta >= $data_ini) && ($falta <= $data_fi) &&*/ ($posicio <= $top)){ ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
   	 <td><?php echo $falta['data'];?></td>
     <td><?php echo $posicio; $posicio++;?></td>
     <td><?php echo $falta['estudiant'];?></td>
     <td><?php echo $falta['grup'];?></td>     
     <td><?php echo $falta['total'];?></td>
   </tr>
   <?php } ?>
  <?php endforeach; }?>
 </tbody>
</table>

<!-- Fi proves datatable -->

	</div>		