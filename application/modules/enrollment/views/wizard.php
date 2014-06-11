<div class="main-content" >

  <!-- Breadcrumbs -->
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
      <li class="active"><?php echo lang('enrollment');?></li>
    </ul>
  </div><!-- /breadcrumbds -->

  <!-- Page Header -->
  <div class="page-header position-relative">
    <h1>
      <?php echo lang("enrollment");?>
      <small>
        <i class="icon-double-angle-right"></i>
        <?php echo lang('wizard');?>
      </small>
    </h1>
  </div><!-- /.page-header -->	

  <div style='height:10px;'></div>  
  <div style="margin:10px;">

    <!-- PAGE CONTENT BEGINS -->
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-header widget-header-blue widget-header-flat">
          <h4 class="lighter"><?php echo lang('new_enrollment');?></h4> <i class="icon-double-angle-right"></i>

              <span name="step0_title" id="enrollment_breadcump_step1_student" class="step1_student green">
                <small>
                  <b><?php echo lang("enrollment_student_personal_data");?></b>
                </small>
              </span>
              </span>
              <span name="step1_title" id="enrollment_breadcrump_step2_selected_academic_period" class="step2_selected_academic_period"></span>
              <span name="step2_title" id="enrollment_breadcrump_step3_selected_study" class="step3_selected_study"></span>                
              <span name="step3_title" id="enrollment_breadcrump_step4_selected_course" class="step4_selected_course"></span>
              <span name="step4_title" id="enrollment_breadcrump_step5_selected_classroom_group" class="step5_selected_classroom_group"></span>                            
              <span name="step5_title" id="enrollment_breadcrump_step6_selected_study_module" class="step6_selected_study_module"></span>
              <span name="step6_title" id="enrollment_breadcrump_step7_selected_study_submodule" class="step7_selected_study_submodule"></span>
              
          <div class="widget-toolbar">
            <label>
              <small class="green">
                <b><?php echo lang('validation');?></b>
              </small>
              <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4" checked="checked" />
              <span class="lbl"></span>
            </label>
          </div>
        </div> <!-- /widget-header -->

        <div class="widget-body">
          <div class="widget-main">
            <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
              <ul class="wizard-steps">

                <li data-target="#step0" class="active">
                  <span class="step">0</span>
                  <span class="title"><?php echo lang('student');?></span>
                </li>

                <li data-target="#step1">
                  <span class="step">1</span>
                  <span class="title"><?php echo lang('enrollment_academic_period');?></span>
                </li>

                <li data-target="#step2">
                  <span class="step">2</span>
                  <span class="title"><?php echo lang('enrollment_studies');?></span>
                </li>

                <li data-target="#step3">
                  <span class="step">3</span>
                  <span class="title"><?php echo lang('enrollment_courses');?></span>
                </li>

                <li data-target="#step4">
                  <span class="step">4</span>
                  <span class="title"><?php echo lang('enrollment_classgroups');?></span>
                </li>

                <li data-target="#step5">
                  <span class="step">5</span>
                  <span class="title"><?php echo lang('enrollment_modules');?></span>
                </li>

                <li data-target="#step6">
                  <span class="step">6</span>
                  <span class="title"><?php echo lang('enrollment_submodules');?></span>
                </li>
              </ul>
            </div> <!-- /fuelux-wizard -->

            <hr />

            <div class="step-content row-fluid position-relative" id="step-container">

