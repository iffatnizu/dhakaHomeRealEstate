<div class="container">
    <?php
    if ($this->session->userdata('_delete')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Project Successfully Deleted</div>
        <?php
    }elseif ($this->session->userdata('_notdelete')) {
        ?>
        <div class="alert alert-warning"><i class="glyphicon glyphicon-warning-sign"></i> Project could not be Deleted.there was some plot or apartment or commercial related to this project </div>
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
    <h3><i class="glyphicon glyphicon-list"></i> Project List</h3>

    <div id="dynamic">
        <table class="table table-bordered tablesorter" id="myTable">
            <thead>

                <tr style="background: #EAEDF2">
                    <td colspan="8" align="right" style="padding: 0px;">
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
                    <th width="10%">Project Name</th>
                    <th width="10%">Project Type</th>
                    <th width="15%">Company</th>
                    
                    <th width="15%">City</th>               
                    <th width="15%">State</th>               
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                foreach ($projectList as $list) {
                    $i++;
                    ?>
                    <tr class="dlist">
                        <td class="checkArea"><input type="checkbox" name="checkId[]" value="<?php echo $list[dbConfig::TABLE_PROJECT_ATT_ID]; ?>"/></td>
                        <td><?php echo $list[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_COMPANY_ATT_NAME] ?></td>
                        
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
                        <button type="button" class="btn btn-primary" onclick="sendMailProject()">Send</button>
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