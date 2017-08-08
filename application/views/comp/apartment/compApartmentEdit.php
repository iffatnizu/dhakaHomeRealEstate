<div class="container">

    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Apartment Successfully Updated</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>

    <h3><i class="glyphicon glyphicon-adjust"></i> Edit Apartment </h3>
    <hr/>

    <?php
    ?>
    <form action="<?php echo current_url() ?>" method="POST">
        <div class="row">
            <div class="col-md-2">Apartment Name: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-name" value="<?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] ?>" class="form-control"/>
                <?php echo form_error('apartment-name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Address: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-address" value="<?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ADDRESS] ?>" class="form-control"/>
                <?php echo form_error('apartment-address'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Size: </div>
            <div class="col-md-10">
                <select name="apartment-size" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($size as $b) {
                        $selected = "";
                        if ($b[dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SIZE]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $b[dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_ID] . '">' . $b[dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_VALUE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-size'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Floor: </div>
            <div class="col-md-10">
                <select name="apartment-floor" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($floor as $b) {
                        $selected = "";
                        if ($b[dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FLOOR]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $b[dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_ID] . '">' . $b[dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-floor'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Facing: </div>
            <div class="col-md-10">
                <select name="apartment-facing" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($facing as $f) {

                        $selected = "";
                        if ($f[dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FACING]) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option ' . $selected . ' value="' . $f[dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_ID] . '">' . $f[dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-facing'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Bed: </div>
            <div class="col-md-10">
                <select name="apartment-bed" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($bed as $f) {
                        $selected = "";
                        if ($f[dbConfig::TABLE_APARTMENT_BED_ATT_BED_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BED]) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option ' . $selected . ' value="' . $f[dbConfig::TABLE_APARTMENT_BED_ATT_BED_ID] . '">' . $f[dbConfig::TABLE_APARTMENT_BED_ATT_BED_VALUE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-bed'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Bath: </div>
            <div class="col-md-10">
                <select name="apartment-bath" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($bath as $f) {
                        $selected = "";
                        if ($f[dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BATH]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $f[dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_ID] . '">' . $f[dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_VALUE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-bath'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Project : </div>
            <div class="col-md-10">
                <select name="apartment-project" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    if (!empty($project)) {
                        foreach ($project as $p) {
                            ?>
                            <option <?php
                            if ($this->session->userdata('_setProjectId') == $p[dbConfig::TABLE_PROJECT_ATT_ID]) {
                                echo 'selected="selected"';
                            } elseif ($details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID] == $p[dbConfig::TABLE_PROJECT_ATT_ID]) {
                                echo 'selected="selected"';
                            }
                            ?> value="<?php echo $p[dbConfig::TABLE_PROJECT_ATT_ID] ?>"><?php echo $p[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?></option> 
                                <?php
                            }
                        } else {
                            ?>
                        <option selected="selected" value="PROJECT_NOT_APPLICABLE">_NA</option>   
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-project'); ?>
            </div>
        </div>

        <script type="text/javascript">
            function disabledSeller()
            {
                var v = $("input[name=markAsCompany]:checked").val();
                //alert(v);
                if (v == '1')
                {
                    $("select[name=apartment-seller]").attr("disabled", true)
                }
                else {
                    $("select[name=apartment-seller]").removeAttr("disabled");
                }
            }
            function checkStatus(id)
            {
                if(id=='1')
                {
                    //alert("a");
                    location.href = base_url+'<?php echo siteConfig::CONTROLLER_APARTMENT.siteConfig::METHOD_APARTMENT_SELL_APARTMENT ?>'+'<?php echo encode($details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID]) ?>';
                }
            }
        </script>
        <div class="row">
            <div class="col-md-2">Seller : </div>
            <div class="col-md-3">
                <select <?php
                if ($details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_MARK_AS_COMPANY] == '1') {
                    echo 'disabled="disabled"';
                }
                ?> name="apartment-seller" class="form-control">
                    <option value="">-Please Select-</option>
                    <option selected="selected" value="<?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID] ?>"><?php echo $details['seller'] ?></option>
                </select>
                <span style="color: red;"><?php echo form_error('apartment-seller'); ?></span>
            </div>
            <div class="col-md-5">
                <input <?php
                if ($details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_MARK_AS_COMPANY] == '1') {
                    echo 'checked="checked"';
                }
                ?>  type="checkbox" name="markAsCompany" value="1" onclick="disabledSeller()"/> Mark as company
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-asking-price" value="<?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_PRICE] ?>" class="form-control"/>
                <?php echo form_error('apartment-asking-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Minimum Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-asking-min-price" value="<?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_MIN_PRICE] ?>" class="form-control"/>
                <?php echo form_error('apartment-asking-min-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Currency: </div>
            <div class="col-md-10">

                <select name="apartment-currency" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($currency as $c) {

                        $selected = "";
                        if ($c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CURRENCY]) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option ' . $selected . ' value="' . $c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID] . '">' . $c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-currency'); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Condition: </div>
            <div class="col-md-10">
                <select name="apartment-condition" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($condition as $co) {

                        $selected = "";
                        if ($co[dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CONDITION]) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option ' . $selected . ' value="' . $co[dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_ID] . '">' . $co[dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-condition'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Status : </div>
            <div class="col-md-10">
                <select name="apartment-status" class="form-control" onchange="checkStatus(this.value)">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($status as $st) {

                        $selected = "";
                        if ($st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID] == $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_STATUS]) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option ' . $selected . ' value="' . $st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID] . '">' . $st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_NAME] . '</option>';
                    }
                    ?>
                </select>
                <span style="color: red;"><?php echo form_error('apartment-status'); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Comment: </div>
            <div class="col-md-10">

                <textarea name="apartment-comment" class="form-control"><?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_COMMENT]; ?></textarea>
                <?php echo form_error('apartment-comment'); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-10">
                <input class="btn btn-info" name="submit" type="submit" value="Update" />
                <input class="btn btn-default" name="reset" type="reset" value="Cancel" />
            </div>

        </div>

    </form>
</div>