<!--  
STEP 0 - STUDENT DATA
-->                
              <div class="step-pane active" id="step0">

                <!-- Show notification if student exists -->
                <div id="student_exists"></div>
                <!-- /Show notification if student exists -->

                    <div class="widget-box">
                      <div class="widget-header" style="text-align: center;">
                      <!-- /widget-header -->
                        <span >
                          <small class="green" >
                           <b><?php echo lang("enrollment_student_personal_data");?></b>
                          </small>
                        </span>
                        <div class="widget-toolbar">
                          <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                          </a>
                        </div>
                      </div>
                      <div class="widget-body">

                          <form id="validation-form">
                          <div class="row-fluid">
                            <div class="span12">
                              <!-- PAGE CONTENT BEGINS -->
                              <div>
                                <div id="user-profile-1" class="user-profile row-fluid">
                                  
                                  <!-- AVATAR -->
                                  <div class="span3 center">
                                    
                                    <div class="span2"></div>
                                    <div class="span8 center">
                                      <div class="space-4"></div>
                                      
                                      <!-- Student Photo -->
                                      <div id="student_photo">
                                        <span class="profile-picture">
                                          <img id="avatar" style="height: 150px;" class="editable img-responsive editable-click" src="<?php echo base_url('assets/img/alumnes').'/foto.png';?>" alt="photo" />
                                        </span>
                                      </div>                                        

                                      <div id="student_full_name" class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                          <i class="icon-circle light-green middle"></i> <span class="white">Alumne</span>
                                        </div>
                                      </div>                                      
                                    </div>  
                                    <div class="space-4"></div>
                                  </div>
                                  <!-- AVATAR END -->

                                  <div class="span9">


                                      <!-- TIPUS DE DOCUMENT -->

                                      <div class="span12">
                                        <label>&nbsp;</label>
                                        <input class="span12" name="person_id" type="hidden" />  
                                      </div>                                      

                                      <div class="span7">
                                        <div class="span2">
                                          <input type="radio" name="official_id_type" id="rb_is_dni" value="1"><span><?php echo lang('wizzard_official_DNI');?>&nbsp;</span>
                                        </div>
                                        <div class="span2">
                                          <input type="radio" name="official_id_type" value="2"><span><?php echo lang('wizzard_official_NIE');?>&nbsp;</span>
                                        </div>
                                        <div class="span4">
                                          <input type="radio" name="official_id_type" value="3"><span><?php echo lang('wizzard_official_passport');?>&nbsp;</span>
                                        </div>
                                      </div>
                                      <!-- /TIPUS DE DOCUMENT -->                               
                                    <!-- DNI / TIS -->
                                    <div class="space-20"></div>                                    
                                    <div class="space-6"></div>
                                    <div class="span11" >
                                      <div class="form-group control-group">  
                                        <div class="span5" >                                  
                                          <label id="lbl_student_official_id" for="student_official_id" class="control-label no-padding-right"><?php echo lang('wizzard_official_DNI');?>&nbsp;</label>
                                          <div class="controls">
                                            <input type="text" id="student_official_id" name="student_official_id" placeholder="Escriu el <?php echo lang('wizzard_official_DNI');?>" />
                                          </div>
                                        </div>
                                      </div>  

                                      <div class="form-group control-group">                                        
                                        <div class="span5">
                                          <label class="control-label" for="person_secondary_official_id"><?php echo lang('wizzard_secondary_official_id');?>&nbsp;</label>
                                          <input type="text" name="person_secondary_official_id" placeholder="Escriu el nº TSI" />
                                        </div>
                                      </div>  
                                    </div>
                                    
                                    
                                    <!-- /DNI / TIS --> 
                                  </div>

                                  <div class="span11">
                                    <div class="span4">
                                        <div class="control-group">
                                          <label class="control-label" for="student_givenName"><?php echo lang('wizzard_givenName');?></label>

                                          <div class="controls">
                                             <input id="givenName" type="text" name="person_givenName" placeholder="Escriu un nom d'alumne" />
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                          <label class="control-label"><?php echo lang('wizzard_sn1');?></label>

                                          <div class="controls">
                                             <input id="sn1" type="text" name="person_sn1" placeholder="Escriu el Primer Cognom" />
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                      <label class="control-label" for="student_sn2"><?php echo lang('wizzard_sn2');?>&nbsp;</label>
                                      <input id="sn2" type="text" name="person_sn2" placeholder="Escriu el Segon Cognom" />
                                    </div>
                                  </div>
                                  
                                  <div class="span11" >
                                    <div class="span3">
                                      <label class="control-label" for="student_username">Username:&nbsp;</label>
                                      <input id="username" type="text" name="person_username" placeholder="Username" readonly />                                    
                                    </div>
                                    
                                    <div class="span3">
                                        <label class="control-label" for="student_generated_password">Generated Password:&nbsp;</label>
                                        <input id="generated_password" type="text" name="person_generated_password" placeholder="Generated Password" readonly />
                                    </div>
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_password">Password:&nbsp;</label>
                                        <div class="controls">
                                          <input type="password" name="person_password" id="person_password" placeholder="Password"/>
                                        </div>    
                                      </div>  
                                    </div>
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_verify_password">Verify Password:&nbsp;</label>
                                        <div class="controls">
                                          <input type="password" name="person_verify_password" placeholder="Verify Password"/>
                                        </div>    
                                      </div>    
                                    </div>                                    
                                  </div>                                  
                            
                                  <div class="span11" >
                                    <div class="span3">
                                      <label class="control-label" for="student_telephoneNumber"><?php echo lang('wizzard_telephoneNumber');?>&nbsp;</label>
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>
                                        <input type="text" name="person_telephoneNumber" id="person_telephoneNumber" placeholder="Escriu el telèfon fixe" />                          
                                      </div>
                                    </div>
                                    
                                    <div class="span3">
                                      <label class="control-label" for="student_mobile"><?php echo lang('wizzard_mobile');?>&nbsp;</label>  
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>                                     
                                        <input type="text" name="person_mobile" placeholder="Escriu el telèfon mòbil" />                      
                                      </div>
                                    </div>
                                    <div class="span6">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" name="person_email" placeholder="Escriu el Correu electrònic" />                         
                                        </div>  
                                      </div>  
                                    </div>
                                  </div>

                                  <div class="span11" >
                                    <div class="span7">
                                      <label class="control-label" for="student_homePostalAddress"><?php echo lang('wizzard_homePostalAddress');?>&nbsp;</label>
                                      <input class="span12" type="text" name="person_homePostalAddress" placeholder="Escriu l'Adreça" />                          
                                    </div>
                                    <div class="span5">
                                      <div class="span8">
                                        <label class="control-label" for="student_locality_name"><?php echo lang('wizzard_locality_name');?>&nbsp;</label>
                                        <input class="span12" type="text" name="person_locality_name" placeholder="Escriu la Localitat" />          
                                      </div>
                                      <div class="span4">
                                        <label class="control-label" for="student_postal_code"><?php echo lang('wizzard_postal_code');?>&nbsp;</label>
                                        <input class="span12" type="text" name="person_postal_code" placeholder="Escriu el codi postal" />                 
                                      </div>                                      
                                    </div>                                    
                                  </div>

                                  <div class="span6" >
                                    <div class="span6">
                                      <label class="control-label" for="student_date_of_birth"><?php echo lang('wizzard_date_of_birth');?>&nbsp;</label>
                                      <input class="span11" type="text" name="person_date_of_birth" placeholder="Escriu la Data de naixement" />                            
                                    </div>
                                    <label for="Tipus" >Sexe</label>
                                    <div class="span6">
                                      <div class="span4">
                                        <label>
                                          <input name="sexe" type="radio" class="ace" value="M" />
                                          <span class="lbl"> Home</span>
                                        </label>                                      
                                      </div>
                                      <div class="span4">
                                        <label>
                                          <input name="sexe" type="radio" class="ace" value="F"/>
                                          <span class="lbl"> Dona</span>
                                        </label>                                      
                                      </div>
                                    </div>                                  
                                  </div>
                                </div>
                                <!-- PAGE CONTENT ENDS -->
                              </div><!-- /.span -->
                            </div>
                          </div><!-- /.row-fluid -->

                        </form>




                      </div>  
                    </div>

                        
                        
                      
              </div><!-- /step0 -->

