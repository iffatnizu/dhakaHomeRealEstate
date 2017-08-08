<div class="container">
    <h3><i class="glyphicon glyphicon-adjust"></i> Add Commercial :: Step 3 <small>(Add Client)</small> </h3>
    <hr/>
    <?php
    $d = array();
    foreach ($client as $c) {
        array_push($d, $c[dbConfig::TABLE_CLIENT_ATT_EMAIL]);
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

        function checkAddClient()
        {
            var typename = $("input[name=client-email]").val();

            if ($.trim(typename) != "") {

                if (jQuery.inArray(typename, jsArray) == -1) {
                    $("div[class=formArea]").show();
                    $("input[name=email]").val(typename);
                    $("input[name=client-email]").val("");
                }
                else
                {
                    $("div[class=formArea]").hide();

                    $.ajax({
                        type: "POST",
                        url: base_url + "commercial/setClient",
                        data: {
                            "typename": typename,
                            "submit": "1"
                        },
                        success: function(res)
                        {
                            if (res == '1')
                            {
                                location.href = base_url + "commercial/addCommercial/step4/"
                            }
                        }
                    })
                }
            }
        }
    </script>

    <div class="companyArea">
        <h4>Select Client </h4>
        <div class="demo">

            <input name="client-email" class="typeahead" type="text" placeholder="Enter client email">
            <input style="margin-top: 15px;" class="btn btn-info" type="button" name="selected-clientmail" value="GO" onclick="checkAddClient()"/>
        </div>
    </div>
    <hr/>

    <div class="formArea" <?php if ($submit != '2') { ?>style="display: none;"> <?php } ?>

        <form action="<?php echo current_url() ?>" method="POST">

            

            <div class="row">
                <div class="col-md-2">File Number: </div>
                <div class="col-md-10">
                    <input name="file-number" class="form-control" class="form-control" type="text"  />
                    <?php echo form_error('file-number'); ?>
                </div>
            </div>

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

</div>
