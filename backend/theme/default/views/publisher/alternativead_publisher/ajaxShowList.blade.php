<table class="table table-responsive table-condensed">

    <thead>
        <tr>
            <th><a href="javascript:;">Action</a></th>
            @include('partials.show_field')
        </tr>
    </thead>

    <tbody>
        <?php
        if (count($items)) {          
            ?>
            <?php
            foreach ($items as $item) { 
                ?>
                <tr>

                    <td>
                         
                        <a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item->id) }}" class="btn btn-default">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="javascript:;" onclick="deleteItem({{{$item->id}}})" class="btn btn-default">
                            <span class="fa fa-trash-o"></span> 
                        </a>
                    </td>	
                    <td>{{$item->name}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->name}}</td> 
                </tr>
    <?php } ?>
        <?php } else { ?>
            <tr>
                <td class="no-data" >{{trans("text.no_data")}}</td>
            </tr>
<?php } ?>
    </tbody>

</table> 