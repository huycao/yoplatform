<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Fax</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @if( !empty($contactList) )
            <?php $stt = 0; ?>
            @foreach( $contactList as $contact )
                <?php $stt++; ?>
                <tr>
                    <td>{{$stt}}</td>
                    <td>{{$contact->name}}</td>
                    <td>{{$contact->email}}</td>
                    <td>{{$contact->phone}}</td>
                    <td>{{$contact->fax}}</td>
                    <td>
                        <a href="javascript:;" onclick="Contact.loadModal({{$contact->id}})" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="javascript:;" onclick="Contact.deleteContact({{$contact->id}})" class="btn btn-default btn-sm">
                            <span class="fa fa-trash-o"></span> Del
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>