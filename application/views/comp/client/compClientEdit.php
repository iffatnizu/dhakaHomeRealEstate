<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Client Successfully Updated</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var response = '<?php echo $state ?>';
            var obj = $.parseJSON(response);
            $.each(obj, function(i, v) {
                var element = '<option value="' + v.stateShortName + '">' + v.stateName + '</option>';
                $("select[name=state]").append(element);
            });

            var response2 = '<?php echo $city ?>';
            var obj2 = $.parseJSON(response2);
            $.each(obj2, function(index, value) {
                var element2 = '<option value="' + value.cityId + '">' + value.cityName + '</option>';
                $("select[name=city]").append(element2);
            })
        })
    </script>
    <?php
    //debugPrint($city);
    if (!empty($details)) {
        ?>
    <form action="<?php echo current_url() ?>" method="POST">

        <h3><i class="glyphicon glyphicon-adjust"></i> Edit Client</h3>

       
        <div class="row">
            <div class="col-md-2">File Number: </div>
            <div class="col-md-10">
                <input name="file-number" class="form-control" class="form-control" type="text" value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_FILE_NUMBER] ?>"/>
                <?php echo form_error('file-number'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">First Name: </div>
            <div class="col-md-10">
                <input name="first-name" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME] ?>"/>
                <?php echo form_error('first-name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Last Name: </div>
            <div class="col-md-10">
                <input name="last-name" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_LAST_NAME] ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Address: </div>
            <div class="col-md-10">
                <input name="address" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_ADDRESS] ?>"/>
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
                        <option <?php if ($name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID] == $details[dbConfig::TABLE_CLIENT_ATT_COUNTRY]) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo $name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID] ?>"><?php echo $name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME] ?></option>
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
                    <option selected="selected" value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_STATE] ?>">-<?php echo $details[dbConfig::TABLE_STATES_ATT_STATE_NAME] ?>-</option>
                </select>
                <?php echo form_error('state'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">City: </div>
            <div class="col-md-10">
                <select name="city" class="form-control">
                    <option value="">-Please Select-</option>
                    <option selected="selected" value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_CITY] ?>">-<?php echo $details[dbConfig::TABLE_CITY_ATT_CITY_NAME] ?>-</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Zip : </div>
            <div class="col-md-10">
                <input name="zip" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_ZIP] ?>"/>
                <?php echo form_error('zip'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Cell Number: </div>
            <div class="col-md-10">
                <input name="cell-number" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_CELL_CONTACT_NUMBER] ?>"/>
                <?php echo form_error('cell-number'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Home Number: </div>
            <div class="col-md-10">
                <input name="home-number" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_HOME_CONTACT_NUMBER] ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">Email: </div>
            <div class="col-md-10">
                <input name="e-mail" class="form-control" type="email"  value="<?php echo $details[dbConfig::TABLE_CLIENT_ATT_EMAIL] ?>"/>
                <?php echo form_error('e-mail'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Comment: </div>
            <div class="col-md-10">
                <textarea name="comment" class="form-control"><?php echo $details[dbConfig::TABLE_CLIENT_ATT_COMMENT] ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-10">
                <input class="btn btn-info" name="submit" type="submit" value="Update" />
                <a href="<?php echo base_url() ?>" class="btn btn-default">Cancel</a>
            </div>

        </div>

    </form>
    <?php
    } else {
        ?>
        <div class="alert alert-warning">Content Not Found</div>
        <?php
    }
    ?>
</div>
