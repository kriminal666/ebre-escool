<!-- http://jqueryui.com/datepicker/ -->
<script>
$(function(){
	$(".chosen-select,.chosen-multiple-select").chosen({allow_single_deselect:true});	
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

<div class="row">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <?php echo lang("select_data_source")?> : 
  </div>
</div>  

<div class="row">
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

<?php
$groups=array();
$groups['grup1']="GRUP 1";
$groups['grup2']="GRUP 2";
$groups['grup3']="GRUP 3";
$groups['grup4']="GRUP 4";
$selected_group="grup2";
?>

<div class="row">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <select class="chosen-select" data-place_holder="<?php echo lang("select_group")?>">
	<?php foreach ($groups as $group_key => $group_value) : ?>
	    <?php $data_source_additional_parameters=""; ?>
		<?php if ($group_key == $selected_group)	{
			$group_additional_parameters='selected="selected"';
		}?>
		
		<option value="<?php echo $group_key?>" <?php echo $group_additional_parameters?>$><?php echo $group_value?></option>

	 <?php endforeach; ?>
   </select>
  </div>
</div>

<div class="row">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <center><button class="btn">Imprimir</button></center>
  </div>
</div>

  

<br/>ou=Grup A,ou=Curs 1,ou=Administracio i finances,ou=Administracio,ou=Alumnes,ou=All,dc=iesebre,dc=com 
<br/>physicalDeliveryOfficeName=1AF

</div>
