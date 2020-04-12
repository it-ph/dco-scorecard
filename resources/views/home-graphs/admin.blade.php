<div class="col-md-7">
        <h3> Hello, <strong>{{strtoupper(Auth::user()->name)}}!</strong></h3> 
</div><!--div 5 -->

<div class="col-md-5">
    <div class="card">
            <div class="card-header" style="background: #06d79c">
                <h4 class="m-b-0 text-white"> <i class="mdi mdi-book-open"></i> Team unAcknowledge card: <span style="font-weight: bold; font-size: 25px;"></span>  </h4></div>
            <div class="card-body" style="text-align: center">
                <h3 class="card-title"> Count  </h3>
            <h2 style="font-weight: bold; font-family: arial; font-size: 40px; margin-bottom: 10px">
                        {{count($unAcknowledge_list)}}
                </h2>
             </div>
        </div>
   
            
</div><!--div 5 -->