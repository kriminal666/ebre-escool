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

        <div class="page-header position-relative">
                        <h1>
                            <a href="<?php echo base_url('index.php/inventory/inventory');?>"><?php echo lang("inventory");?></a>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                Objectes
                            </small>
                        </h1>
        </div><!-- /.page-header -->

	<div style="margin:10px;">
   		
      <!-- Load Grocery Crud -->
      <?php echo $output; ?>




	</div>	
</div>

<script type="text/javascript">

$(document).ready(function() {


//console.debug("provaheyfar");

/*new FixedColumns( oTableArray[0], {
    "iLeftColumns": 1,
    "iRightColumns": 1
  } );
*/


});

</script>