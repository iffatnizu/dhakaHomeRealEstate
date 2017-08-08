<div class="container">
    <h3><i class="glyphicon glyphicon-list"></i> Due Invoice List</h3>

    <ul class="nav nav-tabs">
        <li><a href="#home" data-toggle="tab">Plot</a></li>
        <li><a href="#profile" data-toggle="tab">Apartment</a></li>
        <li><a href="#messages" data-toggle="tab">Commercial</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="home">
            <div>
                <table class="table table-bordered table-striped tablesorter" id="myTable">
                    <thead>
                        <tr style="background: #E8F1FA;">
                            <th width="10%">Plot Name</th>
                            <th width="10%">Seller</th>
                            <th width="10%">Buyer</th>
                            <th width="10%">Subtotal</th>
                            <th width="15%">Down Payment</th>
                            <th width="10%">Installment Period</th>
                            <th width="10%">Monthly Payment</th>
                            <th width="10%">Date</th>                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($paymentplot as $p) {
                            ?>
                            <tr>
                                <td width="10%"><?php echo $p['plotName'] ?></td>
                                <td width="10%"><?php echo $p['seller'] ?></td>
                                <td width="10%"><?php echo $p['buyer'] ?></td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_SUBTOTAL] ?></td>
                                <td width="15%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_DOWN_PAYMENT] ?></td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_INSTALLMENT_PERIOD] ?> months</td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_MONTH_PAYMENT] ?></td>
                                <td width="10%"><?php echo date("m/d/Y h:i:s A T", $p[dbConfig::TABLE_SOLD_PLOT_ATT_TIME]) ?></td> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="profile">
            <div>
                <table class="table table-bordered table-striped tablesorter" id="myTable">
                    <thead>
                        <tr style="background: #E8F1FA;">
                            <th width="10%">Apartment Name</th>
                            <th width="10%">Seller</th>
                            <th width="10%">Buyer</th>
                            <th width="10%">Subtotal</th>
                            <th width="15%">Down Payment</th>
                            <th width="10%">Installment Period</th>
                            <th width="10%">Monthly Payment</th>
                            <th width="10%">Date</th>                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($paymentapartment as $p) {
                            ?>
                            <tr>
                                <td width="10%"><?php echo $p['apartmentName'] ?></td>
                                <td width="10%"><?php echo $p['seller'] ?></td>
                                <td width="10%"><?php echo $p['buyer'] ?></td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_SUBTOTAL] ?></td>
                                <td width="15%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_DOWN_PAYMENT] ?></td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_INSTALLMENT_PERIOD] ?> months</td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_MONTH_PAYMENT] ?></td>
                                <td width="10%"><?php echo date("m/d/Y h:i:s A T", $p[dbConfig::TABLE_SOLD_PLOT_ATT_TIME]) ?></td> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="messages">
            <div>
                <table class="table table-bordered table-striped tablesorter" id="myTable">
                    <thead>
                        <tr style="background: #E8F1FA;">
                            <th width="10%">Commercial Name</th>
                            <th width="10%">Seller</th>
                            <th width="10%">Buyer</th>
                            <th width="10%">Subtotal</th>
                            <th width="15%">Down Payment</th>
                            <th width="10%">Installment Period</th>
                            <th width="10%">Monthly Payment</th>
                            <th width="10%">Date</th>                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($paymentcommercial as $p) {
                            ?>
                            <tr>
                                <td width="10%"><?php echo $p['commercialName'] ?></td>
                                <td width="10%"><?php echo $p['seller'] ?></td>
                                <td width="10%"><?php echo $p['buyer'] ?></td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_SUBTOTAL] ?></td>
                                <td width="15%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_DOWN_PAYMENT] ?></td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_INSTALLMENT_PERIOD] ?> months</td>
                                <td width="10%"><?php echo $p[dbConfig::TABLE_SOLD_PLOT_ATT_MONTH_PAYMENT] ?></td>
                                <td width="10%"><?php echo date("m/d/Y h:i:s A T", $p[dbConfig::TABLE_SOLD_PLOT_ATT_TIME]) ?></td> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>


</div>