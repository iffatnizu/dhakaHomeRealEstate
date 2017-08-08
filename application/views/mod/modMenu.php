<div class="topMenu">
    <div class="container">
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo base_url() ?>"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a></li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-question-sign"></i> Client <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().siteConfig::CONTROLLER_CLIENT.siteConfig::METHOD_ADD_CLIENT ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url().siteConfig::CONTROLLER_CLIENT.siteConfig::METHOD_CLIENT_LIST ?>">View All</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-asterisk"></i> Company <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_ADD_COMPANY; ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_LIST; ?>">View All</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cloud"></i> Project <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_ADD_PROJECT; ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_LIST; ?>">View All</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_MANAGE_TYPE; ?>">Manage Project Type</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cloud"></i> Payment <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PAYMENT . siteConfig::METHOD_ADD_PAYMENT; ?>">Create Invoice</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PAYMENT . siteConfig::METHOD_ALL_PAYMENT; ?>">All Invoices</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PAYMENT . siteConfig::METHOD_DUE_PAYMENT; ?>">Due Payments List</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PAYMENT . siteConfig::METHOD_PAID_PAYMENT ?>">Paid Payments List</a></li>
                            <li class="divider"></li>
                            
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-tower"></i> Plot <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT.'step1/'; ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_LIST_PLOT; ?>">View All</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-home"></i> Apartment <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_ADD_APARTMENT.'step1/'; ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_LIST_APARTMENT; ?>">View All</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-bullhorn"></i> Commercial <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL.'step1/'; ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_LIST_COMMMERCIAL; ?>">View All</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> User <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_ADD; ?>">Add New</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_LIST; ?>">View All</a></li>
                            
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench"></i> Setting <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_PROFILE; ?>">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_EDIT_PROFILE; ?>">Edit Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_CHANGE_PASSWORD; ?>">Change Password</a></li>
                            
                        </ul>
                    </li>
                    <li><a href="#"><i class="glyphicon glyphicon-envelope"></i> Contact Us</a></li>
                    <li><a onclick="return confirm('Are you want to logout ?')"  href="<?php echo site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_LOGOUT); ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                    
                </ul>
            </div>
        </nav>
    </div>
</div>