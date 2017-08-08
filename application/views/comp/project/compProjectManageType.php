<div class="container">
    <?php
    if ($this->session->userdata('_addsuccess')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Project Type Successfully Added</div>
        <?php
    }
    $session['_addsuccess'] = FALSE;
    $this->session->unset_userdata($session);
    ?>

    <h3><i class="glyphicon glyphicon-adjust"></i> Add Project Type</h3>
    <form action="<?php echo current_url() ?>" method="POST" autocomplete="off">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="2">
                        Add Project Type
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        Type Name:
                    </td>
                    <td>
                        <input type="text" class="form-control" name="type-name" value=""/>
                        <?php echo form_error('type-name'); ?>
                    </td>
                </tr>       
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <input class="btn btn-default" type="submit" name="add-submit" value="Add"/>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>

    <h3><i class="glyphicon glyphicon-list"></i> Manage Type List</h3>

    <?php
    if ($this->session->userdata('_delsuccess')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Project Type Successfully Delete</div>
        <?php
    }
    $session['_delsuccess'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <?php
    if ($this->session->userdata('_delfail')) {
        ?>
        <div class="alert alert-danger"><i class="glyphicon glyphicon-remove-sign"></i> Error Occured Try Again</div>
        <?php
    }
    $session['_delfail'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
        
    <?php
    if ($this->session->userdata('_upsuccess')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Project Type Successfully Updated</div>
        <?php
    }
    $session['_upsuccess'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <?php
    if ($this->session->userdata('_upfail')) {
        ?>
        <div class="alert alert-danger"><i class="glyphicon glyphicon-remove-sign"></i> Error Occured Try Again</div>
        <?php
    }
    $session['_upfail'] = FALSE;
    $this->session->unset_userdata($session);
    ?>

    <script type="text/javascript">
        $(document).on(' change', 'input[name="selectAll"]', function() {
            $('td[class=checkArea] input').prop("checked", this.checked);
        });
    </script>
    <form action="<?php echo current_url() ?>" method="POST" onsubmit="return validateUpDelForm()">
        <table class="table table-bordered tablesorter" id="myTable">
            <thead>
                <tr>
                    <th style="width: 100px;"><i class="glyphicon glyphicon-sort"></i></th>
                    <th>Project Name</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                foreach ($typeList as $list) {
                    $i++;
                    ?>
                    <tr>
                        <td class="checkArea"><input type="checkbox" name="checkId[]" value="<?php echo $list[dbConfig::TABLE_PROJECT_TYPE_ATT_ID]; ?>"/></td>
                        <td><input type="text" class="form-control" name="project-type[<?php echo $list[dbConfig::TABLE_PROJECT_TYPE_ATT_ID]; ?>]" value="<?php echo $list[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME] ?>"/></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <input type="checkbox" class="selectAll" name="selectAll" value="1"/> Check All
                    </td>
                    <td>
                        <input class="btn btn-info" type="submit" name="update-submit" value="Update"/>
                        <input class="btn btn-default" type="submit" name="delete-submit" value="Delete"/>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
