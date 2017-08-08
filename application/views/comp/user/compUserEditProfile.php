<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Profile Successfully Updated</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <div class="">
        <h3><i class="glyphicon glyphicon-user"></i> User Profile</h3>
        <form action="<?php echo current_url() ?>" method="POST">
            <table class="table table-hover" style="width: 100%">   
                <tr>
                    <td>First Name : </td> 
                    <td><input type="text" name="first-name" class="form-control" value="<?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME]; ?>"/> <?php echo form_error('first-name'); ?></td>
                </tr>    
                <tr>
                    <td>Last Name : </td> 
                    <td><input type="text" name="last-name" class="form-control" value="<?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_LASTNAME]; ?>"/> <?php echo form_error('last-name'); ?></td>
                </tr> 
                <tr>
                    <td>Email : </td> 
                    <td><input type="text" name="email" class="form-control" value="<?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_EMAIL]; ?>"/> <?php echo form_error('email'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" name="submit" class="btn btn-info" value="Edit Profile"/>
                        <a href="<?php echo base_url() ?>" class="btn btn-default">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
