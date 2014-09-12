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
  <li class="active"><?php echo lang('users');?></li>
 </ul>
</div>

<div class="page-header position-relative">
                <h1>
                    <?php echo lang("users_ldap");?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Usuaris ldap
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		


      <script>
      $(function(){

              //Jquery select plugin: http://ivaynberg.github.io/select2/
              $("#select_user_ldaps_academic_period_filter").select2();

              $('#select_user_ldaps_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_user_ldaps_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_user_ldaps";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              var all_ldap_users_table = $('#all_ldap_users').DataTable( {
                      "columnDefs": [
                                      { "type": "html", "targets": 3 }
                                    ],
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
                                              "sPdfMessage": "<?php echo lang("all_ldap_users");?>",
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

        $("#select_all_ldap_users_main_organizational_unit_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una unitat organitzativa", allowClear: true });

        $("#select_all_ldap_users_main_organizational_unit_filter").on( 'change', function () {
            var val = $(this).val();
            all_ldap_users_table.column(4).search( val , false, true ).draw();
        } );

        all_ldap_users_table.column(4).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_ldap_users_main_organizational_unit_filter").append( '<option value="'+ textToSearch  +'">'+ textToSearch +'</option>' )
        } );

});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_all_ldap_userss_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="6" style="text-align: center;"> <h4>Filtres per columnes
        </h4></td>
    </tr>
    <tr> 
       <td><?php echo "Unitat organitzativa"?>:</td>
       <td>
        <select id="select_all_ldap_users_main_organizational_unit_filter"><option value=""></option></select>
      </td>
    </tr>
  </thead>  
</table> 

<table class="table table-striped table-bordered table-hover table-condensed" id="all_ldap_users">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="13" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/user_ldaps') ;?>">
        <?php echo $user_ldap_table_title?>
      </a>
      </h4></td>
  </tr>
  <tr> 
     <th><?php echo lang('user_ldap_id')?></th>
     <th><?php echo lang('user_ldap_person_id')?></th>
     <th><?php echo lang('user_ldap_username')?></th>
     <th><?php echo lang('user_ldap_password')?></th>
     <th><?php echo lang('user_ldap_mainOrganizationaUnitId')?></th>
     <th><?php echo lang('user_ldap_ldap_dn')?></th>
     <th><?php echo lang('user_ldap_active')?></th>
  </tr>
 </thead>
 <tbody> 

  <!-- Iteration that shows user_ldaps-->

 <?php if (is_array($all_ldap_users) ) : ?>
  <?php foreach ($all_ldap_users as $user_ldap_key => $user_ldap) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">   
     <td>
      <a href="<?php echo base_url('/index.php/skeleton/users/read/' . $user_ldap->id ) ;?>">
          <?php echo $user_ldap->id;?>
      </a> 
      (<a href="<?php echo base_url('/index.php/skeleton/users/edit/' . $user_ldap->id ) ;?>">
          edit</a>)
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/persons/index/read/' . $user_ldap->person_id ) ;?>">
          <?php echo $user_ldap->person_sn1 . " " . $user_ldap->person_sn2  . ", " . $user_ldap->person_givenName;?>
      </a> 
      (<a href="<?php echo base_url('/index.php/persons/index/edit/' . $user_ldap->person_id ) ;?>">
          <?php echo $user_ldap->person_id;?>
      </a> )
     </td>

     <td>
      <?php echo $user_ldap->username;?>   
     </td>
     
     <td>
      <?php echo $user_ldap->password;?>   
     </td>

      <td>
       <?php echo $user_ldap->mainOrganizationaUnitId;?>   
      </td>

      <td>
       <?php echo $user_ldap->ldap_dn;?>   
      </td>   

      <td>

       <?php if ($user_ldap->ldap_dn === ""): ?>

        <label>
          <input name="switch-field-1" class="ace ace-switch" type="checkbox" />
          <span class="lbl"></span>
        </label> 

       <?php else: ?>       

        <label>
          <input name="switch-field-1" class="ace ace-switch ace-switch-4" type="checkbox" />
          <span class="lbl"></span>
        </label>

       <?php endif; ?>
        


      </td>   

   </tr>
  <?php endforeach; ?>
  <?php endif; ?>
 </tbody>
</table> 

</div>

<div class="space-30"></div>

	</div>	
</div>