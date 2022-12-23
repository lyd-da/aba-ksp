<div class="row">
{!! Form::open(['route' => ['files.verify'], 'method' => 'post']) !!}
        <div class="form-group text-right">
            <button class="btn btn-success" type="submit" name="action" value="approve"><i class="fa fa-check"></i> Approve All
            </button>
            <button class="btn btn-danger" type="submit" name="action" value="reject"><i class="fa fa-close"></i> Reject All
            </button>
        </div>
        {!! Form::close() !!}
        <div class="col-xs-12 col-md-12 col-lg-12">
       
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($document->files->sortBy('file_type_id') as $file)
                   
                    <tr>
                    <th scope="row">{{$file->id}}</th>
                    <td>{{$file->name}}</td>
                    <td>{{$file->status}}</td>
                    <td> {!! Form::open(['route' => ['
                        
                        
                        .verify', $file->id], 'method' => 'post']) !!}


                        <div class="form-group">
                            <button class="btn btn-success" type="submit" name="action" value="approve"><i class="fa fa-check"></i> Approve
                            </button>
                            <button class="btn btn-danger" type="submit" name="action" value="reject"><i class="fa fa-close"></i> Reject
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
                
                <!-- @else -->
                <!-- <div class="form-group">
                    <span class="label label-success">{{$file->name}}</span>
                </div>
                <div class="form-group">
                    Verifier: <b>{{$file->verifiedBy->name}}</b>
                </div>
                <div class="form-gorup">
                    Verified At: <b>{{formatDateTime($file->verified_at)}}</b>
                    ({{\Carbon\Carbon::parse($file->verified_at)->diffForHumans()}})
                </div> -->
            
                @endforeach
            </tbody>
        </table>
    </div>
</div>