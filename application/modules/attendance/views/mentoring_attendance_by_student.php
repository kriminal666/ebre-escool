<div class="main-content">

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
  <li class="active"><?php echo lang('mentoring');?></li>
 </ul>
</div>

<div class="page-content">
<div class="page-header position-relative">
 <h1>
  <?php echo lang('mentoring_attendance_by_student');?>
  <small>
   <i class="icon-double-angle-right"></i>
    <span id="title_teacher_name">TODO</span>
  </small>
 </h1>
</div>

<div class="row-fluid">
  <!-- FILTER FORM -->    
   <div style="width:60%; margin:0px auto;">
    

    <form method="post" action="" class="form-horizontal" role="form">
      <table class="table table-bordered" cellspacing="10" cellpadding="5">
        <div class="form-group ui-widget">
          <tr>
            <td><label for="grup" style="width:150px;">Període acadèmic:</label></td>
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
            <!--
          <tr>
            <td><label for="grup">Selecciona el grup:</label></td>
            <td><select data-place_holder="TODO" style="width:580px;" id="grup" name="grup" data-size="5" data-live-search="true">
              <?php foreach ($grups as $key => $value) { ?>
                <option value="<?php echo $key ?>" ><?php echo $value ?></option>
              <?php } ?>
              </select> 
            </td>
          </tr> 
          -->
          <tr>
            <td><label for="grup">Selecciona l'alumne:</label></td>
            <td><select data-place_holder="TODO" id="selected_student" name="grup" data-size="5" data-live-search="true">
              <option></option>
              <?php foreach ($students as $student_key => $student) { ?>
                <?php if ( $student_key == $default_student_key ) : ?>
                  <option selected="selected" value="<?php echo $student_key ?>" ><?php echo $student->fullname_alt; ?></option>
                <?php else: ?>  
                  <option value="<?php echo $student_key ?>" ><?php echo $student->fullname_alt; ?></option>  
                <?php endif;?>

              <?php } ?>
              </select> 
            </td>
          </tr> 
        </div>
      </table>
     </form>
    </div>

    <center><i id="spinner" class="icon-spinner icon-spin orange bigger-300" style="display: none;"></i></center>

    <!-- DEBUG --> 
    <?php //var_export($students);?>

    <table class="table table-striped table-bordered table-hover table-condensed" id="student_incidents">

       <thead style="background-color: #d9edf7;">
        <tr>
          <td colspan="12" style="text-align: center;"> <h4>
              Incidències
            </h4></td>
        </tr>
        <tr>      
           <th><?php echo lang('attendance_reports_student_incidents_id')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_date')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_day')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_time_slot')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_incident_type')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_study_submodule')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_study_module')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_classroom_group')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_entryDate')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_last_update')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_creationUserId')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_lastupdateUserId')?></th>
        </tr>
       </thead>  
     </table>   

    <br/><br/><br/><br/><br/>


</div>



<script>

var student_incidents_table;

function get_selected_academic_period_id() {
  $("#spinner").show();   // Show the spinner
  var selected_academic_period_id = $("#select_class_list_academic_period_filter").select2("val");
  //console.debug("selected_academic_period_id: " + selected_academic_period_id);
  return selected_academic_period_id;
}

function get_selected_student() {
  var selected_student = $("#selected_student").select2("val");
  //console.debug("selected_student: " + selected_student);
  return selected_student;
}


$(function() { 

  $("#select_class_list_academic_period_filter").select2({dropdownAutoWidth: 'true'});

  $("#selected_student").select2({placeholder: "Seleccioneu un alumne...",allowClear: true,dropdownAutoWidth: 'true'});

  $('#select_class_list_academic_period_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/mentoring_attendance_by_student";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

    });

  $('#selected_student').on("change", function(e) {  
        var selected_student = $("#selected_student").select2("val");
        console.debug("selected_student onchange: " + selected_student);

        //Reload datatables
        console.debug(student_incidents_table);
        student_incidents_table.ajax.reload();
    });


    student_incidents_table = $('#student_incidents').DataTable( {
                      "order": [[ 1, "desc" ],[3, "desc"]],
                      "bDestroy": true,
                      "sServerMethod": "POST",
                      "sAjaxSource": "<?php echo base_url('index.php/attendance/attendance_reports/get_student_incidents');?>", 
                      "fnServerParams": function ( aoData ) {
                          aoData.push( { "name": "academic_period_id", "value": get_selected_academic_period_id() });
                          aoData.push( { "name": "student_id", "value": get_selected_student() });
                      },
                      "fnDrawCallback": function () {
                          $("#spinner").hide();   // Hide the spinner
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return data.id;
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.date;
                                  }},
                        { "mData": function(data, type, full) {

                                  switch (data.day) {
                                      case "1":
                                          return "1-Dilluns";
                                      case "2":
                                          return "2-Dimarts";
                                      case "3":
                                          return "3-Dimecres";
                                      case "4":
                                          return "4-Dijous";
                                      case "5":
                                          return "5-Divendres";
                                     default:
                                          return "error";
                                  } 
                                    return ;
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.time_slot_start_time + "-" + data.time_slot_end_time + "(" + data.time_slot_id + ")";
                                  }},
                        { "mData": function(data, type, full) {
                                    return '<span title="' + data.incident_type_name + '">' + data.type + "-" + data.incident_type_shortName + "</span>";
                                  }},          
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/curriculum/study_submodules/read/')?>/" +  data.study_submodule_id;
                                    return '<a href="' + url + '" title="' + data.study_submodules_name + '">' + data.study_submodules_shortname + ' (' + data.study_submodule_id + ')</a>';
                                  }},          
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/curriculum/study_module/read/')?>/" +  data.study_module_id;
                                    return '<a href="' + url + '" title="' + data.study_module_name + '">' + data.study_module_shortname + ' (' + data.study_module_id + ')</a>';
                                  }},  
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/curriculum/classroom_group/read/')?>/" +  data.enrollment_group_id;
                                    return '<a href="' + url + '" title="' + data.classroom_group_name + '">' + data.classroom_group_code + ' (' + data.enrollment_group_id + ')</a>';
                                  }}, 
                        { "mData": function(data, type, full) {
                                    return data.entryDate;
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.last_update;
                                  }},
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/users/index/read/')?>/" +  data.creationUserId;
                                    return '<a href="' + url + '" title="' + data.creationUserTitle + '">' + data.creationUser + ' (' + data.creationUserId + ')</a>';
                                  }},
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/users/index/read/')?>/" +  data.lastupdateUserId;
                                    return '<a href="' + url + '" title="' + data.lastupdateUserTitle + '">' + data.lastupdateUser + ' (' + data.lastupdateUserId + ')</a>';
                                  }},
                      ],
                  "aLengthMenu": [[10, 25, 50,100,200,500,1000,5000,-1], [10, 25, 50,100,200,500,1000,5000,"Totes"]],
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
                                              "sPdfMessage": "TODO",
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