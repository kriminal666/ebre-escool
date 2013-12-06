<!-- http://jqueryui.com/datepicker/ -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
$(function() {

	$('#groups_by_teacher_an_date').dataTable( {
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
	    },
		"bPaginate": false,
		"bFilter": false,
        "bInfo": false,
	});
	
    //$('#groups_by_teacher_an_date1').dataTable();
    //console.log("HEY YOU1");
    
	$.datepicker.regional['ca'] = {
	                closeText: 'Tancar',
	                prevText: '&#x3c;Ant',
	                nextText: 'Seg&#x3e;',
	                currentText: 'Avui',
	                monthNames: ['Gener','Febrer','Mar&ccedil;','Abril','Maig','Juny',
	                'Juliol','Agost','Setembre','Octubre','Novembre','Desembre'],
	                monthNamesShort: ['Gen','Feb','Mar','Abr','Mai','Jun',
	                'Jul','Ago','Set','Oct','Nov','Des'],
	                dayNames: ['Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'],
	                dayNamesShort: ['Dug','Dln','Dmt','Dmc','Djs','Dvn','Dsb'],
	                dayNamesMin: ['Dg','Dl','Dt','Dc','Dj','Dv','Ds'],
	                weekHeader: 'Sm',
	                dateFormat: 'dd/mm/yy',
	                firstDay: 1,
	                isRTL: false,
	                showMonthAfterYear: false,
	                yearSuffix: ''};
$( "#datepicker" ).datepicker($.datepicker.regional['ca']);
});

//DATATABLES:

</script>

<div class="container">

<center>
 <?php echo $choose_date_string?> : <input type="text" id="datepicker" class=""/>	

	
<table class="table table-striped table-bordered table-hover table-condensed" id="groups_by_teacher_an_date">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="3" style="text-align: center;"> <h4><?php echo $check_attendance_table_title?> | Dia: <?php echo $check_attendance_day?></h4></td>
  </tr>
  <tr>
     <th>Column 1</th>
     <th>Column 2</th>
     <th>Column 3</th>
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

</center>

</div>