<!--  
STEP 1 - ACADEMIC PERIOD AND STUDENT
-->
              <div class="step-pane" id="step1">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4><?php echo lang("enrollment_academic_period_title")?></h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="validation-form" method="get">
                        <!-- Academin Period -->
                        <label class="control-label" for="academic_period"><?php echo lang('academinc_period'); ?>:&nbsp;&nbsp;</label>
                        <select id="academic_period" name="academic_period" class="select2" >
                          <? foreach($this->config->item('academic_periods') as $key => $periode): ?>
                          <option value="<?php echo $key; ?>" <?php if($periode == $this->config->item('current_period')){ ?> selected <?php } ?> ><?php echo $periode; ?></option>
                          <? endforeach; ?>
                        </select>
                        <br />
                        <br />
                         <!-- Student -->
                        <label class="control-label" for="student"><?php echo lang('student'); ?>:&nbsp;&nbsp;</label>
                        <select id="student" name="student" class="select2" data-placeholder="Selecciona un estudiant..." style="width:800px;">
                          <option value=""></option>
                          <? foreach($enrollment_students as $enrollment_student): ?>
                           <option value="<?php echo $enrollment_student['student_person_id'];?>" >
                            <?php echo $enrollment_student['person_official_id'] . ". " . $enrollment_student['student_fullName']; ?>
                           </option>
                          <? endforeach; ?>
                        </select>
                           <?php echo lang("enrollment_total_students");?>: <?php echo count($enrollment_students);?>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step1 -->
<!--  
STEP 2 - ALL STUDIES
-->                
              <div class="step-pane" id="step2">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Estudi</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="enrollment_study-form" method="get">
                        <label class="control-label" for="enrollment_study">Estudi:&nbsp;&nbsp;</label>
                        <select id="enrollment_study" name="enrollment_study" class="select2" data-placeholder="<?php echo lang('enrollment_select_study_title') ;?>">
                          <? foreach($enrollment_studies as $enrollment_study): ?>
                          <option value="<?php echo $enrollment_study['studies_id']; ?>" <?php if ( $this->config->item('default_study_id') == $enrollment_study['studies_id'] ) { echo "selected=\"selected\""; } ;?> ><?php echo $enrollment_study['studies_shortname'] . ". " . $enrollment_study['studies_name']; ?></option>
                          <? endforeach; ?>
                        </select>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step2 -->
<!--  
STEP 3 - ALL COURSES
-->                
              <div class="step-pane" id="step3">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Curs</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="enrollment_course-form" method="get">
                        <label class="control-label" for="enrollment_course">Curs:&nbsp;&nbsp;</label>
                        <select id="enrollment_course" name="enrollment_course" class="select2" data-placeholder="Selecciona un Curs">
                          <option value=""></option>                          
                        </select>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step3 -->

<!--  
STEP 4 - ALL CLASSROOM GROUPS FROM SELECTED STUDY
-->                
              <div class="step-pane" id="step4">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Grup de Classe</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="classroom_group-form" method="get">
                        <div id="step4_classroom_group" class="form-group">
                          <label class="control-label" for="classroom_group">Grups de Classe:&nbsp;&nbsp;</label>
                          <select id="classroom_group" name="classroom_group" class="select2" data-placeholder="Selecciona un Grup de Classe">
                            <option value=""></option>
                          </select>
                        </div>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step4 -->

<!--  
STEP 5 - ALL MODULES FROM SELECTED STUDY
-->                      
              <div class="step-pane" id="step5">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Mòdul</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="study_module-form" method="get">
                        <div id="step5_study_module" class="form-group">
                          <div id="checkbox_study_module"></div>
                        </div>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- /widget-box -->                                   
              </div><!-- /step5 -->

<!--  
STEP 6 - ALL SUB-MODULES FROM SELECTED MODULES
-->      

              <div class="step-pane" id="step6">               
<!-- STUDY WIDGET -->
                <div class="widget-box">
                  <div class="widget-header">
                    <h3 id="study_name"></h3>
                      <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                          <i class="icon-chevron-up"></i>
                        </a>
                      </div>                      
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
    
                      <!--<div id="checkbox_study_submodules"></div>-->
                      <!-- COURSE WIDGET -->
                      <div class="step6_course_widget"></div>
                      <!-- /COURSE WIDGET -->
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->
                </div><!-- /widget-box -->
<!-- /STUDY WIDGET -->

              </div><!-- /step6 -->
            </div><!-- /step-container -->
            <hr />
            <div class="row-fluid wizard-actions">
              <button class="btn btn-prev">
                <i class="icon-arrow-left"></i>
                Prev
              </button>
              <button class="btn btn-success btn-next" data-last="Finish ">
                Next
                <i class="icon-arrow-right icon-on-right"></i>
              </button>
            </div><!-- /wizard-actions -->
          </div><!-- /widget-main -->
        </div><!-- /widget-body -->
      </div><!-- /widget-box -->
    </div><!-- /row-fluid -->
  </div>
    <!-- PAGE CONTENT ENDS -->

<!--  
  JAVASCRIPT
