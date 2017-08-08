<div class="container">
    <?php
    if ($this->session->userdata('_success')) {
    ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Commercial Successfully Added</div>
    <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>
    <h3><i class="glyphicon glyphicon-adjust"></i> Add Commercial :: Step 1<small>(Add Company)</small> </h3>
    <hr/>

    <?php
    $d = array();
    foreach ($company as $c) {
        array_push($d, $c[dbConfig::TABLE_COMPANY_ATT_NAME]);
    }
    ?>
    <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/typeahead.js"></script>

    <script type="text/javascript">
        var jsArray = <?php echo json_encode($d); ?>;
        var projects;

        $(document).ready(function() {
            $('input.typeahead').typeahead({
                name: 'company',
                local: jsArray
            });
        })

        function checkAddCompany()
        {
            var typename = $("input[name=company-name]").val();

            if ($.trim(typename) != "") {

                if (jQuery.inArray(typename, jsArray) == -1) {
                    $("div[class=formArea]").show();
                    $("input[name=company]").val(typename);
                    $("input[name=company-name]").val("");
                }
                else
                {
                    $("div[class=formArea]").hide();

                    $.ajax({
                        type: "POST",
                        url: base_url + "commercial/setCompany",
                        data: {
                            "typename": typename,
                            "submit": "1"
                        },
                        success: function(res)
                        {
                            if (res == '1')
                            {
                                location.href = base_url + "commercial/addCommercial/step2/"
                            }
                        }
                    })
                }
            }
        }
        function checkAddCompanyNa()
        {
            var v = $("input[name=markAsIndividualSeller]:checked").val();
            if (v == '1') {
                var typename = '_NA';
                $.ajax({
                    type: "POST",
                    url: base_url + "apartment/setCompany",
                    data: {
                        "typename": typename,
                        "submit": "1"
                    },
                    success: function(res)
                    {
                        if (res == '1')
                        {
                            location.href = base_url + "commercial/addCommercial/step2/"
                        }
                    }
                })
            }

        }
        function markAsIndividualSeller()
        {
            var v = $("input[name=markAsIndividualSeller]:checked").val();
            //alert(v);
            if (v == '1')
            {
                $("div[class=formArea]").hide();
                $("input[name=company-name]").attr("disabled", true)
                $("input[name=selected-company]").attr("disabled", true)
            }
            else {
                $("input[name=company-name]").removeAttr("disabled")
                $("input[name=selected-company]").removeAttr("disabled")
            }
        }
    </script>

    <div class="companyArea row">
        <div class="col-md-5">
            <h4>Select Company </h4>
            <div class="demo">

                <input name="company-name" class="typeahead" type="text" placeholder="Enter company name">
                <input style="margin-top: 15px;" class="btn btn-info" type="button" name="selected-company" value="GO" onclick="checkAddCompany()"/>
            </div>
        </div>
        <div class="col-md-5">
            <h4>Mark as individual seller </h4>
            <input type="checkbox" name="markAsIndividualSeller" value="1" onclick="markAsIndividualSeller()"/> Not applicable<br/>
            <input style="margin-top: 15px;" class="btn btn-info" type="button" name="na-company" value="GO" onclick="checkAddCompanyNa()"/>
        </div>
    </div>
    
    <br class="clear"/>
    <hr/>
    <div class="formArea" <?php if ($submit != '1') { ?>style="display: none;"> <?php } ?>

        <form action="<?php echo current_url(); ?>" method="POST">
            <div class="row">
                <div class="col-md-2">Company Name: </div>
                <div class="col-md-10">
                    <input name="company" class="form-control" class="form-control" type="text"  />
                    <?php echo form_error('company'); ?>
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
                <div class="col-md-2">Contact Number: </div>
                <div class="col-md-10">
                    <input name="cell-number" class="form-control" type="text"  />
                    <?php echo form_error('cell-number'); ?>
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
                <div class="col-md-2">Contact Person: </div>
                <div class="col-md-10">
                    <input name="contact-person" class="form-control" type="text"  />
                    <?php echo form_error('contact-person'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">Contact Person Number: </div>
                <div class="col-md-10">
                    <input name="contact-person-number" class="form-control" type="text"  />
                    <?php echo form_error('contact-person-number'); ?>
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
</div>

