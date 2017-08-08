<div class="container">
    <?php
    if ($this->session->userdata('_delete')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Commercial Successfully Deleted</div>
        <?php
    }
    elseif ($this->session->userdata('_notdelete')) {
        ?>
        <div class="alert alert-warning"><i class="glyphicon glyphicon-warning-sign"></i> Commercial could not be deleted.Commercial already sold </div>
        <?php
    }
    $session['_delete'] = FALSE;
    $session['_notdelete'] = FALSE;
    $this->session->unset_userdata($session);
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
    <h3><i class="glyphicon glyphicon-list"></i> Commercial List</h3>
    <?php
    //debugPrint($commercialList);
    ?>
    <div id="dynamic">
        <table class="table table-bordered table-striped tablesorter" id="myTable">
            <thead>

                <tr style="background: #EAEDF2">
                    <td colspan="11" align="right" style="padding: 0px;">
                        <div class="form-group" style="float: right;padding: 3px;margin: 0px;">
                            <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top: 8px;">Search</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="search-input" placeholder="Search...">
                            </div>
                        </div>
                    </td>
                </tr>

                <tr style="background: #E8F1FA;">
                    <th width="5%"><i class="glyphicon glyphicon-sort"></i></th>
                    <th width="15%">Project Name</th>
                    <th width="12%">Commercial Name</th>
                    <th width="13%">Address</th>
                    <th width="10%">Size</th>
                    <th width="10%">Floor</th>
                    <th width="8%">Condition</th>
                    <th width="10%">Status</th>
                    <th width="10%">Price</th>
                    <th width="13%">Currency</th>                   
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                foreach ($commercialList as $list) {
                    $i++;
                    ?>
                    <tr class="dlist">
                        <td class="checkArea"><input type="checkbox" name="checkId[]" value="<?php echo encode($list[dbConfig::TABLE_COMMERCIAL_ATT_ID]); ?>"/></td>
                        <td>
                            
                            <?php
                            if($list[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME]=="")
                            {
                                echo 'Individual Project';
                            }
                            else{
                                echo $list[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME];
                            }
                            ?>
                        </td>
                        <td><?php echo $list[dbConfig::TABLE_COMMERCIAL_ATT_NAME] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_COMMERCIAL_ATT_ADDRESS] ?></td>
                        <td><?php echo $list['size'] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_VALUE] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_COMMERCIAL_CONDITION_ATT_NAME] ?></td>
                        <td>
                            
                            <?php
                            if ($list[dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_NAME] == 'Sold') {
                                ?>
                                <span class="alert alert-danger" style="padding: 5px;"><?php echo $list[dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_NAME] ?></span>
                                <?php
                            } else {
                                ?>
                                <span class="alert alert-success" style="padding: 5px;"><?php echo $list[dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_NAME] ?></span>
                                <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $list[dbConfig::TABLE_COMMERCIAL_ATT_MINIMUM_ASKING_PRICE] ?>-<?php echo $list[dbConfig::TABLE_COMMERCIAL_ATT_ASKING_PRICE] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE] ?></td>                        
                        <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_VIEW_COMMMERCIAL. encode($list[dbConfig::TABLE_COMMERCIAL_ATT_ID]); ?>" class="btn btn-info">View</a></td>
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
                    <td colspan="11" align="right">

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
                        <button type="button" class="btn btn-primary" onclick="sendMailCommercial()">Send</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        
        <input type="button" data-toggle="modal" data-target="#myModal" name="sendmail" class="btn btn-info" value="Send mail" style="margin-top: 0px;" />


        <?php
        echo $this->pagination->create_links();
        ?>



    </div>
</div>