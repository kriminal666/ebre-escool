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
                    Usuaris Google Apps
                    <small>
                        <i class="icon-double-angle-right"></i>
                        consulta i operacions
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		
      <script>

      var all_google_apps_users_table;

      $(function(){

              $("#select_class_list_academic_period_filter").select2();

              $("#academic_period_text").text( $("#select_class_list_academic_period_filter").select2("data").text);

              $('#select_class_list_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/users_ldap";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;
              });

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

              var selectedAP = $("#select_class_list_academic_period_filter").select2("val");


              /*
              <th>&nbsp;</th> 
               <th>Id</th>
               <th>Etag</th>
               <th>Kind</th>
               <th>primaryEmail</th>
               <th>givenName</th>
               <th>familyName</th>
               <th>isAdmin</th>
               <th>isDelegatedAdmin</th>
               <th>lastLoginTime</th>
               <th>creationTime</th>
               <th>deletionTime</th>
               <th>agreedToTerms</th>
               <th>password</th>
               <th>hashFunction</th>
               <th>suspended</th>
               <th>suspensionReason</th>
               <th>changePasswordAtNextLogin</th>
               <th>ipWhitelisted</th>
               <th>customerId</th>
               <th>orgUnitPath</th>
               <th>isMailboxSetup</th>
               <th>includeInGlobalAddressList</th>
               <th>thumbnailPhotoUrl</th>
              */

              var all_google_apps_users_table = $('#all_google_apps_users').DataTable( {
                      "bDestroy": true,
                      "sAjaxSource": "<?php echo base_url('index.php/managment/get_users_google_apps/');?>/" + selectedAP,
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    //return data.last_modification_user;
                                    return "checbox";
                                  }},                      
                        { "mData": function(data, type, full) {
                            return "Id";            
                        }},    
                        { "mData": function(data, type, full) {
                            return "Etag";            
                        }},    
                        { "mData": function(data, type, full) {
                            return "Kind";            
                        }},    
                        { "mData": function(data, type, full) {
                            return "primaryEmail";            
                        }},    
                        { "mData": function(data, type, full) {
                            return "givenName";            
                        }},    
                        { "mData": function(data, type, full) {
                            return "familyName";            
                        }},
                        { "mData": function(data, type, full) {
                            return "isAdmin";            
                        }}, 
                        { "mData": function(data, type, full) {
                            return "isDelegatedAdmin";            
                        }}, 
                        { "mData": function(data, type, full) {
                            return "lastLoginTime";            
                        }}, 
                        { "mData": function(data, type, full) {
                            return "creationTime";            
                        }}, 
                        { "mData": function(data, type, full) {
                            return "deletionTime";            
                        }},
                        { "mData": function(data, type, full) {
                            return "agreedToTerms";            
                        }},  
                        { "mData": function(data, type, full) {
                            return "deletionTime";            
                        }},  
                        { "mData": function(data, type, full) {
                            return "password";            
                        }},  
                        { "mData": function(data, type, full) {
                            return "hashFunction";            
                        }},  
                        { "mData": function(data, type, full) {
                            return "suspended";            
                        }},  
                        { "mData": function(data, type, full) {
                            return "suspensionReason";            
                        }}, 
                        { "mData": function(data, type, full) {
                            return "changePasswordAtNextLogin";            
                        }},   
                        { "mData": function(data, type, full) {
                            return "ipWhitelisted";            
                        }},   
                        { "mData": function(data, type, full) {
                            return "orgUnitPath";            
                        }},   
                        { "mData": function(data, type, full) {
                            return "isMailboxSetup";            
                        }},   
                        { "mData": function(data, type, full) {
                            return "includeInGlobalAddressList";            
                        }},   
                        { "mData": function(data, type, full) {
                            return "thumbnailPhotoUrl";            
                        }},                             
                      ],
                      "columnDefs": [
                                      { "type": "html", "targets": 3 }
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
                                              "sPdfMessage": "<?php echo lang("all_google_apps_users");?>",
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

        $("#select_all").click(function() {

          $('input:checkbox').map(function () {
            this.checked = true;
          }).get(); 
          
        });

        $("#unselect_all").click(function() {

          $('input:checkbox').map(function () {
            this.checked = false;
          }).get(); 
          
        });

      
        $("#sync_mysql_password_to_ldap").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta sincronització massiva de paswords de MySQL a Ldap?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/sync_mysql_password_to_ldap");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/sync_mysql_password_to_ldap' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/sync_mysql_password_to_ldap ' ,
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
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_google_apps_users_table));
                    all_google_apps_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });



        $("#interchange_windows_passwords").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta operació de intercanviar paraules de pas Windows de forma massiva?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/interchange_windows_passwords");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/interchange_windows_passwords' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/interchange_windows_passwords ' ,
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
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_google_apps_users_table));
                    all_google_apps_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });

      $("#avoid_change_of_password_on_windows").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta operació de forma massiva?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/avoid_change_of_password_on_windows");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/avoid_change_of_password_on_windows' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/avoid_change_of_password_on_windows ' ,
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
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_google_apps_users_table));
                    all_google_apps_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });
        

        $("#sync_mysql_ldap").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta sincronització massiva de MySQL a Ldap?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/sync_mysql_ldap");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/sync_mysql_ldap' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/sync_mysql_ldap ' ,
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
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_google_apps_users_table));
                    all_google_apps_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });

        
        $("#assign_ldap_rol").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta modificació massiva d'assignació de rols?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/assign_multiple_ldap_roles");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/assign_multiple_ldap_roles' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/assign_multiple_ldap_roles ' ,
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
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_google_apps_users_table));
                    all_google_apps_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });


        $("#create_multiple_initial_passwords").click(function() {

                var txt;
                var r = confirm("Esteu segurs que voleu fer aquesta modificació massiva de paraules de pas dels usuaris? Els usuaris ja no podran entrar al sistema fins que no els entregueu la nova paraula de pas!");
                if (r == true) {

                    var values = $('input:checkbox:checked.ace').map(function () {
                      return this.id;
                    }).get(); 
                    
                    //AJAX
                    $.ajax({
                    url:'<?php echo base_url("index.php/managment/create_multiple_initial_passwords");?>',
                    type: 'post',
                    data: {
                        values: values,
                    },
                    datatype: 'json',
                    statusCode: {
                      404: function() {
                        $.gritter.add({
                          title: 'Error connectant amb el servidor!',
                          text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/create_multiple_initial_passwords' ,
                          class_name: 'gritter-error gritter-center'
                        });
                      },
                      500: function() {
                        $("#response").html('A server-side error has occurred.');
                        $.gritter.add({
                          title: 'Error connectant amb el servidor!',
                          text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/create_multiple_initial_passwords ' ,
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
                    success: function(data) {
                      //console.debug("data:" + JSON.stringify(data));
                      //console.debug(JSON.stringify(all_google_apps_users_table));
                      all_google_apps_users_table.ajax.reload();
                    }
                  }).done(function(data){
                      //TODO: Something to check?
                  
                  });
                }

                
                

        });

        $("#select_all_google_apps_users_main_organizational_unit_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una unitat organitzativa", allowClear: true });

        $("#select_all_google_apps_users_main_organizational_unit_filter").on( 'change', function () {
            var val = $(this).val();
            all_google_apps_users_table.column(5).search( val , false, true ).draw();
        } );

        all_google_apps_users_table.column(5).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_google_apps_users_main_organizational_unit_filter").append( '<option value="'+ textToSearch  +'">'+ textToSearch +'</option>' )
        } );

        $("#select_all_google_apps_users_user_type_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un tipus d'usuari", allowClear: true });

        $("#select_all_google_apps_users_user_type_filter").on( 'change', function () {
          console.debug("TEST");
            var val = $(this).val();
            all_google_apps_users_table.column(6).search( val  , false, true ).draw();
        } );

        all_google_apps_users_table.column(6).data().unique().sort().each( function ( d, j ) {
              $("#select_all_google_apps_users_user_type_filter").append( '<option value="'+ d  +'">'+ d +'</option>' )
        } );

});
</script>

