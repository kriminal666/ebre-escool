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
            <li class="active"><?php echo lang('timetable');?></li>
        </ul>
    </div><!-- /.breadcrumbs -->


    <div class="page-content">

        <div class="page-header position-relative">
            <h1>
                <?php echo "Horaris grups de classe";?>
                <small>
                    <i class="icon-double-angle-right"></i>
                    <span id="classroom_group_name"></span>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row-fluid">
            <div class="span4"></div>
            <div class="span4">
                <select id="cl_groups" style="width: 600px; left:-100px;">
                    <option></option>
                    <?php foreach( (array) $classroom_groups as $classroom_group_id => $classroom_group): ?>
                        <?php if( $classroom_group_id == $default_classroom_group): ?>
                            <option value="<?php echo $classroom_group_id; ?>" selected="selected"><?php echo $classroom_group; ?></option>
                        <?php else: ?> 
                            <option value="<?php echo $classroom_group_id; ?>" ><?php echo $classroom_group; ?></option>
                        <?php endif; ?> 
                    <?php endforeach; ?> 
                </select> 
            </div>
            <div class="span4"></div>
        </div>

        <div style="height: 10px;"></div>
        <center>
        <table border="0">
            <tr>
                <td>
                    <?php echo lang('show_legend'); ?> 
                </td>
                <td>
                    <input id="hide_show_legend" type="checkbox" class="switch-small" 
                    data-label-icon="icon-eye-open" 
                    data-on-label="<i class='icon-ok'></i>" 
                    data-off-label="<i class='icon-remove'></i>"
                    data-off="danger">
                </td>
            </tr>
            <tr>
                <td><?php echo "Mostrar llista de professors"; ?></td>
                <td>
                    <input id="hide_show_teachers_list" type="checkbox" class="switch-small" 
                    data-label-icon="icon-eye-open" 
                    data-on-label="<i class='icon-ok'></i>" 
                    data-off-label="<i class='icon-remove'></i>"
                    data-off="danger">    
                </td>    
            </tr>
        </table>
        </center>            
        
        <center>
            <strong>Hores totals setmanals:</strong> <?php echo $total_week_hours;?>
        </center>
        <center>
            <strong>Tutor:</strong> <?php echo $group_mentor->sn1 . " " . $group_mentor->sn2 . ", " . $group_mentor->givenName . " ( " . $group_mentor->code  . ")" ;?>
        </center>
        <div style="height: 10px;"></div>

        <div id="study_modules_legend" style="display: none;">
            <center>
                <table class="table table-striped table-bordered table-hover table-condensed" id="study_modules_legend_table" style="width:50%;">
                    <thead style="background-color: #d9edf7;">
                        <tr>
                            <td colspan="4" style="text-align: center;">
                                <h4><?php echo lang('legend');?></h4>
                            </td>
                        </tr>
                        <tr>
                            <!--<th><?php //echo lang('group');?></th>-->
                            <th><?php echo lang('lesson_id');?></th>
                            <th><?php echo lang('name');?></th>
                            <th><?php echo lang('hours_per_week');?></th>
                            <th><?php echo lang('hours_per_week_calc');?></th>
                        </tr>
                    </thead>
                    <tbody><?php $i=0; ?>
                        <?php foreach ($all_group_study_modules as $study_module) : ?>
                        <tr align="center" class="{cycle values='tr0,tr1'}">
                            <!--<td>TODO</td>-->
                            <td class="<?php echo $study_modules_colours[$study_module->study_module_id];?>">
                                <a href="study_module_info/<?php echo $study_module->study_module_shortname;?>"><?php echo $study_module->study_module_shortname;?></a>
                                <?php //echo $study_module->study_module_shortname;?>
                            </td>
                            <td>
                                <?php echo $study_module->study_module_name." - ".$study_module->study_module_id;?>
                            </td>
                            <td>
                                <?php echo $study_module->study_module_hoursPerWeek;?>
                            </td>
                            <td>
                                <?php echo $all_teacher_study_modules_hours_per_week[$i]; $i++;?>
                            </td>  
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </center>
        </div>

        <div style="height: 5px;"></div>

        <div id="teachers_list_legend" style="display: none;">
            <center>
                <table class="table table-striped table-bordered table-hover table-condensed" id="teachers_list_legend_table" style="width:50%;">
                    <thead style="background-color: #d9edf7;">
                        <tr>
                            <td colspan="4" style="text-align: center;">
                                <h4><?php echo "Llista de professors";?></h4>
                            </td>
                        </tr>
                        <tr>
                            <!--<th><?php //echo lang('group');?></th>-->
                            <th><?php echo "Codi";?></th>
                            <th><?php echo "Nom";?></th>
                            <th><?php echo "Mòduls";?></th>
                        </tr>
                    </thead>
                    <tbody><?php $i=0; ?>
                        <?php foreach ($all_group_teachers as $teacher) : ?>
                        <tr align="center" class="{cycle values='tr0,tr1'}">
                            <!--<td>TODO</td>-->
                            <td>
                                <?php echo $teacher->code;?>
                            </td>
                            <td>
                                <?php echo $teacher->sn1 . " " . $teacher->sn2 . ", " . $teacher->givenName;?>
                            </td>
                            <td>
                                <?php echo $teacher->study_modules;?>
                            </td>  
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </center>
        </div>

        <div style="height: 10px;"></div>

        <div id="group_timetable" class="timetable" data-days="5" data-hours="<?php echo $time_slots_count;?>">
            <ul class="tt-events">

                <?php $day_index = 0;?>
                <?php foreach ($days as $day) : ?>

                    <?php foreach ( $lessonsfortimetablebygroupid[$day->day_number] as $day_lessons) : ?>
                        <?php foreach ( $day_lessons as $day_lesson) : ?>
                            <?php 
                                if ($day_lesson->time_slot_lective) {
                                    @$bootstrap_button_colour = $study_modules_colours[$day_lesson->study_module_id];
                                } else {
                                    $bootstrap_button_colour = "btn-inverse";
                                }
                            $time_slot_current_position = $day_lesson->time_slot_order - $first_time_slot_order; ?> 

                            <li class="tt-event <?php echo $bootstrap_button_colour;?>" data-id="10" data-day="<?php echo $day->day_number - 1 ;?>" 
                            data-start="<?php echo $time_slot_current_position;?>" 
                            data-duration="<?php echo $day_lesson->duration;?>" style="margin-top:5px;">
                                <a href="<?php echo base_url('/index.php/curriculum/classroom_group/read') ."/". $day_lesson->group_id;?>"><?php echo $day_lesson->group_code;?></a>
                                <a href="<?php echo base_url('/index.php/curriculum/study_module/read') ."/". $day_lesson->study_module_id;?>"><?php echo $day_lesson->study_module_shortname;?></a><br/>
                                <a href="<?php echo base_url('/index.php/location/location/index/read') ."/". $day_lesson->location_id;?>"><?php echo $day_lesson->location_code;?></a>
                                <?php //DEBUG:echo $day_lesson->group_code;?>
                                <?php //echo $day_lesson->study_module_shortname;?>
                                <?php //echo $day_lesson->location_code;?> 
                                <?php echo @$day_lesson->study_module_id;?>
                            </li>
                        <?php endforeach; ?>

                    <?php endforeach; ?> 

                    <?php $day_index++;?> 

                <?php endforeach; ?>

            </ul>
            <div class="tt-times">
                <?php $time_slot_index = 0; ;?>
                <?php foreach ($time_slots as $time_slot_key => $time_slot) : ?>
                    <?php list($time_slot_start_time1, $time_slot_start_time2) = explode(':', $time_slot->time_slot_start_time); ;?>

                    <div class="tt-time" data-time="<?php echo $time_slot_index;?>">
                        <?php echo $time_slot_start_time1;?><span class="hidden-phone">:<?php echo $time_slot_start_time2;?></span>
                    </div>
                    <?php $time_slot_index++;?>
                <?php endforeach; ?>

            </div>

            <div class="tt-days">
                <?php $day_index = 0; ;?>
                <?php foreach ($days as $day) : ?>
                    <div class="tt-day" data-day="<?php echo $day_index;?>">
                        <?php echo $day->day_shortname;?>.
                    </div>
                    <?php $day_index++;?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="well">
            <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/deed.en_GB">
            <img alt="Creative Commons Licence" style="border-width: 0" src="http://i.creativecommons.org/l/by-nc-sa/2.0/uk/88x31.png" /></a><br />
            <?php echo lang('creative_commons_timetables_text');?>
        </div>
    </div>
