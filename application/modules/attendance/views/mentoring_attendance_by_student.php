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
    <span id="title_teacher_name"></span>
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
          <tr>
            <td><label for="student">Selecciona l'alumne:</label></td>
            <td><select data-place_holder="TODO" id="selected_student" name="student" data-size="5" data-live-search="true">
              <option></option>
              <?php foreach ($students as $student_key => $student) { ?>
                <?php if ( $student_key == $default_student_key ) : ?>
                  <option enrollment_ids="<?php echo implode(',', $student->enrollments);?>" enrollment_classroom_groups="<?php echo implode(',', $student->enrolled_classroom_groups);?>" enrollment_classroom_groups_fullnames="<?php echo implode(',', $student->enrolled_classroom_groups_full_names);?>" selected="selected" value="<?php echo $student_key ?>" ><?php echo $student->fullname_alt; ?></option>
                <?php else: ?>  
                  <option enrollment_ids="<?php echo implode(',', $student->enrollments);?>" enrollment_classroom_groups="<?php echo implode(',', $student->enrolled_classroom_groups);?>" enrollment_classroom_groups_fullnames="<?php echo implode(',', $student->enrolled_classroom_groups_full_names);?>" value="<?php echo $student_key ?>" ><?php echo $student->fullname_alt; ?></option>  
                <?php endif;?>

              <?php } ?>
              </select> 
            </td>
          </tr> 
          <tr id="selected_classroom_group_tr" style="display:none;">
            <td><label for="classroom_group">Selecciona el grup de classe:</label></td>
            <td><select data-place_holder="TODO" id="selected_classroom_group" name="classroom_group" data-size="5" data-live-search="true">
              <option value="-1">---</option>
              </select> 
            </td>
          </tr> 
        </div>
      </table>
     </form>
    </div>






                  <div class="widget-box collapsed" id="student_statistics_widget-box">
                    <div class="widget-header widget-header-flat widget-header-small">
                      <h5>
                        <i class="icon-signal"></i>
                        <span class="green">Dades glogals Alumne. </span> <span class="green" id="selected_student_title"></span> &nbsp;&nbsp;&nbsp; Rang de dates: <span class="purple" id="selected_date_range"></span>
                      </h5>

                      <div class="widget-toolbar no-border">
                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                          Tot l'any
                          <i class="icon-angle-down icon-on-right"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-info pull-right dropdown-caret">
                          <li class="active">
                            <a href="#">Tot l'any</a>
                          </li>
                          <li >
                            <a href="#">Setmana actual</a>
                          </li>

                          <li>
                            <a href="#">Setmana anterior</a>
                          </li>

                          <li>
                            <a href="#">Més actual</a>
                          </li>

                          <li>
                            <a href="#">Altres mesos...</a>
                          </li>
                        </ul>
                      </div>
                      <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">
                        <div class="clearfix">
                          <div class="grid3">
                            <span class="grey">
                              <i class="icon-bell icon-2x red"></i>
                              &nbsp; Incidències totals
                            </span>
                            <h4 class="bigger pull-right"><span title="TODO" id="total_incidents_current_academic_period">---</span></h4>
                            <div class="space-6"></div>
                              <i class="icon-bell icon-2x purple"></i>
                              &nbsp; Tipus 
                            </span>
                            <h5 class="pull-right"><span title="TODO" id="total_incidents_current_academic_period_by_type">---</span></h4>
                            <div class="space-6"></div>
                              <i class="icon-bell icon-2x green"></i>
                              &nbsp; Dies 
                            </span>
                            <h5 class="smaller pull-right"><span title="TODO" id="total_incidents_by_day">---</span></h4>
                            <div class="space-6"></div>
                              <i class="icon-bell icon-2x orange2"></i>
                              &nbsp; Franjes h. 
                            </span>
                            <h5 class="smaller pull-right"><span title="TODO" id="total_incidents_by_time_slot">---</span></h4>
                          </div>

                          <div class="grid3">
                            <span class="grey">
                              <div id="piechart-placeholder1">MPs/Cs</div>
                          </div>

                          <div class="grid3">
                            <span class="grey">
                              <div id="piechart-placeholder">UFs/UDs</div>
                            </span>
                            
                          </div>
                        </div>

                        <div class="hr hr8 hr-double"></div>

                        <div class="clearfix">
                          <div class="grid3">
                            <span class="grey">
                              <div class="infobox infobox-orange2" style="width: 100%;" >
                                <div class="infobox-chart" style="width: 60px;">
                                  <span data-values="0,0,0,0,0" class="sparkline" id="sparkline_days"><canvas style="display: inline-block; width: 65px; height: 29px; vertical-align: top;" width="65" height="29"></canvas></span>
                                </div>

                                <div class="infobox-data" style="padding-left: 25px;">
                                  <span class="infobox-data-number" id="day_of_week_total">---</span>
                                  <div class="infobox-content">Dies de la setmana</div>
                                </div>
                              </div>  
                          </div>

                          <div class="grid3">
                            <span class="grey">
                              <div class="infobox infobox-red" style="width: 100%;" >
                                <div class="infobox-chart" style="width: 77px;">
                                  <span data-values="0,0,0,0,0" class="sparkline" id="sparkline_time_slots"><canvas style="display: inline-block; width: 77px; height: 29px; vertical-align: top;" width="77" height="29"></canvas></span>
                                </div>

                                <div class="infobox-data" style="padding-left: 25px;">
                                  <span class="infobox-data-number" id="time_slots_total">---</span>
                                  <div class="infobox-content">Franjes horàries. Torn: <span id="shift_span"></span></div>
                                </div>
                              </div>
                          </div>

                          <div class="grid3">
                            <span class="grey">
                               Pendent estadístiques Avaluació continuada
                          </div>
                        </div>

                      </div><!-- /widget-main -->
                    </div><!-- /widget-body -->
                  </div><!-- /widget-box -->











    <center><i id="spinner" class="icon-spinner icon-spin orange bigger-300" style="display: none;"></i></center>

    <!-- DEBUG --> 
    <?php //var_export($students);?>

    <div class="table-header" style="text-align:center;">
      Incidències
    </div>
    <table class="table table-striped table-bordered table-hover table-condensed" id="student_incidents">

       <thead style="background-color: #d9edf7;">
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