<div class="container">

<table style="display: none;" class="table table-striped table-bordered table-hover table-condensed" id="all_google_apps_users_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="6" style="text-align: center;"> <strong>Filtres per columnes
        </strong></td>
    </tr>
    <tr>
      <td style="text-align: center;"> <strong>Període acadèmic:
        </strong>
      </td>
      <td colspan="4" style="text-align: center;"> 
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
       <td><?php echo "Unitat organitzativa"?>:</td>
       <td>
        TODO<select id="select_all_google_apps_users_main_organizational_unit_filter"><option value=""></option></select>
       </td>
       <td><?php echo "Tipus usuari"?>:</td>
       <td colspan="2">
        TODO<select id="select_all_google_apps_users_user_type_filter"><option value=""></option><option value="1">1</option><option value="2">2</option></select>
      </td>
    </tr>
  </thead>  
 </table>

 <table style="display:none;"  class="table table-striped table-bordered table-hover table-condensed" id="actions"> 
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="8" style="text-align: center;"> <strong>Accions massives (aplica l'acció sobre tots els usuaris seleccionats)
        </strong></td>
    </tr>
    <tr> 
       <td>
        <button class="btn btn-mini btn-info" id="create_multiple_initial_passwords">
          <i class="icon-bolt"></i>
          Crear paraula de pas inicial
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="select_all">
          <i class="icon-bolt"></i>
          Seleccionar tots
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="unselect_all">
          <i class="icon-bolt"></i>
          Deseleccionar tots
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="sync_mysql_ldap">
          <i class="icon-bolt"></i>
          Sync MySQL -> Ldap
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="assign_ldap_rol">
          <i class="icon-bolt"></i>
          Assignar Rol ldap
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="sync_mysql_password_to_ldap">
          <i class="icon-bolt"></i>
          Sync MySQL password a Ldap
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="avoid_change_of_password_on_windows">
          <i class="icon-bolt"></i>
          Impedir canvi de password a Windows
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="interchange_windows_passwords">
          <i class="icon-bolt"></i>
          Canviar hash NT per LM i viceversa
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
    </tr>
  </thead>  
</table> 

</div>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_google_apps_users">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="36" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/user_ldaps') ;?>">
        <?php echo $user_ldap_table_title?>. Període acadèmic: <span id="academic_period_text">
      </a>
      </h4></td>
  </tr>
  <tr>
     <th>&nbsp;</th> 
     <th>Id</th>
     <th>Etag</th>
     <th>Kind</th>
     <th>primaryEmail</th>
     <th>givenName</th>
     <th>familyName</th>
     <th>isAdmin</th>
     <th>isDelegatedAdmin</th>
     <th>lastLoginTime</th>
     <th>creationTime</th>
     <th>deletionTime</th>
     <th>agreedToTerms</th>
     <th>password</th>
     <th>hashFunction</th>
     <th>suspended</th>
     <th>suspensionReason</th>
     <th>changePasswordAtNextLogin</th>
     <th>ipWhitelisted</th>
     <th>customerId</th>
     <th>orgUnitPath</th>
     <th>isMailboxSetup</th>
     <th>includeInGlobalAddressList</th>
     <th>thumbnailPhotoUrl</th>
  </tr>
 </thead>
 
</table> 

<!-- 

{
  "kind": "admin#directory#user",
  "id": string,
  "etag": etag,
  "primaryEmail": string,
  "name": {
    "givenName": string,
    "familyName": string,
    "fullName": string
  },
  "isAdmin": boolean,
  "isDelegatedAdmin": boolean,
  "lastLoginTime": datetime,
  "creationTime": datetime,
  "deletionTime": datetime,
  "agreedToTerms": boolean,
  "password": string,
  "hashFunction": string,
  "suspended": boolean,
  "suspensionReason": string,
  "changePasswordAtNextLogin": boolean,
  "ipWhitelisted": boolean,
  "ims": [
    {
      "type": string,
      "customType": string,
      "protocol": string,
      "customProtocol": string,
      "im": string,
      "primary": boolean
    }
  ],
  "ims": string,
  "emails": [
    {
      "address": string,
      "type": string,
      "customType": string,
      "primary": boolean
    }
  ],
  "emails": string,
  "externalIds": [
    {
      "value": string,
      "type": string,
      "customType": string
    }
  ],
  "externalIds": string,
  "relations": [
    {
      "value": string,
      "type": string,
      "customType": string
    }
  ],
  "relations": string,
  "addresses": [
    {
      "type": string,
      "customType": string,
      "sourceIsStructured": boolean,
      "formatted": string,
      "poBox": string,
      "extendedAddress": string,
      "streetAddress": string,
      "locality": string,
      "region": string,
      "postalCode": string,
      "country": string,
      "primary": boolean,
      "countryCode": string
    }
  ],
  "addresses": string,
  "organizations": [
    {
      "name": string,
      "title": string,
      "primary": boolean,
      "type": string,
      "customType": string,
      "department": string,
      "symbol": string,
      "location": string,
      "description": string,
      "domain": string,
      "costCenter": string
    }
  ],
  "organizations": string,
  "phones": [
    {
      "value": string,
      "primary": boolean,
      "type": string,
      "customType": string
    }
  ],
  "phones": string,
  "aliases": [
    string
  ],
  "nonEditableAliases": [
    string
  ],
  "customerId": string,
  "orgUnitPath": string,
  "isMailboxSetup": boolean,
  "includeInGlobalAddressList": boolean,
  "thumbnailPhotoUrl": string,
  "customSchemas": {
    (key): {
      (key): (value)
    }
  }
}

-->


<div class="space-30"></div>

	</div>	
</div>