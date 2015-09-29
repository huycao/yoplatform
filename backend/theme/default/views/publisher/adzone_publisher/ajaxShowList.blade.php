                <div class="list-zone">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default panel-list-zone">
                            <?php
                            $t = 0;
                            foreach ($siteLists as $site) { 
                                ?>
                                <div class="panel-heading">
                                    <a href="{{ URL::Route($moduleRoutePrefix.'ShowCreate') }}" class="addzone btn btn-default pull-left" ><span class="fa fa-plus"></span></a>
                                    <h4 class="panel-title pull-left" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $site->id; }}">
                                        <a>
                                            {{ $site->name; }} <span>{{ count($site->publisherAdZone)}}</span>
                                        </a>
                                    </h4>
                                    <div class="clearfix"></div>
                                </div>

                                <div id="collapse{{ $site->id; }}" class="panel-collapse panel-heading collapse <?php ($t == 0) ? print 'in' : print "";
                            $t++; ?>">
                                    <div class="panel-body">

                                            <table class="table table-striped table-hover table-condensed">

                                            <thead>
                                                <tr>
                                                    <th><a href="javascript:;">Action</a></th>
                                                    @include('partials.show_field')
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                if (count($site->publisherAdZone)) {
                                                    $stt = 0;
                                                    ?>
                                                    <?php foreach ($site->publisherAdZone as $item) {
                                                        $stt++;
                                                        ?>
                                                        <tr>

                                                            <td>
                                                                <a href="{{ URL::Route($moduleRoutePrefix.'ShowTags',$item['id']) }}" class="btn btn-default"><>
                                                                </a>
                                                                <a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>
                                                                <a href="javascript:;" onclick="deleteItem({{{$item->id}}})" class="btn btn-default">
                                                                    <span class="fa fa-trash-o"></span> 
                                                                </a>
                                                            </td>	
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->site->name}}</td>
                                                            <td><?php
                                                        ($item->platform == 1) ? print "Web" : print "Mobile"
                                                                        
                                                        ?></td>
                                                            <td>{{$item->format->name}}</td>
                                                            <td><?php
                                                        ($item->adplacement == 1) ? print "Above the fold" : print "Bellow the fold"
                                                                        
                                                        ?></td>
                                                            <td>{{$item->alternateadtype}}</td>


                                                        </tr>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="no-data" >{{trans("text.no_data")}}</td>
                                                    </tr>
    <?php } ?>
                                            </tbody>

                                        </table> 
                                    </div>
                                </div>
<?php } ?>
                        </div>					  

                    </div>
                </div>

<script>
$('.addzone').on('click',function(){
  window.location.href = $(this).attr('href');
});
</script>