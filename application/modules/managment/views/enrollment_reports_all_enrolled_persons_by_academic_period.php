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
                    <?php echo "Matrícula";?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Tots els matrículats per període acadèmic
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		



      <script>
      $(function(){

              $("#select_class_list_academic_period_filter").select2();

              $("#academic_period_text").text( $("#select_class_list_academic_period_filter").select2("data").text);

              $('#select_class_list_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/enrollment_reports_all_enrolled_persons_by_academic_period";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });


              $('#all_enrollments').dataTable( {
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
                                              "sPdfMessage": "<?php echo lang("all_enrollments");?>",
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
  <table class="table table-striped table-bordered table-hover table-condensed" id="TODO_filter">
          <thead style="background-color: #d9edf7;">
            <tr>
              <td colspan="6" style="text-align: center;"> <strong>Filtres
                </strong></td>
            </tr>
            <tr> 
              <td><?php echo "Període acadèmic"?>:</td>
              <td>
                <select id="select_class_list_academic_period_filter">
                <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>
                  <?php if ( $selected_academic_period_id) : ?>
                    <?php if ( $academic_period_key == $selected_academic_period_id) : ?>
                      <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                    <?php else: ?>
                        <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                    <?php endif; ?>
                  <?php else: ?>   
                      <?php if ( $academic_period_value->current == 1) : ?>
                        <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                      <?php else: ?>
                        <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                      <?php endif; ?> 
                  <?php endif; ?> 
                <?php endforeach; ?>
                </select>    
              </td>           
            </tr>
          </thead>  
        </table> 
</div>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_enrollments">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="10" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/studies') ;?>">
        <?php echo $enrollment_reports_all_enrolled_persons_by_academic_period_title?> Període acadèmic: <span id="academic_period_text">
      </a>
      </h4></td>
  </tr>
  <tr> 

     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_id')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_person')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_person_official_id')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_study')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_course')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_classroom_group')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_entryDate')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_last_update')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_creationUserId')?></th>
     <th><?php echo lang('enrollment_reports_all_enrolled_persons_by_academic_period_enrollment_lastupdateUserId')?></th>

  </tr>
 </thead>
 <tbody> 
  
  <!-- Iteration that shows study-->
  <?php foreach ($all_enrollments as $enrollment_key => $enrollment) : ?>
   <tr>
    <td><?php echo $enrollment->id;?></td>
    <td><?php echo $enrollment->person_id . " " . $enrollment->person_sn1 . " " . $enrollment->person_sn2 . ", " . $enrollment->person_givenName;?></td>
    <td><?php echo $enrollment->person_official_id;?></td>
    <td><?php echo $enrollment->study_id . " " . $enrollment->studies_shortname . " " . $enrollment->studies_name . " " .   $enrollment->studies_studies_law_id . " " .   
    $enrollment->studies_law_shortname . "" . $enrollment->studies_law_name  ?></td>
    <td><?php echo $enrollment->enrollment_course_id . " " . $enrollment->course_shortname  . " " .  $enrollment->course_name;?></td>
    <td><?php echo $enrollment->enrollment_group_id . " " . $enrollment->classroom_group_code  . " " .  $enrollment->classroom_group_shortName . " " . $enrollment->classroom_group_name;?></td>
    <td><?php echo $enrollment->enrollment_entryDate;?></td>
    <td><?php echo $enrollment->enrollment_last_update;?></td>
    <td><?php echo $enrollment->enrollment_creationUserId . " " . $enrollment->enrollment_creationUserId_username;?></td>
    <td><?php echo $enrollment->enrollment_lastupdateUserId . " " . $enrollment->enrollment_lastupdateUserId_username;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table> 

</div>

<div class="space-30"></div>


















	</div>	
</div>