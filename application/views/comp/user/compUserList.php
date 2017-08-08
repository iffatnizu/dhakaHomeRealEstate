<div class="container">
    <?php
    if ($this->session->userdata('_delete')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> User Successfully Deleted</div>
        <?php
    }
    $session['_delete'] = FALSE;
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
    <h3><i class="glyphicon glyphicon-user"></i> User List</h3>

    <div id="dynamic">
        <table class="table table-bordered table-striped tablesorter" id="myTable">
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
                    <th width="10%">First Name</th>
                    <th width="10%">Last Name</th>
                    <th width="15%">User Name</th>
                    <th width="20%">E-mail Address</th>
                    <th width="15%">Priviledge </th>                          
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                foreach ($userList as $list) {
                    $i++;
                    ?>
                    <tr class="dlist">
                        <td><?php echo $list[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_USER_ATT_USER_LASTNAME] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_USER_ATT_USER_USERNAME] ?></td>
                        <td><?php echo $list[dbConfig::TABLE_USER_ATT_USER_EMAIL] ?> </td>
                        <td><?php echo $list[dbConfig::TABLE_USER_PRIVILEDGE_ATT_NAME] ?></td>
                        
                                       
                        <td><a href="<?php echo base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $list[dbConfig::TABLE_USER_ATT_USER_ID]; ?>" class="btn btn-info">View</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>



    </div>
</div>