<!-- http://jqueryui.com/datepicker/ -->
<script>
$(function(){
	$(".chosen-select,.chosen-multiple-select").chosen({allow_single_deselect:true});	
	
	//$("#dialog-message").dialog("open");
	
	
	$('#massive_password_change_form').submit(function(e) {
		window.open('', 'formpopup', 'width=200,height=200,scrollbars=yes');
        this.target = 'formpopup';
        /*
		e.preventDefault();
		alert("test:" + $(this).attr('action'));
		$('<div/>', {'id':'dialog-message', 'title':'Descàrrega completada'})
			.html($('<iframe/>', {
				'src' : $(this).attr('action'),
				'style' :'width:100%; height:100%;border:none;'
			})).appendTo('body')
			.dialog({
				'width' : 400,
				'height' :250,
				buttons: [ { 
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); } 
                } ]
			});
       */
    });
    
    $('#all_users_in_group').dataTable( {
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
   <select name="group_code" class="chosen-select" data-place_holder="<?php echo lang("select_group")?>">
	<?php foreach ($all_groups as $group_key => $group) : ?>
	    <?php $group_additional_parameters=""; ?>
		<?php if ($group->groupCode == $selected_group)	{
			$group_additional_parameters='selected="selected"';
		}?>
		<option value="<?php echo $group->groupCode;?>" <?php echo $group_additional_parameters?>$><?php echo $group->groupShortName?></option>

	 <?php endforeach; ?>
   </select>
   <br/>
   <button id="show_group_data" class="btn">Mostrar dades</button>
   <button id="print_new_passwords" class="btn">Imprimir</button>
  </div>
</div>
</form>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_users_in_group">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="18" style="text-align: center;"> <h4><?php echo lang('all_students_table_title')?>. Grup: <?php echo lang('selected_group')?></h4></td>
  </tr>
  <tr>
     <th><font size="-4"><?php echo lang('externalID')?></font></th>
     <th><font size="-4"><?php echo lang('irisPersonalUniqueIDType')?></font></th>
     <th><font size="-4"><?php echo lang('TSI')?></font></th>
     <th><font size="-4"><?php echo lang('internalID')?></font></th>
     <th><font size="-4"><?php echo lang('employeeNumber')?></font></th>
     <th><font size="-4"><?php echo lang('sn1')?></font></th>
     <th><font size="-4"><?php echo lang('sn2')?></font></th>
     <th><font size="-4"><?php echo lang('givenName')?></font></th>
     <th><font size="-4"><?php echo lang('Gender')?></font></th>
     <th><font size="-4"><?php echo lang('homePostalAddress')?></font></th>
     <th><font size="-4"><?php echo lang('location')?></font></th>
     <th><font size="-4"><?php echo lang('postalCode')?></font></th>
     <th><font size="-4"><?php echo lang('mobile')?></font></th>
     <th><font size="-4"><?php echo lang('homePhone')?></font></th>
     <th><font size="-4"><?php echo lang('dateOfBirth')?></font></th>
     <th><font size="-4"><?php echo lang('uid')?></font></th>
     <th><font size="-4"><?php echo lang('personal_email')?></font></th>
     <th><font size="-4"><?php echo lang('photo')?></font></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_students_in_group as $student_key => $student) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><font size="-4"><?php echo $student->irisPersonalUniqueID;?></font></td>
     <td><font size="-4"><?php echo $student->irisPersonalUniqueIDType;?></font></td>
     <td><font size="-4"><?php echo $student->highSchoolTSI;?></font></td>
     <td><font size="-4"><?php echo $student->highSchoolUserId;?></font></td>
     <td><font size="-4"><?php echo $student->employeeNumber;?></font></td>
     <td><font size="-4"><?php echo $student->sn1;?></font></td>
     <td><font size="-4"><?php echo $student->sn2;?></font></td>
     <td><font size="-4"><?php echo $student->givenName;?></font></td>
     <td><font size="-4"><?php echo $student->gender;?></font></td>
     <td><font size="-4"><?php echo $student->homePostalAddress;?></font></td>
     <td><font size="-4"><?php echo $student->location;?></font></td>
     <td><font size="-4"><?php echo $student->postalCode;?></font></td>
     <td><font size="-4"><?php echo $student->mobile;?></font></td>
     <td><font size="-4"><?php echo $student->homePhone;?></font></td>
     <td><font size="-4"><?php echo $student->dateOfBirth;?></font></td>
     <td><font size="-4"><?php echo $student->uid;?></font></td>
     <td><font size="-4"><?php echo $student->highSchoolPersonalEmail;?></font></td>
     <td>
	   <?php if ($student->jpegPhoto !="") {
				echo "Sí";
		   }
		   else {
				echo "No";
		   }?>
	 </td>
     <!-- <?php echo $student->jpegPhoto;?> -->
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>


</div>