-->  
    <script type="text/javascript">
      if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <!-- inline scripts related to this page -->

    <script type="text/javascript">

      var existeix=false;

      /******************
       *  Editable Avatar
      ******************/
      function editableAvatar() {

        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
        
        // *** editable avatar *** //
        try {//ie8 throws some harmless exception, so let's catch it
      
          //it seems that editable plugin calls appendChild, and as Image doesn't have it, it causes errors on IE at unpredicted points
          //so let's have a fake appendChild for it!
          if( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ) Image.prototype.appendChild = function(el){}
      
          var last_gritter
          $('#avatar').editable({
            type: 'image',
            name: 'avatar',
            value: null,
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Canvieu el Avatar',
              droppable: true,
              /**
              //this will override the default before_change that only accepts image files
              before_change: function(files, dropped) {
                return true;
              },
              */
      
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              max_size: 110000,//~100Kb
              on_error : function(code) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(code == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'El fitxer no és una imatge!',
                    text: 'Escolliu un fitxer jpg|gif|png!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(code == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'El fitxer és massa gran!',
                    text: 'La imatge no pot superar els 100Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
              url: function(params) {
              // ***UPDATE AVATAR HERE*** //
              //You can replace the contents of this function with examples/profile-avatar-update.js for actual upload
      
              var deferred = new $.Deferred
      
              //if value is empty, means no valid files were selected
              //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
              //so we return just here to prevent problems
              var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred.resolve();
                return deferred.promise();
              }
      
              //dummy upload
              setTimeout(function(){
                if("FileReader" in window) {
                  //for browsers that have a thumbnail of selected image
                  var thumb = $('#avatar').next().find('img').data('thumb');
                  if(thumb) $('#avatar').get(0).src = thumb;
                }
                
                deferred.resolve({'status':'OK'});
      
                if(last_gritter) $.gritter.remove(last_gritter);
                last_gritter = $.gritter.add({
                  title: "Foto actualitzada correctament!",
                  text: "El avatar de l'usuari s'ha modificat correctament!",
                  time: 3000,
                  class_name: 'gritter-info gritter-center'
                });
                
               } , parseInt(Math.random() * 800 + 800))
      
              return deferred.promise();
            },
            
            success: function(response, newValue) {
            }
          })
        }catch(e) {}

      }

      jQuery(function($) {
      
          student_official_id = $('#student_official_id');
          student_official_id_label = $('#lbl_student_official_id');

          rb_official_id_type = $("input[name=official_id_type]:radio");
          official_id_type = rb_official_id_type.val();
          official_id_type_text = $("input:checked + span").text();

          rb_official_id_type.change(function () {
            official_id_type = $(this).val();
            official_id_type_text = $("input:checked + span").text();
            student_official_id.attr("placeholder", "Escriu el "+official_id_type_text);  
            student_official_id_label.text(official_id_type_text);      
          });

           var availableTags = <?php echo json_encode($all_person_official_ids);?>;

           student_official_id.autocomplete({
            source: availableTags
           });

            $('input:radio[name=official_id_type]').val(['1']);

            $('[data-rel=tooltip]').tooltip();

            /******************
            *  /Editable Avatar
            ******************/
            editableAvatar();

            $('select.academic_period').select2();
            $(".select2").css('width','400px').select2({
              allowClear:true
            }).on('change', function(){
              $(this).closest('form').validate().element($(this));
            }); 
      
            var actual_step = $('ul.wizard-steps').children().hasClass('active');      
            if(actual_step == false){
              $('ul.wizard-steps li').first().addClass('active');
              $('#step-container div').first().addClass('active');
            } 

          /* remove accents */

          var accent_fold = (function () {
              var accent_map = {
                  'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', // a
                  'ç': 'c',                                                   // c
                  'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e',                     // e
                  'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',                     // i
                  'ñ': 'n',                                                   // n
                  'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ø': 'o', // o
                  'ß': 's',                                                   // s
                  'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u',                     // u
                  'ÿ': 'y'                                                    // y
              };

              return function accent_fold(s) {
                  if (!s) { return ''; }
                  var ret = '';
                  for (var i = 0; i < s.length; i++) {
                      ret += accent_map[s.charAt(i)] || s.charAt(i);
                  }
                  return ret;
              };
          } ());

/* remove accents */

        /* Get generated password */
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/generate_password");?>',
                type: 'post',
                datatype: 'json'
              }).done(function(data){
                data = $.parseJSON(data);
                password = data['password'];
                $('#generated_password').val(password);
              });

        $("#student_official_id").change(function(){
          student = $(this).val();

              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/check_student");?>',
                type: 'post',
                data: {
                    student_official_id : student
                },
                datatype: 'json'
              }).done(function(data){

                /* Student Exists */
                if(data != false){
                  student_exist = $("#student_exists");
                  existeix = true;
                  student_exist.html("<i class='icon-ok green'></i> La persona ja existeix a la base de dades. Us hem omplert tots els camps amb les dades de la persona. Comproveu que les dades siguin correctes! <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>")
                  .addClass("alert alert-block alert-success");

                  /* Show notification during 5 seconds */
                  setTimeout(function(){
                    student_exist.html('');
                    student_exist.removeClass("alert alert-block alert-success")
                  },5000);

                  var all_data = $.parseJSON(data);

                $.each(all_data, function(idx,obj) {
                  
                  /* Fill form with student data from Database */
                  $("#step0 input[name$="+idx+"]").val(obj);
                    student_full_name = $('#student_full_name').find("span.white");
                  if(idx=='person_photo'){
                    var student_photo = $('#student_photo');

                    //Sergi Tur: change only img source not all span!!
                    //student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click" src="<?php echo base_url('uploads/person_photos'); ?>/'+obj+'" alt="'+ obj +'"/></span>');
                    $('#avatar').attr("src","<?php echo base_url('uploads/person_photos');?>/"+obj);
                  }
                  if(idx=='person_gender'){
                    if(obj == 'M'){
                      $('input:radio[name=sexe]').val(['M']);  
                    } else if(obj == 'F'){
                      $('input:radio[name=sexe]').val(['F']);  
                    }
                    
                  }
                    student_full_name.text(all_data['person_givenName']+" "+all_data['person_sn1']+" "+all_data['person_sn2']);
                });

                /* Student doesn't exists, clear form data */
                } else {
                    existeix = false;
                    empty_student = {"person_id":"",
                    "person_photo":"","person_secondary_official_id":"","person_givenName":"",
                    "person_sn1":"","person_sn2":"","person_email":"","person_date_of_birth":"",
                    "person_gender":"","person_homePostalAddress":"","person_locality_name":"","username":"",
                    "person_telephoneNumber":"","person_mobile":""}

                    /*
                    student_photo = $('#student_photo');
                    student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url('assets/img/alumnes/foto.png'); ?>" alt="photo"/></span>');                  
                    student_full_name.text('Alumne');*/

                    $.each(empty_student, function(idx,obj) {
                      $("#step0 input[name$="+idx+"]").val(obj);
                    });
                }

              });

        editableAvatar();          

        });

        $("#givenName").change(function(){
          student_full_name = $('#student_full_name').find("span.white");
          student_full_name.text( $("#givenName").val() + " " + $("#sn1").val() + " " + $("#sn2").val() );      

        });

        $("#sn1").change(function(){
          student_full_name = $('#student_full_name').find("span.white");
          student_full_name.text( $("#givenName").val() + " " + $("#sn1").val() + " " + $("#sn2").val() );      
        });

        $("#sn2").change(function(){
          student_full_name = $('#student_full_name').find("span.white");
          student_full_name.text( $("#givenName").val() + " " + $("#sn1").val() + " " + $("#sn2").val() );      
        });

        /* username */
        username_input = $('#username');
        givenName_input = $('#givenName');
        sn1_input = $('#sn1');                

        givenName = givenName_input.val();
        sn1 = $.trim(sn1_input.val());
        username = username_input.val();

        givenName_input.blur(function(){
          givenName = $.trim(givenName_input.val());
          if (!existeix) {
            username = username_input.val(accent_fold(givenName.toLowerCase()+sn1.toLowerCase()));  
          }
          if(givenName!='' && sn1!='' && !existeix){
            generate_username();
          }
        });

        sn1_input.blur(function(){
          sn1 = $.trim(sn1_input.val());
          if (!existeix) {
            username = username_input.val(accent_fold(givenName.toLowerCase()+sn1.toLowerCase()));
          }
          if(givenName!='' && sn1!='' && !existeix){
            generate_username();
          }
        });
        
        /* /username */

        function generate_username()  {

              // AJAX get student by username
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/get_user_by_username");?>',
                type: 'post',
                datatype: 'json',
                data: {
                  username : $("#username").val()
                }
              }).done(function(data){

                if(data!=false){
                  $('#username').val(data);
                }
            });
        }          

      $(".btn-prev").click(function(){
        console.debug("Click on prev button");
        step = $("#step-container div.active").attr("id");
        step_number = parseInt( step.substr(step.length - 1) , 10);
        previous_step_number = step_number -1 ;
        /*console.debug("Step:" + step);
        console.debug("step_number:" + step_number);
        console.debug("step_number -1:" + (step_number -1));
        */
        

        $('[name ^=step][name $=_title]').removeClass("green");
        previous_step_number_string = previous_step_number.toString() ;
        step_to_green = "step" + previous_step_number_string + "_title" ;

        $('[name ^="' + step_to_green + '"]').addClass("green");
      });


      $(".btn-next").click(function(){
        console.debug("Click on next button");
        step = $("#step-container div.active").attr("id");
        console.debug("Step:" + step);

        $('[name ^=step][name $=_title]').removeClass("green");
        $('[name ^="' + step + ' _title"]').addClass("green");

/***********
 *  STEP 0 - Student Personal Data
 ***********/

        if(step == "step0") {

          /* store student data from form */
          student_person_id = $("#"+step+" input[name$='person_id']").val();
          //console.debug("student_person_id: " . student_person_id);
          student_official_id = $("#"+step+" input[name$='student_official_id']").val();
          student_secondary_official_id = $("#"+step+" input[name$='person_secondary_official_id']").val();          

          student_givenName = $("#"+step+" input[name$='person_givenName']").val();
          student_sn1 = $("#"+step+" input[name$='person_sn1']").val();
          student_sn2 = $("#"+step+" input[name$='person_sn2']").val();

          student_username = $("#"+step+" input[name$='person_username']").val();
          student_generated_password = $("#"+step+" input[name$='person_generated_password']").val();
          student_password = $("#"+step+" input[name$='person_password']").val();
          student_verify_password = $("#"+step+" input[name$='person_verify_password']").val();

          student_telephoneNumber = $("#"+step+" input[name$='person_telephoneNumber']").val();
          student_mobile = $("#"+step+" input[name$='person_mobile']").val();
          student_email = $("#"+step+" input[name$='person_email']").val();

          student_homePostalAddress = $("#"+step+" input[name$='person_homePostalAddress']").val();
          student_locality_name = $("#"+step+" input[name$='person_locality_name']").val();
          student_postal_code = $("#"+step+" input[name$='person_postal_code']").val();

          student_date_of_birth = $("#"+step+" input[name$='person_date_of_birth']").val();
          student_gender = $("input:radio[name=sexe]").val();


          /*
          if(student_password != student_verify_password){
            //alert("NO");
          } else {
            //alert("SI");
          }
          */
          if(existeix) {
          /**/
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/insert_update_user");?>',
                type: 'post',
                data: {
                    student_person_id : student_person_id,
                    student_official_id : student_official_id,
                    student_secondary_official_id : student_secondary_official_id,
                    student_givenName : student_givenName,
                    student_sn1 : student_sn1,
                    student_sn2 : student_sn2,
                    student_username : student_username,
                    student_generated_password : student_generated_password,
                    student_password : student_password,
                    student_verify_password : student_verify_password,
                    student_email : student_email,
                    student_homePostalAddress : student_homePostalAddress,
                    student_locality_name : student_locality_name,
                    student_postal_code : student_postal_code,
                    student_telephoneNumber : student_telephoneNumber,
                    student_mobile : student_mobile,
                    student_date_of_birth : student_date_of_birth,
                    student_gender : student_gender,
                    action : "update"
                },
                datatype: 'json'
              }).done(function(data){

              
              });
          /**/
          } else {
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/insert_update_user");?>',
                type: 'post',
                data: {
                    student_official_id : student_official_id,
                    student_secondary_official_id : student_secondary_official_id,
                    student_givenName : student_givenName,
                    student_sn1 : student_sn1,
                    student_sn2 : student_sn2,
                    student_username : student_username,
                    student_generated_password : student_generated_password,
                    student_password : student_password,
                    student_verify_password : student_verify_password,
                    student_email : student_email,
                    student_homePostalAddress : student_homePostalAddress,
                    student_locality_name : student_locality_name,
                    student_postal_code : student_postal_code,
                    student_telephoneNumber : student_telephoneNumber,
                    student_mobile : student_mobile,
                    student_date_of_birth : student_date_of_birth,
                    student_gender : student_gender,
                    action : "insert"
                },
                datatype: 'json'
              }).done(function(data){

              
              });
          }
          
          //CHECK student_person_id if undefined?!!!!!!
          $("#student option[value=" + student_person_id +"]").attr("selected","selected");
          $("#student").select2();
          
          $(".step1_student").html( student_sn1 + " " + student_sn2 + "," + student_givenName + " ("+student_official_id+") <i class='icon-double-angle-right'></i>");    
          if($.trim($("[name = 'step1_title' ]").html())=='') {
              $("[name = 'step1_title' ]").html("<b><small><?php echo lang('enrollment_academic_period_title');?></b></small>");     
          }
          
          $("[name = 'step1_title' ]").addClass("green"); 
          
