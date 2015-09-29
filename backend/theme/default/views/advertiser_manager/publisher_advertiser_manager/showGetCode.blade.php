<div class="row mb12">
    <div class="col-md-12">
        <div class="box">
            <div class="head">Get Tag</div>
            <div class="content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2">Site: </label>
                        <div class="col-sm-10">
                            <?= $item->site->name; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Name: </label>
                        <div class="col-sm-10">
                            <?= $item->name; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Ad format: </label>
                        <div class="col-sm-10">
                            <?= $item->adformat->name; ?>
                        </div>
                    </div>
                </form>
                {{$code}}
            </div>
        </div>      
    </div>
</div>

