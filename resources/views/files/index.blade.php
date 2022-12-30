<div  >
    <div class="form-group hidden visible-xs">
        <button type="button" class="btn btn-default btn-block" data-toggle="collapse"
                data-target="#filterForm"><i class="fa fa-filter"></i> Filter
        </button>
    </div>
    {!! Form::open(['route' => ['search', $document->id], 'method'=>'get','class'=>'form-inline visible hidden-xs','style'=>'float:left','id'=>'filterForm']) !!}
    <div class="form-group">
        <label for="search" class="sr-only">Search</label>
        {!! Form::text('search',null,['class'=>'form-control input-sm','placeholder'=>'Search...']) !!}
    </div>
   
    <div class="form-group">
        <label for="status" class="sr-only">{{config('settings.tags_label_singular')}}:</label>
        {!! Form::select('status',['0'=>"ALL",config('constants.STATUS.PENDING')=>config('constants.STATUS.PENDING'),config('constants.STATUS.APPROVED')=>config('constants.STATUS.APPROVED'),config('constants.STATUS.REJECT')=>config('constants.STATUS.REJECT')],null,['class'=>'form-control input-sm']) !!}
    </div>
    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-filter"></i> Filter</button>
    {!! Form::close() !!}
    <div>

        @can('update', [$document, $document->tags->pluck('id')])
                    <a href="{{route('documents.files.create',$document->id)}}" class="btn btn-primary btn-sm float-right" style="float: right;">New  <i class="fa fa-plus"></i>
                        </a>
                    @endcan
    </div>
</div>
{{-- <ul class="list-group mt-3">
    @if(!empty($files))
        @forelse($files as $file)
            <li class="list-group-item">{{ $file->name }}</li>
        @empty
            <li class="list-group-item list-group-item-danger">User Not Found.</li>
        @endforelse
    @endif
</ul> --}}