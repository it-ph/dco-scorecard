@extends('layouts.dco-app')

@section('content')
<h3><strong>My Signatures</strong></h3>

<div class="row" style="margin-bottom: 10px">
    <div class="col-md-12 text-right">
        <a href="{{url('signature/create')}}"><button type="button" title="Add Signature" class="btn btn-success waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Create</button></a>
        <a href="{{url('signature/upload')}}"><button type="button" title="Upload Signature" class="btn btn-success waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-upload"></i></span>Upload</button></a>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')

        <div class="card">
            <div class="card-body">

            <table id="signature_datatable" class="display nowrap table table-hover table-bordered dataTable " cellspacing="0" width="100%">
                <thead style="background: #04b381; color: white; font-weight: bold">
                    <tr>
                        <td>Name</td>
                        <td>Signature At</td>
                        <td>Date Created</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($signatures as $signature)
                    <tr>
                        <td class="table-dark-border">{{ucwords($signature->filename)}}
                            @if($signature->is_default == 1)
                                <br>
                                <span style="font-size: 12px; font-style: italic; color: #d70127">(default signature)</span>
                            @endif
                        </td>
                        <td class="table-dark-border" style="width: 40%">
                            <img src="{{ asset('storage')}}/{{Auth::user()->id}}/signatures/{{$signature->file}}" alt="">
                        </td>
                        <td class="table-dark-border">{{$signature->created_at->format('Y-m-d h:i:s A')}}</td>
                        <td class="table-dark-border" style="width: 150px; text-align: center" class="table-dark-border">
                            <form method="POST" action="{{route('signature.destroy', ['signatureId' => $signature->id])}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this signature?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> </button>
                            </form>
                        </td>
                        <td class="table-dark-border" style="width: 150px; text-align: center" class="table-dark-border">
                            <form method="POST" action="{{route('signature.default', ['signatureId' => $signature->id])}}">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure you want to set this as your default signature?')" class="btn btn-sm btn-info"> set to default</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-md-12-->
</div><!--row-->

@endsection

@section('js')
@include('js_addons')
<script>
        $(document).ready(function() {
          var table = $('#signature_datatable').DataTable( {
            "pagingType": "full_numbers",

              orderCellsTop: true,
              fixedHeader: true,
            //   dom: 'Bfrtip',
            //   buttons: [
            //       'excel', 'print'
            //   ],



          } );
      } );
</script>
@endsection
