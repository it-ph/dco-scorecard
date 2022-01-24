<!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" style="border-bottom: 10px solid #04b381;">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-profile" >
                        <a class="waves-effect waves-dark @if (\Request::is('user/password')) active @endif" href="{{url('user/password')}}" aria-expanded="false"><img src="{{asset('images/profile.png')}}" alt="user" /><span class="hide-menu">{{strtoupper(Auth::user()->name)}}</span></a>
                         </li>
                        <li class="nav-devider"></li>
                        <li class="nav-small-cap">MAIN NAVIGATION</li>
                        <li> <a class=" waves-effect waves-dark  @if (\Request::is('home')) active @endif" href="{{url('home')}}"><i class="mdi mdi-gauge" style="color: #04b381"></i><span class="hide-menu">Dashboard
                      </span></a>

                        </li>
                        @if(Auth::user()->isAdmin() || Auth::user()->isManager() || Auth::user()->isSupervisor())
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye" style="color: #04b381"></i><span class="hide-menu">Scores </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a class=" waves-effect waves-dark  @if (\Request::is('scores/agent')) active @endif" href="{{url('scores/agent')}}">
                                    Agents
                                    </a>
                                </li>
                                <li><a class=" waves-effect waves-dark  @if (\Request::is('scores/tl')) active @endif" href="{{url('scores/tl')}}">Team Leaders </a></li>
                            </ul>
                        </li>
                        @else
                         <li>
                                <a class=" waves-effect waves-dark  @if (\Request::is('scores/agent')) active @endif" href="{{url('scores/agent')}}">
                                    <i class="mdi mdi-bullseye" style="color: #04b381"></i> <span class="hide-menu">Scores</span>
                                </a>
                            </li>
                        @endif

                    @if(Auth::user()->isAdmin())
                        <li class="nav-small-cap">ADMIN SETTINGS</li>
                        <li>
                            <a class="waves-effect waves-dark @if (\Request::is('admin/users')) active @endif" href="{{url('admin/users')}}" aria-expanded="false"><i class="mdi mdi-account-multiple" style="color: #e99d23"></i><span class="hide-menu">Users</span></a>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-hexagon-multiple" style="color: #e99d23"></i><span class="hide-menu" >Set up</span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a class="waves-effect waves-dark @if (\Request::is('admin/admin-positions')) active @endif" href="{{url('admin/admin-positions')}}">Positions</a></li>

                                <li><a class="waves-effect waves-dark @if (\Request::is('admin/admin-roles')) active @endif" href="{{url('admin/admin-roles')}}">Roles</a></li>

                                <li><a class="waves-effect waves-dark @if (\Request::is('admin/departments')) active @endif" href="{{url('admin/departments')}}">Departments</a></li>
                                <li><a class="waves-effect waves-dark @if (\Request::is('admin/settings')) active @endif" href="{{url('admin/settings')}}">Settings</a></li>
                            </ul>
                        </li>
                    @endif


                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
