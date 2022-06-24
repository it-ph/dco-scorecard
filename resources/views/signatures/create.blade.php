@extends('layouts.dco-app')
@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> --}}

    <script type="text/javascript" src="{{asset('js/theme/jquery.min-1.12.4.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/theme/jquery-ui.min-1.12.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/theme/jquery.signature.js')}}"></script>
    <style>
        .kbw-signature {
            /* width: 100%;
            height: 200px; */
            display: inline-block;
            border: 1px solid #a0a0a0;
            -ms-touch-action: none;
            width: 100%  !important; height: 200px ;
        }

        .kbw-signature-disabled {
            opacity: 0.35;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
            background: white !important;
        }
    </style>
@endsection

@section('content')
    <h3><strong>Create Signature</strong></h3>

    <div class="col-md-9" style="margin-bottom: 10px">
    </div>
    <div class="col-md-3" style="margin-bottom: 10px">
        <a href="{{url('signatures')}}">
            <button class="btn btn-info" type="button">
            <i class="mdi mdi-chevron-left"></i> Back</button></a>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <form method="POST" action="{{ route('signature.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="">Signature Name <span style="color: red; font-weight: bold">*</span></label>
                                <input type="text" class="form-control" required name="filename" value="{{old('filename')}}">
                                <br>
                                <br/>
                                <label class="" for="">Draw on Canvas:</label>
                                <br/>
                                <div id="sig"></div>
                                <br>
                                <input type="checkbox" id="is_default" name="is_default" value="1">
                                <label for="is_default"> Set as Default</label><br>
                                <div class="col-md-12 text-right">
                                    <button id="clear" class="btn btn-danger">Clear</button>
                                    <button type="submit" onclick="return confirm('Are you sure you want to save this signature?')" class="btn btn-success"> Save</button>
                                </div>
                                <textarea id="signature" name="signed" style="display: none"></textarea>
                            </div>
                        </form>
                    </div>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-md-12-->
    </div><!--row-->

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script> --}}
    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature").val('');
        });
    </script>
@endsection
