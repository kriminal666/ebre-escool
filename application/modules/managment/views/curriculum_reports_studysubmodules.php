<div class="main-content" >
<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>
 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="#">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active"><?php echo lang('reports');?></li>
 </ul>
</div>

<div class="page-header position-relative">
                <h1>
                    <?php echo lang("curriculum");?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Mòduls professionals / Crèdits
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		



      <script>
      $(function(){

              $('#all_groups').dataTable( {
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],
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
                                              "sPdfMessage": "<?php echo lang("all_groups");?>",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>"
                                      },
                              ]

              },
              "iDisplayLength": 100,
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
    <td colspan="13" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodules') ;?>">
        <?php echo $study_submodules_table_title?>
      </a>
      </h4></td>
  </tr>
  <tr> 
     <th><?php echo lang('study_submodule_id')?></th>
     <th><?php echo lang('study_submodule_shortname')?></th>
     <th><?php echo lang('study_submodule_name')?></th>
     <th><?php echo lang('study_submodule_course')?></th>
     <th><?php echo lang('study_submodule_study')?></th>
     <th><?php echo lang('study_submodules_totalHours')?></th>
     <th><?php echo lang('study_submodules_order')?></th>
     <th><?php echo lang('study_submodule_initialDate')?></th>
     <th><?php echo lang('study_submodule_endDate')?></th>
  </tr>
 </thead>
 <tbody> 

  <!-- Iteration that shows study_submodules-->
  <?php foreach ($all_study_submodules as $study_submodule_key => $study_submodule) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">   
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodule/edit/' . $study_submodule->id ) ;?>">
          <?php echo $study_submodule->id;?>
      </a> 
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodule/read/' . $study_submodule->id ) ;?>">
          <?php echo $study_submodule->shortname;?>
      </a> 
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodule/read/' . $study_submodule->id ) ;?>">
          <?php echo $study_submodule->name;?>
      </a> 
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/course/read/' . $study_submodule->course_id ) ;?>">
          <?php echo $study_submodule->course_shortname . ". " . $study_submodule->course_name;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/curriculum/course/edit/' . $study_submodule->course_id ) ;?>">
          <?php echo $study_submodule->course_id ;?>
      </a> )
     </td>
     
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/studies/read/' . $study_submodule->study_id ) ;?>">
          <?php echo $study_submodule->study_shortname . ". " . $study_submodule->study_name . " - " . $study_submodule->study_law_name . " -" . $study_submodule->study_law_shortname;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/curriculum/studies/edit/' . $study_submodule->course_id ) ;?>">
          <?php echo $study_submodule->course_id ;?>
      </a> )
     </td>

     <td>
      <?php echo $study_submodule->study_submodules_totalHours;?>
    </td>
    
    <td>
      <?php echo $study_submodule->study_submodules_order;?>
    </td>

    <td>
      <?php echo $study_submodule->study_submodule_initialDate;?>
    </td>

    <td>
      <?php echo $study_submodule->study_submodule_endDate;?>
    </td>

   </tr>
  <?php endforeach; ?>
 </tbody>
</table> 

</div>

<div class="space-30"></div>

	</div>	
</div>