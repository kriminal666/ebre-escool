<script type="text/javascript">

$(function() {



    $.fn.showHide = function (options) {
 
    //default vars for the plugin
        var defaults = {
            speed: 1000,
            easing: '',
            changeText: 0,
            showText: 'Show',
            hideText: 'Hide'
 
        };
        var options = $.extend(defaults, options);
 
        $(this).click(function () {
// optionally add the class .toggleDiv to each div you want to automatically close
                      $('.toggleDiv').slideUp(options.speed, options.easing);
             // this var stores which button you've clicked
             var toggleClick = $(this);
             // this reads the rel attribute of the button to determine which div id to toggle
             var toggleDiv = $(this).attr('rel');
             // here we toggle show/hide the correct div at the right speed and using which easing effect
             $(toggleDiv).slideToggle(options.speed, options.easing, function() {
             // this only fires once the animation is completed
             if(options.changeText==1){
             $(toggleDiv).is(":visible") ? toggleClick.text(options.hideText) : toggleClick.text(options.showText);
             }
              });
 
          return false;
 
        });
 
    };

    //***************************
    //* CHECK ATTENDANCE TABLE **
    //***************************

     $('#study_modules_legend_table').dataTable( {
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
                "bFilter": false,
        "bInfo": false,
        });

});

</script>

