@extends('layouts.app')
@section('title',"Show ".ucfirst(config('settings.document_label_singular')))
@section('css')
    <style>
        .box.custom-box {
            border: 1px solid #3c8dbc;
            box-shadow: 0 1px 2px 1px rgba(0, 0, 0, 0.08)
        }

        .box.custom-box .box-header {
            background-color: #3c8dbc;
            color: #fff;
            padding: 3px 5px;
        }

        .custom-box .user-block > .username, .custom-box .user-block > .description {
            margin-left: 0;
        }

        .custom-box .box-body img {
            height: 145px;
            object-fit: contain;
            width: 100%;
            border-radius: 3px;
        }

        object.obj-file-box {
            height: 80vh;
            object-fit: contain;
            width: 100%;
            border: 1px solid rgba(0, 40, 100, 0.2);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .img-d-select .icheckbox_square-blue{
            position: absolute;
            right: 0;
            top: 0;
        }

        #sticky_footer {
            position: fixed;
            bottom: -4px;
            right: 10px;
        }





        /* * {
         box-sizing: border-box;
         } */
         /* Add a gray background color with some padding */
         /* body {
         font-family: Arial;
         padding: 20px;
         background: #f1f1f1;
         } */
         /* Header/Blog Title */
         .header {
         padding: 30px;
         font-size: 40px;
         text-align: center;
         background: white;
         }
         /* Create two unequal columns that floats next to each other */
         /* Left column */
         .leftcolumn {   
         float: left;
         width: 75%;
         }
         /* Right column */
         .rightcolumn {
         float: left;
         width: 25%;
         padding-left: 20px;
         }
         /* Fake image */
         .fakeimg {
         background-color: #aaa;
         width: 100%;
         padding: 20px;
         }
         /* Add a card effect for articles */
         .card {
         background-color: white;
         padding: 20px;
         margin-top: 20px;
         }
         /* Clear floats after the columns */
         .row:after {
         content: "";
         display: table;
         clear: both;
         }
         .avatar {
         vertical-align: middle;
         width: 50px;
         height: 50px;
         border-radius: 50%;
         }
        .rate {
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         .rate:not(:checked) > input {
         position:absolute;
         display: none;
         }
         .rate:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rate:not(:checked) > label:before {
         content: '★ ';
         }
         .rate > input:checked ~ label {
         color: #ffc700;
         }
         .rate:not(:checked) > label:hover,
         .rate:not(:checked) > label:hover ~ label {
         color: #deb217;
         }
         .rate > input:checked + label:hover,
         .rate > input:checked + label:hover ~ label,
         .rate > input:checked ~ label:hover,
         .rate > input:checked ~ label:hover ~ label,
         .rate > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
         .rating-container .form-control:hover, .rating-container .form-control:focus{
         background: #fff;
         border: 1px solid #ced4da;
         }
         .rating-container textarea:focus, .rating-container input:focus {
         color: #000;
         }
    </style>
@stop
@section('scripts')
    <script src="https://cdn.scaleflex.it/plugins/filerobot-image-editor/3/filerobot-image-editor.min.js"></script>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    <script id="file-modal-template" type="text/x-handlebars-template">
        <div id="fileModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@{{name}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <a href="{{\Illuminate\Support\Str::finish(route('files.showfile',['dir'=>'original']),"/")}}@{{file}}?force=true"
                                   download class="btn btn-primary"><i
                                        class="fa fa-download"></i> Download original
                                </a>
                            </div>
                            <div class="form-group">
                                <label>{{ucfirst(config('settings.file_label_singular'))." Type"}}</label>
                                <p>@{{file_type.name}}</p>
                            </div>
                            <div class="form-group">
                                <label>Uploaded By:</label>
                                <p>
                                    @{{created_by.name}}
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Uploaded On:</label>
                                <p>@{{formatDate created_at}}</p>
                            </div>
                            @{{#each custom_fields}}
                            <div class="form-group">
                                <label>@{{titleize @key}}</label>
                                <p>@{{this}}</p>
                            </div>
                            @{{/each}}
                        </div>
                        <div class="col-md-9">
                            <div class="file-modal-preview">
                                <object class="obj-file-box" classid=""
                                        data="{{\Illuminate\Support\Str::finish(route('files.showfile',['dir'=>'original']),"/")}}@{{file}}">
                                </object>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                            Close
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </script>
    <script id="file-rate-modal-template" type="text/x-handlebars-template">
        <div id="fileRateModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title" style="color:#0071a1;">@{{name}}</h2>
                    </div>
                    <div class="row">
                        <div class="leftcolumn">
                           <div class="card">
                              <h2 style="color:#0071a1;">Title</h2>
                              <p style="color:#e91e63;">Published at : </p>
                              <p>Description</p>
                              <hr>
                              <!-- Display review section start -->
                              <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                                 <div>
                                    <div class="row mt-5">
                                       <h4>Comment Section :</h4>
                                       <div class="col-sm-12 mt-5">
                                          {{-- @foreach($post_detail->ReviewData as $review)
                                          <div class=" review-content">
                                             <img src="https://www.w3schools.com/howto/img_avatar.png" class="avatar ">
                                             <span class="font-weight-bold ml-2">{{$review->name}}</span>
                                             <p class="mt-1">
                                                @for($i=1; $i<=$review->star_rating; $i++) 
                                                <span><i class="fa fa-star text-warning"></i></span>
                                                @endfor
                                                <span class="font ml-2">{{$review->email}}</span>
                                             </p>
                                             <p class="description ">
                                                {{$review->comments}}
                                             </p>
                                          </div>
                                          <hr>
                                          @endforeach --}}
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Review store Section -->
                              <div class="container">
                                 <div class="row">
                                    <div class="col-sm-10 mt-4 ">
                                       <form class="py-2 px-4" action="" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                                          @csrf
                                          <input type="hidden" name="post_id" value="">
                                          <div class="row justify-content-end mb-1">
                                             <div class="col-sm-8 float-right">
                                                @if(Session::has('flash_msg_success'))
                                                <div class="alert alert-success alert-dismissible p-2">
                                                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                   <strong>Success!</strong> {!! session('flash_msg_success')!!}.
                                                </div>
                                                @endif
                                             </div>
                                          </div>
                                          <p class="font-weight-bold ">Review</p>
                                          <div class="form-group row">
                                             <div class=" col-sm-6">
                                                <input class="form-control" type="text" name="name" placeholder="Name" maxlength="40" required/>
                                             </div>
                                             <div class="col-sm-6">
                                                <input class="form-control" type="email" name="email" placeholder="Email" maxlength="80" required/>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <div class="col-sm-6">
                                                <input class="form-control" type="text" name="phone" placeholder="Phone" maxlength="40" required/>
                                             </div>
                                             <div class="col-sm-6">
                                                <div class="rate">
                                                   <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                                                   <label for="star5" title="text">5 stars</label>
                                                   <input type="radio" checked id="star4" class="rate" name="rating" value="4"/>
                                                   <label for="star4" title="text">4 stars</label>
                                                   <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                                   <label for="star3" title="text">3 stars</label>
                                                   <input type="radio" id="star2" class="rate" name="rating" value="2">
                                                   <label for="star2" title="text">2 stars</label>
                                                   <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                                   <label for="star1" title="text">1 star</label>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group row mt-4">
                                             <div class="col-sm-12 ">
                                                <textarea class="form-control" name="comment" rows="6 " placeholder="Comment" maxlength="200"></textarea>
                                             </div>
                                          </div>
                                          <div class="mt-3 ">
                                             <button class="btn btn-sm py-2 px-3 btn-info">Submit
                                             </button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="rightcolumn">
                           <div class="card">
                              <h2>About Me</h2>
                              <img class="fakeimg" style="height:100px;" src="https://8bityard.com/ezoimgfmt/mllibnjakigh.i.optimole.com/e4PqOHU-NUmggukx/w:110/h:48/q:auto/https://8bityard.com/wp-content/uploads/2020/05/cropped-cropped-LogoMakr_48yknb-2.png?ezimgfmt=rs:110x48/rscb1/ng:webp/ngcb1">
                              <p>Laravel | WordPress | JQuery.</p>
                           </div>
                        </div>
                     </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                            Close
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </script>
    
    <script>
        const ImageEditor = new FilerobotImageEditor();

        function showFileModal(data) {
            var template = Handlebars.compile($("#file-modal-template").html());
            var html = template(data);
            $("#modal-space").html(html);
            $("#fileModal").modal('show');

        }

        function showFileRateModal(data) {
            var template = Handlebars.compile($("#file-rate-modal-template").html());
            var html = template(data);
            $("#modal-space").html(html);
            $("#fileRateModal").modal('show');

        }

        function submitPdfForm(varient){
            $("input[name='images_varient']").val(varient);
            $("#frm_image2pdf").submit();
        }

        $(function () {
            $("input[name='topdf_check[]']").on('ifToggled', function(event){
                var selectedValues = $("input[name='topdf_check[]']:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedValues.length>0){
                    $("#sticky_footer").show();
                }else{
                    $("#sticky_footer").hide();
                }
                $("input[name='images']").val(selectedValues.join());
            });
            $("input[name='topdf_check[]']").trigger('ifToggled');
        });
    </script>
@stop
@section('content')
    <div id="modal-space">
    </div>
    <section class="content-header" style="margin-bottom: 27px;">
        <h1 class="pull-left">
            {{ucfirst(config('settings.document_label_singular'))}}
            <small>{{$document->name}}</small>
        </h1>
        <h1 class="pull-right" style="margin-bottom: 5px;">
            <div class="dropdown" style="display: inline-block">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i
                        class="fa fa-download"></i> Download Zip
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('files.downloadZip',['dir'=>'all','id'=>$document->id])}}">All</a>
                    </li>
                    <li>
                        <a href="{{route('files.downloadZip',['dir'=>'original','id'=>$document->id])}}">Original</a>
                    </li>
                    @foreach (explode(",",config('settings.image_files_resize')) as $varient)
                        <li>
                            <a href="{{route('files.downloadZip',['dir'=>$varient,'id'=>$document->id])}}">{{$varient}}w
                                (Images Only)</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @can('edit', $document)
                <a href="{{route('documents.edit', $document->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>
                    Edit</a>
            @endcan
            @can('delete', $document)
                {!! Form::open(['route' => ['documents.destroy', $document->id], 'method' => 'delete', 'style'=>'display:inline;']) !!}
                <button class="btn btn-danger" onclick="conformDel(this,event)" type="submit"><i
                        class="fa fa-trash"></i>
                    Delete
                </button>
                {!! Form::close() !!}
            @endcan
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label>{{ucfirst(config('settings.document_label_singular'))}} Name:</label>
                            <p>{{$document->name}}</p>
                        </div>
                        <div class="form-group">
                            <label>{{ucfirst(config('settings.tags_label_plural'))}}:</label>
                            <p>
                                @foreach ($document->tags as $tag)
                                    <small class="label"
                                           style="background-color: {{$tag->color}};">{{trimText($tag->name,20)}}</small>
                                @endforeach
                            </p>
                        </div>
                        @foreach ($document->custom_fields??[] as $custom_field_name=>$custom_field_value)
                            <div class="form-group">
                                {!! Form::label($custom_field_name, Str::title(str_replace('_',' ',$custom_field_name)).":") !!}
                                <p>{{ $custom_field_value }}</p>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>Description:</label>
                            <p>{!! $document->description !!}</p>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            @if ($document->status==config('constants.STATUS.PENDING'))
                                <span class="label label-warning">{{$document->status}}</span>
                            @elseif($document->status==config('constants.STATUS.APPROVED'))
                                <span class="label label-success">{{$document->status}}</span>
                            @else
                                <span class="label label-danger">{{$document->status}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Created By:</label> {{$document->createdBy->name}}
                        </div>
                        <div class="form-group">
                            <label>Created At:</label>
                            <p>{!! formatDateTime($document->created_at) !!} <br>
                                ({{\Carbon\Carbon::parse($document->created_at)->diffForHumans()}})
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Last Updated:</label>
                            <p>{!! formatDateTime($document->updated_at) !!} <br>
                                ({{\Carbon\Carbon::parse($document->updated_at)->diffForHumans()}})
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_files" data-toggle="tab"
                                              aria-expanded="true">{{ucfirst(config('settings.file_label_plural'))}}</a>
                        </li>
                        @can('verify', $document)
                            <li class=""><a href="#tab_verification" data-toggle="tab"
                                            aria-expanded="false">Verification</a></li>
                        @endcan
                        <li class=""><a href="#tab_activity" data-toggle="tab" aria-expanded="false">Activity</a></li>
                        @can('user manage permission')
                            <li class=""><a href="#tab_permissions" data-toggle="tab"
                                            aria-expanded="false">Permission</a>
                            </li>
                        @endcan
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_files">
                            @if (config('settings.show_missing_files_errors')=='true' && $document->status!=config('constants.STATUS.APPROVED') && count($missigDocMsgs)!=0)
                                <div class="alert alert-danger fade in alert-dismissible">
                                    <button class="close" data-dismiss="alert" aria-label="close" title="close">
                                        &times;
                                    </button>
                                    <strong>The Following {{ucfirst(config('settings.file_label_plural'))}} Are
                                        Missing:</strong>
                                    <ul style="padding-inline-start: 20px;">
                                        @foreach ($missigDocMsgs as $msg)
                                            <li>{{$msg}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                @foreach ($document->files->sortBy('file_type_id') as $file)
                                    <div class="col-xs-6 col-md-6 col-lg-4">
                                        <div class="box custom-box">
                                            <div class="box-body">
                                                <!-- @if (checkIsFileIsImage($file->file)) -->
                                                    <span class="img-d-select">
                                                    <input type="checkbox" value="{{$file->file}}" name="topdf_check[]" class="iCheck-helper"/>
                                                </span>
                                                <!-- @endif -->
                                                <img onclick="showFileModal({{json_encode($file)}})"
                                                     style="cursor:pointer;"
                                                     src="{{buildPreviewUrl($file->file)}}"
                                                     alt="">
                                            </div>
                                            <div class="box-header">
                                                <div class="user-block">
                                                    <span class="label label-default">{{$file->fileType->name}}</span>
                                                    <span class="label label-default">{{$document->status}}</span>
                                                    <span class="username" style="cursor:pointer;"
                                                          onclick="showFileModal({{json_encode($file)}})">{{$file->name}}</span>
                                                    <small class="description text-gray"><b
                                                            title="{{formatDateTime($file->created_at)}}"
                                                            data-toggle="tooltip">{{\Carbon\Carbon::parse($file->created_at)->diffForHumans()}}</b>
                                                        by <b>{{$file->createdBy->name}}</b></small>
                                                </div>
                                                <div class="pull-right box-tools">
                                                    <button type="button"
                                                            class="btn btn-default btn-flat dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"
                                                            style="    background: transparent;border: none;">
                                                        <i class="fa fa-ellipsis-v" style="color: #fff;"></i>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="javascript:void(0);"
                                                               onclick="showFileModal({{json_encode($file)}})">Show
                                                                Detail</a></li>
                                                        <li><a href="javascript:void(0);"
                                                                    onclick="showFileRateModal({{json_encode($file)}})">Rate ✩</a></li>
                                                        <li>
                                                            <a href="{{route('files.showfile',['dir'=>'original','file'=>$file->file])}}?force=true"
                                                               download>Download
                                                                original</a>
                                                        </li>
                                                        
                                                        @if (checkIsFileIsImage($file->file))
                                                            @foreach (explode(",",config('settings.image_files_resize')) as $varient)
                                                                <li>
                                                                    <a href="{{route('files.showfile',['dir'=>$varient,'file'=>$file->file])}}?force=true"
                                                                       download>Download {{$varient}}w</a></li>
                                                            @endforeach
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                   onclick="javascript:ImageEditor.open('{{route('files.showfile',['dir'=>'original','file'=>$file->file])}}')">
                                                                    Edit Image
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            {!! Form::open(['route' => ['documents.files.destroy', $file->id], 'method' => 'delete', 'style'=>'display:inline;']) !!}
                                                            <button class="btn btn-link"
                                                                    onclick="conformDel(this,event)" type="submit">
                                                                Delete
                                                            </button>
                                                            {!! Form::close() !!}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @can('update', [$document, $document->tags->pluck('id')])
                                <a href="{{route('documents.files.create',$document->id)}}"
                                   class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                                    Add {{ucfirst(config('settings.file_label_plural'))}}</a>
                            @endcan
                        </div>
                        @can('verify', $document)
                            <div class="tab-pane" id="tab_verification">
                                @if ($document->status!=config('constants.STATUS.APPROVED'))
                                    {!! Form::open(['route' => ['documents.verify', $document->id], 'method' => 'post']) !!}
                                    <div class="form-group text-center">
                                    <textarea class="form-control" name="vcomment" id="vcomment" rows="4"
                                              placeholder="Enter Comment to verify with comment(optional)"></textarea>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success" type="submit" name="action" value="approve"><i
                                                class="fa fa-check"></i> Approve
                                        </button>
                                        <button class="btn btn-danger" type="submit" name="action" value="reject"><i
                                                class="fa fa-close"></i> Reject
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                @else
                                    <div class="form-group">
                                        <span class="label label-success">Verified</span>
                                    </div>
                                    <div class="form-group">
                                        Verifier: <b>{{$document->verifiedBy->name}}</b>
                                    </div>
                                    <div class="form-gorup">
                                        Verified At: <b>{{formatDateTime($document->verified_at)}}</b>
                                        ({{\Carbon\Carbon::parse($document->verified_at)->diffForHumans()}})
                                    </div>
                                @endif
                            </div>
                        @endcan
                        <div class="tab-pane" id="tab_activity">
                            <ul class="timeline">
                                <li class="time-label">
                                    <span class="bg-red">{{formatDate($document->updated_at,'d M Y')}}</span>
                                </li>
                                @foreach ($document->activities as $activity)
                                    <li>
                                        <i class="fa fa-user bg-aqua" data-toggle="tooltip"
                                           title="{{$activity->createdBy->name}}"></i>

                                        <div class="timeline-item">
                                            <span class="time" data-toggle="tooltip"
                                                  title="{{formatDateTime($activity->created_at)}}"><i
                                                    class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($activity->created_at)->diffForHumans()}}</span>

                                            <h4 class="timeline-header no-border">{!! $activity->activity !!}</h4>
                                        </div>
                                    </li>
                                @endforeach
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                        @can('user manage permission')
                            <div class="tab-pane" id="tab_permissions">
                                <div>
                                    <div class="modal fade" id="modal-permission">
                                        {{Form::open(['route' => ['documents.store-permission',request('document')]])}}
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Give Permission</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="user_id" required>
                                                                <option value="">- Select User -</option>
                                                                @foreach($users as $usr)
                                                                    <option value="{{$usr->id}}">{{$usr->name}}({{$usr->username}})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @foreach (config('constants.DOCUMENT_LEVEL_PERMISSIONS')  as $perm)
                                                            <div class="col-sm-6" style="margin-top: 20px;">
                                                                <label>
                                                                    <input name="document_permissions[{{$perm}}]"
                                                                           type="checkbox" class="iCheck-helper"
                                                                           value="1"> {{ucfirst($perm)}}
                                                                    this {{config('settings.document_label_singular')}}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Save Permission</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th colspan="3" style="font-size: 1.8rem;">
                                                Direct Permissions
                                                <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal"
                                                        data-target="#modal-permission">
                                                    <i class="fa fa-plus"></i> New Permission
                                                </button>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>User</th>
                                            <th>Permissions</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (count($thisDocPermissionUsers)==0)
                                            <tr>
                                                <td colspan="2">No record found</td>
                                            </tr>
                                        @endif
                                        @foreach($thisDocPermissionUsers as $perm)
                                            <tr>
                                                <td>{{$perm['user']->name}}</td>
                                                <td>
                                                    @foreach($perm['permissions'] as $item)
                                                        <label class="label label-default">{{$item}}</label>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{Form::open(['route' => ['documents.delete-permission',request('document'),$perm['user']->id]])}}
                                                    <button type="submit" class="btn btn-danger btn-xs"
                                                            onclick="return conformDel(this,event)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    {{Form::close()}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th colspan="3" style="font-size: 1.8rem;">Permissions inherited
                                                by {{config('settings.tags_label_plural')}}</th>
                                        </tr>
                                        <tr>
                                            <th>{{ucfirst(config('settings.tags_label_singular'))}}</th>
                                            <th>User</th>
                                            <th>Permissions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (count($tagWisePermList)==0)
                                            <tr>
                                                <td colspan="3">No record found</td>
                                            </tr>
                                        @endif
                                        @foreach ($tagWisePermList as $perm)
                                            <tr>
                                                <td>{{$perm['tag']->name}}</td>
                                                <td>{{$perm['user']->name}}</td>
                                                <td>
                                                    @foreach ($perm['permissions'] as $p)
                                                        <label class="label label-default">{{$p}}</label>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th colspan="3" style="font-size: 1.8rem;">Global Permission of {{config('settings.document_label_plural')}}</th>
                                        </tr>
                                        <tr>
                                            <th>User</th>
                                            <th>Permissions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (count($globalPermissionUsers)==0)
                                            <tr>
                                                <td colspan="2">No record found</td>
                                            </tr>
                                        @endif
                                        @foreach ($globalPermissionUsers as $perm)
                                            <tr>
                                                <td>{{$perm['user']->name}}</td>
                                                <td>
                                                    @foreach ($perm['permissions'] as $p)
                                                        <label class="label label-default">{{$p}}</label>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="sticky_footer">
        <form id="frm_image2pdf" action="{{route('files.downloadPdf')}}" method="post" style="display: inline">
            @csrf
            <input type="hidden" name="images">
            <input type="hidden" name="images_varient">
            <div class="dropup">
                <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-file-pdf-o"></i>  Convert PDF
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);" onclick="submitPdfForm('original')">Original</a></li>
                    @foreach (explode(',',config('settings.image_files_resize')) as $varient)
                        <li><a href="javascript:void(0);" onclick="submitPdfForm('{{$varient}}')">{{$varient}}w</a></li>
                    @endforeach
                </ul>
            </div>
        </form>
    </div>
@endsection
