<div class="container">

     <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Commercial Successfully Updated</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>

    <h3><i class="glyphicon glyphicon-adjust"></i> Edit Commercial </h3>
    <hr/>

    <?php
    ?>
    <form action="<?php echo current_url() ?>" method="POST">
        <div class="row">
            <div class="col-md-2">Commercial Name: </div>
            <div class="col-md-10">
                <input type="text" name="commercial-name" value="<?php echo $details[dbConfig::TABLE_COMMERCIAL_ATT_NAME] ?>" class="form-control"/>
                <?php echo form_error('commercial-name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Commercial Address: </div>
            <div class="col-md-10">
                <input type="text" name="commercial-address" value="<?php echo $details[dbConfig::TABLE_COMMERCIAL_ATT_ADDRESS] ?>" class="form-control"/>
                <?php echo form_error('commercial-address'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Commercial Floor: </div>
            <div class="col-md-10">
                <select name="commercial-floor" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($floor as $b) {
                        $selected = "";
                        if ($b[dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_ID] == $details[dbConfig::TABLE_COMMERCIAL_ATT_FLOOR]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $b[dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_ID] . '">' . $b[dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_VALUE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('commercial-floor'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Commercial Size: </div>
            <div class="col-md-10">
                <select name="commercial-size" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($size as $f) {
                        $selected = "";
                        if ($f[dbConfig::TABLE_COMMERCIAL_SIZE_ATT_ID] == $details[dbConfig::TABLE_COMMERCIAL_ATT_SIZE]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $f[dbConfig::TABLE_COMMERCIAL_SIZE_ATT_ID] . '">' . $f[dbConfig::TABLE_COMMERCIAL_SIZE_ATT_VALUE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('commercial-size'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Project : </div>
            <div class="col-md-10">
                <select name="commercial-project" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    if (!empty($project)) {
                        foreach ($project as $p) {
                            ?>
                            <option <?php
                            if ($this->session->userdata('_setProjectId') == $p[dbConfig::TABLE_PROJECT_ATT_ID]) {
                                echo 'selected="selected"';
                            } elseif ($details[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID] == $p[dbConfig::TABLE_PROJECT_ATT_ID]) {
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
                <?php echo form_error('commercial-project'); ?>
            </div>
        </div>

        <script type="text/javascript">
            function disabledSeller()
            {
                var v = $("input[name=markAsCompany]:checked").val();
                //alert(v);
                if (v == '1')
                {
                    $("select[name=commercial-seller]").attr("disabled", true)
                }
                else {
                    $("select[name=commercial-seller]").removeAttr("disabled");
                }
            }
            function checkStatus(id)
            {
                if(id=='1')
                {
                    //alert("a");
                    location.href = base_url+'<?php echo siteConfig::CONTROLLER_COMMERCIAL.siteConfig::METHOD_COMMMERCIAL_SELL_COMMMERCIAL ?>'+'<?php echo encode($details[dbConfig::TABLE_COMMERCIAL_ATT_ID]) ?>';
                }
            }
        </script>
        <div class="row">
            <div class="col-md-2">Seller : </div>
            <div class="col-md-3">
                <select <?php
                if ($details[dbConfig::TABLE_COMMERCIAL_ATT_MARK_AS_COMPANY] == '1') {
                    echo 'disabled="disabled"';
                }
                ?>  name="commercial-seller" class="form-control">
                    <option value="">-Please Select-</option>
                    <option selected="selected" value="<?php echo $details[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID] ?>"><?php echo $details['seller'] ?></option>
                </select>
                <span style="color: red;"><?php echo form_error('commercial-seller'); ?></span>
            </div>
            <div class="col-md-5">
                <input <?php
                if ($details[dbConfig::TABLE_COMMERCIAL_ATT_MARK_AS_COMPANY] == '1') {
                    echo 'checked="checked"';
                }
                ?> type="checkbox" name="markAsCompany" value="1" onclick="disabledSeller()"/> Mark as company
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="commercial-asking-price" value="<?php echo $details[dbConfig::TABLE_COMMERCIAL_ATT_ASKING_PRICE] ?>" class="form-control"/>
                <?php echo form_error('commercial-asking-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Minimum Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="commercial-asking-min-price" value="<?php echo $details[dbConfig::TABLE_COMMERCIAL_ATT_MINIMUM_ASKING_PRICE] ?>" class="form-control"/>
                <?php echo form_error('commercial-asking-min-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Currency: </div>
            <div class="col-md-10">

                <select name="commercial-currency" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($currency as $c) {
                        $selected = "";
                        if ($c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID] == $details[dbConfig::TABLE_COMMERCIAL_ATT_CURRENCY]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID] . '">' . $c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('commercial-currency'); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Condition: </div>
            <div class="col-md-10">
                <select name="commercial-condition" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($condition as $co) {
                        $selected = "";
                        if ($co[dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_ID] == $details[dbConfig::TABLE_COMMERCIAL_ATT_CONDITION]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option '.$selected.' value="' . $co[dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_ID] . '">' . $co[dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('commercial-condition'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Status : </div>
            <div class="col-md-10">
                <select name="commercial-status" class="form-control" onchange="checkStatus(this.value)">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($status as $st) {
                        $selected = "";
                        if ($st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID] == $details[dbConfig::TABLE_COMMERCIAL_ATT_STATUS]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID] . '">' . $st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_NAME] . '</option>';
                    }
                    ?>
                </select>
                <span style="color: red;"><?php echo form_error('plot-status'); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Comment: </div>
            <div class="col-md-10">

                <textarea name="commercial-comment" class="form-control"><?php echo $details[dbConfig::TABLE_COMMERCIAL_ATT_COMMENTS]; ?></textarea>
                <?php echo form_error('commercial-comment'); ?>
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
