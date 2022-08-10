@extends('layouts.dco-app')

@section('content')

    @if(Auth::user()->isAdmin())
    <div class="col-md-12" style="margin-top: 5px">
        @include('notifications.success')
        @include('notifications.error')
    </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card" >
                    <div class="card-body p-b-20">
                        <h3><strong><i class="fa fa-file-excel-o" style="background: #04B381;"></i>  GENERATE REPORT</strong></h3>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#download-report" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Download</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#upload-report" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-upload"></i></span> <span class="hidden-xs-down">Upload</span></a> </li>
                        {{-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#upload-report" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Upload Agent Scores</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#upload-report1" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Upload Team Leader Scores</span></a> </li> --}}
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="download-report" role="tabpanel" aria-expanded="true">


                                        <form  action="{{route('export')}}" method="POST">
                                                @csrf
                                            <div class="row">


                                                <div class="col-md-12">
                                                    <label class="m-t-40">Select Report <span style="font-weight: bold; color: red">*</span></label>
                                                    <select data-toggle="tooltip" data-placement="left" title="Select Report"  onchange="isTarget()" class="form-control" name="report" id="report">
                                                        <option value="">--Please Select Report --</option>
                                                        <option value="agent">Agents Scorecard Summary</option>
                                                        {{-- <option value="tl">Team Leaders Scorecard Summary</option> --}}
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row"  id="date_div"  style="display: none">
                                                {{-- <div class="col-md-12">
                                                    <label class="m-t-20">Date Range <span style="font-weight: bold; color: red">*</span></label>.

                                                    <input class="form-control input-daterange-datepicker" type="text" name="daterange" value=" {{\Carbon\Carbon::now()->subDays(7)->format('m-d-Y')}} - {{date('m-d-Y')}}">

                                                </div> --}}
                                                {{-- <div class="col-md-6">
                                                    <label class="m-t-20">Date From <span style="font-weight: bold; color: red">*</span></label>.
                                                    <input type="text" name="date_from" class="form-control mdate" style="cursor: pointer" placeholder="--Select Date From--">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="m-t-20">Date to <span style="font-weight: bold; color: red">*</span></label>.
                                                    <input type="text" name="date_to" class="form-control mdate" style="cursor: pointer" placeholder="--Select Date To--">
                                                </div> --}}

                                                <div class="col-md-6">
                                                    <label class="m-t-20">Date From <span style="font-weight: bold; color: red">*</span></label>.
                                                    <input type="text" name="date_from" class="form-control ddate" style="cursor: pointer" placeholder="--Select Date From--" autocomplete="off">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="m-t-20">Date to <span style="font-weight: bold; color: red">*</span></label>.
                                                    <input type="text" name="date_to" class="form-control ddate" style="cursor: pointer" placeholder="--Select Date To--" autocomplete="off">
                                                </div>

                                            </div>

                                            <div class="row">


                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <button type="submit" data-toggle="tooltip" title="Click to Download Report" class="m-t-20 btn btn-info pull-right"> <strong> <i class="fa fa-download"></i>  DOWNLOAD </strong></button>
                                                </div>


                                            </div><!--row-->

                                            </form>


                        </div><!--download-report-->


                        <div class="tab-pane m-t-20" id="upload-report" role="tabpanel" aria-expanded="false">
                            <div class="pull-right m-b-10">
                                <a href="{{url('export_agent_template/upload-agent_template')}}">
                                    <button class="btn btn-info btn-sm"  data-toggle="tooltip" title="Click to Download Upload Template"><i class="fa fa-download"></i> Template</button>
                                    </a>
                            </div>

                            <form action="{{ route('import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control" name="import_file"/><br>
                                <button class="btn m-t-20 btn btn-info pull-right"  data-toggle="tooltip" title="Click to Upload Report" onclick="return confirm('Confirm Report Upload?')"><strong> <i class="fa fa-upload"></i> UPLOAD </strong></button>
                            </form>
                        </div>

                        {{-- <div class="tab-pane m-t-20" id="upload-report1" role="tabpanel" aria-expanded="false">
                            <div class="pull-right m-b-10">
                                <a href="{{url('export_tl_template/upload-tl_template')}}">
                                    <button class="btn btn-info btn-sm"  data-toggle="tooltip" title="Click to Download Upload Template"><i class="fa fa-download"></i> Template</button>
                                    </a>
                            </div>

                            <form action="{{ route('import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control" name="import_file"/><br>
                                <button class="btn m-t-20 btn btn-info pull-right"  data-toggle="tooltip" title="Click to Upload Report" onclick="return confirm('Confirm Report Upload?')"><strong> <i class="fa fa-upload"></i> UPLOAD </strong></button>
                            </form>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    @else
        <h3>Hello, <strong>{{strtoupper(Auth::user()->name)}}!</strong></h3>
    @endif
@endsection
