<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> User Successfully Created</div>
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
        <h3><i class="glyphicon glyphicon-user"></i> Add User</h3>

        <form action="<?php echo current_url(); ?>" method="POST">

            <table class="table table-hover" style="width: 100%">

                <tr>
                    <td>First Name : </td> 
                    <td>
                        <input type="text" name="first-name" class="form-control">
                        <?php echo form_error('first-name'); ?>
                    </td>
                </tr>    
                <tr>
                    <td>Last Name : </td> 
                    <td>
                        <input type="text" name="last-name" class="form-control">
                        <?php echo form_error('last-name'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Username :</td> 
                    <td>
                        <input type="text" name="user-name" class="form-control">
                        <?php echo form_error('user-name'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Password :</td> 
                    <td>
                        <input type="password" name="password" class="form-control">
                        <?php echo form_error('password'); ?>
                    </td>
                </tr> 
                <tr>
                    <td>Email : </td> 
                    <td>
                        <input type="text" name="email" class="form-control">
                        <?php echo form_error('email'); ?>
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
                                <option value="<?php echo $row[dbConfig::TABLE_USER_PRIVILEDGE_ATT_ID] ?>"><?php echo $row[dbConfig::TABLE_USER_PRIVILEDGE_ATT_NAME] ?></option>
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
                        <input class="btn btn-info" type="submit"  name="submit" value="Add"/>
                        <input class="btn btn-default" name="reset" type="reset" value="Cancel" />
                    </td>

                </tr>
            </table>
        </form>
    </div>
</div>