@if(Session::has('with_success'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         {{ Session::get('with_success') }} <i class="fa fa-check"></i>
</div>
@endif



