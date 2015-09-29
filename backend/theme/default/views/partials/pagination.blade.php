<?php
    $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>
<?php if ($paginator->getLastPage() > 1): ?>
    <div class="row">
        <div class="col-xs-9">
            <ul class="pagination pagination-sm pull-left">
                <?php
                /* How many pages need to be shown before and after the current page */
                $showBeforeAndAfter = 2;

                /* Current Page */
                $currentPage = $paginator->getCurrentPage();
                $lastPage = $paginator->getLastPage();
                $firstPage= 1;


                /* Check if the pages before and after the current really exist */
                $start = $currentPage - $showBeforeAndAfter;

                /* 
                Check if first page in pagination goes below 1, and substract that from 
                $showBeforeAndAfter var so the pagination won't start with page 0 or below 
                */
                if($start < 1){

                $diff = $start - 1;

                $start = $currentPage - ($showBeforeAndAfter + $diff);
                }

                $end = $currentPage + $showBeforeAndAfter;
                $numEnd = $paginator->getLastPage();

                if($end > $lastPage){

                $diff = $end - $lastPage;
                $end = $end - $diff;
                }


                $disabledFirst=($paginator->getCurrentPage() == 1) ? "disabled" : "";
                $disabledEnd=($paginator->getCurrentPage() == $paginator->getLastPage()) ? "disabled" : "";
                if($paginator->getCurrentPage() > 1){
                echo '<li class="'.$disabledFirst.'">                  
                      <a style="border-radius:4px 0px 0px 4px;" href="'.$paginator->getUrl($firstPage).'">&laquo; First</a>
                  </li>';  
                }else{
                echo '<li class="'.$disabledFirst.'">                  
                      <span>&laquo; First</span>
                  </li>'; 
                }

                if($paginator->getCurrentPage() > 1)
                echo $presenter->getPrevious('Prev');

                echo $presenter->getPageRange($start, $end);

                if($paginator->getCurrentPage() < $numEnd)
                echo $presenter->getNext('Next');

                if($paginator->getCurrentPage() < $numEnd){
                echo '<li class="'.$disabledEnd.'">                  
                      <a style="border-radius:0 4px 4px 0;" href="'.$paginator->getUrl($numEnd).'">Last &raquo;</a>                  
                  </li>';
                }else{
                echo '<li class="'.$disabledEnd.'">
                      <span>Last &raquo;</span>
                  </li>';
                }         

                ?>
            </ul>

            <div class="form-horizontal pull-left">

                    <div class="pull-left">
                        <select class="form-control input-sm showNumberField" >
                            <option <?php if($paginator->getPerPage()== 10) echo 'selected="selected"'; ?> value="10">10</option>
                            <option <?php if($paginator->getPerPage()== 20) echo 'selected="selected"'; ?> value="20">20</option>
                            <option <?php if($paginator->getPerPage()== 50) echo 'selected="selected"'; ?> value="50">50</option>
                            <option <?php if($paginator->getPerPage()== 100) echo 'selected="selected"'; ?> value="100">100</option>
                        </select>
                    </div>
                    <span class="control-label text-left pull-left" for="">&nbsp; items per page</span>

            </div>
        </div>
        


        <div class="col-xs-3 count-item pull-right">
            <?=$paginator->getFrom()?>-<?php echo $paginator->getTo(); ?> of
            <?php echo $paginator->getTotal(); ?> items
        </div>
    </div>

<?php endif; ?>

