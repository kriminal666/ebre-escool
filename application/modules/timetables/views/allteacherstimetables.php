<script>

$(function() {

    //*****************************
    //* CLASSROOMGROUP DROPDOWN  **
    //*****************************

    //Jquery select plugin: http://ivaynberg.github.io/select2/
    $("#teachers").select2(); 

    $('#teachers').on("change", function(e) {   
        selectedValue = $("#teachers").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/timetables/allteacherstimetables";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

    });

});

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
    });

</script>

<div class="container">
    <center>
        <select id="teachers" style="width: 400px">
            <option></option>
            <?php foreach( (array) $teachers as $teacher_id => $teacher): ?>
            <?php if( $teacher_id == $default_teacher): ?>
            <option value="<?php echo $teacher_id; ?>" selected="selected"><?php echo $teacher; ?></option>
            <?php else: ?> 
            <option value="<?php echo $teacher_id; ?>" ><?php echo $teacher; ?></option>
           <?php endif; ?> 
        <?php endforeach; ?> 
        </select> 
    </center>



        <header class="jumbotron subhead" id="overview"> 
			<h1>Horaris</h1>
		</header>
        <div class="timetable" data-days="5" data-hours="15">
            <ul class="tt-events">
				
                <?php $day_index = 0; ;?>
                <?php foreach ($days as $day) : ?>
                    <li class="tt-event btn-inverse" data-id="10" data-day="<?php echo $day_index;?>" data-start="4" data-duration="1" style="margin-top:5px;">
                        <?php echo strtoupper(lang("patio_break"));?>
                    </li>
                    <li class="tt-event btn-inverse" data-id="10" data-day="<?php echo $day_index;?>" data-start="7" data-duration="1" style="margin-top:5px;">
                        <?php echo strtoupper(lang("lunch_break"));?>
                    </li>
                    <li class="tt-event btn-inverse" data-id="10" data-day="<?php echo $day_index;?>" data-start="11" data-duration="1" style="margin-top:5px;">
                        <?php echo strtoupper(lang("patio_break"));?>
                    </li>
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
            <table class="table table-striped table-bordered table-hover table-condensed" id="groups_by_teacher_an_date" style="width:50%;">
                <thead style="background-color: #d9edf7;">
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <h4><?php echo "Llegenda";?></h4>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo "Codi assignatura";?></th>
                        <th><?php echo "Assignatura";?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center" class="{cycle values='tr0,tr1'}" id="tr_todo">
                        <td>
                            <?php echo "TODO CODI";?>
                        </td>
                        <td>
                            <?php echo "TODO NOM";?>
                        </td>
                    </tr>
                </tbody>
            </table>
            </center>
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
