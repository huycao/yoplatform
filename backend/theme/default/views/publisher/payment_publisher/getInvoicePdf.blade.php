<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            *{ 
            }
            table{
                width: 100%;
                margin: 10px 0;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                vertical-align: top
            }
            th,td {
                padding: 5px;  
            }   
            .table thead{
                background: #CCC;

            }
            .logo{
                background: url('/public/logo.png') no-repeat;
                width: 100%;
                height: 43px;
                margin-bottom: 20px;
                border-bottom: 2px solid #CCC;
                padding-bottom: 10px;
            }
            h3{
                font-size: 12px;
                font-weight: normal;
                margin: 10px 0  0 0 ;
            }
            .table th{
                font-size: 10px;
                font-weight: bold;
                vertical-align: middle;
            }
            .table td{
                font-size: 10px;
                font-weight: normal;   
            }
            .table2 td,p{
                font-size: 12px;
                font-weight: normal;   
            }
            .table2 th,.table2 td {
               padding: 0px;  
            }   
            p{
                line-height: 10px;
            }
        </style>
    </head>
    <body>
        
        <?php
        $totalEarning = 0;
        $publisherpayment = $publisher->payment;
        ?>
        <div class="logo"></div>
        <table class="table2 table-bordered" border="0">            
            <tr>
                <td width="10%" align="left" rowspan="2"><strong>Compagny</strong></td>
                <td width="5%" rowspan="2">:</td>
                <td width="55%" align="left" rowspan="2"><?= $publisher->company ?></td>
                <td width="10%" align="left"><strong>Date</strong></td>
                <td width="5%">:</td>
                <td width="25%"><?php echo date("t M, Y", strtotime($mont)); ?></td>
            </tr>  
            <tr>
                <td width="15%" align="left"><strong>Invoice#</strong></td>
                <td width="5%">:</td>
                <td width="25%"><?php
                    echo "Pine" . date('y', time()) . '/' . $datemonth . '/' . $publisher->id . '-' . strtoupper(substr(md5(time()), 0, 5));
                    ?></td>
            </tr> 
            <tr>
                <td width="10%" align="left" rowspan="2"><strong>Address</strong></td>
                <td width="5%" rowspan="2">:</td>
                <td width="55%" align="left" rowspan="2"><?= $publisher->address; ?></td>
                <td width="10%" align="left"><strong>For</strong></td>
                <td width="5%">:</td>
                <td width="25%">Performance Campaign</td>
            </tr>  
            <tr>
                <td width="10%" align="left"><strong>Account Name</strong></td>
                <td width="5%">:</td>
                <td width="25%"><?php
                    if($publisherpayment!= null){
                       echo  $publisherpayment->account_number;
                    }
                    ?></td>
            </tr> 
            <tr>
                <td width="10%" align="left"><strong>Bill to</strong></td>
                <td width="5%">:</td>
                <td width="55%" align="left"><?= $pinetech->name ?></td>
                <td width="10%" align="left"> </td>
                <td width="5%"> </td>
                <td width="25%"> </td>
            </tr>  
            <tr>
                <td width="10%" align="left"><strong>Attn</strong></td>
                <td width="5%">:</td>
                <td width="55%" align="left">Accounting Department</td>
                <td width="10%" align="left"> </td>
                <td width="5%"> </td>
                <td width="25%"> </td>
            </tr>
        </table>
        <div>
            <p><?= $pinetech->name ?></p>
            <p><?= $pinetech->address ?></p>
            <p><?= $pinetech->state ?></p>
            <p><?= $pinetech->city ?></p>
            <p><?= $pinetech->country ?></p>
        </div>
        <?php
        if (count($camend)) {
            ?>
            <h3><strong>Ended Campaign</strong></h3>
            <table class="table table-bordered" border="1">
                <thead>
                    <tr>
                        <th width="30%">Campaign</th>
                        <th width="20%">Duration</th>
                        <th width="10%">Platform</th>
                        <th width="5%" >Model</th>
                        <th width="5%">Total Delivered</th>
                        <th width="15%">Total (VND)</th> 
                        <th width="15%">Campaign Tax</th>  
                    </tr>
                </thead>
                <?php
                $total = 0;
                foreach ($camend as $cam) {
                    $total += $cam->earning;
                    ?>
                    <tr>
                        <td><?= $cam->campaignname ?></td>
                        <td align="center"><?= date('d M, Y', strtotime($cam->start_date)) . ' - ' . date('d M, Y', strtotime($cam->end_date)); ?></td>
                        <td  align="center">Web</td>
                        <td  align="center"><?= strtoupper($cam->cost_type) ?></td>
                        <td  align="center"><?= numberVN($cam->delivered) ?></td>
                        <td align="right"><?= numberVN($cam->earning) ?></td>
                        <td align="right"><?= numberVN($cam->earning_tax) ?></td>
                    </tr>
                    <?php
                }
                $total_tax = $total * 0.1;
                ?>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td  colspan="2" align="center">Total(<?= date("M", time()) ?>)</td>
                    <td align="right"><?= numberVN($total) ?></td>                
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td  colspan="2" align="center"> 10% Tax</td>
                    <td align="right"><?= numberVN($total_tax) ?></td>                
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td  colspan="2" align="center">Total(<?= date("M", time()) ?>)</td>
                    <td align="right"><?= numberVN($total + $total_tax);
                    $totalEarning += $total + $total_tax;
                    ?></td>                
                    <td></td>
                </tr>
            </table>

            <?php
        }
        if (count($camrun)) {
            ?>
            <h3><strong>Running Campaign</strong></h3>
            <table class="table table-bordered" border="1">
                <thead>
                    <tr>
                        <th width="30%">Campaign</th>
                        <th width="20%">Duration</th>
                        <th width="10%">Platform</th>
                        <th width="5%" >Model</th>
                        <th width="5%">Total Delivered</th>
                        <th width="15%">Total (VND)</th> 
                        <th width="15%">Campaign Tax</th>  
                    </tr>
                </thead>
                <?php
                $total = 0;
                foreach ($camrun as $cam) {
                    $total += $cam->earning;
                    ?>
                    <tr>
                        <td><?= $cam->campaignname ?></td>
                        <td align="center"><?= date('d M, Y', strtotime($cam->start_date)) . ' - ' . date('d M, Y', strtotime($cam->end_date)); ?></td>
                        <td  align="center">Web</td>
                        <td  align="center"><?= strtoupper($cam->cost_type) ?></td>
                        <td  align="center"><?= numberVN($cam->delivered) ?></td>
                        <td align="right"><?= numberVN($cam->earning) ?></td>
                        <td align="right"><?= numberVN($cam->earning_tax) ?></td>
                    </tr>
                    <?php
                }
                 $total_tax = $total * 0.1;
                ?>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td  colspan="2" align="center">Total(<?= date("M", time()) ?>)</td>
                    <td align="right"><?= numberVN($total) ?></td>                
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td  colspan="2" align="center"> 10% Tax</td>
                    <td align="right"><?= numberVN($total_tax) ?></td>                
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td  colspan="2" align="center">Total(<?= date("M", time()) ?>)</td>
                    <td align="right"><?= numberVN($total + $total_tax);
                $totalEarning += $total + $total_tax;
                    ?></td>                
                    <td></td>
                </tr>
            </table>
            <?php
        }
       
        ?>
        <table class="table table-bordered" border="1">
            <tr>
                <td colspan="2" align="center"><strong>Payment Information</strong></td>
            </tr>
            <tr>
                <td><strong>Company:</strong></td>
                <td><?= $publisher->company ?></td> 
            </tr>
            <tr>
                <td><strong>Payment Preference:</strong></td>
                <td><?php 
                if($publisherpayment!= null){
                       echo  $publisherpayment->payment_preference;
                    } 
                    ?></td> 
            </tr>
            <tr>
                <td><strong>Account Name:</strong></td>
                <td><?php
                if($publisherpayment!= null){
                       echo  $publisherpayment->payment_preference;
                    } 
                ?></td> 
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td>
                <td><?= $publisher->phone_contact ?></td> 
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td><?= $publisher->address_contact ?></td> 
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td><?= $publisher->phone_contact ?></td> 
            </tr>
            <tr>
                <td><strong>Fax:</strong></td>
                <td><?= $publisher->fax ?></td> 
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?= $publisher->email_contact ?></td> 
            </tr>
            <tr>
                <td><strong>Bring Forward:</strong></td>
                <td>N/A</td> 
            </tr>
            <tr>
                <td><strong>Total Earning(<?= date("M", time()) ?>):</strong></td>
                <td>VND <?= numberVN($totalEarning);?> </td> 
            </tr>
            <tr>
                <td><strong>Cash Out Value:</strong></td>
                <td>N/A</td> 
            </tr>
            <tr>
                <td><strong>Total Outstanding:</strong></td>
                <td>N/A</td> 
            </tr>
            <tr>
                <td><strong>Total Payable:</strong></td>
                <td>VND <?= numberVN($totalEarning);?> </td> 
            </tr>
        </table>
        <table class="table table-bordered" border="0">            
            <tr>
                <td  align="left">Checked By,</td>
                <td align="right">Yomedia</td>

            </tr>  
        </table>
    </body>
</html> 