function get_selected_classroom_group_id() {
  var selected_classroom_group_id = $("#selected_classroom_group").select2("val");
  return selected_classroom_group_id;
}

function reload_incidents_statistics_by_student() {

  var selected_student = get_selected_student();
  var student_id = selected_student;
  var selected_classroom_group_id = get_selected_classroom_group_id();
  var classroom_group_id = selected_classroom_group_id;
  //AJAX. get_incidents_statistics_by_student
    $.ajax({
      url:'<?php echo base_url("index.php/attendance/get_incidents_statistics_by_student");?>',
      type: 'post',
      datatype: 'json',
      data: {
          student_id : student_id,
          classroom_group_id : classroom_group_id,
      },
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/attendance/get_incidents_statistics_by_student' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/attendance/get_incidents_statistics_by_student' ,
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
      data = $.parseJSON(data);
      
      //console.debug("totalIncidents: " + data.totalIncidents  );
      //console.debug("totalIncidents_current_academic_period: " + data.totalIncidents_current_academic_period );

      //$("#total_incidents").html(data.totalIncidents);
      $("#total_incidents_current_academic_period").html(data.totalIncidents_current_academic_period);
      $("#day_of_week_total").html(data.totalIncidents_current_academic_period);
      $("#time_slots_total").html(data.totalIncidents_current_academic_period);

      var str_total_incidents_current_academic_period_by_type="";
      $.each(data.incident_types, function( index, value ) {
        //console.debug( value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_current_academic_period_by_type = str_total_incidents_current_academic_period_by_type + "<strong>" + value.shortName + "</strong>: " + value.subtotal + " ";
      });
      $("#total_incidents_current_academic_period_by_type").html(str_total_incidents_current_academic_period_by_type);

      var str_total_incidents_by_day="";
      var str_array_total_incidents_by_day="";
      $.each(data.incident_days, function( index, value ) {
        //console.debug( value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_by_day = str_total_incidents_by_day + "<strong>" + value.shortName + "</strong>: " + value.subtotal + " ";
        str_array_total_incidents_by_day = str_array_total_incidents_by_day + value.subtotal + ",";
      });
      str_array_total_incidents_by_day = str_array_total_incidents_by_day.substring(0,str_array_total_incidents_by_day.length - 1);
      $("#total_incidents_by_day").html(str_total_incidents_by_day);
      $("#sparkline_days").attr("data-values",str_array_total_incidents_by_day);

      //Time slots
      var str_total_incidents_by_time_slot="";
      var str_array_total_incidents_by_time_slot="";
      $.each(data.incident_time_slots, function( index, value ) {
        //console.debug( value.external_code + " " + value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_by_time_slot = str_total_incidents_by_time_slot + "<span title=\"" + value.shortName +"\"><strong>" + value.external_code + "</strong></span>: " + value.subtotal + " ";
        str_array_total_incidents_by_time_slot = str_array_total_incidents_by_time_slot + value.subtotal + ",";
      });
      str_array_total_incidents_by_time_slot = str_array_total_incidents_by_time_slot.substring(0,str_array_total_incidents_by_time_slot.length - 1);
      
      $("#total_incidents_by_time_slot").html(str_total_incidents_by_time_slot);
      $("#sparkline_time_slots").attr("data-values",str_array_total_incidents_by_time_slot);

      $("#shift_span").html(data.shift.name);

      var date_range = data.initialDate + " - " + data.finalDate;
      $("#selected_date_range").html(date_range);

      $("#student_statistics_widget-box").removeClass("collapsed");
      update_statistics_graphs();

      //$("#").html(totalIncidents_current_academic_period);
    });

}

