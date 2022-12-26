<div class="box-header">
    <div class="form-group hidden visible-xs">
        <button type="button" class="btn btn-default btn-block" data-toggle="collapse"
                data-target="#filterForm"><i class="fa fa-filter"></i> Filter
        </button>
    </div>
    {!! Form::model(request()->all(), ['method'=>'get','class'=>'form-inline visible hidden-xs','id'=>'filterForm']) !!}
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
</div>