</div>
<script>

$(function() {

//$('#hide_show_legend').bootstrapSwitch({});

//*****************************
//* CLASSROOMGROUP DROPDOWN  **
//*****************************

//Jquery select plugin: http://ivaynberg.github.io/select2/
$("#cl_groups").select2(); 

var theSelection = $("#cl_groups").select2('data').text;
$("#classroom_group_name").text(theSelection);

$('#cl_groups').on("change", function(e) {   

    selectedValue = $("#cl_groups").select2("val");
    var theSelection = $("#cl_groups").select2('data').text;
    $("#classroom_group_name").text(theSelection);
    var pathArray = window.location.pathname.split( '/' );
    var secondLevelLocation = pathArray[1];
    var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/timetables/allgroupstimetables";
//alert(baseURL + "/" + selectedValue);
window.location.href = baseURL + "/" + selectedValue;

});

$('#hide_show_legend').bootstrapSwitch({});

$('#hide_show_teachers_list').bootstrapSwitch({});

$('#hide_show_legend').on('switch-change', function (e, data) {
    var $element = $(data.el),
    value = data.value;
//console.log(e, $element, value);
$("#study_modules_legend").slideToggle();
});

$('#hide_show_teachers_list').on('switch-change', function (e, data) {
    var $element = $(data.el),
    value = data.value;
//console.log(e, $element, value);
$("#teachers_list_legend").slideToggle();
});

$('#study_modules_legend_table').dataTable( {
    "oLanguage": {
        "sProcessing":   "Processant...",
        "sLengthMenu":   "Mostra _MENU_ registres",
        "sZeroRecords":  "No s'han trobat registres.",
        "sInfo": "Mostrant de _START_ a _END_ de _TOTAL_ registres",
        "sInfoEmpty":"Mostrant de 0 a 0 de 0 registres",
        "sInfoFiltered": "(filtrat de _MAX_ total registres)",
        "sInfoPostFix":  "",
        "sSearch":   "Filtrar:",
        "sUrl":  "",
        "oPaginate": {
            "sFirst":"Primer",
            "sPrevious": "Anterior",
            "sNext": "Següent",
            "sLast": "Últim"
        }
    },
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,
});


$('#teachers_list_legend_table').dataTable( {
    "oLanguage": {
        "sProcessing":   "Processant...",
        "sLengthMenu":   "Mostra _MENU_ registres",
        "sZeroRecords":  "No s'han trobat registres.",
        "sInfo": "Mostrant de _START_ a _END_ de _TOTAL_ registres",
        "sInfoEmpty":"Mostrant de 0 a 0 de 0 registres",
        "sInfoFiltered": "(filtrat de _MAX_ total registres)",
        "sInfoPostFix":  "",
        "sSearch":   "Filtrar:",
        "sUrl":  "",
        "oPaginate": {
            "sFirst":"Primer",
            "sPrevious": "Anterior",
            "sNext": "Següent",
            "sLast": "Últim"
        }
    },
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,
});

});
</script>