function update_statistics_graphs(){
  var $box = $('#sparkline_days').closest('.infobox');
  var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
  $('#sparkline_days').sparkline('html', {tagValuesAttribute:'data-values', type: 'bar',
    tooltipFormat: '{{offset:offset}} {{value}}',
    tooltipValueLookups: {
      'offset': {
          0: 'Dilluns',
          1: 'Dimarts',
          2: 'Dimecres',
          3: 'Dijous',
          4: 'Divendres',
     }
    }, barWidth: 12, barColor: barColor , chartRangeMin:$('#sparkline_time_slots').data('min') || 0} );

  var $box = $('#sparkline_time_slots').closest('.infobox');
  var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
  $('#sparkline_time_slots').sparkline('html', {tagValuesAttribute:'data-values', type: 'bar',
    tooltipFormat: '{{offset:offset}} {{value}}',
    tooltipValueLookups: {
      'offset': {
          0: 'F1',
          1: 'F2',
          2: 'F3',
          3: 'F4',
          4: 'F5',
     }
    }, barWidth: 12, barColor: barColor , chartRangeMin:$('#sparkline_time_slots').data('min') || 0} );
  

  // UF PIE CHART
  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
  var data = [
        { label: "UF1",  data: 38.7, color: "#68BC31"},
        { label: "UF2",  data: 24.5, color: "#2091CF"},
        { label: "UF3",  data: 8.2, color: "#AF4E96"},
        { label: "UF4",  data: 18.6, color: "#DA5430"},
        { label: "UF5",  data: 10, color: "#FEE074"}
        ];
  function drawPieChart(placeholder, data, position) {
    $.plot(placeholder, data, {
    series: {
      pie: {
        show: true,
        tilt:0.8,
        highlight: {
          opacity: 0.25
        },
        stroke: {
          color: '#fff',
          width: 2
        },
        startAngle: 2
      }
    },
    legend: {
      show: true,
      position: position || "ne", 
      labelBoxBorderColor: null,
      margin:[-30,15]
    }
    ,
    grid: {
      hoverable: true,
      clickable: true
    }
   })
   };

   drawPieChart(placeholder, data);

   /**
   we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
   so that's not needed actually.
   */
   placeholder.data('chart', data);
   placeholder.data('draw', drawPieChart);
  
  
  
    var $tooltip = $("<div class='tooltip top in hide'><div class='tooltip-inner'></div></div>").appendTo('body');
    var previousPoint = null;
  
    placeholder.on('plothover', function (event, pos, item) {
    if(item) {
      if (previousPoint != item.seriesIndex) {
        previousPoint = item.seriesIndex;
        var tip = item.series['label'] + " : " + item.series['percent']+'%';
        $tooltip.show().children(0).text(tip);
      }
      $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
    } else {
      $tooltip.hide();
      previousPoint = null;
    }
    
   });

  // END UF PIE CHART

  // MP PIE CHART
  var placeholder1 = $('#piechart-placeholder1').css({'width':'90%' , 'min-height':'150px'});
  var data1 = [
        { label: "MP1",  data: 38.7, color: "#68BC31"},
        { label: "MP2",  data: 24.5, color: "#2091CF"},
        { label: "MP3",  data: 8.2, color: "#AF4E96"},
        { label: "MP4",  data: 18.6, color: "#DA5430"},
        { label: "MP5",  data: 10, color: "#FEE074"}
        ];
  drawPieChart(placeholder1, data1);

   /**
   we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
   so that's not needed actually.
   */
   placeholder1.data('chart', data);
   placeholder1.data('draw', drawPieChart);

   placeholder1.on('plothover', function (event, pos, item) {
    if(item) {
      if (previousPoint != item.seriesIndex) {
        previousPoint = item.seriesIndex;
        var tip = item.series['label'] + " : " + item.series['percent']+'%';
        $tooltip.show().children(0).text(tip);
      }
      $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
    } else {
      $tooltip.hide();
      previousPoint = null;
    }
    
   });  
  // END MP PIE CHART
}


