<div class="container">
    

    <h3><i class="glyphicon glyphicon-adjust"></i> Add Apartment :: Step 4 <small>(Add Apartment)</small> </h3>
    <hr/>

    <?php
    ?>
    <form action="<?php echo current_url() ?>" method="POST">
        <div class="row">
            <div class="col-md-2">Apartment Name: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-name" value="" class="form-control"/>
                <?php echo form_error('apartment-name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Address: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-address" value="" class="form-control"/>
                <?php echo form_error('apartment-address'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Apartment Size: </div>
            <div class="col-md-10">
                <select name="apartment-size" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach($size as $b){
                        echo '<option value="'.$b[dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_ID].'">'.$b[dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_VALUE].'</option>';
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
                    foreach($floor as $b){
                        echo '<option value="'.$b[dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_ID].'">'.$b[dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_NAME].'</option>';
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
                    foreach($facing as $f){
                        echo '<option value="'.$f[dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_ID].'">'.$f[dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_NAME].'</option>';
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
                    foreach($bed as $f){
                        echo '<option value="'.$f[dbConfig::TABLE_APARTMENT_BED_ATT_BED_ID].'">'.$f[dbConfig::TABLE_APARTMENT_BED_ATT_BED_VALUE].'</option>';
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
                    foreach($bath as $f){
                        echo '<option value="'.$f[dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_ID].'">'.$f[dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_VALUE].'</option>';
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
                            }
                            ?> value="<?php echo $p[dbConfig::TABLE_PROJECT_ATT_ID] ?>"><?php echo $p[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?></option> 
                                <?php
                            }
                        } else {
                            ?>
                        <option selected="selected" value="<?php echo $this->session->userdata('_setProjectId') ?>"><?php echo $this->session->userdata('_setProject') ?></option>   
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
                if(v=='1')
                {
                    $("select[name=apartment-seller]").attr("disabled",true)
                }
                else{
                    $("select[name=apartment-seller]").removeAttr("disabled");
                }
            }
        </script>
        <div class="row">
            <div class="col-md-2">Seller : </div>
            <div class="col-md-3">
                <select name="apartment-seller" class="form-control">
                    <option value="">-Please Select-</option>
                    <option selected="selected" value="<?php echo $this->session->userdata('_setClientId') ?>"><?php echo $this->session->userdata('_setClient') ?></option>
                </select>
                <span style="color: red;"><?php echo form_error('apartment-seller'); ?></span>
            </div>
            <div class="col-md-5">
                <input type="checkbox" name="markAsCompany" value="1" onclick="disabledSeller()"/> Mark as company
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-asking-price" value="" class="form-control"/>
                <?php echo form_error('apartment-asking-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Minimum Asking Price: </div>
            <div class="col-md-10">
                <input type="text" name="apartment-asking-min-price" value="" class="form-control"/>
                <?php echo form_error('apartment-asking-min-price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Currency: </div>
            <div class="col-md-10">

                <select name="apartment-currency" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach($currency as $c){
                        echo '<option value="'.$c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID].'">'.$c[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE].'</option>';
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
                    foreach($condition as $co){
                        echo '<option value="'.$co[dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_ID].'">'.$co[dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_NAME].'</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('apartment-condition'); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-2">Status : </div>
            <div class="col-md-10">
                <select name="apartment-status" class="form-control">
                    <option value="">-Please Select-</option>
                    <?php
                    foreach($status as $st){
                        echo '<option value="'.$st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID].'">'.$st[dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_NAME].'</option>';
                    }
                    ?>
                </select>
                <span style="color: red;"><?php echo form_error('apartment-status'); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">Comment: </div>
            <div class="col-md-10">

                <textarea name="apartment-comment" class="form-control"></textarea>
                <?php echo form_error('apartment-comment'); ?>
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
