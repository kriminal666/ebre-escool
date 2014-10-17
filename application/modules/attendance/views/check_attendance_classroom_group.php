<div class="main-content">
<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>
 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="<?php echo base_url();?>">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li>
    <i class="icon-bell bell-icon"></i>
    <a href="<?php echo base_url('/index.php/attendance/check_attendance');?>">Passar llista</a>       
  <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active">
   Grup classe
  </li> 

 </ul>
</div>

<?php //echo "Departaments: ";echo  "<pre>";print_r($departments);echo "</pre>";?>
<?php //echo "Grups de Classe: ";echo  "<pre>";print_r($classroom_groups);echo "</pre>";?>
<?php //echo "Lliçons: ";echo  "<pre>";print_r($all_lessons);echo "</pre>";?>
<?php //echo "Timeslots Lective: ";echo  "<pre>";print_r($timeslots['time_slots_lective']);echo "</pre>";?>

<div class="page-content">
<div class="page-header position-relative">
 <h1>
  Grup classe
  <small>
   <i class="icon-double-angle-right"></i>
    <?php echo "( " . $selected_classroom_group_code . " ) " . $selected_classroom_group . " ( Id: " . $selected_classroom_group_key . " )";?>
  </small>
 </h1>
</div>

<div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="icon-remove"></i>
                </button>

                <i class="icon-ok red"></i>

                
                <strong class="red">
                  IMPORTANT : 
                </strong>
                No passeu faltes fins que no rebeu un correu conforme ja està activada la funcionalitat. Estem treballant per posar en marxa aquesta funcionalitat.
              </div>


<div class="space-3"></div>

              <div class="row-fluid">
                <div class="span1"></div>

                <div class="widget-box span5 collapsed">
                        <div class="widget-header widget-header-small header-color-green">
                          <h6>Data i franja horaria: <?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date . " " . $selected_time_slot;?></h6>

                          <span class="widget-toolbar">
                            <a href="#" data-action="collapse">
                              <i class="icon-chevron-down"></i>
                            </a>

                            <a href="#" data-action="close">
                              <i class="icon-remove"></i>
                            </a>
                          </span>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                            <label for="id-date-picker-1"><span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                  </span>Escolliu la data:</label>

                                <div class="input-group">                                  
                                  <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $check_attendance_date;?>" />                                  
                                </div>
                            

                            <label for="timepicker1"><span class="input-group-addon">
                                <i class="icon-time bigger-110"></i>
                              </span>Escolliu la franja horaria</label>

                            <div class="input-group bootstrap-timepicker">
                              <select id="time_slots" data-placeholder="Escolliu la franja horaria">                                
                                <option value=""> </option>
                                <?php foreach ($time_slots as $time_slot_key => $time_slot): ?>
                                  <option value="<?php echo $time_slot_key;?>" <?php if ($selected_time_slot_key == $time_slot_key ) { echo 'selected="selected"';};?>>
                                    <?php echo $time_slot->range;?>
                                  </option>
                                <?php endforeach;?>
                              </select>  

                              
                            </div>

                          </div>
                        </div>
                      </div>

                <div class="span4 widget-container-span">
                  <div class="widget-box collapsed">
                    <div class="widget-header widget-header-small header-color-orange">
                      <h6>
                        <i class="icon-sort"></i>
                        Llistats de classe
                      </h6>

                      <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                          <i class="icon-chevron-down"></i>
                        </a>

                        <a href="#" data-action="close">
                          <i class="icon-remove"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">                        

                    <ol class="dd-list">
                      <li class="dd-item dd2-item" data-id="13">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Llista dels estudiants del grup (amb foto)</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Llista dels estudiants del grup (sense foto)</a></div>

                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Llençol amb les fotos dels estudiants</a></div>
                      </li>
                    </ol>






                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                

              <div class="span2"></div>
            </div>

<div class="space-8"></div>


