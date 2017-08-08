<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Password Successfully Updated</div>
        <?php
    }
    if ($this->session->userdata('_error')) {
        ?>
        <div class="alert alert-warning"><i class="glyphicon glyphicon-remove-sign"></i> Old Password Did Not Match</div>
        <?php
    }
    $session['_success'] = FALSE;
    $session['_error'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <div class="">
        <h3><i class="glyphicon glyphicon-user"></i> User Profile</h3>
        <form action="<?php echo current_url() ?>" method="POST">
            <table class="table table-hover" style="width: 100%">   
                <tr>
                    <td>Old Password : </td> 
                    <td><input type="password" name="old-password" class="form-control" value=""/> <?php echo form_error('old-password'); ?></td>
                </tr>    
                <tr>
                    <td>New Password : </td> 
                    <td><input type="password" name="new-password" class="form-control" value=""/> <?php echo form_error('new-password'); ?></td>
                </tr> 
                <tr>
                    <td>Confirm New Password : </td> 
                    <td><input type="password" name="connew-password" class="form-control" value=""/> <?php echo form_error('connew-password'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" name="submit" class="btn btn-info" value="Update"/>
                        <a href="<?php echo base_url() ?>" class="btn btn-default">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
