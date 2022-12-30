<style>
    .title{
        color: whitesmoke;
        font-family:'Times New Roman', Times, serif;
        margin-top: -30px;
        padding-left: 10px
    }
</style>
<aside class="main-sidebar blue-background" id="sidebar-wrapper" style=" background-color: #0361d8;">
    <div class="title"> <h2>{{config('settings.system_title')}}</h2></div>

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            {{-- <div class="pull-left image">
                <img src="../../../public/doc.png" class="img-circle" style="background-color: white"
                     alt="User Image"/>
            </div> --}}
           
            {{-- <div class="pull-left info">
                @if (Auth::guest())
                <p>{{config('settings.system_title')}}</p>
                @else
                    <p>{{ Auth::user()->name}}</p>
                @endif
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>--}}
        </div> 

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
          <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
            </div>
        </form> --}}
        <!-- Sidebar Menu -->
        {{-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a> --}}
        <ul class="sidebar-menu" data-widget="tree">
            @include('layouts.menu')
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
