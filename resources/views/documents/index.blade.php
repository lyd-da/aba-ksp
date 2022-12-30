@extends('layouts.app')
@section('title',ucfirst(config('settings.document_label_plural'))." List")
@section('css')
    <style type="text/css">
        .bg-folder-shaper {
            width: 100%;
            height: 115px;
            border-radius: 0px 15px 15px 15px !Important;
        }

        .folder-shape-top {
            width: 57px;
            height: 17px;
            border-radius: 20px 37px 0px 0px;
            position: absolute;
            top: -16px;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .widget-user-2 .widget-user-username, .widget-user-2 .widget-user-desc {
            margin-left: 10px;
            font-weight: 400;
            font-size: 17px;
        }

        .widget-user-username {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-t-20 {
            margin-top: 20px;
        }

        .dropdown-menu {
            min-width: 100%;
        }

        .doc-box.box {
            box-shadow: 0 0px 0px rgba(0, 0, 0, 0.0) !important;
        }

        .bg-folder-shaper:hover {
            background-color: yellow;
        }

        .select2-container {
            width: 100% !important;
        }

        #filterForm.in, filterForm.collapsing {
            display: block !important;
        }
    </style>
@stop
@section('scripts')
@include('modal.show_file')
@stop
@section('content')

<section class="content-header">
        @include('flash::message')
        {{-- <h1 class="pull-left">
            {{ucfirst(config('settings.document_label_plural'))}}
        </h1> --}}
        {{-- <h1 class="pull-right">
            @can('create',\App\Document::class)
                <a href="{{route('documents.create')}}"
                   class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Add New
                </a>
            @endcan
        </h1> --}}
    </section>
    <div class="content" style="margin-top: -10px;">
        <div class="clearfix"></div>


        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-header">
                <div class="form-group hidden visible-xs">
                    <button type="button" class="btn btn-default btn-block" data-toggle="collapse"
                            data-target="#filterForm"><i class="fa fa-filter"></i> Filter
                    </button>
                </div>
                {!! Form::open(['route' => ['docsearch'], 'method'=>'get','class'=>'form-inline visible hidden-xs','id'=>'filterForm']) !!}
                <div class="form-group">
                    <label for="search" class="sr-only">Search</label>
                    {!! Form::text('search',null,['class'=>'form-control input-sm','placeholder'=>'Search...']) !!}
                </div>
                <div class="form-group">
                    <label for="tags" class="sr-only">{{config('settings.tags_label_singular')}}:</label>
                    <select class="form-control select2 input-sm" name="tags[]" id="tags"
                            data-placeholder="Choose {{config('settings.tags_label_singular')}}" multiple>
                        @foreach($tags as $tag)
                            @canany(['read documents','read documents in tag '.$tag->id])
                                <option
                                    value="{{$tag->id}}" {{in_array($tag->id,request('tags',[]))?'selected':''}}>{{$tag->name}}</option>
                            @endcanany
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status" class="sr-only">{{config('settings.tags_label_singular')}}:</label>
                    {!! Form::select('status',['0'=>"ALL",config('constants.STATUS.PENDING')=>config('constants.STATUS.PENDING'),config('constants.STATUS.APPROVED')=>config('constants.STATUS.APPROVED'),config('constants.STATUS.REJECT')=>config('constants.STATUS.REJECT')],null,['class'=>'form-control input-sm']) !!}
                </div>
                <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-filter"></i> Filter</button>
                {!! Form::close() !!}
                {{-- <a href="{{route('documents.create')}}"
                class="pull-righ btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a> --}}
            <h1 class="pull-right" style="margin-top: -40px">
                @can('create',\App\Document::class)
                    <a href="{{route('documents.create')}}"
                       class="btn btn-primary">New  
                        <i class="fa fa-plus"></i>
                       
                    </a>
                @endcan
            </h1>
        </div>
            <div class="box-body">
                <div class="row">
                    @foreach ($documents as $document)
                        @cannot('view',$document)
                            @continue
                        @endcannot
                        {{-- @if(!(auth()->user()->is_super_admin) && !($document->isVerified) && auth()->user()->cannot('verify', $document)  )
                        @continue
                        @endif --}}
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 m-t-20" style="cursor:pointer;">
                            <div class="doc-box box box-widget widget-user-2">
                                <div class="widget-user-header bg-gray bg-folder-shaper no-padding">
                                    <div class="folder-shape-top bg-gray"></div> 
                                    <div class="box-header">
                                        <a href="{{route('documents.show',$document->id)}}" style="color: black;">
                                            <h3 class="box-title"><i class="fa fa-folder text-yellow"></i></h3>
                                        </a>

                                        <div class="box-tools pull-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"
                                                        style="    background: transparent;border: none;">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                                    <li><a href="{{route('documents.show',$document->id)}}">Show</a>
                                                    </li>
                                                    @can('edit',$document)
                                                        <li><a href="{{route('documents.edit',$document->id)}}">Edit</a>
                                                        </li>
                                                    @endcan
                                                    @can('delete',$document)
                                                        <li>
                                                            {!! Form::open(['route' => ['documents.destroy', $document->id], 'method' => 'delete']) !!}
                                                            {!! Form::button('Delete', [
                                                                        'type' => 'submit',
                                                                        'class' => 'btn btn-link',
                                                                        'onclick' => "return conformDel(this,event)"
                                                                    ]) !!}
                                                            {!! Form::close() !!}
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.widget-user-image -->
                                    <a href="{{route('documents.show',$document->id)}}" style="color: black;">
                                    <span style="max-lines: 1; white-space: nowrap;margin-left: 3px;">
                                    <?php 
                                    $tags = sliceTag($document->tags);
                                    if(count($tags) <= 1) {
                                        $sliceLen = 25;
                                    } else {
                                        $sliceLen = 10;
                                    }
                                    ?>
                                    @foreach ($tags as $tag)
                                            <small class="label"
                                                   style="background-color: {{$tag->color}};font-size: 0.93rem;">{{trimText($tag->name, $sliceLen)}}</small>
                                        @endforeach
                                    </span>
                                    <h5 class="widget-user-username" title="{{$document->name}}"
                                            data-toggle="tooltip">{{$document->name}}</h5>
                                        <h5 class="widget-user-desc" style="font-size: 12px"><span data-toggle="tooltip"
                                                                                                   title="{{formatDateTime($document->updated_at)}}">{{formatDate($document->updated_at)}}</span>
                                            <span
                                                class="pull-right" style="margin-right: 15px;">
                                            {!! $document->isVerified ? '<i title="Verified" data-toggle="tooltip" class="fa fa-check-circle" style="color: #388E3C;"></i>':'<i title="Unverified" data-toggle="tooltip" class="fa fa-remove" style="color: #f44336;"></i>' !!}
                                        </span></h5>
                                    </a>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    @endforeach
                </div>
                @if (!empty($seafiles))
                
                <table class="table">
                    <thead>
                        <tr>
                           
                            <th scope="col">Name</th>
                            <th scope="col">File Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Rate</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                                @foreach ($seafiles->sortBy('name') as $file)
                                <?php 
    $rate_count_plunk = App\Review::where('file_id','=',$file->id)->pluck('rate_count');
    $rate_count_avg = $rate_count_plunk->avg();
    $no_of_reviews = $rate_count_plunk->count();
    ?>
                 <tr>
                    <th scope="row" onclick="showFileModal({{json_encode($file)}})"><i
                        class="fa fa-file-text" style=" color: #3c8dbc; margin-right: 10px"></i>{{$file->name}}.{{last(explode('.', $file->file))}}</th>
                    
                    <td>{{$file->fileType->name}}</td>
                    <td>{{$file->status}}</td>
                    @if($no_of_reviews ==0)         
                        <td><label for="star5" title="text">Not Rated Yet</label>  </td>       
                    @else
                        <td><label for="star5" title="text">{{round($rate_count_avg,1)}} ★</label> <span class="no_of_reviews">({{$no_of_reviews}})</span></td>
                @endif
                <td>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="    background: transparent;border: none;">
                            <i class="fa fa-ellipsis-v" style="color: #000;"></i>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu" style="top: auto; bottom:auto; min-width: auto;">
                            <li><a href="javascript:void(0);" onclick="showFileModal({{json_encode($file)}})">Show 
                                    Detail</a></li>
                            <li><a href="javascript:void(0);" onclick="showFileRateModal({{json_encode($file)}})">Rate ✩</a></li>
                            <li>
                                <a href="{{route('files.showfile',['dir'=>'original','file'=>$file->file])}}?force=true" download>Download
                                    original</a>
                            </li>
    
                            @if (checkIsFileIsImage($file->file))
                            @foreach (explode(",",config('settings.image_files_resize')) as $varient)
                            <li>
                                <a href="{{route('files.showfile',['dir'=>$varient,'file'=>$file->file])}}?force=true" download>Download {{$varient}}w</a>
                            </li>
                            @endforeach
                            <li>
                                <a href="javascript:void(0)" onclick="javascript:ImageEditor.open('{{route('files.showfile',['dir'=>'original','file'=>$file->file])}}')">
                                    Edit Image
                                </a>
                            </li>
                            @endif
                            <li>
                                {!! Form::open(['route' => ['documents.files.destroy', $file->id], 'method' => 'delete', 'style'=>'display:inline;']) !!}
                                <button class="btn btn-link" onclick="conformDel(this,event)" type="submit">
                                    Delete
                                </button>
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </div>
                </td>
                </tr>
           
                                @endforeach
                            </tbody>
                        </table>
              
                @endif
            </div>
            <div class="box-footer">
                {!! $documents->appends(request()->all())->render() !!}
            </div>
        </div>
    </div>

@endsection