// End step 0
        
/***********
 *  STEP 1 - Academic Period and Student Data
 ***********/

        } else if(step == "step1"){

          academic_period = $("#academic_period option:selected").text();
          student_dni = $("#"+step+" input[name$='student_personal_id']").val();
          student_name = $("#student option:selected").text();
          student_id = $("#student option:selected").val();
          

          $(".step2_selected_academic_period").html(academic_period+" <i class='icon-double-angle-right'></i>");  
          if($.trim($("[name = 'step2_title' ]").html())=='') {        
              $("[name = 'step2_title' ]").html("<b><small><?php echo lang('enrollment_select_study_title');?></b></small>");   
          }
          $("[name = 'step2_title' ]").addClass("green");

// End step 1
        
/***********
 *  STEP 2 - Study Data
 ***********/

        } else if(step == "step2"){
        
          study_id = $("#enrollment_study").val();
          study_name = $("#enrollment_study option:selected").text();

          console.debug("study_name:" . study_name);

          $("#enrollment_study").change(function(){
              study_id = $("#enrollment_study").val();
              study_name = $("#enrollment_study option:selected").text();

          });    
 
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/classroom_course");?>',
                type: 'post',
                data: {
                    study_id : study_id
                },
                datatype: 'json'
              }).done(function(data){
             
                courses = [];
                var $_courses = $('select#enrollment_course');
                var $_course_widget = $('div.step6_course_widget');
                $_course_widget.empty();
                $_courses.empty();
                first = 1;
                $.each(JSON.parse(data), function(idx, obj) {
                  if (first == 1) {
                    $_courses.append($('<option selected="selected"></option>').attr("value",obj.course_id).text(obj.course_shortname + ". " + obj.course_name));
                    first = 0;
                  } else {
                    $_courses.append($('<option></option>').attr("value",obj.course_id).text(obj.course_shortname + ". " + obj.course_name));
                  }
                  
                  
                  courses.push(obj.course_id);

                  $_course_widget.append("<div class='widget-box'>"+
                                            "<div class='widget-header'>"+
                                              "<h4>"+obj.course_name+"</h4>"+
                                              "<div class='widget-toolbar'>"+
                                                "<a data-action='collapse' href='#'>"+
                                                  "<i class='icon-chevron-up'></i>"+
                                                "</a>"+
                                              "</div><!-- /widget-toolbar -->"+
                                            "</div><!-- /widget-header -->"+
                                            "<div class='widget-body'>"+
                                              "<div class='widget-main'>"+
                                                "<div id=module_widget_"+obj.course_id+" class='module_widget'></div>"+
                                              "</div><!-- /widget-main -->"+
                                            "</div><!-- /widget-body -->"+
                                          "</div><!-- /widget-box -->");
                });
                $_courses.select2();
              });

              $(".step3_selected_study").html(study_name+" <i class='icon-double-angle-right'></i>");  
              if($.trim($("[name = 'step3_title' ]").html())=='') {
                  $("[name = 'step3_title' ]").html("<b><small><?php echo lang('enrollment_select_course_title');?></b></small>");   
              }
              $("[name = 'step3_title' ]").addClass("green");
              $("#study_name").text(study_name);
