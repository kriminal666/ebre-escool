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
  <li class="active">Passar llista. Grup classe</li>
 </ul>
</div>

<div class="page-content">
<div class="page-header position-relative">
 <h1>
  Grup classe
  <small>
   <i class="icon-double-angle-right"></i>
    <?php echo "(" . $selected_classroom_group_shortname . ") " . $selected_classroom_group;?>
  </small>
 </h1>
</div>
<div class="space-3"></div>

              <div class="row-fluid">
                <div class="span1"></div>

                <div class="widget-box span5 collapsed">
                        <div class="widget-header widget-header-small header-color-green">
                          <h6>Data i franja horaria: <?php echo $selected_day . " " . $selected_time_slot;?></h6>

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
                            <label for="id-date-picker-1">Escolliu la data:</label>

                                <div class="input-group">
                                  <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $selected_day;?>" />
                                  <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                  </span>
                                </div>
                            

                            <label for="timepicker1">Escolliu la franja horaria</label>

                            <div class="input-group bootstrap-timepicker">
                              <input id="timepicker1" type="text" class="form-control" />
                              <span class="input-group-addon">
                                <i class="icon-time bigger-110"></i>
                              </span>
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
    <i class="icon-table"></i> 
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
                                <?php echo $study_module; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>

    <i class="icon-user" style="margin-left:50px;"></i> Alumnes: <?php echo " " . $total_number_of_students;?> 

    <div class="inline position-relative" style="float:right;">
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
                                <?php echo $group_teacher; ?>
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
                      <th>15:30</th>
                      <th>16:30</th>
                      <th>17:30</th>
                      <th>19:00</th>
                      <th>20:00</th>
                      <th>21:00</th>
                      <th class="hidden-480">Observacions</th>
                      <th>Accions&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td>
                        <img src="<?php echo base_url('/assets/avatars/avatar3.png')?>" class="msg-photo" alt="Pepe's Avatar" />
                      </td>
                      <td>
                        <a href="#">1</a>
                      </td>
                      <td>
                        <a href="#">Adell</a>
                      </td>
                      <td>
                        <a href="#">Girbes</a>
                      </td>
                      <td>
                        <a href="#">Julià</a>
                      </td>
                      <td>
                        <a href="#">juliaadell</a>
                      </td>
                      <th>
                        <a href="#">juliadell@email.com</a>                      
                      </th> 
                      <td><select id="form-field-select-1" width="50" style="width: 50px">
                              <option value="">&nbsp;</option>
                              <option value="1">F</option>
                              <option value="2">FJ</option>
                              <option value="3">R</option>
                              <option value="4">RJ</option>
                              <option value="5">E</option>                              
                            </select></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>
                            <select id="form-field-select-1" width="50" style="width: 50px">
                              <option value="">&nbsp;</option>
                              <option value="1">F</option>
                              <option value="2">FJ</option>
                              <option value="3">R</option>
                              <option value="4">RJ</option>
                              <option value="5">E</option>                              
                            </select>
                      </td>

                      <td class="hidden-480">
                        <textarea id="comments" class="autosize-transition span12" rows="1"></textarea>
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
                                    <i class="icon-zoom-in bigger-120"></i>
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


                    <tr>
                      <td>
                        <img src="<?php echo base_url('/assets/avatars/avatar1.png')?>" class="msg-photo" alt="Sergi's Avatar" />
                      </td>
                      <td>
                        <a href="#">2</a>
                      </td>
                      <td>
                        <a href="#">Blanch</a>
                      </td>
                      <td>
                        <a href="#">Garzon</a>
                      </td>
                      <td>
                        <a href="#">Manuel</a>
                      </td>
                      <td>
                        <a href="#">manuelblanch</a>
                      </td>
                      <th>
                        <a href="#">manuelblanch@email.com</a>                      
                      </th>
                      <td><select id="form-field-select-1" width="50" style="width: 50px">
                              <option value="">&nbsp;</option>
                              <option value="1">F</option>
                              <option value="2">FJ</option>
                              <option value="3">R</option>
                              <option value="4">RJ</option>
                              <option value="5">E</option>                              
                            </select></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><select id="form-field-select-1" width="50" style="width: 50px">
                              <option value="">&nbsp;</option>
                              <option value="1">F</option>
                              <option value="2">FJ</option>
                              <option value="3">R</option>
                              <option value="4">RJ</option>
                              <option value="5">E</option>                              
                            </select></td>

                      <td class="hidden-480">
                        <textarea id="form-field-11" class="autosize-transition span12" rows="1"></textarea>
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
                            <i class="icon-trash bigger-130"></i>
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
                                    <i class="icon-zoom-in bigger-120"></i>
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
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                  <span class="red">
                                    <i class="icon-trash bigger-120"></i>
                                  </span>
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </td>
                    </tr>



                    <tr>
                      <td>
                        <img src="<?php echo base_url('/assets/avatars/avatar4.png')?>" class="msg-photo" alt="Pepe's Avatar" />
                      </td>
                      <td>
                        <a href="#">3</a>
                      </td> 

                      <td>
                        <a href="#">Borrell</a>
                      </td>
                      <td>
                        <a href="#">Sanchez</a>
                      </td>
                      <td>
                        <a href="#">Josep Francesc</a>
                      </td>
                      <td>
                        <a href="#">josepborrell</a>
                      </td>
                      <th>
                        <a href="#">josepborrell@email.com</a>                      
                      </th>
                      <td><select id="form-field-select-1" width="50" style="width: 50px">
                              <option value="">&nbsp;</option>
                              <option value="1">F</option>
                              <option value="2">FJ</option>
                              <option value="3">R</option>
                              <option value="4">RJ</option>
                              <option value="5">E</option>                              
                            </select></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><select id="form-field-select-1" width="50" style="width: 50px">
                              <option value="">&nbsp;</option>
                              <option value="1">F</option>
                              <option value="2">FJ</option>
                              <option value="3">R</option>
                              <option value="4">RJ</option>
                              <option value="5">E</option>                              
                            </select></td>

                      <td class="hidden-480">                        
                        <textarea id="form-field-11" class="autosize-transition span12" rows="1"></textarea>
                      </td>

                      <td>
                        <span class="label label-warning">Expiring</span>
                        <div class="hidden-phone visible-desktop action-buttons">
                          <a class="blue" href="#">
                            <i class="icon-zoom-in bigger-130"></i>
                          </a>

                          <a class="green" href="#">
                            <i class="icon-pencil bigger-130"></i>
                          </a>

                          <a class="red" href="#">
                            <i class="icon-trash bigger-130"></i>
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
                                    <i class="icon-zoom-in bigger-120"></i>
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
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                  <span class="red">
                                    <i class="icon-trash bigger-120"></i>
                                  </span>
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
  </table>                

</div>
</div>
</div>
<script type="text/javascript">
      jQuery(function($) {
        
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
</script>