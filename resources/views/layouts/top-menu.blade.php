<!-- ============================================================== -->
                        {{-- <li class="nav-item hidden-xs-down search-box"> <a class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li> --}}
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->

                        <!--AGENT-->
                        @if(agentHasUnAcknowledgeCard() > 0 && \Auth::user()->isAgent())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/agent?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> You have <span style="font-weight: bold">{{agentHasUnAcknowledgeCard()}}</span></h5> <span class="mail-desc"> UnAcknowledge Scorecard!</span> </div>
                                            </a>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="{{url('/scores/agent?not_acknowledge')}}"> <strong>View Scorecards</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!--TL -->
                        @elseif(tlHasUnAcknowledgeCard() > 0 && \Auth::user()->isSupervisor() || memberUnacknowledgeCard('supervisor')> 0 && \Auth::user()->isSupervisor() )
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/agent?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> Your Team has <span style="font-weight: bold">{{memberUnacknowledgeCard('supervisor')}}</span></h5> <span class="mail-desc"> UnAcknowledge Scorecard!</span> </div>
                                            </a>
                                            
                                        </div>

                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/tl?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> You have <span style="font-weight: bold">{{tlHasUnAcknowledgeCard()}}</span></h5> <span class="mail-desc"> UnAcknowledge Scorecard!</span> </div>
                                            </a>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="{{url('/scores/agent?not_acknowledge')}}"> <strong>View Scorecards</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Manager -->
                        @elseif(memberUnacknowledgeCard('manager')> 0 && \Auth::user()->isManager() || memberTLUnacknowledgeCard() > 0 && \Auth::user()->isManager()  )
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/agent?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> Agent has <span style="font-weight: bold">{{memberUnacknowledgeCard('manager')}}</span></h5> <span class="mail-desc"> UnAcknowledge Scorecard!</span> </div>
                                            </a>
                                            
                                        </div>

                                        @if(memberTLUnacknowledgeCard() > 0)
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/tl?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> Team Leaders has <span style="font-weight: bold">{{memberTLUnacknowledgeCard()}}</span></h5> </div>
                                            </a>
                                            
                                        </div>
                                        @endif

                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="{{url('/scores/agent?not_acknowledge')}}"> <strong>View Scorecards</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!--admin-->
                        @elseif( \Auth::user()->isAdmin() && allAgentUnacknowledgeCard() > 0 ||  \Auth::user()->isAdmin() && allTLUnacknowledgeCard() > 0) 

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Un Acknowledge Scorecards </div>
                                    </li>
                                    <li>
                                        @if(allAgentUnacknowledgeCard() > 0)
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/agent?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> Agent has <span style="font-weight: bold">{{allAgentUnacknowledgeCard()}}</span></h5> </div>
                                            </a>
                                            
                                        </div>
                                        @endif
                                        @if(allTLUnacknowledgeCard() > 0)
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{url('/scores/tl?not_acknowledge')}}">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link fa-spin"></i></div>
                                                <div class="mail-contnet">
                                                    <h5> Team Leaders has <span style="font-weight: bold">{{allTLUnacknowledgeCard()}}</span></h5> </div>
                                            </a>
                                            
                                        </div>
                                        @endif
                                    </li>
                                    {{-- <li>
                                        <a class="nav-link text-center" href="{{url('/scores/agent?not_acknowledge')}}"> <strong>View Scorecards</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>

                        @endif
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <!-- ============================================================== -->
                        <!-- End Messages -->