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
  <?php echo lang('mentoring');?>
  <small>
   <i class="icon-double-angle-right"></i>
    <?php echo "Llistes de classe"; ?>
  </small>
 </h1>
</div>

<div style='height:10px;'></div>
  <div style="margin:10px;">

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


               <td><?php echo "Tutors"?>:</td>
               <td>

                <select id="select_class_list_mentor_filter">
                 <option value=""></option>
                <?php foreach ($mentors as $mentor_key => $mentor_value) : ?>
                  <option selected="selected" value="<?php echo $mentor_key ;?>"><?php echo $mentor_value->code . " - " .  $mentor_value->sn1 . " " . $mentor_value->sn2 . ", " . $mentor_value->givenName . " ( càrrec:" . $mentor_value->charge_full . " )" ;?></option>
                <?php endforeach; ?>
                </select> 

               </td>
               <td><?php echo "Grup de classe"?>:</td>
               <td>
                
                <select id="select_class_list_classgroup_filter">
                 <option value=""></option>
                <?php foreach ($all_classgroups as $classgroup_key => $classgroup_value) : ?>
                  <option selected="selected" value="<?php echo $classgroup_key ;?>"><?php echo $classgroup_value->code . " - " .  $classgroup_value->name;?></option>
                <?php endforeach; ?>
                </select> 




              </td>
            </tr>
          </thead>  
        </table> 

        <table class="table table-striped table-bordered table-hover table-condensed" id="class_list">
         <thead style="background-color: #d9edf7;">
          <tr>
            <td colspan="12" style="text-align: center;"> <h4>
              <a href="<?php echo base_url('/index.php/curriculum/user_ldaps') ;?>">
                <?php echo "Llista de classe"?>
              </a>
              </h4></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center;">Nom grup:</td>
            <td colspan="2" style="text-align: center;"> NOM </td>
            <td style="text-align: center;">Codi:</td>
            <td style="text-align: center;"> CODI </td>
            <td style="text-align: center;">Tutor:</td>
            <td style="text-align: center;"> TUTOR </td>
          </tr>
          <tr>
             <th><?php echo lang('mentoring_classlists_num')?></th>
             <th><?php echo lang('mentoring_classlists_photo')?></th>
             <th><?php echo lang('mentoring_classlists_student')?></th>
             <th><?php echo lang('mentoring_classlists_officialid')?></th>
             <th><?php echo lang('mentoring_classlists_username')?></th>
             <th><?php echo lang('mentoring_classlists_initial_password')?></th>
             <th><?php echo lang('mentoring_classlists_personal_email')?></th>
             <th><?php echo lang('mentoring_classlists_corporative_email')?></th>
          </tr>
         </thead>
         
        </table> 

    </div>

    <div class="space-30"></div>


</div>

<script>

var selected_classroom_group_id=3;

$(function() {

    $("#select_class_list_academic_period_filter").select2();

    $('#select_class_list_academic_period_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/reports/mentoring_classlists";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

    });

    $("#select_class_list_mentor_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un tutor", allowClear: true });

    $('#select_class_list_mentor_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_mentor_filter").select2("val");
        alert(selectedValue);

    });
    
    //classroom_group_id = 3;
    console.debug("selected_classroom_group_id: " + selected_classroom_group_id);
   
    var class_list_table = $('#class_list').DataTable( {
                      "bDestroy": true,
                      "sAjaxSource": "<?php echo base_url('index.php/reports/get_class_list');?>", 
                      "fnServerParams": function ( aoData ) {
                          aoData.push( { "name": "classroom_group_id", "value": selected_classroom_group_id });
                          aoData.push( { "name": "academic_period_id", "value": <?php echo $academic_period_id;?> });
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return data.number;
                                  }},
                        { "mData": function(data, type, full) {
                                    photos_base_url = "<?php echo base_url('/uploads/person_photos');?>";
                                    return '<img src="' + photos_base_url + '/' + data.photo_url + '" alt="foto alumne" style="width:75px;"></img>';
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.sn1 + " " + data.sn2 + ", " + data.givenName;
                                  }},
                        { "mData": "person_official_id" },
                        { "mData": "username" },
                        { "mData": "initial_password" },
                        { "mData": "personal_email" },
                        { "mData": "corporative_email" }
                      ],
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]], 
                      "sDom": 'TC<"clear">lfrtip',                    
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
                                              "sPdfMessage": "<?php echo lang("class_list");?>",
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

    $("#select_class_list_classgroup_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un grup de classe", allowClear: true });

    $('#select_class_list_classgroup_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_classgroup_filter").select2("val");
        console.debug("selectedValue: " + selectedValue)
        classroom_group_id = selectedValue;
        class_list_table.ajax.reload();
    });

});


</script>