// End step 2

/***********
 *  STEP 3 - Course Data
 ***********/

        } else if(step == "step3"){
        
          course_id = $("#enrollment_course").val();
          course_name = $("#enrollment_course option:selected").text();

          $("#enrollment_course").change(function(){
              course_id = $("#enrollment_course").val();
              course_name = $("#enrollment_course option:selected").text();
          });    

              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/classroom_group");?>',
                type: 'post',
                data: {
                    study_id : study_id
                },
                datatype: 'json'
              }).done(function(data){

                classroom_groups = [];
                var $_classroom_group = $('select#classroom_group');
                
                $_classroom_group.empty();
                first = 1;
                $.each(JSON.parse(data), function(idx, obj) {
                  if (first == 1) {
                    $_classroom_group.append($('<option selected="selected"></option>').attr("value",obj.classroom_group_id).text(obj.classroom_group_name));
                    first = 0;
                  }
                  else {
                    $_classroom_group.append($('<option></option>').attr("value",obj.classroom_group_id).text(obj.classroom_group_name));
                  }
                  
                  classroom_groups.push(obj.classroom_group_id);
                });
                $_classroom_group.select2();
              });

              $(".step4_selected_course").html(course_name + " <i class='icon-double-angle-right'></i>");      
              if($.trim($("[name = 'step4_title' ]").html())=='') {
                  $("[name = 'step4_title' ]").html("<b><small><?php echo lang('enrollment_select_classroomgroup_title');?></b></small>");   
              }

              $("[name = 'step4_title' ]").addClass("green");   
              $("#course_name").text(course_name);
// End step 3

