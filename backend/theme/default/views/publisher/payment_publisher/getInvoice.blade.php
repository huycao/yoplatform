
<div class="row">
    <div class="col-sm-12">

        <?php 
        if (isset($_SESSION['error'])) {
            ?>
            <div class="alert alert-danger">
                <h2><?php echo $_SESSION['error'];unset($_SESSION['error']);?></h2>
            </div>
        <?php } ?>
        <div class="alert alert-info">
            <div class="row">
                <form action="{{URL::Route('PaymentPublisherGetPdf')}}" method="post">
                    <label class="col-sm-2 text-right">Date :</label>
                    <div class="col-sm-5">
                        <select name="datemonth" id="datemonth" class="form-control ">
                            <option value="">Choose...</option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<option value="' . $i . '">' . date("M, Y", strtotime(date('Y', time()) . '-' . $i . '-01')) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-default btn-file-pdf" type="submit"><i class="fa fa-file-pdf-o"></i> Export PDF</button>	
                    </div>
                </form>
            </div>
        </div>
    </div>	
</div>