$(function() { 

  $("#select_class_list_academic_period_filter").select2({dropdownAutoWidth: 'true'});

  $("#selected_student").select2({placeholder: "Seleccioneu un alumne...",allowClear: true,dropdownAutoWidth: 'true'});

  $("#selected_classroom_group").select2({placeholder: "Seleccioneu un grup de classe...",allowClear: true,dropdownAutoWidth: 'true'});

  

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
        //console.debug("selected_student: " + selected_student);

        selected_student_text = "";
        if (selected_student != "") {
          var selected_student_text = $("#selected_student").select2('data').text;
        }        
        //console.debug("selected_student onchange: " + selected_student);
        $("#selected_student_title").html(selected_student_text);

        if (selected_student != "") {
          $("#selected_classroom_group_tr").show();

          //POPULATE classroom_group SELECT2 id: selected_classroom_group
          // Info ara in options :
          // Example1:                   <option enrollment_ids="6012" enrollment_classroom_groups="53" value="3933" >Abdelghani , Carxofa - X3480024P ( 3333 )</option>  
          // Example2: <option enrollment_ids="6010,4577" enrollment_classroom_groups="34,43" value="2930" >Abella Pepiton, Marco - 45670085N ( 2933 )</option>  

          var enrollment_classroom_groups = $("option[value='" + selected_student + "']").attr("enrollment_classroom_groups");        
          var enrollment_classroom_groups_fullnames = $("option[value='" + selected_student + "']").attr("enrollment_classroom_groups_fullnames");
          var enrollment_ids = $("option[value='" + selected_student + "']").attr("enrollment_ids");  


          //console.debug("enrollment_ids: " + enrollment_ids);      
          //console.debug("enrollment_classroom_groups: " + enrollment_classroom_groups); 

          $('#selected_classroom_group').find('option').remove();

          var enrollment_classroom_groupsSplit= enrollment_classroom_groups.split(',');
          var enrollment_classroom_groupsFullNamesSplit= enrollment_classroom_groups_fullnames.split(',');
          $.each(enrollment_classroom_groupsSplit,function(enrollment_classroom_group_id){
                //console.debug("enrollment_classroom_group_id: " + enrollment_classroom_groupsSplit[enrollment_classroom_group_id]);
                $("#selected_classroom_group").append('<option value="'+enrollment_classroom_groupsSplit[enrollment_classroom_group_id]+'">'+enrollment_classroom_groupsFullNamesSplit[enrollment_classroom_group_id]+'</option>');
          });
          
          $("#selected_classroom_group").select2("val", enrollment_classroom_groupsSplit[0]);
          $("#selected_classroom_group").select2();

          reload_incidents_statistics_by_student();

        } else {
          $("#student_statistics_widget-box").addClass("collapsed");
        }

        //Reload datatables
        student_incidents_table.ajax.reload();
});

$('#selected_classroom_group').on("change", function(e) { 
      var selected_student = $("#selected_classroom_group").select2("val");
      console.debug("selected_classroom_group: " + selected_classroom_group);

      reload_incidents_statistics_by_student();
      //Reload datatables
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
                          aoData.push( { "name": "classroom_group_id", "value": get_selected_classroom_group_id() });
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
                  "sDom": 'TRfC<"clear">lrtip', 
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