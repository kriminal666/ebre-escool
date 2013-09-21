<!-- http://jqueryui.com/datepicker/ -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
$(function(){

	$('#all_groups').dataTable( {
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

});
</script>

<?php

$all_groups_table_title="Tots els grups";

$all_groups=array();

$all_groups['1AF']= new stdClass;
$all_groups['1AF']->group_code="1AF";
$all_groups['1AF']->group_name="1r Admin i finances";
$all_groups['1AF']->mentor_code="17";
$all_groups['1AF']->mentor_name="Pilar nuez";
$all_groups['1AF']->ldap_cn="cn=prova";
$all_groups['1AF']->total_students=20;

$all_groups['1APD']= new stdClass;
$all_groups['1APD']->group_code="1APD";
$all_groups['1APD']->group_name="1r APD";
$all_groups['1APD']->mentor_code="18";
$all_groups['1APD']->mentor_name="Pepito Grillo";
$all_groups['1APD']->ldap_cn="cn=prova1";
$all_groups['1APD']->total_students=25;


$all_groups['1DIE']= new stdClass;
$all_groups['1DIE']->group_code="1DIE";
$all_groups['1DIE']->group_name="DIE";
$all_groups['1DIE']->mentor_code="19";
$all_groups['1DIE']->mentor_name="Linus Torvalds";
$all_groups['1DIE']->ldap_cn="cn=prova1";
$all_groups['1DIE']->total_students=25;

?>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_groups">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="6" style="text-align: center;"> <h4><?php echo $all_groups_table_title?></h4></td>
  </tr>
  <tr>
     <th><?php echo lang('group_code')?></th>
     <th><?php echo lang('group_name')?></th>
     <th><?php echo lang('mentor_code')?></th>
     <th><?php echo lang('mentor_name')?></th>
     <th><?php echo lang('ldap_cn')?></th>
     <th><?php echo lang('total_students')?></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_groups as $group_key => $group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $group->group_code;?></td>
     <td><?php echo $group->group_name;?></td>
     <td><?php echo $group->mentor_code;?></td>
     <td><?php echo $group->mentor_name;?></td>
     <td><?php echo $group->ldap_cn;?></td>
     <td><?php echo $group->total_students;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>


</div>
