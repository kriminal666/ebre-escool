<!-- http://jqueryui.com/datepicker/ -->

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
	    }
		
	});

});
</script>

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
     <th><?php echo lang('ldap_dn')?></th>
     <th><?php echo lang('total_students')?></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_groups as $group_key => $group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $group->groupCode;?></td>
     <td><?php echo $group->groupShortName;?></td>
     <td><?php echo $group->mentorId;?></td>
     <td><?php echo $group->mentor_name;?></td>
     <td><font size="-3"><?php echo $group->ldap_dn;?></font></td>
     <td><?php echo $group->total_students;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>


</div>
