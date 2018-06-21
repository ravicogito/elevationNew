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
		<?php if($this->session->userdata('role_id')==1){?>
        <!--<li class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>         
        </li>-->
		<li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Customer Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Customer/listcustomer/'; ?>"><i class="fa fa-circle-o"></i> All customers</a></li>
			<li><a href="<?php echo base_url().'Customer/RefidToCustomerList/'; ?>"><i class="fa fa-circle-o"></i>Assign RFID To Customer </a></li>
			<li><a href="<?php echo base_url().'customerImageUpload/'; ?>"><i class="fa fa-circle-o"></i> Image List</a></li>
			<li><a href="<?php echo base_url().'Customer/getMailchimpSubscribers/'; ?>"><i class="fa fa-circle-o"></i> Mailchimp List Subscribers</a></li>
			<li><a href="<?php echo base_url().'Mailchimp/mailchimplist/'; ?>"><i class="fa fa-circle-o"></i> Mailchimp Template</a></li>
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
            <!--<li><a href="<?php //echo base_url().'Event'; ?>"><i class="fa fa-circle-o"></i>Event List</a></li>
			<li><a href="<?php //echo base_url().'Event/EventToCustomerList/'; ?>"><i class="fa fa-circle-o"></i>Assign Customer</a></li>-->
			<li><a href="<?php echo base_url().'Event/listAll'; ?>"><i class="fa fa-circle-o"></i>Event List</a></li>
			
			<li><a href="<?php echo base_url().'Guide/listAll'; ?>"><i class="fa fa-circle-o"></i>Rafting List</a></li>
			
			<li><a href="<?php echo base_url().'Category/allCategory/'; ?>"><i class="fa fa-circle-o"></i>Category List</a></li>
          </ul>
        </li>
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>River Rafting Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Riverraftingcompany/'; ?>"><i class="fa fa-circle-o"></i> River Rafting Company List</a></li>

          </ul>

        </li>
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Guide Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'guide/guideManagement'; ?>"><i class="fa fa-circle-o"></i> Guide Management</a></li>

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

        <li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Options Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li><a href="<?php echo base_url().'Options/listoption/'; ?>"><i class="fa fa-circle-o"></i> Manage Option</a></li>
             <li><a href="<?php echo base_url().'ManageOptionPrint/listOptionPrint/'; ?>"><i class="fa fa-circle-o"></i> Manage Option Print Size</a></li>
             <li><a href="<?php echo base_url().'Options/listoptionhead/'; ?>"><i class="fa fa-circle-o"></i> Manage Option Head</a></li>
             <li><a href="<?php echo base_url().'Options/listoptionmeta/'; ?>"><i class="fa fa-circle-o"></i> Manage Option Meta</a></li>
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

            <i class="fa fa-edit"></i> <span>Order Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Order/listorder'; ?>"><i class="fa fa-circle-o"></i> Order Management</a></li>

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
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>FAQ Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Faq/'; ?>"><i class="fa fa-circle-o"></i> FAQ  List</a></li>

          </ul>

        </li>
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Privacy Policy Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Privacypolicy/'; ?>"><i class="fa fa-circle-o"></i> Privacy Policy List</a></li>

          </ul>

        </li>
		
		<li class="treeview">

          <a href="javascript:void(0)">

            <i class="fa fa-edit"></i> <span>Inner page Banner Management</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url().'Banner/'; ?>"><i class="fa fa-circle-o"></i> Banner List</a></li>

          </ul>

        </li>
		
		
		
		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'page/listpages'; ?>"><i class="fa fa-circle-o"></i> All Pages</a></li>
           
          </ul>
        </li>
		
		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Photographer/accountsetting'; ?>"><i class="fa fa-circle-o"></i> My Setting</a></li>
           
          </ul>
        </li>
		
		<?php } else{ ?>	
		<li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Customer Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Customer/listcustomer/'; ?>"><i class="fa fa-circle-o"></i> All customer</a></li>
			<li><a href="<?php echo base_url().'Customer/RefidToCustomerList/'; ?>"><i class="fa fa-circle-o"></i>Assign RFID To Customer </a></li>
			<li><a href="<?php echo base_url().'customerImageUpload/'; ?>"><i class="fa fa-circle-o"></i> Image List</a></li>
			<li><a href="<?php echo base_url().'Customer/getMailchimpSubscribers/'; ?>"><i class="fa fa-circle-o"></i> Mailchimp List Subscribers</a></li>
			<li><a href="<?php echo base_url().'Mailchimp/mailchimplist/'; ?>"><i class="fa fa-circle-o"></i> Mailchimp Template</a></li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="javascript:void(0)">
            <i class="fa fa-edit"></i> <span>Event Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Event'; ?>"><i class="fa fa-circle-o"></i>Event List</a></li>
			<li><a href="<?php echo base_url().'Event/EventToCustomerList/'; ?>"><i class="fa fa-circle-o"></i>Assign Event To Customer </a></li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'Photographer/accountsetting'; ?>"><i class="fa fa-circle-o"></i> My Setting</a></li>
           
          </ul>
        </li>
		
		<?php } ?>	
	</ul>


    </section>
    <!-- /.sidebar -->
  </aside>