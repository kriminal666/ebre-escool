<script>
$(function(){
	
	$("[rel='tooltip']").tooltipster();	
	
	$(".chosen-select,.chosen-multiple-select").chosen({allow_single_deselect:true});	
	
	$('#group_code').chosen().change(function(event) {
		selectedValue = $(this).find("option:selected").val();
		window.location.href = "<?php echo base_url('index.php/managment/users_in_group');?>/" + selectedValue;
	}); 
	
	
	$('#massive_password_change_form').submit(function(e) {
		var r=confirm("<?php echo lang("are_you_sure_change_and_print_passwords"); ?>? <br/><?php echo lang("are_you_sure_change_and_print_passwords2");?>.");
		if (r==true)	{
			window.open('', 'formpopup', 'width=200,height=200,scrollbars=yes');
			this.target = 'formpopup';
		} else {
			e.preventDefault();
		}
    });
    
    $('#all_users_in_group').dataTable( {
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
					"sExtends": "csv",
					"sButtonText": "CSV"
				},
				{
					"sExtends": "xls",
					"sButtonText": "XLS"
				},
				{
					"sExtends": "pdf",
					"sPdfOrientation": "landscape",
					"sPdfMessage": "<?php echo lang("students_group");?>",
					"sTitle": "<?php echo $selected_group . ". " . $selected_group_names[1] . "( " . $selected_group_names[0] . ")" ;?>",
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
    
});
</script>

<div class="container">
	

<div class="row">
 <div class="span12"> </div>
</div>

<?php
$datasources=array();
$datasources['mysql']="MySQL";
$datasources['ldap']="Ldap";
$selected_datasource="ldap";
$data_source_additional_parameters="";
?>

<div class="row" style="display:none">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <?php echo lang("select_data_source")?> : 
  </div>
</div>  

<form id="massive_password_change_form" action="<?php echo base_url('index.php/managment/massive_change_password_print');?>" method="post">

<div class="row" style="display:none">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
    <select class="chosen-select" data-place_holder="<?php echo lang("select_data_source")?>">
	 <?php foreach ($datasources as $data_source_key => $data_source_value): ?>
		<?php $group_additional_parameters=""; ?>
		<?php if ($data_source_key == $selected_datasource)	{
			$data_source_additional_parameters='selected="selected"';
		}
		?>
		
		<option value="<?php echo $data_source_key?>" <?php echo $data_source_additional_parameters?>$><?php echo $data_source_value?></option>

	 <?php endforeach; ?>
    </select>
  </div>

</div>

<div class="row">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <?php echo lang("select_group")?> : 
  </div>
</div>  

<div class="row" >
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <select id="group_code" name="group_code" class="chosen-select" data-place_holder="<?php echo lang("select_group")?>">
    <option value="ALL_GROUPS"><?php echo lang("all_groups");?></option>
	<?php foreach ($all_groups as $group_key => $group) : ?>
	    <?php $group_additional_parameters=""; ?>
		<?php if ($group->groupCode == $selected_group)	{
			$group_additional_parameters='selected="selected"';
		}?>
		<option value="<?php echo $group->groupCode;?>" <?php echo $group_additional_parameters?>$><?php echo $group->groupShortName?></option>

	 <?php endforeach; ?>
   </select>
  </div>
</div>
</form>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_users_in_group">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="29" style="text-align: center;"> <h4><?php echo lang('all_students_table_title') . ". " . lang('group') . ": " .$selected_group_names[1] . " (" . $selected_group_names[0] . ")"?></h4></td>
  </tr>
  <tr>
     <th><font size="-6"><?php echo lang('externalID')?></font></th>
     <th><font size="-6"><?php echo lang('irisPersonalUniqueIDType')?></font></th>
     <th><font size="-6"><?php echo lang('TSI')?></font></th>
     <th><font size="-6"><?php echo lang('internalID')?></font></th>
     <th><font size="-6"><?php echo lang('employeeNumber')?></font></th>
     <th><font size="-6"><?php echo lang('sn1')?></font></th>
     <th><font size="-6"><?php echo lang('sn2')?></font></th>
     <th><font size="-6"><?php echo lang('givenName')?></font></th>
     <th><font size="-6"><?php echo lang('Gender')?></font></th>
     <th><font size="-6"><?php echo lang('homePostalAddress')?></font></th>
     <th><font size="-6"><?php echo lang('location')?></font></th>
     <th><font size="-6"><?php echo lang('postalCode')?></font></th>
     <th><font size="-6"><?php echo lang('state')?></font></th>
     <th><font size="-6"><?php echo lang('mobile')?></font></th>
     <th><font size="-6"><?php echo lang('homePhone')?></font></th>
     <th><font size="-6"><?php echo lang('dateOfBirth')?></font></th>
     <th><font size="-6"><?php echo lang('uid')?></font></th>
     <th><font size="-6"><?php echo lang('uidnumber')?></font></th>
     <th><font size="-6"><?php echo lang('personal_email')?></font></th>
     <th><font size="-6"><?php echo lang('gidNumber')?></font></th>
     <th><font size="-6"><?php echo lang('homeDirectory')?></font></th>
     <th><font size="-6"><?php echo lang('loginShell')?></font></th>
     <th><font size="-6"><?php echo lang('sambaDomainName')?></font></th>
     <th><font size="-6"><?php echo lang('sambaHomeDrive')?></font></th>
     <th><font size="-6"><?php echo lang('sambaHomePath')?></font></th>
     <th><font size="-6"><?php echo lang('sambaLogonScript')?></font></th>
     <th><font size="-6"><?php echo lang('sambaSID')?></font></th>
     <th><font size="-6"><?php echo lang('sambaPrimaryGroupSID')?></font></th>
     <th><font size="-6"><?php echo lang('photo')?></font></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_students_in_group as $student_key => $student) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->irisPersonalUniqueID;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->irisPersonalUniqueIDType;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->highSchoolTSI;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->highSchoolUserId;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->employeeNumber;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sn1;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sn2;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->givenName;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->gender;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->homePostalAddress;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->location;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->postalCode;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->state;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->mobile;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->homePhone;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->dateOfBirth;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->uid;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->uidnumber;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->highSchoolPersonalEmail;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->gidNumber;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->homeDirectory;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->loginShell;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sambaDomainName;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sambaHomeDrive;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sambaHomePath;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sambaLogonScript;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sambaSID;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>"><font size="-6"><?php echo $student->sambaPrimaryGroupSID;?></font></td>
     <td rel='tooltip' title="<?php echo $student->dn;?>">
	   <?php if ($student->jpegPhoto !="") {
				echo "Sí";
		   }
		   else {
				echo "No";
		   }?>
	 </td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>


</div>
