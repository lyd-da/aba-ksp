{{-- @include('layout.style') --}}
@can('viewAny',\App\Document::class)
    <li class="{{ Request::is('admin/documents*') ? 'active' : '' }}">
        <a href="{!! route('documents.index') !!}"><i
                class="fa fa-file"style="color: whitesmoke"></i><span style="color: whitesmoke">{{ucfirst(config('settings.document_label_plural'))}}</span></a>
    </li>
    <h1 class="awhite">Hello</h1>
@endcan
<li class="{{ Request::is('admin/home*') ? 'active' : '' }}">
    <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home" style="color: whitesmoke"></i><span class="bg-white" style="color: whitesmoke">Home</span></a>
</li>
@can('read users')
    <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}" ><i class="fa fa-users"style="color: whitesmoke"></i><span style="color: whitesmoke">Users</span></a>
    </li>
@endcan
@can('read tags')
    <li class="{{ Request::is('admin/tags*') ? 'active' : '' }}">
        <a href="{!! route('tags.index') !!}"><i
                class="fa fa-tags" style="color: whitesmoke"></i><span style="color: whitesmoke">{{ucfirst(config('settings.tags_label_plural'))}}</span></a>
    </li>
@endcan
@if(auth()->user()->is_super_admin)
    <li class="treeview {{ Request::is('admin/advanced*') ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-info-circle" style="color: whitesmoke"></i>
            <span style="color: whitesmoke">Advanced Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="color: whitesmoke"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::is('admin/advanced/settings*') ? 'active' : '' }}">
                <a href="{!! route('settings.index') !!}"><i class="fa fa-gear"></i><span>Settings</span></a>
            </li>
            <li class="{{ Request::is('admin/advanced/custom-fields*') ? 'active' : '' }}">
                <a href="{!! route('customFields.index') !!}"><i
                        class="fa fa-file-text-o"></i><span>Custom Fields</span></a>
            </li>
            <li class="{{ Request::is('admin/advanced/file-types*') ? 'active' : '' }}">
                <a href="{!! route('fileTypes.index') !!}"><i class="fa fa-file-o"></i><span>{{ucfirst(config('settings.file_label_singular'))}} Types</span></a>
            </li>
        </ul>
    </li>
@endif

