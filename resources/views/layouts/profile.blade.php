<!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown" style="background: rgba(0,0,0,.4);">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/profile.png')}}" alt="user" style="width: 40px" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{asset('images/profile.png')}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{ucwords(\Auth::user()->name)}}</h4>
                                            <p class="text-muted">{{\Auth::user()->email}}</p>
                                            <p class="text-muted">@if(\Auth::user()->theposition)
                                                {{ucwords(\Auth::user()->theposition->position)}}
                                                @endif
                                            </p>
                                            {{-- <a href="pages-profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a> --}}
                                        </div>
                                        </div>
                                    </li>
                                    {{-- <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>--}}
                                    <li><a href="{{url('user/password')}}"><i class="ti-user"></i> Change Password</a></li> 
                                    <li role="separator" class="divider"></li>
                                    <li><a onclick="return confirm('Are you sure you want to Sign-out?')" href="{{url('logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>