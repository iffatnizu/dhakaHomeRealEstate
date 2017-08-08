<div class="container">

    <?php
    //debugPrint($details);
    if (!empty($details)) {
        ?>
        <div class="modal fade" id="single-mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-envelope"></i> Compose New Mail</h4>
                    </div>
                    <div class="modal-body">
                        <div id="s-mailStatus" class="alert alert-info" style="display: none;"></div>
                        <table class="table table-striped">
                            <tr>
                                <td style="width: 100px;">Subject:</td>
                                <td><input type="text" name="s-subject" value="" class="form-control"/></td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td>
                                    <div class="designelement">
                                        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/cpr_editor.js"></script>
                                        <ul id="formateText">
                                            <li><a onclick="changeStyle('bold')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-bold"></i></a></li>
                                            <li><a onclick="changeStyle('italic')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-italic"></i></a></li>
                                            <li><a onclick="changeStyle('underline')" href="javascript:;" class="btn">U</a></li>                                                                                             
                                            <li><a onclick="changeStyle('insertunorderedlist')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-list"></i></a></li>
                                            <li><a onclick="changeStyle('indent')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-indent-right"></i></a></li>
                                            <li><a onclick="changeStyle('outdent')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-indent-left"></i></a></li>
                                            <li><a onclick="changeFontColor()" href="javascript::" class="btn"><i class="glyphicon glyphicon-pencil"></i></a></li>

                                            <li><a onclick="changeLink()" href="javascript:;" class="btn"><i class="glyphicon glyphicon-font"></i></a></li>                    
                                            <li><a onclick="changeStyle('justifyleft')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-left"></i></a></li>
                                            <li><a onclick="changeStyle('justifycenter')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-center"></i></a></li>
                                            <li><a onclick="changeStyle('justifyright')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-right"></i></a></li> 
                                            <li><a onclick="changeStyle('justifyfull')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-justify"></i></a></li>
                                        </ul>
                                    </div>
                                    <br clear="all"/>
                                    <div id="s-sendMsgWriteArea" contenteditable="true" class="form-control" style="height: auto;min-height: 200px"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="sentMailToSingleCompany('<?php echo $details[dbConfig::TABLE_COMPANY_ATT_EMAIL] ?>')">Send</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <h3><i class="glyphicon glyphicon-asterisk"></i> Company Details</h3>

        <div class="row">
            <div class="col-md-2">Company Name: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_NAME]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Address: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_ADDRESS]; ?>
            </div>
        </div>
        <?php
        //debugPrint($country);
        ?>
        <div class="row">
            <div class="col-md-2">Country: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">State: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_STATES_ATT_STATE_NAME]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">City: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_CITY_ATT_CITY_NAME]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Zip : </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_ZIP]; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Contact Number: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_CONTACT_NUMBER]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Email: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_EMAIL]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Contact Person: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NAME]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Contact Person Number: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NUMBER]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <input data-toggle="modal" data-target="#single-mail" class="btn btn-warning" type="button" name="email" value="Send E-mail" />
            </div>
            <div class="col-md-10">
                <a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_EDIT . $details[dbConfig::TABLE_COMPANY_ATT_ID] ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a href="<?php echo base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_DELETE_COMPANY . $details[dbConfig::TABLE_COMPANY_ATT_ID] ?>" onclick="return confirm('Are you sure ? want to delete this')" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> Delete</a>
            </div>

        </div>
        <hr/>
        <h3><i class="glyphicon glyphicon-cloud"></i> Company Project</h3>
        <?php
        if (!empty($projectList)) {
            ?>
            <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/jquery.tablesorter.js"></script>
            <script type="text/javascript">
                    $(document).ready(function() {
                        $("#myTable").tablesorter();
                    });
                    $(document).on(' change', 'input[name="selectAll"]', function() {
                        $('td[class=checkArea] input').prop("checked", this.checked);
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
            <div id="dynamic">
                <table class="table table-bordered tablesorter" id="myTable">
                    <thead>

                        <tr>
                            <td colspan="8" align="right">
                                <div class="form-group" style="float: right;">
                                    <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top: 8px;">Search</label>
                                    <div class="col-xs-10">
                                        <input type="text" class="form-control" id="search-input" placeholder="Search...">
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th width="5%"><i class="glyphicon glyphicon-sort"></i></th>
                            <th width="10%">Project Name</th>
                            <th width="10%">Project Type</th>
                            <th width="15%">Company</th>
                            <th width="20%">Client</th>
                            <th width="15%">City</th>               
                            <th width="15%">State</th>               
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
                                <td class="checkArea"><input type="checkbox" name="checkId[]" value="<?php echo $list[dbConfig::TABLE_PROJECT_ATT_ID]; ?>"/></td>
                                <td><?php echo $list[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?></td>
                                <td><?php echo $list[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME] ?></td>
                                <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_NAME] ?></td>
                                <td><?php echo $list[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME] ?> <?php echo $list[dbConfig::TABLE_CLIENT_ATT_LAST_NAME] ?></td>
                                <td><?php echo $list[dbConfig::TABLE_CITY_ATT_CITY_NAME] ?></td>
                                <td><?php echo $list[dbConfig::TABLE_STATES_ATT_STATE_NAME] ?></td>

                                <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_VIEW_PROJECT . $list[dbConfig::TABLE_PROJECT_ATT_ID]; ?>" class="btn btn-info">View</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" class="selectAll" name="selectAll" value="1"/> Check All
                            </td>
                            <td colspan="6" align="right">

                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-envelope"></i> Compose New Mail</h4>
                            </div>
                            <div class="modal-body">
                                <div id="mailStatus" class="alert alert-info" style="display: none;"></div>
                                <table class="table table-striped">
                                    <tr>
                                        <td style="width: 100px;">Subject:</td>
                                        <td><input type="text" name="subject" value="" class="form-control"/></td>
                                    </tr>
                                    <tr>
                                        <td>Description:</td>
                                        <td>
                                            <div class="designelement">
                                                <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/cpr_editor.js"></script>
                                                <ul id="formateText">
                                                    <li><a onclick="changeStyle('bold')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-bold"></i></a></li>
                                                    <li><a onclick="changeStyle('italic')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-italic"></i></a></li>
                                                    <li><a onclick="changeStyle('underline')" href="javascript:;" class="btn">U</a></li>                                                                                             
                                                    <li><a onclick="changeStyle('insertunorderedlist')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-list"></i></a></li>
                                                    <li><a onclick="changeStyle('indent')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-indent-right"></i></a></li>
                                                    <li><a onclick="changeStyle('outdent')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-indent-left"></i></a></li>
                                                    <li><a onclick="changeFontColor()" href="javascript::" class="btn"><i class="glyphicon glyphicon-pencil"></i></a></li>

                                                    <li><a onclick="changeLink()" href="javascript:;" class="btn"><i class="glyphicon glyphicon-font"></i></a></li>                    
                                                    <li><a onclick="changeStyle('justifyleft')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-left"></i></a></li>
                                                    <li><a onclick="changeStyle('justifycenter')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-center"></i></a></li>
                                                    <li><a onclick="changeStyle('justifyright')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-right"></i></a></li> 
                                                    <li><a onclick="changeStyle('justifyfull')" href="javascript:;" class="btn"><i class="glyphicon glyphicon-align-justify"></i></a></li>
                                                </ul>
                                            </div>
                                            <br clear="all"/>
                                            <div id="sendMsgWriteArea" contenteditable="true" class="form-control" style="height: auto;min-height: 200px"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="sendMailCompany()">Send</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <input type="button" data-toggle="modal" data-target="#myModal" name="sendmail" class="btn btn-info" value="Send mail" style="margin-top: 0px;" />



            </div>
            <?php
        } else {
            echo '<div class="alert alert-warning">No project found for this company</div>';
        }
        ?>
        <?php
    } else {
        ?>
        <div class="alert alert-warning">Content Not Found</div>
        <?php
    }
    ?>
</div>
