<div class="container">

    <?php
    if ($this->session->userdata('_success')) {
        ?>
        <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Plot Successfully Updated</div>
        <?php
    }
    $session['_success'] = FALSE;
    $this->session->unset_userdata($session);
    ?>

    <h3><i class="glyphicon glyphicon-adjust"></i> Edit Plot</h3>
    <hr/>

    <?php
    //debugPrint($details);
    ?>
    <form action="<?php echo current_url() ?>" method="POST">
        <div class="row">
            <div class="col-md-2">Plot Name: </div>
            <div class="col-md-10">
                <input type="text" name="plot-name" value="<?php echo $details[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] ?>" class="form-control"/>
                <?php echo form_error('plot-name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Plot Address: </div>
            <div class="col-md-10">
                <input type="text" name="plot-address" value="<?php echo $details[dbConfig::TABLE_PLOT_ATT_PLOT_ADDESS] ?>" class="form-control"/>
                <?php echo form_error('plot-address'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Plot Block: </div>
            <div class="col-md-10">
                <select name="plot-block" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($block as $b) {
                        $selected = "";
                        if ($b[dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_ID] == $details[dbConfig::TABLE_PLOT_ATT_PLOT_BLOCK]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $b[dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_ID] . '">' . $b[dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('plot-block'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Plot Facing: </div>
            <div class="col-md-10">
                <select name="plot-facing" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($facing as $f) {
                        $selected = "";
                        if ($f[dbConfig::TABLE_PLOT_FACING_ATT_FACE_ID] == $details[dbConfig::TABLE_PLOT_ATT_PLOT_FACING]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $f[dbConfig::TABLE_PLOT_FACING_ATT_FACE_ID] . '">' . $f[dbConfig::TABLE_PLOT_FACING_ATT_FACE_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('plot-facing'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Project : </div>
            <div class="col-md-10">
                <select name="plot-project" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    if (!empty($project)) {
                        foreach ($project as $p) {
                            ?>
                            <option <?php
                            if ($this->session->userdata('_setProjectId') == $p[dbConfig::TABLE_PROJECT_ATT_ID]) {
                                echo 'selected="selected"';
                            } elseif ($details[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID] == $p[dbConfig::TABLE_PROJECT_ATT_ID]) {
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
                <?php echo form_error('plot-project'); ?>
            </div>
        </div>

        <script type="text/javascript">
            function disabledSeller()
            {
                var v = $("input[name=markAsCompany]:checked").val();
                //alert(v);
                if (v == '1')
                {
                    $("select[name=plot-seller]").attr("disabled", true)
                }
                else {
                    $("select[name=plot-seller]").removeAttr("disabled");
                }
            }
            function checkStatus(id)
            {
                if (id == '1')
                {
                    //alert("a");
                    location.href = base_url + '<?php echo siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_SELL_PLOT ?>' + '<?php echo encode($details[dbConfig::TABLE_PLOT_ATT_PLOT_ID]) ?>';
                }
            }
        </script>
        <div class="row">
            <div class="col-md-2">Seller : </div>
            <div class="col-md-3">
                <select <?php
                if ($details[dbConfig::TABLE_PLOT_ATT_PLOT_MARK_AS_COMPANY] == '1') {
                    echo 'disabled="disabled"';
                }
                ?> name="plot-seller" class="form-control">
                    <option value="">-Please Select-</option>
                    <option selected="selected" value="<?php echo $details[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID] ?>"><?php echo $details['seller'] ?></option>
                </select>
                <span style="color: red;"><?php echo form_error('plot-seller'); ?></span>
            </div>
            <div class="col-md-5">
                <input type="checkbox" <?php
                if ($details[dbConfig::TABLE_PLOT_ATT_PLOT_MARK_AS_COMPANY] == '1') {
                    echo 'checked="checked"';
                }
                ?> name="markAsCompany" value="1" onclick="disabledSeller()"/> Mark as company
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="plot-asking-price" value="<?php echo $details[dbConfig::TABLE_PLOT_ATT_PLOT_ASKING_PRICE]; ?>" class="form-control"/>
                <?php echo form_error('plot-asking-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Minimum Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="plot-asking-min-price" value="<?php echo $details[dbConfig::TABLE_PLOT_ATT_PLOT_ASKING_MIN_PRICE]; ?>" class="form-control"/>
                <?php echo form_error('plot-asking-min-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Currency: </div>
            <div class="col-md-10">

                <select name="plot-currency" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($currency as $c) {
                        $selected = "";
                        if ($c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID] == $details[dbConfig::TABLE_PLOT_ATT_PLOT_CURRENCY]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID] . '">' . $c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('plot-currency'); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Condition: </div>
            <div class="col-md-10">
                <select name="plot-condition" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($condition as $co) {
                        $selected = "";
                        if ($co[dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_ID] == $details[dbConfig::TABLE_PLOT_ATT_PLOT_CONDITION]) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option ' . $selected . ' value="' . $co[dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_ID] . '">' . $co[dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_NAME] . '</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('plot-condition'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Status : </div>
            <div class="col-md-10">
                <select name="plot-status" class="form-control" onchange="checkStatus(this.value)">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach ($status as $st) {
                        $selected = "";
                        if ($st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID] == $details[dbConfig::TABLE_PLOT_ATT_PLOT_STATUS]) {
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

                <textarea name="plot-comment" class="form-control"><?php echo $details[dbConfig::TABLE_PLOT_ATT_PLOT_COMMENT] ?></textarea>
                <?php echo form_error('plot-comment'); ?>
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