<div class="container">
        <header class="jumbotron subhead" id="overview"> 
			<h3><?php echo lang("mytimetables_teacher_timetable_title") .": ". $teacher_full_name . 
            " ( ". lang("mytimetables_teacher_timetable_code") . ": ". $teacher_code . " )";?> </h3>
		</header>
        
        <div class="timetable" data-days="5" data-hours="15">
            <ul class="tt-events">
                
                <?php $day_index = 0; ;?>
                <?php foreach ($days as $day) : ?>
                    
                    <?php foreach ( $lessonsfortimetablebyteacherid[$day->day_number] as $day_lessons) : ?>
                        <?php foreach ( $day_lessons as $day_lesson) : ?>
                            <?php 
                            if ($day_lesson->time_slot_lective) {
                                $bootstrap_button_colour = "btn-inverse";
                            } else {
                                $bootstrap_button_colour = $study_modules_colours[$day_lesson->study_module_id];
                            }

                            ?> 
                            <li class="tt-event <?php echo $bootstrap_button_colour;?>" data-id="10" data-day="<?php echo $day->day_number - 1 ;?>" 
                                data-start="<?php echo $day_lesson->time_slot_order - 1 ;?>" 
                                data-duration="<?php echo $day_lesson->duration;?>" style="margin-top:5px;">
                                <?php echo $day_lesson->group_code;?> <?php echo $day_lesson->study_module_shortname;?><br/>
                                <?php echo $day_lesson->location_code;?>
                            </li>
                        <?php endforeach; ?>



                    <?php endforeach; ?> 
                    
                    <?php $day_index++;?> 

                <?php endforeach; ?>

            </ul>
            <div class="tt-times">
                <?php $time_slot_index = 0; ;?>
                <?php foreach ($all_time_slots as $time_slot_key => $time_slot) : ?>
                    <?php
                    list($time_slot_start_time1, $time_slot_start_time2) = explode(':', $time_slot->time_slot_start_time);
                    ;?>

                    <div class="tt-time" data-time="<?php echo $time_slot_index;?>">
                        <?php echo $time_slot_start_time1;?><span class="hidden-phone">:<?php echo $time_slot_start_time2;?></span></div>
                    <?php $time_slot_index++;?>    
                <?php endforeach; ?>

            </div>
            <div class="tt-days">
                <?php $day_index = 0; ;?>
                <?php foreach ($days as $day) : ?>
                    <div class="tt-day" data-day="<?php echo $day_index;?>">
                        <?php echo $day->day_shortname;?>.</div>
                    <?php $day_index++;?>    
                <?php endforeach; ?>
            </div>
        </div>

        <div id="study_modules_legend">
            <center>
            <table class="table table-striped table-bordered table-hover table-condensed" id="study_modules_legend_table" style="width:50%;">
                <thead style="background-color: #d9edf7;">
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            <h4><?php echo "Llegenda";?></h4>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo "Grup";?></th>
                        <th><?php echo "Codi assignatura";?></th>
                        <th><?php echo "Nom";?></th>
                        <th><?php echo "Hores setmanals";?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_teacher_study_modules as $study_module) : ?>
                        <tr align="center" class="{cycle values='tr0,tr1'}">
                            <td>
                                <?php echo "TODO";?>
                            </td>
                            <td>
                                <?php echo $study_module->study_module_shortname;?>
                            </td>
                            <td>
                                <?php echo $study_module->study_module_name;?>
                            </td>
                            <td>
                                <?php echo $study_module->study_module_hoursPerWeek;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
            </center>
        </div>
        
        
        Horaris dels grups:<br/>
        
        <div class="row">
			
            <div class="span6">
				<b>2 ASIX (exemple fals grup matí):</b>
                <div class="timetable" data-days="5" data-hours="7">
                    <ul class="tt-events">
                     <li class="tt-event btn-inverse" data-id="10" data-day="0" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="1" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="2" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="3" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="4" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                    </ul>
                    <div class="tt-times">
                        <div class="tt-time" data-time="0">
                            8</div>
                        <div class="tt-time" data-time="1">
                            9</div>
                        <div class="tt-time" data-time="2">
                            10</div>
                        <div class="tt-time" data-time="3">
                            11</div>
                        <div class="tt-time" data-time="4">
                            11:30</div>    
                        <div class="tt-time" data-time="5">
                            12:30</div>
                        <div class="tt-time" data-time="6">
                            13:30</div>
                    </div>
                    <div class="tt-days">
                        <div class="tt-day" data-day="0">
							Dl.</div>
						<div class="tt-day" data-day="1">
							Dt.</div>
						<div class="tt-day" data-day="2">
							Dc.</div>
						<div class="tt-day" data-day="3">
							Dj.</div>
						<div class="tt-day" data-day="4">
							Dv.</div>
						</div>
                </div>
            </div>
            
            <div class="span6">
				<b>2 DAW:</b>
                <div class="timetable" data-days="5" data-hours="7">
                    <ul class="tt-events">
                     <li class="tt-event btn-inverse" data-id="10" data-day="0" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="1" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="2" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="3" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                     <li class="tt-event btn-inverse" data-id="10" data-day="4" data-start="3" data-duration="1">
                      DESCANS
                     </li>
                    </ul>
                    <div class="tt-times">
                        <div class="tt-time" data-time="0">
                            15:30</div>
                        <div class="tt-time" data-time="1">
                            16:30</div>
                        <div class="tt-time" data-time="2">
                            17:30</div>
                        <div class="tt-time" data-time="3">
                            18:30</div>
                        <div class="tt-time" data-time="4">
                            19:00</div>    
                        <div class="tt-time" data-time="5">
                            20:00</div>
                        <div class="tt-time" data-time="6">
                            21:00</div>
                    </div>
                    <div class="tt-days">
                        <div class="tt-day" data-day="0">
							Dl.</div>
						<div class="tt-day" data-day="1">
							Dt.</div>
						<div class="tt-day" data-day="2">
							Dc.</div>
						<div class="tt-day" data-day="3">
							Dj.</div>
						<div class="tt-day" data-day="4">
							Dv.</div>
						</div>
                </div>
            </div>
        </div>    
            
            
        <div class="well">
            <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/deed.en_GB">
                <img alt="Creative Commons Licence" style="border-width: 0" src="http://i.creativecommons.org/l/by-nc-sa/2.0/uk/88x31.png" /></a><br />
            Els horaris s'han fet utilitzant l'obra de <a target="_blank" href="http://twitter.com/Ben_Lowe">Ben Lowe</a> de 
            <a target="_blank" href="http://www.triballabs.net">Tribal Labs</a> amb una llicència <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/deed.en_GB">
                Creative Commons Attribution-NonCommercial-ShareAlike 2.0 UK: England &amp; Wales
                License</a>.
        </div>
</div>
