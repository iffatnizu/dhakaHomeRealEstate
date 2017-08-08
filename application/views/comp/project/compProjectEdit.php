<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Project Successfully Updated</div>
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
                var selected = "";
                if (v.stateShortName == '<?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE] ?>')
                {
                    selected = 'selected="selected"';
                }
                var element = '<option ' + selected + ' value="' + v.stateShortName + '">' + v.stateName + '</option>';
                $("select[name=state]").append(element);
            });

            var response2 = '<?php echo $city ?>';
            var obj2 = $.parseJSON(response2);
            $.each(obj2, function(index, value) {
                var selected = "";
                if (value.cityId == '<?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_CITY] ?>')
                {
                    selected = 'selected="selected"';
                }
                var element2 = '<option ' + selected + ' value="' + value.cityId + '">' + value.cityName + '</option>';
                $("select[name=city]").append(element2);
            })

            
        })
    </script>
    <?php
    //debugPrint($city);
    if (!empty($details)) {
        ?>
        <form action="<?php echo current_url() ?>" method="POST">

            <h3><i class="glyphicon glyphicon-adjust"></i> Edit Project</h3>

            <div class="row">
                <div class="col-md-2">Company: </div>
                <div class="col-md-10">
                    <select name="company" class="form-control" onchange="getClientList(this.value)">
                        <option value="">-Please Select-</option>
                        <?php
                        foreach ($company as $name) {
                            ?>
                            <option <?php
                            if ($name[dbConfig::TABLE_COMPANY_ATT_ID] == $details[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]) {
                                echo 'selected="selected"';
                            }
                            ?> value="<?php echo $name[dbConfig::TABLE_COMPANY_ATT_ID] ?>"><?php echo $name[dbConfig::TABLE_COMPANY_ATT_NAME]; ?></option>
                                <?php
                            }
                            ?>
                    </select>
                    <?php echo form_error('company'); ?>
                </div>
            </div>



            <div class="row">
                <div class="col-md-2">Project Type: </div>
                <div class="col-md-10">
                    <select name="project-type" class="form-control">
                        <option value="">-Please Select-</option>
                        <?php
                        foreach ($type as $name) {
                            ?>
                            <option <?php
                            if ($name[dbConfig::TABLE_PROJECT_TYPE_ATT_ID] == $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID]) {
                                echo 'selected="selected"';
                            }
                            ?> value="<?php echo $name[dbConfig::TABLE_PROJECT_TYPE_ATT_ID] ?>"><?php echo ucfirst($name[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME]); ?></option>
                                <?php
                            }
                            ?>
                    </select>
                    <?php echo form_error('project-type'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">Project Name: </div>
                <div class="col-md-10">
                    <input name="project-name" class="form-control" type="text"  value="<?php echo ucfirst($details[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME]); ?>"/>
                    <?php echo form_error('project-name'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">Project Details: </div>
                <div class="col-md-10">
                    <textarea name="project-details" class="form-control"><?php echo ucfirst($details[dbConfig::TABLE_PROJECT_ATT_PROJECT_DETAILS]); ?></textarea>
                    <?php echo form_error('project-details'); ?>
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
                            <option <?php
                            if ($name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID] == $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY]) {
                                echo 'selected="selected"';
                            }
                            ?> value="<?php echo $name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID] ?>"><?php echo $name[dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME] ?></option>
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
                    <?php echo form_error('city'); ?>
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
