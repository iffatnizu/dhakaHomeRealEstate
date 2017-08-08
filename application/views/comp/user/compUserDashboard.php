<div class="container">
    <div class="row">
        <h3><i class="glyphicon glyphicon-asterisk"></i> Activity</h3>

        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/jquery.tablesorter.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#myTable").tablesorter();
            });
            $(document).ready(function() {
                // Write on keyup event of keyword input element
                $("#search-input").keyup(function() {
                    // When value of the input is not blank
                    if ($(this).val() != "")
                    {
                        // Show only matching TR, hide rest of them
                        $("#myTable tbody>tr").hide();
                        $("#myTable td:contains-ci('" + $(this).val() + "')").parent("tr").show();
                    }
                    else
                    {
                        // When there is no input or clean again, show everything back
                        $("#myTable tbody>tr").show();
                    }
                });
            });
            // jQuery expression for case-insensitive filter
            $.extend($.expr[":"], {"contains-ci": function(elem, i, match, array) {
                    return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                }
            });
        </script>
        <?php
        //debugPrint($feed);
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("[rel=tooltip]").tooltip({placement: 'top'});
            });
        </script>
        <table class="table table-bordered table-striped tablesorter" id="myTable">
            <thead>
                <tr style="background: #EAEDF2">
                    <td colspan="8" align="right" style="padding: 3px;">
                        <div class="form-group" style="float: right;margin-bottom: 0px;">
                            <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top: 8px;">Search</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="search-input" placeholder="Search...">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="background: #E8F1FA">                  
                    <th><i class="glyphicon glyphicon-sort"></i></th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
            <style>
                .qcont:first-letter{
                    text-transform: capitalize
                }
            </style>
            <?php
            $i = 0;
            foreach ($feed as $f):
                $i++;
                ?>
                <tr>
                    <td style="width: 50px;"><?php echo $f[dbConfig::TABLE_LOG_ATT_ID] ?></td>
                    <td class="qcont" style="font-size: 11px;">
                        <?php echo $f[dbConfig::TABLE_LOG_ATT_LOG_TXT] ?>
                        <span style="float: right"><a href="javascript:;" rel="tooltip" data-toggle="tooltip" title="<?php echo date("m/d/Y h:i:s A T", $f[dbConfig::TABLE_LOG_ATT_TIME]); ?>"><i class="glyphicon glyphicon-time"></i></a></span>
                    </td>
                </tr>

                <?php
            endforeach;
            ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
    <?php 
    echo $this->pagination->create_links();
    ?>
    <!--    <div class="row">
            <div class="col-md-5 alert alert-warning">
                <h3><i class="glyphicon glyphicon-asterisk"></i> Company Activity</h3>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover" id="myTable">
                    <thead>
                        <tr>                  
                            <th width="15%">Name</th>
                            <th width="15%">City</th>
                            <th width="20%">Address</th>
                            <th width="20%">Contact Number</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $i = 0;
    foreach ($companyList as $list) {
        $i++;
        ?>
                                            <tr>                
                                                <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_NAME]; ?></td>
                                                <td><?php echo $list[dbConfig::TABLE_CITY_ATT_CITY_NAME]; ?></td>
                                                <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_ADDRESS]; ?></td>
                                                <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_CONTACT_NUMBER]; ?></td>
                                                <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $list[dbConfig::TABLE_COMPANY_ATT_ID]; ?>" class="btn btn-info">View</a></td>
                                            </tr>
        <?php
    }
    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_LIST; ?>" class="btn btn-sm btn-info">View All</a>
                                <a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_ADD_COMPANY; ?>" class="btn btn-sm btn-danger">Add New</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-1">
    
            </div>
            <div class="col-md-6 alert alert-info">
                <h3><i class="glyphicon glyphicon-question-sign"></i> Client Activity</h3>
                <table class="table table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th width="10%">Company</th>
                        <th width="15%">File</th>
                        <th width="15%">Name</th>
                        <th width="20%">City</th>
                        <th width="20%">Contact Number(Cell)</th>                
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
    
    <?php
    $i = 0;
    foreach ($clientList as $list) {
        $i++;
        ?>
                                        <tr>                       
                                            <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_NAME] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_CLIENT_ATT_FILE_NUMBER] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME] ?> <?php echo $list[dbConfig::TABLE_CLIENT_ATT_LAST_NAME] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_CITY_ATT_CITY_NAME] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_CLIENT_ATT_CELL_CONTACT_NUMBER] ?></td>                     
                                            <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_VIEW_CLIENT . $list[dbConfig::TABLE_CLIENT_ATT_ID]; ?>" class="btn btn-info">View</a></td>
                                        </tr>
        <?php
    }
    ?>
                </tbody>
                <tfoot>
                    <tr>
                            <td colspan="5">
                                <a href="<?php echo base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_CLIENT_LIST ?>" class="btn btn-sm btn-info">View All</a>
                                <a href="<?php echo base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_ADD_CLIENT ?>" class="btn btn-sm btn-danger">Add New</a>
                            </td>
                        </tr>
                </tfoot>
            </table>
            </div>
        </div>-->
    <!--    <div class="row">
            <div class="col-md-5 alert alert-success">
                <h3><i class="glyphicon glyphicon-cloud"></i> Project Activity</h3>
                <table class="table table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th width="10%">Project</th>
                        <th width="10%">Project Type</th>
                        <th width="15%">Company</th>
                        <th width="20%">Client</th>
                                 
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
    
    <?php
    $i = 0;
    foreach ($projectList as $list) {
        $i++;
        ?>
                                        <tr>                        
                                            <td><?php echo $list[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_NAME] ?></td>
                                            <td><?php echo $list[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME] ?> <?php echo $list[dbConfig::TABLE_CLIENT_ATT_LAST_NAME] ?></td>
                                            
                                                           
                                            <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_VIEW_PROJECT . $list[dbConfig::TABLE_PROJECT_ATT_ID]; ?>" class="btn btn-info">View</a></td>
                                        </tr>
        <?php
    }
    ?>
                </tbody>
                <tfoot>
                    <tr>
                            <td colspan="5">
                                <a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_LIST; ?>" class="btn btn-sm btn-info">View All</a>
                                <a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_ADD_PROJECT; ?>" class="btn btn-sm btn-danger">Add New</a>
                            </td>
                        </tr>
                </tfoot>
            </table>
            </div>
            <div class="col-md-1">
    
            </div>
            <div class="col-md-6 alert alert-danger">
                <h3><i class="glyphicon glyphicon-user"></i> User Activity</h3>
            </div>
        </div>-->
    <!--    <a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_PROFILE; ?>">
            <img src="<?php echo base_url() ?>assets/images/userProfile.jpg" alt="HTML tutorial" width="150" height="150">
        </a>
        <a href="#">
            <img src="<?php echo base_url() ?>assets/images/settings.jpg" alt="HTML tutorial" width="150" height="150">
        </a>-->
    Loading Time: <?php echo $this->benchmark->elapsed_time(); ?>
</div>