<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Company Successfully Updated</div>
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

            <h3><i class="glyphicon glyphicon-adjust"></i> Edit Company</h3>

            <div class="row">
                <div class="col-md-2">Company Name: </div>
                <div class="col-md-10">
                    <input name="company" class="form-control" class="form-control" type="text" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_NAME] ?>"/>
                    <?php echo form_error('company'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">Address: </div>
                <div class="col-md-10">
                    <input name="address" class="form-control" type="text"  value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_ADDRESS] ?>"/>
                    <?php echo form_error('address'); ?>
                </div>
            </div>
            <?php
            //debugPrint($state);
            ?>
            <div class="row">
                <div class="col-md-2">Country: </div>
                <div class="col-md-10">
                    <select name="countryId" class="form-control" onchange="getState(this.value)">
                        <option value="">-Please Select-</option>
                        <?php
                        foreach ($country as $name) {
                            ?>
                            <option <?php if ($name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID] == $details[dbConfig::TABLE_COMPANY_ATT_COUNTRY]) {
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
                        <option selected="selected" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_STATE] ?>">-<?php echo $details[dbConfig::TABLE_STATES_ATT_STATE_NAME] ?>-</option>
                    </select>
    <?php echo form_error('state'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">City: </div>
                <div class="col-md-10">
                    <select name="city" class="form-control">
                        <option value="">-Please Select-</option>
                        <option selected="selected" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_CITY] ?>">-<?php echo $details[dbConfig::TABLE_CITY_ATT_CITY_NAME] ?>-</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">Zip : </div>
                <div class="col-md-10">
                    <input name="zip" class="form-control" type="text" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_ZIP] ?>"/>
    <?php echo form_error('zip'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">Contact Number: </div>
                <div class="col-md-10">
                    <input name="cell-number" class="form-control" type="text" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_CONTACT_NUMBER] ?>"/>
    <?php echo form_error('cell-number'); ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-2">Contact Person: </div>
                <div class="col-md-10">
                    <input name="contact-person" class="form-control" type="text" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NAME] ?>"/>
    <?php echo form_error('contact-person'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">Contact Person Number: </div>
                <div class="col-md-10">
                    <input name="contact-person-number" class="form-control" type="text" value="<?php echo $details[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NUMBER] ?>"/>
    <?php echo form_error('contact-person-number'); ?>
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
