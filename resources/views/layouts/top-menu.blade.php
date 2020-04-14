@inject('allRoles', 'App\helpers\AllRoles')
@inject('homeQuery', 'App\helpers\HomeQueries')
<!-- ============================================================== -->
                        {{-- <li class="nav-item hidden-xs-down search-box"> <a class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li> --}}
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->

                        @if(Auth::user()->isAdmin() || Auth::user()->isManager() )
                        
                        <?php $unAcknowledge_list =  ($homeQuery->adminUnAcknowledgeList()) ? $homeQuery->adminUnAcknowledgeList() : []; ?>
                        @if( count($unAcknowledge_list) > 0 )
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title" style="border-bottom: 0px">
                                            <span title="Unacknowledge Scorecard count" class="label label-rouded label-danger">{{count($unAcknowledge_list) }}</span> UnAcknowledged cards
                                        </div>
                                    </li>
                                    {{-- <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/agent?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> <span style="font-weight: bold">{{count($unAcknowledge_list) }}</span></h5> <span class="mail-desc"> UnAcknowledge Scorecard!</span> </div>
                                            </a>
                                            
                                        </div>
                                    </li> --}}
                                    {{-- <li>
                                        <a class="nav-link text-center" href="{{url('/scores/agent?not_acknowledge')}}"> <strong>View Scorecards</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>
                        @endif <!--if hasUnacknowledge manager-->
                        <!--supervisor -->
                        @elseif(Auth::user()->isSupervisor())
                        <?php $unAcknowledge_list =  ($homeQuery->unAcknowledgeListForSupervisor()) ? $homeQuery->unAcknowledgeListForSupervisor() : []; ?>
                        <?php $unAcknowledge_member_only =  ($homeQuery->unAcknowledgeListForMemberOnly()) ? $homeQuery->unAcknowledgeListForMemberOnly() : []; ?>

                        @if( count($unAcknowledge_list) > 0 )
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Un Acknowledge Scorecards</div>
                                    </li>

                                    <li>
                                        <div class="message-center">
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                    <div class="mail-contnet">
                                                        <h5> Team Members : <span style="font-weight: bold">{{count($unAcknowledge_list) - count($unAcknowledge_member_only)}}</span></h5> </div>
                                                </a>
                                             </div>
                                    </li>
                                    @if( count($unAcknowledge_member_only) > 0 )
                                    <li>
                                            <div class="message-center">
                                                    <!-- Message -->
                                                    <a href="#"">
                                                        <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                        <div class="mail-contnet">
                                                            <h5> You : <span style="font-weight: bold">{{count($unAcknowledge_member_only) }}</span></h5> </div>
                                                    </a>
                                                 </div>
                                        </li>
                                    @endif
                                  
                                </ul>
                            </div>
                        </li>
                        @endif <!--if hasUnacknowledge sup-->
                       
                        @else <!-- member -->
                        <?php $unAcknowledge_member_only =  ($homeQuery->unAcknowledgeListForMemberOnly()) ? $homeQuery->unAcknowledgeListForMemberOnly() : []; ?>
                            @if( count($unAcknowledge_member_only) > 0 )
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                    <ul>
                                        <li>
                                            <div class="drop-title" style="border-bottom: 0px">
                                            <a style="color: #454547" href="{{url('v2/scores')}}/{{Auth::user()->role_id}}?not_acknowledge">
                                                <span title="Unacknowledge Scorecard count" class="label label-rouded label-danger">{{count($unAcknowledge_member_only) }}</span> Un Acknowledged cards
                                            </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                    @endif