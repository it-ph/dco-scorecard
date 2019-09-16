@include('layouts.head')
@include('layouts.header-with-body')
@include('layouts.left-menu')
    <div class="page-wrapper">
        <div class="container-fluid">
               
            @yield('content')
                
        </div>
        
        @include('layouts.footer')
    </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
@include('layouts.scripts')
</body>
@yield('modal')

</html>
