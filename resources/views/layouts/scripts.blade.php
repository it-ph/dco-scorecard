    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('js/theme/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('js/theme/popper.min.js')}}"></script>
    <script src="{{asset('js/theme/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/theme/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/theme/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/theme/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('js/theme/sticky-kit.min.js')}}"></script>
    <script src="{{asset('js/theme/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/theme/custom.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('js/theme/jQuery.style.switcher.js')}}"></script>

    
    <script src="{{asset('js/theme/jquery.dataTables.min.js')}}"></script>
    
    <script src="{{asset('themes/assets/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('themes/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('themes/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('themes/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('themes/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

    $('.mdate').bootstrapMaterialDatePicker({
        weekStart: 0, time: false,
    });

    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-inverse'
    });

    $('.ddate').datepicker( {
        format: "M yyyy",
        startView: "months",
        minViewMode: "months",
        orientation: "bottom auto",
    });

    </script>


    <script>
        function isTarget()
        {
            $("#date_div").slideDown();
            // report = $("#report").val();
            // if(report == 'target')
            // {
            //     $("#date_div").slideUp();
            //     $("#div_effectivity_year").slideDown();
            // }else{
            //     $("#date_div").slideDown();
            //     $("#div_effectivity_year").slideUp();
            // }
        }
    </script>

    @yield('js')