/***********
 *  STEP 4 - Classroom Group Data
 ***********/

        } else if(step == "step4") {

          //alert(classroom_groups);

          classroom_group_name = $("select#classroom_group option:selected").text();
          classroom_group_id = $("select#classroom_group option:selected").val();

          var $_module_widget = $('div[id^="module_widget_"]');   
          console.debug($_module_widget);
          $_module_widget.empty(); 

          $("#classroom_group").change(function(){
            classroom_group_name = $("select#classroom_group option:selected").text();
            classroom_group_id = $("select#classroom_group option:selected").val();            
          }); 
              //alert(study_id);
              // AJAX get Study_Modules from Classroom_Group for step 5

              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/study_modules");?>',
                type: 'post',
                data: {
                    classroom_group_id : classroom_group_id,
                    classroom_groups : classroom_groups
                },
                datatype: 'json'
              }).done(function(data){
                //study_modules_data = data;
                var $_study_module = $('#checkbox_study_module');
                $_study_module.empty();

                $.each(JSON.parse(data), function(idx, obj) {
                  //console.log("Data: "+data);
                  //$_study_module.append('<h3>'+idx+'</h3>');
                  $_study_module.append("<div class='widget-box'>"+
                                            "<div class='widget-header'>"+
                                              "<h3>"+idx+"</h3>"+
                                              "<div class='widget-toolbar'>"+
                                                "<a data-action='collapse' href='#'>"+
                                                  "<i class='icon-chevron-up'></i>"+
                                                "</a>"+
                                              "</div><!-- /widget-toolbar -->"+
                                            "</div><!-- /widget-header -->"+
                                            "<div class='widget-body'>"+
                                              "<div class='step4_widget-main_"+idx+" widget-main'>");  
                        var $_step4_widget_main = $(".step4_widget-main_"+idx);
                        $_step4_widget_main.empty();
                        $.each(obj, function(index, object){
                          //console.log("Object: "+object);
                          if(object.selected_classroom_group=="yes"){
                            checked = 'checked';
                          } else {
                            checked = '';
                          }

                          $_step4_widget_main.append('<input class="ace" type="checkbox" '+ checked +' name="'+object.study_module_shortname+'" value="'+object.study_module_id+'"/> <span class="lbl">  ('+object.classroom_group_code+') '+object.study_module_shortname+' - '+object.study_module_name+' ('+object.study_module_id+')</span><br />');

                          //console.debug("courseid: " + object.study_module_courseid);
                          var $_module_widget = $('#module_widget_' + object.study_module_courseid);   
                          $_module_widget.append("<div class='widget-box'>"+
                                                  "<div class='widget-header'>"+
                                                    "<h4 id='h4_study_module_" + object.study_module_id + "'>" +object.study_module_name+"</h4>"+
                                                    "<div class='widget-toolbar'>"+
                                                      "<a data-action='collapse' href='#'>"+
                                                        "<i class='icon-chevron-up'></i>"+
                                                      "</a>"+
                                                    "</div><!-- /widget-toolbar -->"+
                                                  "</div><!-- /widget-header -->"+
                                                  "<div class='widget-body'>"+
                                                    "<div class='widget-main'>"+
                                                      "<div id='"+object.study_module_id+"' class='submodule_widget'></div><!-- /submodule-widget -->"+
                                                    "</div><!-- /widget-main -->"+
                                                  "</div><!-- /widget-body -->"+
                                                "</div><!-- /widget-box -->");

                          });
                  
                  $_study_module.append("</div><!-- /widget-main -->"+
                                        "</div><!-- /widget-body -->"+
                                        "</div><!-- /widget-box --><br />");
                });                  

            });
              
              $(".step5_selected_classroom_group").html(classroom_group_name + " <i class='icon-double-angle-right'></i>");          
              if($.trim($("[name = 'step5_title' ]").html())=='') {
                  $("[name = 'step5_title' ]").html("<b><small><?php echo lang('enrollment_select_studymodule_title');?></b></small>");   
              }     
              $("[name = 'step5_title' ]").addClass("green");  

              

// End step 4

/***********
 *  STEP 5 - Study Modules
 ***********/

        } else if(step == "step5") {
          
        study_module_names = $('#checkbox_study_module input:checked').map(function(){
          return this.name;
        }).get();
        study_module_ids = $('#checkbox_study_module input:checked').map(function(){
          return $(this).val()
        }).get();
        study_module_ids = study_module_ids.toString().replace(/,/g ,"-");

              //AJAX get Study_Submodules from Study_Modules for step 6
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/study_submodules");?>',
                type: 'post',
                data: {
                    study_module_ids : study_module_ids,
                    classroom_group_id : classroom_group_id,
                    classroom_groups : classroom_groups
                },
                datatype: 'json'
              }).done(function(data){

               var $_study_submodule = $('#checkbox_study_submodules');
               $_study_submodule.attr("style","visibility:hidden;");
               $_study_submodule.empty();

                $.each(JSON.parse(data), function(idx, obj) {
                //$("#"+obj.study_submodules_study_module_id).append($('<input type="checkbox" checked name="'+obj.study_submodules_shortname+'" value="'+obj.study_submodules_study_module_id+'#'+obj.study_submodules_id+'"/> ('+obj.study_module_shortname+') '+obj.study_submodules_shortname+' - '+obj.study_submodules_name+' ('+obj.study_submodules_id+')<br />'));
                $_study_submodule.append($('<input type="checkbox" checked name="'+obj.study_submodules_shortname+'" value="'+obj.study_submodules_study_module_id+'#'+obj.study_submodules_id+'"/> ('+obj.study_module_shortname+') '+obj.study_submodules_shortname+' - '+obj.study_submodules_name+' ('+obj.study_submodules_id+')<br />'));

                });
              }).fail(function(){
                //alert(data);
              });

        $(".step6_selected_study_module").html( Object.keys(study_module_names).length + " Mòduls Professionals <i class='icon-double-angle-right'></i>");
        $("#study_module_name").text(study_module_names);
        if($.trim($("[name = 'step6_title' ]").html())=='') {
            $("[name = 'step6_title' ]").html("<b><small><?php echo lang('enrollment_select_studysubmodule_title');?></b></small>");   
        }
        $("[name = 'step6_title' ]").addClass("green"); 

// End step 5

