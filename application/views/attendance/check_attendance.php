<!-- http://jqueryui.com/datepicker/ -->
<script>
$(function() {
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
</script>

<div class="container">

<center>
 <?php echo $choose_date_string?> : <input type="text" id="datepicker" class=""/>	

	
<table class="table table-striped table-bordered table-hover table-condensed">
 <thead style="background-color: #d9edf7;text-align: center;">
  <tr>
    <td colspan="5"> <?php echo $check_attendance_table_title?> | Dia: <?php echo $check_attendance_day?></td>
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