<div class="row-fluid">

  <div class="table-header">
    <i class="icon-group"></i> 
    <div class="inline position-relative">
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_department_name;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($departments as $department_key => $department): ?>
                            <li <?php if ($selected_department_key == $department_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($selected_department_key == $department_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $department; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
    <i class="icon-double-angle-right"></i> 
    <div class="inline position-relative">
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_classroom_group_shortname;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($classroom_groups as $classroom_group_key => $classroom_group): ?>
                            <li <?php if ($selected_classroom_group_key == $classroom_group_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($selected_classroom_group_key == $classroom_group_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $classroom_group; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
    <i class="icon-double-angle-right"></i> 
    <div class="inline position-relative">
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_study_module_shortname;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($study_modules as $study_module_key => $study_module): ?>
                            <li <?php if ($selected_study_module_key == $study_module_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($selected_study_module_key == $study_module_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $study_module->name; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>

    <i class="icon-user" style="margin-left:50px;"></i> Alumnes: <?php echo " " . $total_number_of_students;?> 

    <i class="icon-calendar" style="margin-left:50px;"></i> Data: <?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date?>
    <a href="<?php echo base_url('/index.php/timetables/allgroupstimetables/' . $selected_classroom_group_key) ?>" style="text-decoration:none;color: inherit;"><i class="icon-calendar" style="margin-left:50px;"></i> Horari de grup</a>

    <div class="inline position-relative" style="float:right;color:#555;">
              Professor: <strong><?php echo $teacher_givenName . " " . $teacher_sn1 . " " . $teacher_sn2 . " ( codi: " . $teacher_code . " )";   ?></strong> | 
              Professors del grup: 
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_group_teacher;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($group_teachers as $group_teacher_key => $group_teacher): ?>
                            <li <?php if ($group_teachers_default_teacher_key == $group_teacher_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($group_teachers_default_teacher_key == $group_teacher_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $group_teacher->sn1 . " " . $group_teacher->sn2 . ", " . $group_teacher->givenName; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
  </div>


 <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead> 
                    <tr>
                      <th>Foto</th>
                      <th>#</th>
                      <th>Primer cognom</th>
                      <th>Segon cognom</th>
                      <th>Nom</th>
                      <th>
                        <i class="icon-user"></i> User 
                      </th>  
                      <th>
                        <i>@</i> Email 
                      </th>  


                      <?php foreach ( $time_slots as $time_slot_key => $time_slot): ?>

                        <th <?php if ( $selected_time_slot_id == $time_slot->id ) { echo 'class="red"';}?> ><center>
                             <span data-rel="tooltip" title="<?php echo $time_slot->range;?>" <?php if ( $selected_time_slot_id == $time_slot->id ) { echo 'class="bigger-120"';}?>>
                               <?php if ( $selected_time_slot_id == $time_slot->id ):?>
                                    <i class="icon-check bigger-120"></i>
                               <?php endif; ?>
                               <?php echo $time_slot->hour;?>
                             </span>
                             <?php if (isset ($time_slot->study_module_id)): ?>
                              <p>
                               <span class="label label-purple" data-rel="tooltip" 
                                title="<?php echo $time_slot->study_module_name . " ( " . $time_slot->study_module_id . " ). " . $time_slot->teacher_name . " ( " . $time_slot->teacher_code . " )";?>">
                                <i class="icon-group bigger-120"></i><?php echo $time_slot->study_module_shortname;?>
                               </span>
                              </p>
                              <div class="btn-group" id="btn_group_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id;?>">

                               <?php if (is_array ($time_slot->study_submodules)): ?>  
                                <?php foreach ( $time_slot->study_submodules as $study_submodule_key => $study_submodule): ?>
                                 <button style="font-size: x-small;" id="btn_group_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id?>_<?php echo $study_submodule_key;?>"
                                  class="btn btn-minier <?php if ($study_submodule->active) { echo 'btn-inverse'; } else { echo 'btn-grey'; }?>" data-rel="tooltip" onclick="study_submodule_on_click(this,'btn_group_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id;?>');"
                                  title="<?php echo $study_submodule->shortname . ". " . $study_submodule->name . " (" . $study_submodule_key . ") <br/>( " . $study_submodule->startdate . " - " . $study_submodule->finaldate . " )";?>" >
                                  <?php echo $study_submodule->shortname;?> 
                                    <i class="icon-check bigger-120" id="btn_group_icon_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id?>_<?php echo $study_submodule_key;?>" style="display:<?php if($study_submodule->active) { echo 'inline'; } else { echo 'none'; } ;?>"></i>
                                 </button> 
                                <?php endforeach; ?>
                               <?php endif; ?> 

                              </div>
                             <?php endif; ?>                             
                        </th>  

                      <?php endforeach; ?>
                      
                      <th class="hidden-480">Observacions</th>
                      <th>Accions&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                  </thead>

                  <tbody>
                    
                    <?php foreach ($classroom_group_students as $student_key => $student): ?>

                    <?php $student_fullname = $student->givenName . " " . $student->sn1 . " " . $student->sn2;?>
                    <tr>
                      <td>
                        <a class="image-thumbnail" href="<?php echo base_url($student->photo_url)?>">
                         <img data-rel="tooltip" style="max-width:35px;";
                          title="<?php echo $student_fullname;?>" class="msg-photo" alt="<?php echo $student_fullname;?>" 
                          src="<?php echo base_url($student->photo_url)?>"/>
                        </a>
                      </td>
                      <td>
                        <a href="<?php echo base_url('/index.php/persons/index/read/' . $student->person_id );?>"><?php echo $student->person_id;?></a>
                      </td>
                      <td>
                        <?php echo $student->sn1;?>
                      </td>
                      <td>
                        <?php echo $student->sn2;?>
                      </td>
                      <td>
                        <?php echo $student->givenName;?>
                      </td>
                      <td>
                        <div title="<?php echo $student->username . " ( " . $student->userid . ")";?>"><a href="<?php echo base_url('/index.php/users/index/read/' . $student->userid ) ;?>"><?php echo $student->username;?></a></div>
                      </td>
                      <td>
                        <?php echo $student->email;?>
                      </td> 

                      <?php foreach ( $time_slots as $time_slot_key => $time_slot): ?>

                        <td>
                          <?php //echo print_r($time_slot);?>

                          <?php if (isset ($time_slot->study_module_id)): ?>
                            <center>

                              <?php 
                              $active_study_submodule = null;
                              if (is_array($time_slot->study_submodules)) {
                                foreach ($time_slot->study_submodules as $study_submodules_key => $study_submodule) {
                                  if ($study_submodule->active) {
                                    $active_study_submodule = $study_submodule;
                                  }
                                }
                                
                              }
                                 
                              ?>
                             
                             <select altdata="<?php echo $active_study_submodule->id;?>" id="check_attendance_select_<?php echo $student->person_id ;?>_<?php echo $time_slot->id  ;?>_<?php echo $active_study_submodule->id ;?>" width="50" style="width: 50px" onchange="check_attendance_select_on_click(this,<?php echo $student->person_id;?>,<?php echo $time_slot->id;?>,<?php echo $day_of_week_number;?>)">
                              <option value="0">--</option>
                              <?php foreach ($incident_types as $incident_type_key => $incident_type): ?>
                                <option value="<?php echo $incident_type->code; ?>"><?php echo $incident_type->shortname; ?></option>
                              <?php endforeach;?> 
                            </select>

                            <?php if ( $selected_time_slot_id == $time_slot->id ):?>
                              <i class="icon-star red smaller-80"></i>      
                            <?php endif; ?>
                            </center>
                          <?php else: ?>                          
                              <center><i class="icon-remove gray smaller-80"></center></i>
                          <?php endif; ?>

                        </td>                        

                      <?php endforeach; ?>

                      <td class="hidden-480">
                        <textarea id="comments" class="autosize-transition span12" rows="1">TODO</textarea>
                      </td>

                      <td>
                        <div class="hidden-phone visible-desktop action-buttons">
                          <a class="blue" href="#">
                            <i class="icon-zoom-in bigger-130"></i>
                          </a>

                          <a class="green" href="#">
                            <i class="icon-pencil bigger-130"></i>
                          </a>

                          <a class="red" href="#">
                            <i class="icon-eye-close bigger-130"></i>
                          </a>
                        </div>

                        <div class="hidden-desktop visible-phone">
                          <div class="inline position-relative">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                              <i class="icon-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                              <li>
                                <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                  <span class="blue">
                                    <i class="icon-zoom-in bigger-120"></i>1
                                  </span>
                                </a>
                              </li>

                              <li>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                  <span class="green">
                                    <i class="icon-edit bigger-120"></i>
                                  </span>
                                </a>
                              </li>

                              <li>
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Ocultar">
                                  <span class="red">
                                    <i class="icon-eye-close bigger-120"></i>
                                  </span>
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach;?>
                  </tbody>
  </table>                

</div>
</div>
</div>
<script type="text/javascript">

function check_attendance_select_on_click(element,person_id,time_slot_id,day){
  id = element.id;
  study_submodule_id = $("#"+id).attr("altdata");
  selected_value = $("#"+id).val();
  previous_selected_value = $("#"+id).val();

  //DEBUG INFO:
  console.debug("check_attendance_select_on_click!!!");
  console.debug("id: " + id);
  console.debug("person_id: " + person_id);
  console.debug("time_slot_id: " + time_slot_id);
  console.debug("day: " + day);  
  console.debug("study_submodule_id: " + study_submodule_id);
  console.debug("selected_value: " + selected_value);

  //AJAX
  $.ajax({
    url:'<?php echo base_url("/index.php/attendance/crud_incidence");?>',
    type: 'post',
    data: {
        person_id : person_id,
        time_slot_id : time_slot_id,
        day : day,
        study_submodule_id: study_submodule_id,
        absence_type : selected_value  
    },
    datatype: 'json',
    statusCode: {
      404: function() {
        $.gritter.add({
          title: 'Error connectant amb el servidor!',
          text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/attendance/crud_incidence ' ,
          class_name: 'gritter-error gritter-center'
        });
      },
      500: function() {
        $("#response").html('A server-side error has occurred.');
        $.gritter.add({
          title: 'Error connectant amb el servidor!',
          text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/attendance/crud_incidence ' ,
          class_name: 'gritter-error gritter-center'
        });
      }
    },
    error: function() {
      $.gritter.add({
          title: 'Error!',
          text: 'Ha succeït un error!' ,
          class_name: 'gritter-error gritter-center'
        });
    },
  }).done(function(data){
    
    var all_data = $.parseJSON(data);
    result = all_data.result;
    result_message = all_data.message;

    if (result) {
      console.debug(result_message);
    } else {
      $.gritter.add({
        title: 'Error guardant la incidència a la base de dades!',
        text: 'No s\'ha pogut guardar la incidència. Missatge d\'error:  ' + result_message ,
        class_name: 'gritter-error gritter-center'
      });
    }

  });




}

function study_submodule_on_click(study_submodule_button,study_module_button_id) {
  id = study_submodule_button.id;
  //console.debug("click on study_submodule_on_click: " + id + " group: " + study_module_button_id);

  $('#' + study_module_button_id).children('button').each(function () {
    //console.debug(this.id); // "this" is the current element in the loop
    button_id = this.id;
    if ( button_id == id ) {
      $('#' + button_id).removeClass('btn-grey');
      $('#' + button_id).addClass('btn-inverse');
      $('#' + button_id).children('i').show();
    } else {
      $('#' + button_id).removeClass('btn-inverse');
      $('#' + button_id).addClass('btn-grey');
      $('#' + button_id).children('i').hide();
    }
    

});

}
      jQuery(function($) {

        //$(".check_attendance_select2").select2({placeholder: "Select report type", allowClear: true});
        
        var oTable1 = $('#sample-table-2').dataTable( {
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
        "aoColumns": [
            { "bSortable": false },null,null,null,null,null,null, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, null,
          { "bSortable": false }
        ] } );

  $('.date-picker').datepicker({
          format: "dd/mm/yyyy",
          weekStart: 1,
          todayBtn: true,
          language: "ca",
          daysOfWeekDisabled: "0,6",
          autoclose: true,
          todayHighlight: true
          }).next().on(ace.click_event, function(){
          $(this).prev().focus();
        });

  $('[data-rel=tooltip]').tooltip();
  //$('[data-rel=popover]').popover({html:true});        

  //Jquery select plugin: http://ivaynberg.github.io/select2/
  //$("#time_slots").select2();  

  //***********************
  //* Datepicker         **
  //*********************** 
  $('.input-append.date').datepicker({
      format: "dd/mm/yyyy",
      weekStart: 1,
      todayBtn: true,
      language: "ca",
      daysOfWeekDisabled: "0,6",
      autoclose: true,
      todayHighlight: true
    }).on("changeDate", function(e){
        teacher_code = $("#teachers").select2("val");
        selected_date = $('.input-append.date').datepicker('getDate');
        day=selected_date.getDate();
        month = parseInt(selected_date.getMonth());
        converted_month = month +1 ;
        year=selected_date.getFullYear();
        formated_selectedDate = day + "/" + converted_month + "/" + year;

        /*
        alert ( "Day: " + day);
        alert ( "Month: " + converted_month );
        alert ( "Year: " + year);
        */

        //var pathArray = window.location.pathname.split( '/' );
        //var secondLevelLocation = pathArray[1];
        //var  baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance";
        //alert(baseURL + "/" + selectedValue);
        //window.location.href = baseURL + "/" + teacher_code + "/" + formated_selectedDate;
    });
        
  })

  
  $('.image-thumbnail').fancybox(); 

</script>
