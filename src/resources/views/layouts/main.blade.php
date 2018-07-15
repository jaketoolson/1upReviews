@include('layouts.partials._headerhtml')

<main id="root" role="main">
    <!-- Begin page -->
        <div id="wrapper">

            @include('layouts.partials._topnav')

            @include('layouts.partials._leftnav')

            <!-- Page Content Start -->
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page title box -->
                        <div class="page-title-box">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Greeva</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Starter</li>
                            </ol>
                            <h4 class="page-title">Starter</h4>
                        </div>
                        <!-- End page title box -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    @yield('content')
                                </div>
                            </div>
                        </div>

                    </div> <!-- end container-fluid-->
                </div> <!-- end contant-->
            </div>
            <!-- End Page Content-->


            @include('layouts.partials._pagefooter')

        </div>
        <!-- End #wrapper -->

</main>

@include('layouts.partials._footerhtml')
