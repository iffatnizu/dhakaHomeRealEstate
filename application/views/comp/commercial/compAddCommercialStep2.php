<div class="container">
    <h3><i class="glyphicon glyphicon-adjust"></i> Add Commercial :: Step 2 <small>(Add Project)</small> </h3>
    <hr/>

    <?php
    $d = array();
    foreach ($project as $c) {
        array_push($d, $c[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME]);
    }
    ?>
    <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/typeahead.js"></script>

    <script type="text/javascript">
        var jsArray = <?php echo json_encode($d); ?>;
        var projects;

        $(document).ready(function() {
            $('input.typeahead').typeahead({
                name: 'client',
                local: jsArray
            });
        })

        function checkAddProject()
        {
            var typename = $("input[name=p-name]").val();

            if ($.trim(typename) != "") {

                if (jQuery.inArray(typename, jsArray) == -1) {
                    $("div[class=formArea]").show();
                    $("input[name=project-name]").val(typename);
                    $("input[name=p-name]").val("");
                }
                else
                {
                    $("div[class=formArea]").hide();

                    $.ajax({
                        type: "POST",
                        url: base_url + "commercial/setProject",
                        data: {
                            "typename": typename,
                            "submit": "1"
                        },
                        success: function(res)
                        {
                            if (res == '1')
                            {
                                location.href = base_url + "commercial/addCommercial/step3/"
                            }
                        }
                    })
                }
            }
        }
        function checkAddProjectNa()
        {
            var typename = '_NA';
            $.ajax({
                type: "POST",
                url: base_url + "apartment/setProject",
                data: {
                    "typename": typename,
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        location.href = base_url + "commercial/addCommercial/step3/"
                    }
                }
            })
        }
        function markAsIndividualProject()
        {
            var v = $("input[name=markAsIndividualProject]:checked").val();
            //alert(v);
            if (v == '1')
            {
                $("div[class=formArea]").hide();
                $("input[name=p-name]").attr("disabled", true)
                $("input[name=selected-project]").attr("disabled", true)
            }
            else {
                $("input[name=p-name]").removeAttr("disabled")
                $("input[name=selected-project]").removeAttr("disabled")
            }
        }
    </script>

    <div class="companyArea row">
        <?php
        if ($this->session->userdata('_setCompanyId') != 'COMPANY_NOT_APPLICABLE') {
            ?>
            <div class="col-md-5">
                <h4>Select Project </h4>
                <div class="demo">

                    <input name="p-name" class="typeahead" type="text" placeholder="Enter project name">
                    <input style="margin-top: 15px;" class="btn btn-info" type="button" name="selected-project" value="GO" onclick="checkAddProject()"/>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($this->session->userdata('_setCompanyId') == 'COMPANY_NOT_APPLICABLE') {
            ?>
            <div class="col-md-5">
                <h4>Mark as individual seller project </h4>
                <input type="checkbox" name="markAsIndividualProject" value="1" onclick="markAsIndividualProject()"/> Not applicable<br/>
                <input style="margin-top: 15px;" class="btn btn-info" type="button" name="na-project" value="GO" onclick="checkAddProjectNa()"/>
            </div>
            <?php
        }
        ?>
    </div>
    <hr/>

    <?php
    if ($this->session->userdata('_setCompanyId') != 'COMPANY_NOT_APPLICABLE') {
        ?>

        <div class="formArea" <?php if ($submit != '3') { ?>style="display: none;"> <?php } ?>

            <form action="<?php echo current_url() ?>" method="POST">
                <div class="row">
                    <div class="col-md-2">Company: </div>
                    <div class="col-md-10">
                        <select name="company" class="form-control" onchange="getClientList(this.value)">
                            <option value="">-Please Select-</option>
                            <?php
                            foreach ($company as $name) {
                                ?>
                                <option <?php
                                if ($this->session->userdata('_setCompanyId') == $name[dbConfig::TABLE_COMPANY_ATT_ID]) {
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
                            <option value="1" selected="selected">Commercial</option>
                        </select>
                        <?php echo form_error('project-type'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">Project Name: </div>
                    <div class="col-md-10">
                        <input name="project-name" class="form-control" type="text"  />
                        <?php echo form_error('project-name'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">Project E-mail: </div>
                    <div class="col-md-10">
                        <input name="project-email" class="form-control" type="text"  />
                        <?php echo form_error('project-email'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">Project Details: </div>
                    <div class="col-md-10">
                        <textarea name="project-details" class="form-control"></textarea>
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
                        <?php echo form_error('city'); ?>
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
        <?php
    }
    ?>
</div>
