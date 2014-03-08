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
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Nom:</label>

                                  <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                      <input type="text" name="name" id="name" class="col-xs-12 col-sm-6" />
                                    </div>
                                  </div>
                                </div>

                                <div class="space-2"></div>

                                <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="surname1">Primer Cognom:</label>

                                  <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                      <input type="text" name="surname1" id="surname1" class="col-xs-12 col-sm-4" />
                                    </div>
                                  </div>
                                </div>

                                <div class="space-2"></div>

                                <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="surname2">Segon Cognom:</label>

                                  <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                      <input type="text" name="surname2" id="surname2" class="col-xs-12 col-sm-4" />
                                    </div>
                                  </div>
                                </div>


                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="periode_academic">Periode Acadèmic</label>

                                  <div class="col-xs-12 col-sm-9">
                                    <select id="periode_academic" name="periode_academic" class="select2" data-placeholder="Selecciona un periode acadèmic">
                                      <option value="">&nbsp;</option>
                                      <option value="ap1">Periode Acadèmic 1</option>
                                      <option value="ap2">Periode Acadèmic 2</option>
                                      <option value="ap3">Periode Acadèmic 3</option>
                                      <option value="ap4">Periode Acadèmic 4</option>
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
                            </div>

                            <div class="step-pane" id="step3">
                              <div class="center">
                                <h3 class="blue lighter"><?php echo lang('enrollment_classgroups');?></h3>
                                Han de sortir els grups de classe de l'estudi.
                              </div>
                            </div>

                            <div class="step-pane" id="step4">
                              <div class="center">
                                <h3 class="green"><?php echo lang('enrollment_modules');?></h3>
                                Per defecte tots els mòduls marcats.
                              </div>
                            </div>

                            <div class="step-pane" id="step5">
                              <div class="center">
                                <h3 class="green"><?php echo lang('enrollment_submodules');?></h3>
                                Unitats formatives.
                                <br />Tots marcats de tots els MPS del pas anterior.
                              </div>
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
    <!-- inline scripts related to this page -->

    <script type="text/javascript">
      jQuery(function($) {
      
        $('[data-rel=tooltip]').tooltip();
      
        $(".select2").css('width','200px').select2({allowClear:true})
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