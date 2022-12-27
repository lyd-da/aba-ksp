    <style>
        .side-bar-tile-content {
            color: white;
        }
        .side-bar-tile-active {
        background-color: #002e69;
      }

      .side-bar-tile:hover {
        background-color: red !important
      }
    </style>
@can('viewAny',\App\Document::class)
    <li class="{{ Request::is('admin/documents*') ? 'side-bar-tile-active' : ''}}">
        <a class="side-bar-tile" href="{!! route('documents.index') !!}"><i
                class="side-bar-tile-content fa fa-file"></i><span class="side-bar-tile-content">{{ucfirst(config('settings.document_label_plural'))}}</span></a>
    </li>
@endcan
<li class="{{ Request::is('admin/home*') ? 'active' : '' }}">
    <a class="side-bar-tile" href="{!! route('admin.dashboard') !!}"><i class="side-bar-tile-content fa fa-home"></i><span class="side-bar-tile-content bg-white">Home</span></a>
</li>
@can('read users')
    <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="side-bar-tile" href="{!! route('users.index') !!}" ><i class="side-bar-tile-content fa fa-users"></i><span class="side-bar-tile-content">Users</span></a>
    </li>
@endcan
@can('read tags')
    <li class="{{ Request::is('admin/tags*') ? 'active' : '' }}">
        <a class="side-bar-tile" href="{!! route('tags.index') !!}"><i
                class="side-bar-tile-content fa fa-tags"></i><span class="side-bar-tile-content">{{ucfirst(config('settings.tags_label_plural'))}}</span></a>
    </li>
@endcan
@if(auth()->user()->is_super_admin)
    <li class="treeview {{ Request::is('admin/advanced*') ? 'active' : '' }}">
        <a class="side-bar-tile" href="#">
            <i class="side-bar-tile-content fa fa-info-circle"></i>
            <span class="side-bar-tile-content">Advanced Settings</span>
            <span class="pull-right-container">
              <i class="side-bar-tile-content fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::is('admin/advanced/settings*') ? 'active' : '' }}">
                <a href="{!! route('settings.index') !!}"><i class="side-bar-tile-content fa fa-gear"></i><span class="side-bar-tile-content">Settings</span></a>
            </li>
            <li class="{{ Request::is('admin/advanced/custom-fields*') ? 'active' : '' }}">
                <a href="{!! route('customFields.index') !!}"><i
                        class="side-bar-tile-content fa fa-file-text-o"></i><span class="side-bar-tile-content">Custom Fields</span></a>
            </li>
            <li class="{{ Request::is('admin/advanced/file-types*') ? 'active' : '' }}">
                <a href="{!! route('fileTypes.index') !!}"><i class="side-bar-tile-content fa fa-file-o"></i><span class="side-bar-tile-content">{{ucfirst(config('settings.file_label_singular'))}} Types</span></a>
            </li>
        </ul>
    </li>
@endif
