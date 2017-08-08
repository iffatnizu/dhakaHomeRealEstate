<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Client Successfully Added</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <form action="<?php echo current_url() ?>" method="POST">

        <h3><i class="glyphicon glyphicon-adjust"></i> Add Client</h3>

        

<!--        <div class="row">
            <div class="col-md-2">File Number: </div>
            <div class="col-md-10">
                <input name="file-number" class="form-control" class="form-control" type="text"  />
                <?php echo form_error('file-number'); ?>
            </div>
        </div>-->

        <div class="row">
            <div class="col-md-2">First Name: </div>
            <div class="col-md-10">
                <input name="first-name" class="form-control" type="text"  />
                <?php echo form_error('first-name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Last Name: </div>
            <div class="col-md-10">
                <input name="last-name" class="form-control" type="text"  />
                <?php echo form_error('last-name'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Address: </div>
            <div class="col-md-10">
                <input name="address" class="form-control" type="text"  />
                <?php echo form_error('address'); ?>
            </div>
        </div>
        <?php
        //debugPrint($country);
        ?>
        <div class="row">
            <div class="col-md-2">Country: </div>
            <div class="col-md-10">
                <select name="countryId" class="form-control" onchange="getState(this.value)">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($country as $name) {
                        ?>
                        <option value="<?php echo $name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID] ?>"><?php echo $name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('countryId'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">State: </div>
            <div class="col-md-10">
                <select name="state" class="form-control" onchange="getCity(this.value)">
                    <option value="">-Please Select-</option>
                </select>
                <?php echo form_error('state'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">City: </div>
            <div class="col-md-10">
                <select name="city" class="form-control">
                    <option value="">-Please Select-</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Zip : </div>
            <div class="col-md-10">
                <input name="zip" class="form-control" type="text"  />
                <?php echo form_error('zip'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Cell Number: </div>
            <div class="col-md-10">
                <input name="cell-number" class="form-control" type="text"  />
                <?php echo form_error('cell-number'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Home Number: </div>
            <div class="col-md-10">
                <input name="home-number" class="form-control" type="text"  />
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Email: </div>
            <div class="col-md-10">
                <input name="email" class="form-control" type="text"  />
                <?php echo form_error('email'); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">Comment: </div>
            <div class="col-md-10">
                <textarea name="comment" class="form-control"></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-10">
                <input class="btn btn-info" name="submit" type="submit" value="Send" />
                <input class="btn btn-default" name="reset" type="reset" value="Cancel" />
            </div>

        </div>

    </form>
</div>
