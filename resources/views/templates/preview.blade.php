@inject('templateQueries', 'App\helpers\templateQueries')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('css/dco-scorecard.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{asset('css/google.font.css')}}" > --}}
    <style>
        body{
            color: black;
        }

        table {
        border-collapse: collapse;
        }
        td, th {
        border: 1px solid black;
        
        }
        .lbl-bold{
            font-weight: bold
        }

        .ttxt-center{
            text-align: center;
        }

        @media print
        {
        .noprint {display:none;}
        }

        @media print
        {
         table {font-size: 12px !important;}
        }

        .col-print-1 {width:8%;  float:left;}
        .col-print-2 {width:16%; float:left;}
        .col-print-3 {width:25%; float:left;}
        .col-print-4 {width:33%; float:left;}
        .col-print-5 {width:42%; float:left;}
        .col-print-6 {width:50%; float:left;}
        .col-print-7 {width:58%; float:left;}
        .col-print-8 {width:66%; float:left;}
        .col-print-9 {width:75%; float:left;}
        .col-print-10{width:83%; float:left;}
        .col-print-11{width:92%; float:left;}
        .col-print-12{width:100%; float:left;}
        
        
    </style>
    <title>DCO Scorecard</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row noprint" style="margin-top: 20px;">
            <div class="col-md-12">
            @if($from==0)
            <a href="{{url('v2/admin/template/create')}}"><button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> Back to Lists</button></a>
            @else
            <a href="javascript: history.go(-1)"><button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> Go Back</button></a>
            @endif
          </div>
        </div>


        <div class="row" style="margin-top: 40px;">
         
            <div class="col-md-12">
                <table  width="100%"  cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; text-align: center; font-weight: bold;font-size: 22px">
                            SCORECARD</td>
                    </tr>
                    
                    <tr>
                        <td class="lbl-bold">Employee Name:</td>
                        <td></td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 18px;"> FINAL SCORE :</span> </td>
                        <td rowspan="2" style="text-align: center;font-weight: bold; font-size: 18px;"><span id="finalScoreId"> </span> <span></span>
                        </td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Emp ID:</td>
                        <td></td>
                      
                    </tr>

                    <tr>
                        <td class="lbl-bold">Position</td>
                        <td></td>
                        <td class="lbl-bold">Month:</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Department</td>
                        <td> </td>
                        <td class="lbl-bold">Target:</td>
                        <td></td>
                    </tr>
                </table>

            </div><!--col-md-12-->
        </div><!--row-->

        <div class="row">
                <div class="col-md-12">
                    <table  width="100%" style="margin-top: 40px; font-size: 14px" cellspacing="5" cellpadding="5">
                        <tr  style="background: gray; text-align: center; font-weight: bold;">

                            @foreach($template_column as $columns)
                            <td>{{strtoupper($columns->column_name)}}</td>

                            @endforeach
                            {{-- <td>METRICS</td>
                            <td>WEIGHT</td>
                            <td>TARGET</td>
                            <td>PERFORMANCE RANGES</td>
                            <td>ACTUAL SCORE</td>
                            <td>SCORE</td> --}}
                        </tr>

                        @if($templatecontent_lastrow)
                        <?php $lastrow = $templatecontent_lastrow->row_position; ?>
                        <?php $row = $templatecontent_lastrow->row_position + 1; ?>
                                  {{-- ANG COLUMN AYz : {{count($scorecard_column) - 1}} <!--add start with 0--> --}}
                                {{-- ANG LAST ROW  AY : {{$lastrow}} <!--add start with 0--> --}}
                            @for ($irow = 0; $irow <= $lastrow; $irow++)
                            <tr>
                                @for ($jcol = 0; $jcol+1 <= count($template_column) ; $jcol++) <!--column -->
                                <?php $tq = $templateQueries->contentBaseOnRowAndColumnPosition($template->id,$irow,$jcol); ?>
                                <?php  $tqCol = $templateQueries->contentBaseonColumn($template->id,$jcol); ?>
                                <?php $isSame = $templateQueries->templateDuplicateChecker($template->id,$irow,$jcol); ?>
                                <td style="text-align: center">
                                @if($tqCol->is_fillable == 1)
                                   @if($tq)  <div style="border: 1px solid #5e5d62; background: #5e5d62; color: white; font-style: italic">&nbsp;</div> @endif
                                @elseif($isSame)  
                                
                                @else
                                    @if($tq) {!! nl2br($tq->content) !!} @endif
                                @endif
                                </td>
                                @endfor<!--jcol-->
                            </tr>
                            @endfor <!--irow-->
                       
                        @endif <!--if templatecontent_lastrow -->
                        
                    </table>
                </div><!--col-md-12-->
            </div><!--row-->

            @foreach($template_remarks as $user_remarks)
            <div class="row">
                <div class="col-md-12">
                    <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                        <tr>
                        <td colspan="4" style="background: gray; font-weight: bold">{{strtoupper($user_remarks->name)}}</td>
                        </tr>
                        
                        <tr>
                           <td>
                            <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;"></textarea>
                        </td>  
                          
                        </tr>
                        
                        
                    </table>
    
                </div><!--col-md-12-->
            </div><!--row-->
            @endforeach

                    <div class="row" style="margin-top: 20px">
                        <div class="col-print-2"></div>
                        <div class="col-print-4 text-center">
                            <span style="text-decoration: underline; font-weight: bold;"></span>
                            <br> <span style="font-weight: normal;font-size: 14px">Employee Name</span> </p>
                        </div><!--col-md-5-->

                        <div class="col-print-6 text-center">
                                <span style="text-decoration: underline; font-weight: bold;"></span>
                                <br> <span style="font-weight: normal;font-size: 14px">Date</span> </p>
                            </div><!--col-md-5-->
                    </div><!--row-->

                    <div class="row" style="margin-top: 20px">
                            <div class="col-print-2"></div>
                            <div class="col-print-4 text-center">
                                <span style="text-decoration: underline; font-weight: bold;">
                               </span>
                                <br> <span style="font-weight: normal;font-size: 14px">Supervisor</span> </p>
                            </div><!--col-md-5-->
    
                            <div class="col-print-6 text-center">
                                    <span style="text-decoration: underline; font-weight: bold;">
                                     </span>
                                    <br> <span style="font-weight: normal;font-size: 14px">Operations Manager</span> </p>
                                </div><!--col-md-5-->
                    </div><!--row-->
                    <div class="row" style="margin-top: 20px">
                            <div class="col-print-1"></div>
                            <div class="col-print-11 text-center">
                                    <span style="text-decoration: underline; font-weight: bold;">
                                 
                                    </span>
                                    <br> <span style="font-weight: normal;font-size: 14px">Tower Head</span> </p>
                                </div><!--col-md-5-->
                    </div><!--row-->
    

    </div><!--container-->
</body>
</html>

