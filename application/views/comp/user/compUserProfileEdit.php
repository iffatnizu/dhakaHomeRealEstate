<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> User Successfully Updated</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <style>
        td p{
            color:red;
        }
    </style>
    <div class="">
        <h3><i class="glyphicon glyphicon-user"></i> Edit User</h3>

        <form action="<?php echo current_url(); ?>" method="POST">

            <table class="table table-hover" style="width: 100%">

                <tr>
                    <td>First Name : </td> 
                    <td>
                        <input type="text" name="first-name" class="form-control" value="<?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME] ?>">
                        <?php echo form_error('first-name'); ?>
                    </td>
                </tr>    
                <tr>
                    <td>Last Name : </td> 
                    <td>
                        <input type="text" name="last-name" class="form-control" value="<?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_LASTNAME] ?>">
                        <?php echo form_error('last-name'); ?>
                    </td>
                </tr>
                
                <tr>
                    <td>Privilege : </td> 
                    <td>
                        <select name="priviledge" class="form-control">
                            <option value="">-Please Select-</option>

                            <?php
                            foreach ($priviledge as $row) {
                                ?>
                                <option <?php if ($row[dbConfig::TABLE_USER_PRIVILEDGE_ATT_ID] == $userProfile[dbConfig::TABLE_USER_ATT_USER_PREVILEDGE]) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo $row[dbConfig::TABLE_USER_PRIVILEDGE_ATT_ID] ?>"><?php echo $row[dbConfig::TABLE_USER_PRIVILEDGE_ATT_NAME] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo form_error('priviledge'); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input class="btn btn-info" type="submit"  name="submit" value="Update"/>
                        <a href="<?php echo base_url() ?>" class="btn btn-default">Cancel</a>
                    </td>

                </tr>
            </table>
        </form>
    </div>
</div>