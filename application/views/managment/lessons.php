<script>
$(function(){
	
	$("[rel='tooltip']").tooltipster();	
	
	$('#lessons').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"aLengthMenu": [[10, 25, 50,100,200,500,1000,-1], [10, 25, 50,100,200,500,1000, "<?php echo lang("All");?>"]],
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
					"sPdfMessage": "<?php echo lang("lessons");?>",
					"sTitle": "TODO",
					"sButtonText": "PDF"
				},
				{
					"sExtends": "print",
					"sButtonText": "<?php echo lang("Print");?>"
				},
			]

        },
        "aoColumns": [
			null,
			{ "sType": "numeric" },
			null,
			null,
			null,
   		        <?php if ($exists_assignatures_table){ echo "null,"; }?>
			null,
			null,
			null,
		],
        "iDisplayLength": 50,
        "aaSorting": [[ 1, "asc" ]],
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

<table class="table table-striped table-bordered table-hover table-condensed" id="lessons">
 <thead style="background-color: #d9edf7;">
  <tr> 
    <td colspan="8" style="text-align: center;"> <h4><?php echo lang('all_lessons');  ?></h4></td>
  </tr>
  <tr>
	 <th><?php echo lang('lesson_id');?></th>	
	 <th><?php echo lang('lesson_code');?></th>	
	 <th><?php echo lang('classroom_group_code');?></th>	
	 <th><?php echo lang('teacher_code');?></th>	
	 <th><?php echo lang('lesson_shortname');?></th>	
         <?php if ($exists_assignatures_table): ?>
           <th><?php echo lang('lesson_name');?></th>
         <?php endif;?>
	                 
	 <th><?php echo lang('classrom_code');?></th>	
	 <th><?php echo lang('day_code');?></th>	
	 <th><?php echo lang('hour_code')?></th>	
  </tr>
 </thead>
 <tbody>
  <?php 
  foreach ($all_lessons as $lesson_key => $lesson) : ?>
  <?php $lesson_title=$lesson->lesson_shortname; ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->lesson_id;?></td>
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->lesson_code;?></td>
	   <td rel='tooltip' title="<?php echo $lesson_title;?>">
	    <a href="<?php echo base_url("index.php/managment/users_in_group/" . $lesson->classroom_group_code);?>">
	     <?php echo $lesson->groupShortName;?></a> ( <?php echo $lesson->classroom_group_code;?> )
	   </td>
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->teacher_code;?></td>
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->lesson_shortname;?></td>
	   <?php if ($exists_assignatures_table): ?>
	     <?php if ($lesson->nom_assignatura!=""):?>
                        <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->nom_assignatura?></td>
             <?php else: ?>
                        <td rel='tooltip' title="<?php echo $lesson_title;?>"> </td>
             <?php endif;?>             
           <?php endif;?>
	                          
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->classrom_code;?></td>
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->day_code;?></td>
	   <td rel='tooltip' title="<?php echo $lesson_title;?>"><?php echo $lesson->hour_code;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>
</div>
