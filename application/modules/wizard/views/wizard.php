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
  <li class="active"><?php echo lang('enrollment');?></li>
 </ul>
</div><!-- /breadcrumbds -->

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
<!-- Wizard -->

                <!-- PAGE CONTENT BEGINS -->
                <div class="row-fluid">
                  <div class="span12">
                    <div class="widget-box">
                      <div class="widget-header widget-header-blue widget-header-flat">
                        <h4 class="lighter"><?php echo lang('new_enrollment');?></h4>
                        <div class="widget-toolbar">
                          <label>
                            <small class="green">
                              <b><?php echo lang('validation');?></b>
                            </small>
                            <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4" />
                            <span class="lbl"></span>
                          </label>
                        </div>
                      </div> <!-- /widget-header -->

                      <div class="widget-body">
                        <div class="widget-main">
                          <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
                            <ul class="wizard-steps">
                              <li data-target="#step1" class="active">
                                <span class="step">1</span>
                                <span class="title"><?php echo lang('enrollment');?></span>
                              </li>

                              <li data-target="#step2">
                                <span class="step">2</span>
                                <span class="title"><?php echo lang('enrollment_studies');?></span>
                              </li>

                              <li data-target="#step3">
                                <span class="step">3</span>
                                <span class="title"><?php echo lang('enrollment_classgroups');?></span>
                              </li>

                              <li data-target="#step4">
                                <span class="step">4</span>
                                <span class="title"><?php echo lang('enrollment_modules');?></span>
                              </li>

                              <li data-target="#step5">
                                <span class="step">5</span>
                                <span class="title"><?php echo lang('enrollment_submodules');?></span>
                              </li>
                            </ul>
                          </div>

                          <hr />
                          <div class="step-content row-fluid position-relative" id="step-container">
                            <div class="step-pane active" id="step1">
                              <div class="row-fluid center">
                                <h3 class="lighter block green"><?php echo lang('enrollment');?></h3>
                                Persona i període acadèmic
                              </div>
                          
                      <!-- Formulari step 1 -->

                          <form class="form-horizontal" id="validation-form" method="get">

                                <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="academic_period">Periode Acadèmic</label>

                                  <div class="col-xs-12 col-sm-9">
                                    <input type="text" name="academic_period" placeholder="Escriu un periode Acadèmic" />
                                  </div>
                                </div>



                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="student">Alumne</label>

                                  <div class="col-xs-12 col-sm-9">
                                    <select id="student" name="student" class="select2" data-placeholder="Selecciona un Estudiant" style="width:800px;">
                                      <option value="">&nbsp;</option>
                                      <?php 
                                        foreach($enrollment_students as $enrollment_student){
                                          ?>
                                          <option value="<?php echo $enrollment_student['student_person_id']; ?>"><?php echo $enrollment_student['student_fullName']; ?></option>
                                          <?php } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="space-2"></div>
                            </form>
                      <!-- /Formulari step 1 -->
                            </div>

                            <div class="step-pane" id="step2">
                              <div class="row-fluid center">
                                <h3 class="blue lighter"><?php echo lang('enrollment_studies');?></h3>
                                Seleccionar un Studi.
                              </div>

                      <!-- Formulari step 2 -->
                          <form class="form-horizontal" id="enrollment_study-form" method="get">
                                <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="enrollment_study">Estudi</label>
                                  <div class="col-xs-12 col-sm-9">
                                    <select id="enrollment_study" name="enrollment_study" class="select2" data-placeholder="Selecciona un Estudi">
                                      <option value="">&nbsp;</option>
                                      <?php 
                                        foreach($enrollment_studies as $enrollment_study){
                                          ?>
                                          <option value="<?php echo $enrollment_study['studies_id']; ?>"><?php echo $enrollment_study['studies_shortname']; ?></option>
                                          <?php } ?>

                                    </select>
                                  </div>
                                </div>

                                <div class="space-2"></div>
                            </form>
                      <!-- /Formulari step 2 -->


                            </div>

                            <div class="step-pane" id="step3">
                              <div class="center">
                                <h3 class="blue lighter"><?php echo lang('enrollment_classgroups');?></h3>
                                Han de sortir els grups de classe de l'estudi.
                              </div>

                      <!-- Formulari step 3 -->

                          <form class="form-horizontal" id="classroom_group-form" method="get">
                                <div id="step3_selected_study"></div>
                                <div id="step3_classroom_group" class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="enrollment_study">Grups de Classe</label>
                                  <div class="col-xs-12 col-sm-9">
                                    <select id="classroom_group" name="classroom_group" class="select2" data-placeholder="Selecciona un Grup de Classe">
                                      <option value="">&nbsp;</option>
                                      <?php 
                                        foreach($enrollment_classroom_groups as $enrollment_classroom_group){
                                          ?>
                                          <option value="<?php echo $enrollment_classroom_group['classroom_group_id']; ?>"><?php echo $enrollment_classroom_group['classroom_group_shortName']; ?></option>
                                          <?php } ?>

                                    </select>
                                  </div>
                                </div>

                                <div class="space-2"></div>
                            </form>
                      <!-- /Formulari step 3 -->

                            </div>

                            <div class="step-pane" id="step4">
                              <div class="center">
                                <h3 class="green"><?php echo lang('enrollment_modules');?></h3>
                                Per defecte tots els mòduls marcats.
                              </div>

                      <!-- Formulari step 4 -->
                          <form class="form-horizontal" id="study_module-form" method="get">
                                <div id="step4_study_module"class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="study_modules">Mòduls Formatius</label><br /><br />
                                  <div class="col-xs-12 col-sm-9">
                                  <?php      
                                    foreach($enrollment_study_modules as $enrollment_study_module){
                                  ?>
                                          <input type="checkbox" checked name="<?php echo $enrollment_study_module['study_module_id']; ?>" value="<?php echo $enrollment_study_module['study_module_id']; ?>"/><?php echo " ".$enrollment_study_module['study_module_shortname']." - ".$enrollment_study_module['study_module_name']; ?> <br />
                                  <?php } ?>

                                  </div>
                                </div>

                                <div class="space-2"></div>
                            </form>
                      <!-- /Formulari step 4 -->

                            </div>

                            <div class="step-pane" id="step5">
                              <div class="center">
                                <h3 class="green"><?php echo lang('enrollment_submodules');?></h3>
                                Unitats formatives.
                                <br />Tots marcats de tots els MPS del pas anterior.
                              </div>

                      <!-- Formulari step 5 -->
                          <form class="form-horizontal" id="study_submodules-form" method="get">
                                <div id="step5_study_submodules" class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="study_modules">Unitats Formatives</label><br /><br />
                                  <div class="col-xs-12 col-sm-9">
                                      
                                  <?php      
                                    foreach($enrollment_study_submodules as $enrollment_study_submodule){
                                  ?>
                                          <input type="checkbox" checked name="<?php echo $enrollment_study_submodule['study_submodules_id']; ?>" value="<?php echo $enrollment_study_submodule['study_submodules_id']; ?>"/><?php echo " (".$enrollment_study_submodule['study_module_shortname'].") ".$enrollment_study_submodule['study_submodules_shortname']." - ".$enrollment_study_submodule['study_submodules_name']; ?> <br />
                                  <?php } ?>

                                  </div>
                                </div>

                                <div class="space-2"></div>
                            </form>
                      <!-- /Formulari step 5 -->

                          </div>
                            </div>
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
                          </div>
                        </div><!-- /widget-main -->
                      </div><!-- /widget-body -->
                    </div>
                  </div>
                </div><!-- PAGE CONTENT ENDS -->

    <script type="text/javascript">
      if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <script>
    $(document).ready(function(){
      study = $("#enrollment_study").val();
      study_name = $("#enrollment_study option:selected").text();
      $("#enrollment_study").change(function(){
          study = $("#enrollment_study").val();
          study_name = $("#enrollment_study option:selected").text();
          
          //AJAX per obtenir Grup de Classe
          jQuery.ajax({
            url:'<?php echo base_url("index.php/wizard/classroom_group");?>'+'/'+study,
            type: 'get',
            datatype: 'json'
          }).done(function(date){
            $.each(data, function(k,v){
              alert("K: "+k+" V: "+v);
            });
          });
          $("#step3_selected_study").html("<h3>Estudi: "+study_name+"</h3>");          
        });



});

    </script>







    <!-- inline scripts related to this page -->

    <script type="text/javascript">
      jQuery(function($) {
      
        $('[data-rel=tooltip]').tooltip();
      
        $(".select2").css('width','300px').select2({allowClear:true})
        .on('change', function(){
          $(this).closest('form').validate().element($(this));
        }); 
      
      
        var $validation = false;
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
      
      
        $('#skip-validation').removeAttr('checked').on('click', function(){
          $validation = this.checked;
          if(this.checked) {
            $('#sample-form').hide();
            $('#validation-form').removeClass('hide');
          }
          else {
            $('#validation-form').addClass('hide');
            $('#sample-form').show();
          }
        });

        //documentation : http://docs.jquery.com/Plugins/Validation/validate
      
      
        $.mask.definitions['~']='[+-]';
        $('#phone').mask('(999) 999-9999');
      
        jQuery.validator.addMethod("phone", function (value, element) {
          return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");
      
        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-block',
          focusInvalid: false,
          rules: {
            email: {
              required: true,
              email:true
            },
            password: {
              required: true,
              minlength: 5
            },
            password2: {
              required: true,
              minlength: 5,
              equalTo: "#password"
            },
            name: {
              required: true
            },
            phone: {
              required: true,
              phone: 'required'
            },
            url: {
              required: true,
              url: true
            },
            comment: {
              required: true
            },
            state: {
              required: true
            },
            platform: {
              required: true
            },
            subscription: {
              required: true
            },
            gender: 'required',
            agree: 'required'
          },
      
          messages: {
            email: {
              required: "Please provide a valid email.",
              email: "Please provide a valid email."
            },
            password: {
              required: "Please specify a password.",
              minlength: "Please specify a secure password."
            },
            subscription: "Please choose at least one option",
            gender: "Please choose gender",
            agree: "Please accept our policy"
          },
      
          invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('.login-form')).show();
          },
      
          highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
          },
      
          success: function (e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
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
            else error.insertAfter(element.parent());
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