<!-- http://jqueryui.com/datepicker/ -->
<script>
$(function(){
	$(".chosen-select,.chosen-multiple-select").chosen({allow_single_deselect:true});	
});
</script>

<div class="container">

<center>
 <?php echo lang("select_group")?> : 
 
 <select class="chosen-select">
	<option><?php echo lang("select_group")?></option>
	<option>GRUP 1</option>
	<option selected="selected">GRUP 2</option>
	<option>GRUP 3</option>
	<option>GRUP 4</option>
 </select>
 
<br/>ou=Grup A,ou=Curs 1,ou=Administracio i finances,ou=Administracio,ou=Alumnes,ou=All,dc=iesebre,dc=com 
<br/>physicalDeliveryOfficeName=1AF

</center>

</div>