/***********
 *  STEP 6 - Study Submodules Data
 ***********/

        } else if(step == "step6") {

        var study_submodules_names = $('#checkbox_study_submodules input:checked').map(function(){
          return this.name;
        }).get();

        var study_submodules_ids = $('#checkbox_study_submodules input:checked').map(function(){
          return $(this).val()
        }).get();
        study_submodules_ids = study_submodules_ids.toString().replace(/,/g ,"-");

          alert("Alumne: "+student_name+"\nEstudi: "+study_name+"\nGrup de Classe: "+classroom_group_name+"\nMòduls: "+study_module_names+" ("+study_module_ids+") \nUnitats Formatives: "+study_submodules_names+" ("+study_submodules_ids+")");

              // AJAX insert Enrollment data into database
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/enrollment_wizard");?>',
                type: 'post',
                data: { 
                        person_id: student_id,
                        period_id: academic_period,
                        study_id: study_id,
                        classroom_group_id: classroom_group_id,
                        study_module_ids: study_module_ids,
                        study_submodules_ids: study_submodules_ids
                      },
                datatype: 'json'
              }).done(function(data){
                
              });
        }
      });  

// End step 6



        var $validation = true;
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
          if(info.step == 1 && $validation) {
            if(!$('#validation-form').valid()) return false;
          }
        }).on('finished', function(e) {
          bootbox.dialog({
            message: "Thank you! Your information was successfully saved!", 
            buttons: {
              "success" : {
                "label" : "OK",
                "className" : "btn-sm btn-primary"
              }
            }
          });
        }).on('stepclick', function(e){
          //return false;//prevent clicking on steps
        });
      
        //documentation : http://docs.jquery.com/Plugins/Validation/validate
        $('#skip-validation').on('click', function(){
          $validation = this.checked;
          /*
          if(this.checked) {
            $('#sample-form').hide();
            $('#validation-form').removeClass('hide');
          }
          else {
            $('#validation-form').addClass('hide');
            $('#sample-form').show();
          }
          */
        });

      
        $.mask.definitions['~']='[+-]';
        //$('#person_telephoneNumber').mask('(999) 999-9999');
      
        /* VALIDAR DNI */

        jQuery.validator.addMethod( "student_official_id", function ( value, element ) {
         "use strict";
         
         value = value.toUpperCase();
         
         // Basic format test
         if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
          return false;
         }
         
         // Test NIF
         if ( /^[0-9]{8}[A-Z]{1}$/.test( value ) ) {
          return ( "TRWAGMYFPDXBNJZSQVHLCKE".charAt( value.substring( 8, 0 ) % 23 ) === value.charAt( 8 ) );
         }
         // Test specials NIF (starts with K, L or M)
         if ( /^[KLM]{1}/.test( value ) ) {
          return ( value[ 8 ] === String.fromCharCode( 64 ) );
         }
         
         return false;
        
        }, "Especifiqueu un NIF vàlid!.");
        /* /Validar dni */

        /*
        jQuery.validator.addMethod("person_telephoneNumber", function (value, element) {
          return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");
        */

        $.extend($.validator.messages, {
          required: "Aquest camp és obligatori.",
          remote: "Si us plau, omple aquest camp.",
          email: "Si us plau, escriu una adreça de correu-e vàlida",
          url: "Si us plau, escriu una URL vàlida.",
          date: "Si us plau, escriu una data vàlida.",
          dateISO: "Si us plau, escriu una data (ISO) vàlida.",
          number: "Si us plau, escriu un número enter vàlid.",
          digits: "Si us plau, escriu només dígits.",
          creditcard: "Si us plau, escriu un número de tarjeta vàlid.",
          equalTo: "Si us plau, escriu el maateix valor de nou.",
          extension: "Si us plau, escriu un valor amb una extensió acceptada.",
          maxlength: $.validator.format("Si us plau, no escriguis més de {0} caracters."),
          minlength: $.validator.format("Si us plau, no escriguis menys de {0} caracters."),
          rangelength: $.validator.format("Si us plau, escriu un valor entre {0} i {1} caracters."),
          range: $.validator.format("Si us plau, escriu un valor entre {0} i {1}."),
          max: $.validator.format("Si us plau, escriu un valor menor o igual a {0}."),
          min: $.validator.format("Si us plau, escriu un valor major o igual a {0}.")
        });

        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-inline',
          focusInvalid: false,
          rules: {
            student_official_id: {
              required: true,
              student_official_id: 'required',
            },
            person_givenName: {
              required: true
            },
            person_sn1: {
              required: true
            },
            person_email: {
              required: false,
              email:true
            },
            person_password: {
              required: false,
              minlength: 6
            },
            person_verify_password: {
              required: false,
              minlength: 6,
              equalTo: "#person_password"
            },
            
            person_telephoneNumber: {
              required: false
            },
            
            gender: 'required'
          },
      
          messages: {
            person_email: {
              required: "Si us plau especifiqueu un email vàlid.",
              email: "Si us plau especifiqueu un email vàlid."
            },
            person_password: {
              required: "És obligatori especificar una paraula de pas",
              minlength: "Si us plau especifiqueu una paraula de pas segura."
            },
            subscription: "Si us plau escolliu almenys una opció",
            gender: "Si us plau escolliu el gènere"
          },
      
          invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('.login-form')).show();
          },
      
          highlight: function (e) {
            $(e).closest('.control-group').removeClass('info').addClass('error');
          },
      
          success: function (e) {
            $(e).closest('.control-group').removeClass('error').addClass('info');
            $(e).remove();
          },
      
          errorPlacement: function (error, element) {
            if(element.is(':checkbox') || element.is(':radio')) {
              var controls = element.closest('div[class*="col-"]');
              if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
              else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if(element.is('.select2')) {
              error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if(element.is('.chosen-select')) {
              error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element);
          },
      
          submitHandler: function (form) {
          },
          invalidHandler: function (form) {
          }
        });

        $('#modal-wizard .modal-header').ace_wizard();
        $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
      })
    </script>
  
<!-- /Wizard -->
</div>
</div>
<?php


?>
