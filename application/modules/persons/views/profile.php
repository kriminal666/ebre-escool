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
  <li class="active"><?php echo "Perfil d'usuari";?></li>
 </ul>
</div>

        <div class="page-content">


        <div class="page-header position-relative">
                        <h1>
                            <?php echo lang("persons");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo "Perfil";?>
                            </small>
                        </h1>
        </div><!-- /.page-header -->

        <div class="pull-left alert alert-success no-margin">
                    <button type="button" class="close" data-dismiss="alert">
                      <i class="icon-remove"></i>
                    </button>

                    <i class="icon-umbrella bigger-120 blue"></i>
                    Editeu el vostre perfil!
        </div>


        <div class="row-fluid">
            <div class="span12">
              <!-- PAGE CONTENT BEGINS -->

              <div class="hr dotted"></div>

              <div>
                <div id="user-profile-1" class="user-profile row-fluid">
                  <div class="span3 center">
                    <div>
                      <span class="profile-picture">
                        <img id="avatar" class="editable" alt="<?php echo $this->session->userdata('username'); ?> Avatar" src="<?php echo base_url('assets/avatars/profile-pic.jpg');?>" />
                      </span>

                      <div class="space-4"></div>

                      <div class="width-80 label label-info label-large arrowed-in arrowed-in-right">
                        <div class="inline position-relative">
                          <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-circle light-green middle"></i>
                            &nbsp;
                            <span class="white middle bigger-120"><?php echo $this->session->userdata('fullname'); ?></span>
                          </a>

                          <ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
                            <li class="nav-header"> Canviar l'estatus </li>

                            <li>
                              <a href="#">
                                <i class="icon-circle green"></i>
                                &nbsp;
                                <span class="green">Disponible</span>
                              </a>
                            </li>

                            <li>
                              <a href="#">
                                <i class="icon-circle red"></i>
                                &nbsp;
                                <span class="red">Ocupat</span>
                              </a>
                            </li>

                            <li>
                              <a href="#">
                                <i class="icon-circle grey"></i>
                                &nbsp;
                                <span class="grey">Invisible</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="profile-contact-info">
                      <div class="profile-contact-links align-left">
                        <a class="btn btn-link" href="#">
                          <i class="icon-plus-sign bigger-120 green"></i>
                          Afegir com amic
                        </a>

                        <a class="btn btn-link" href="#">
                          <i class="icon-envelope bigger-120 pink"></i>
                          Enviar un missatge
                        </a>

                        <a class="btn btn-link" href="#">
                          <i class="icon-globe bigger-125 blue"></i>
                          www.elmeudomini.com
                        </a>
                      </div>

                      <div class="space-6"></div>

                      <div class="profile-social-links center">
                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
                          <i class="middle icon-facebook-sign icon-2x blue"></i>
                        </a>

                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
                          <i class="middle icon-twitter-sign icon-2x light-blue"></i>
                        </a>

                        <a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
                          <i class="middle icon-pinterest-sign icon-2x red"></i>
                        </a>
                      </div>
                    </div>

                    <div class="hr hr12 dotted"></div>

                    <div class="clearfix">
                      <div class="grid2">
                        <span class="bigger-175 blue">25</span>

                        <br />
                        Followers
                      </div>

                      <div class="grid2">
                        <span class="bigger-175 blue">12</span>

                        <br />
                        Following
                      </div>
                    </div>

                    <div class="hr hr16 dotted"></div>
                  </div>

                  <div class="span9">
                    <div class="center">
                      <span class="btn btn-app btn-small btn-light no-hover">
                        <span class="bigger-150 blue"> 1,411 </span>

                        <br />
                        <span class="smaller-90"> Views </span>
                      </span>

                      <span class="btn btn-app btn-small btn-yellow no-hover">
                        <span class="bigger-175"> 32 </span>

                        <br />
                        <span class="smaller-90"> Followers </span>
                      </span>

                      <span class="btn btn-app btn-small btn-pink no-hover">
                        <span class="bigger-175"> 4 </span>

                        <br />
                        <span class="smaller-90"> Projects </span>
                      </span>

                      <span class="btn btn-app btn-small btn-grey no-hover">
                        <span class="bigger-175"> 23 </span>

                        <br />
                        <span class="smaller-90"> Reviews </span>
                      </span>

                      <span class="btn btn-app btn-small btn-success no-hover">
                        <span class="bigger-175"> 7 </span>

                        <br />
                        <span class="smaller-90"> Albums </span>
                      </span>

                      <span class="btn btn-app btn-small btn-primary no-hover">
                        <span class="bigger-175"> 55 </span>

                        <br />
                        <span class="smaller-90"> Contacts </span>
                      </span>
                    </div>

                    <div class="space-12"></div>

                    <div class="profile-user-info profile-user-info-striped">
                      <div class="profile-info-row">
                        <div class="profile-info-name"> Id usuari </div>

                        <div class="profile-info-value">
                          <span class="editable" id="id"><?php echo $this->session->userdata('id'); ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Id persona </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_id"><?php echo $this->session->userdata('person_id'); ?></span>
                        </div>
                      </div>
                      

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Nom d'usuari </div>

                        <div class="profile-info-value">
                          <span class="editable" id="username"><?php echo $this->session->userdata('username'); ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Nom complet </div>

                        <div class="profile-info-value">
                          <span class="editable" id="fullname"><?php echo $this->session->userdata('fullname'); ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Nom </div>

                        <div class="profile-info-value">
                          <span class="editable" id="givenName"><?php echo $this->session->userdata('givenName'); ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> 1r Cognom </div>

                        <div class="profile-info-value">
                          <span class="editable" id="sn1"><?php echo $this->session->userdata('sn1'); ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> 2n Cognom </div>

                        <div class="profile-info-value">
                          <span class="editable" id="sn2"><?php echo $this->session->userdata('sn2'); ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Unitat </div>

                        <div class="profile-info-value">
                          <span class="editable" id="mainOrganizationaUnitId"><?php echo $this->session->userdata('mainOrganizationaUnitId') . " " . $organizational_unit_name; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Lloc </div>

                        <div class="profile-info-value">
                          <i class="icon-map-marker light-orange bigger-110"></i>
                          <span class="editable" id="city"><?php if ( isset ($person['person_locality_name']) ) { echo $person['person_locality_name']; } ?></span>

                          <!--<span class="editable" id="country">Netherlands</span>
                          <span class="editable" id="city">Amsterdam</span>-->
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Edad </div>

                        <div class="profile-info-value">
                          <span class="editable" id="age"> 38 </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Data Alta </div>

                        <div class="profile-info-value">
                          <span class="editable" id="signup"><?php if ( isset ($person['person_entryDate']) ) { echo $person['person_entryDate']; } ?>
                          </span>
                          <!--<span class="editable" id="signup">20/06/2010</span>-->
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> últim cop online </div>

                        <div class="profile-info-value">
                          <span class="editable" id="login">TODO: fa 3 hores</span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Descripció </div>

                        <div class="profile-info-value">
                          <span class="editable" id="about">Editable com WYSIWYG</span>
                        </div>
                      </div>
                    </div>

                    <div class="space-20"></div>

                    <div class="widget-box transparent">
                      <div class="widget-header widget-header-small">
                        <h4 class="blue smaller">
                          <i class="icon-rss orange"></i>
                          Activitat recent (pendent implementar)
                        </h4>

                        <div class="widget-toolbar action-buttons">
                          <a href="#" data-action="reload">
                            <i class="icon-refresh blue"></i>
                          </a>

                          &nbsp;
                          <a href="#" class="pink">
                            <i class="icon-trash"></i>
                          </a>
                        </div>
                      </div>

                      <div class="widget-body">
                        <div class="widget-main padding-8">
                          <div id="profile-feed-1" class="profile-feed">
                            <div class="profile-activity clearfix">
                              <div>
                                <img class="pull-left" alt="<?php echo $this->session->userdata('fullname'); ?> avatar" src="<?php echo base_url('assets/avatars/avatar5.png');?>" />
                                <a class="user" href="#"> <?php echo $this->session->userdata('fullname'); ?> </a>
                                ha canviat la seva foto.
                                <a href="#">Take a look</a>

                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  an hour ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <img class="pull-left" alt="Susan Smith's avatar" src="<?php echo base_url('assets/avatars/avatar1.png');?>" />
                                <a class="user" href="#"> Susan Smith </a>

                                és ara amiga de <?php echo $this->session->userdata('fullname'); ?>.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  2 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-ok btn-success no-hover"></i>
                                <a class="user" href="#"> <?php echo $this->session->userdata('fullname'); ?> </a>
                                joined
                                <a href="#">Country Music</a>

                                group.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  5 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-picture btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                uploaded a new photo.
                                <a href="#">Take a look</a>

                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  5 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>



                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-edit btn-pink no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                published a new blog post.
                                <a href="#">Read now</a>

                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  11 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  12 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-off btn-inverse no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged out.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  16 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  16 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="hr hr2 hr-double"></div>

                    <div class="space-6"></div>

                    <div class="center">
                      <a href="#" class="btn btn-small btn-primary">
                        <i class="icon-rss bigger-150 middle"></i>

                        Veure més activitat
                        <i class="icon-on-right icon-arrow-right"></i>
                      </a>
                    </div>

                    <div class="space-20"></div>

                  </div>
                </div>
              </div>


         </div>
        </div>      




        
	       <!-- PAGE-CONTENT END -->
        </div>
</div>


<script type="text/javascript">

$(function(){

        //////////////////////////////
        $('#profile-feed-1').slimScroll({
        height: '250px',
        alwaysVisible : true
        });

});
</script>

