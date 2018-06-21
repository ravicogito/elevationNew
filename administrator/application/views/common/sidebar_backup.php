 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">      
        <div class="pull-left image">
        
        	<img src="<?php echo base_url(); ?>assets/dist/img/admin.png" class="img-circle" alt="User Image">
        
        </div><br><br>
        <div class="stats-label text-color">
			<h5 class="font-extra-bold font-uppercase" style="color:white">Site Administrator</h5>
			<div class="dropdown">
				<a class="btn btn-xs btn-default" href="<?php echo base_url(); ?>Login/change_password">
				   <i class="fa fa-lock"></i> Change Password
				</a>
			   
			</div>

		</div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
          
	<ul class="sidebar-menu" data-widget="tree">        
        <?php if($this->session->userdata('admin_user_type') == '1') {?>  
        <!--<li class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>         
        </li>-->
		<?php }?>
		<li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Customer Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Customer/listcustomer/'; ?>"><i class="fa fa-circle-o"></i> All customer</a></li>
			<li><a href="<?php echo base_url().'customerImageUpload/'; ?>"><i class="fa fa-circle-o"></i> Image List</a></li>
          </ul>
        </li>
		
       <!-- <li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Order Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'orderManagement/'; ?>"><i class="fa fa-circle-o"></i>Order List</a></li>
          </ul>
        </li>-->		
		
		<li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Event Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Event'; ?>"><i class="fa fa-circle-o"></i>Event List</a></li>
          </ul>
        </li>
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Photographer Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Photographer/'; ?>"><i class="fa fa-circle-o"></i> Photographer List</a></li>

          </ul>

        </li>
		<!--<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Image Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'customerImageUpload/'; ?>"><i class="fa fa-circle-o"></i> Image List</a></li>

          </ul>

        </li>-->
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Resort Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Resort/'; ?>"><i class="fa fa-circle-o"></i> Resort List</a></li>

          </ul>

        </li>
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Location Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Locations/listlocations'; ?>"><i class="fa fa-circle-o"></i> Location Management</a></li>

          </ul>

        </li>
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Role Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Role/listrole'; ?>"><i class="fa fa-circle-o"></i> Role Management</a></li>

          </ul>

        </li>
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>User Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'User/listuser'; ?>"><i class="fa fa-circle-o"></i> User Management</a></li>

          </ul>

        </li>
		
	</ul>


    </section>
    <!-- /.sidebar -->
  </aside>