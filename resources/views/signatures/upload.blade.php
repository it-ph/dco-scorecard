@extends('layouts.dco-app')
@section('content')
    <h3><strong>Upload Signature</strong></h3>

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
                        <form method="POST" action="{{ route('signature.upload.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="">Signature File <span style="color: red; font-weight: bold">*</span></label>
                                <input type="file" class="form-control" required name="attach">
                                <br>
                                <br>
                                <input type="checkbox" id="is_default" name="is_default" value="1">
                                <label for="is_default"> Set as Default</label><br>
                                <div class="col-md-12 text-right">
                                    <button type="submit" onclick="return confirm('Are you sure you want to save this signature?')" class="btn btn-success"><i class="mdi mdi-upload"></i> Upload</button>
                                </div>
                                <textarea id="signature" name="signed" style="display: none"></textarea>
                            </div>
                        </form>
                    </div>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-md-12-->
    </div><!--row-->

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
