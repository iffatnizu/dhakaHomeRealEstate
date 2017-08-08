<div class="container">

    <?php
    //debugPrint($details);
    if (!empty($details)) {
        ?>

        <style>
            .col-xs-1{
                font-weight: bold;
            }
            table tr td p{
                color: red;
            }
        </style>

        <h3>
            <i class="glyphicon glyphicon-asterisk"></i> Apartment Details
        </h3>


        <div class="row">
            <div class="col-xs-1">Apartment Project: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] ?>
            </div>
            
            <div class="col-xs-1">Name: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] ?>
            </div>
            
            <div class="col-xs-1">Address: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ADDRESS] ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-1">Size </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_VALUE] ?>
            </div>
            
            <div class="col-xs-1">Floor </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_NAME] ?>
            </div>
            
            <div class="col-xs-1">Facing: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_NAME] ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-1">Bed: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_BED_ATT_BED_VALUE] ?>
            </div>
            
            <div class="col-xs-1">Bath: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_VALUE] ?>
            </div>
            
            <div class="col-xs-1">Seller: </div>
            <div class="col-xs-2">
                <?php echo $details['seller'] ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-1">Status: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_STATUS_ATT_STATUS_NAME] ?>
            </div>
            
            <div class="col-xs-1">Asking Price: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_PRICE] ?>
            </div>
            
            <div class="col-xs-1">Minimum Asking Price: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_MIN_PRICE]; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-1">Currency: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE] ?> 
            </div>
            
            <div class="col-xs-1">Condition: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_NAME] ?>  
            </div>
            
            <div class="col-xs-1">Comment: </div>
            <div class="col-xs-2">
                <?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_COMMENT] ?>   
            </div>
        </div>

        

        <?php
        if ($this->session->userdata('_success')) {
            ?>
            <div class="alert alert-success"><i class="glyphicon glyphicon-ok-sign"></i> Apartment Successfully Sold</div>
            <?php
        }
        $session['_success'] = FALSE;
        $this->session->unset_userdata($session);
        ?>

        <div class="row">
            <h3><i class="glyphicon glyphicon-asterisk"></i> Buyer Info</h3>
            <form action="<?php echo current_url() ?>" method="POST">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Company </td>
                            <td>
                                <select name="company" class="form-control" onchange="getClientAndProjectByCompany(this.value, '<?php echo $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID] ?>')">
                                    <option value="">-Please select-</option>
                                    <?php
                                    foreach ($company as $name) {
                                        if ($name[dbConfig::TABLE_COMPANY_ATT_ID] != $details[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID]) {
                                            ?>
                                            <option value="<?php echo $name[dbConfig::TABLE_COMPANY_ATT_ID] ?>"><?php echo $name[dbConfig::TABLE_COMPANY_ATT_NAME]; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select> 
                                <?php echo form_error('company') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Client </td>
                            <td>
                                <select name="client" class="form-control">
                                    <option value="">-Please select-</option>
                                </select> 
                                <?php echo form_error('client') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Project </td>
                            <td>
                                <select name="project" class="form-control">
                                    <option value="">-Please select-</option>
                                </select> 
                                <?php echo form_error('project') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Installment sales </td>
                            <td>
                                <input type="checkbox" value="1" name="markAsInstallmentSales"/> Installment sales
                                <?php echo form_error('markAsInstallmentSales') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>SubTotal </td>
                            <td>
                                <input type="text" name="sub-total" value="" class="form-control" />
                                <?php echo form_error('sub-total') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Down Payment </td>
                            <td>
                                <input type="text" name="down-payment" value="" class="form-control" />
                                <?php echo form_error('down-payment') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Installment Period </td>
                            <td>
                                <select name="installment-period" class="form-control" onchange="calculateInstallment(this.value)">
                                    <option value="">-Please Select</option>
                                    <?php 
                                    for($i=1;$i<=48;$i++)
                                    {
                                        echo '<option value="'.$i.'">'.$i.' months</option>';
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('installment-period') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Monthly Payment </td>
                            <td>
                                <input type="text" readonly="readonly" name="monthly-payment" value="" class="form-control"/>
                                <?php echo form_error('monthly-payment') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Comment </td>
                            <td>
                                <textarea class="form-control" name="comment"></textarea>
                                <?php echo form_error('comment') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input class="btn btn-default" type="submit" name="submit" value="Sell"/> 
                                <input class="btn btn-info" type="reset" name="reset" value="Cancel"/> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        

        <?php
    } else {
        ?>
        <div class="alert alert-warning">Content Not Found</div>
        <?php
    }
    ?>
</div>

