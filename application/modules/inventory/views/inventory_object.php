<div class="main-content">
 
<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>
 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="<?php echo base_url();?>">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active"><a href="<?php echo base_url('/index.php/inventory/inventory');?>"><?php echo lang('inventory');?></a></li>
 </ul>
</div>

<div class="page-content">

<div class="page-header position-relative">
                        <h1>
                            <a href="<?php echo base_url('index.php/inventory/inventory');?>"><?php echo lang("inventory");?></a>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                Objectes
                            </small>
                        </h1>
</div>

<div class="space-3"></div>

              <div class="row-fluid">
                
                <div class="span1"></div>

                <div class="span5 widget-container-span">
                  <div class="widget-box collapsed">
                    <div class="widget-header widget-header-small header-color-green">
                      <h6>
                        <i class="icon-sort"></i>
                        Manteniments
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
                        <div class="dd2-content"><a href="#">Tipus Identificadors externs</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Tipus Material</a></div>

                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Marques</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Models</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Proveïdors</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Origen dels diners</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Codis de barres</a></div>
                      </li>
                    </ol>






                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                      
                <div class="span5 widget-container-span">
                  <div class="widget-box collapsed">
                    <div class="widget-header widget-header-small header-color-orange">
                      <h6>
                        <i class="icon-sort"></i>
                        Informes d'inventari
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
                        <div class="dd2-content"><a href="#">Informe 1 TODO</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Informe 2 TODO</a></div>

                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">INFORME 3 TODO</a></div>
                      </li>
                    </ol>






                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                

              <div class="span2"></div>
            </div>

  <?php if ($data['grocery_crud_state'] == "list"): ?>         
  <div class="table-header">
    <i class="icon-group"></i> 
    <div class="inline position-relative">
              Unitat organitzativa principal:
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                             <?php echo $data['selected_organizational_unit'];?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                            <li> 
                              <a href="#">
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                Totes
                              </a>
                            </li>      
                          <?php foreach ($data['organizational_units'] as $organizational_unit_key => $organizational_unit): ?>
                            <li <?php if ($data['selected_organizational_unit_key'] == $organizational_unit_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($data['selected_organizational_unit_key'] == $organizational_unit_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $organizational_unit; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
    <i class="icon-double-angle-right"></i> 
    <div class="inline position-relative">
              Tipus de material:
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $data['selected_material_name'];?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                            <li> 
                              <a href="#">
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                Tots
                              </a>
                            </li>  
                          <?php foreach ($data['materials'] as $material_key => $material): ?>
                            <li <?php if ($data['selected_material_id'] == $material_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($data['selected_material_id'] == $material_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $material; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
    <i class="icon-double-angle-right"></i> 
    <div class="inline position-relative">
              Ubicació:
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $data['selected_location_name'];?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                            <li> 
                              <a href="#">
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                Totes
                              </a>
                            </li>  
                          <?php foreach ($data['locations'] as $location_key => $location): ?>
                            <li <?php if ($data['selected_location_id'] == $location_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($data['selected_location_id'] == $location_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $location; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>

    <div class="inline position-relative" style="float:right;">
              Proveidors: 
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $data['selected_provider_name'];?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                            <li> 
                              <a href="#">
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                Tots
                              </a>
                            </li>                              
                          <?php foreach ($data['providers'] as $provider_key => $provider_name): ?>
                            <li <?php if ($data['selected_provider_id'] == $provider_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($data['selected_provider_id'] == $provider_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $provider_name; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
  </div>
  <!-- End table header> -->
  <?php endif; ?>


        <!-- Load Grocery Crud -->
      <?php echo $output; ?>



</div>
      


</div>
