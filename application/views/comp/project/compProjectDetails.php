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
                        <button type="button" class="btn btn-primary" onclick="sentMailToSingleProject('<?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL] ?>')">Send</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <h3><i class="glyphicon glyphicon-asterisk"></i> Project Details</h3>


        <div class="row">
            <div class="col-md-2">Company: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COMPANY_ATT_NAME] ?>
            </div>
        </div>



        <div class="row">
            <div class="col-md-2">Project Name: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Project Type: </div>
            <div class="col-md-10">
                <?php echo ucfirst($details[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME]) ?>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Project Details: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_DETAILS] ?>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Project Email: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL] ?>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Country: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">State: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_STATES_ATT_STATE_NAME] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">City: </div>
            <div class="col-md-10">
                <?php echo $details[dbConfig::TABLE_CITY_ATT_CITY_NAME] ?>
            </div>
        </div>




        <div class="row">
            <div class="col-md-2">
                <input data-toggle="modal" data-target="#single-mail" class="btn btn-warning" type="button" name="email" value="Send E-mail" />
            </div>
            <div class="col-md-10">
                <a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_EDIT . $details[dbConfig::TABLE_PROJECT_ATT_ID] ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_DELETE_PROJECT . $details[dbConfig::TABLE_PROJECT_ATT_ID] ?>" onclick="return confirm('Are you sure ? want to delete this')" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> Delete</a>
            </div>

        </div>
        <hr/>
        <h3>
            <i class="glyphicon glyphicon-cloud"></i> Commercial selling history

        </h3>

        <?php
        //debugPrint($sellHistory);
        if (!empty($sellHistory)) {
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
                                <div class="form-group" style="float: right;margin-bottom: 0px;">
                                    <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top: 8px;">Search</label>
                                    <div class="col-xs-10">
                                        <input type="text" class="form-control" id="search-input" placeholder="Search...">
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th width="5%"><i class="glyphicon glyphicon-sort"></i></th>
                            <th width="20%">Buyer</th>
                            <th width="25%">Seller</th>
                            <th width="25%">Project Name</th>
                            <th width="25%">Sold Date</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 0;
                        foreach ($sellHistory as $list) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_VIEW_CLIENT . $list['clientId'] ?>"></i><?php echo getClientNameById($list['clientId']) ?></a></td>
                                <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_VIEW_CLIENT . $list['sellerId'] ?>"></i><?php echo getClientNameById($list['sellerId']) ?></a></td>
                                <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_VIEW_PROJECT . $list['projectId'] ?>"></i><?php echo $list['project'] ?></a></td>
                                <td><?php echo date("l jS \of F Y h:i:s A T", $list[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_TIME]) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <?php
        } else {
            echo '<div class="alert alert-warning">No selling history found</div>';
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

