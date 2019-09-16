<!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-profile">
                        <a class="waves-effect waves-dark text-center @if (\Request::is('profile')) active @endif" href="{{url('test')}}}}" aria-expanded="false"><img src="{{asset('images/profile.png')}}" alt="user" /><span class="hide-menu">{{strtoupper(Auth::user()->name)}}</span></a>
                         </li>
                        <li class="nav-devider" style="border-bottom: 2px solid #003a5d;"></li>
                        <li class="nav-small-cap">MAIN NAVIGATION</li>
                        <li> <a class=" waves-effect waves-dark  @if (\Request::is('dashboard')) active @endif" href="{{url('dashboard')}}"><i class="mdi mdi-gauge" style="color: #e99d23"></i><span class="hide-menu">Dashboard</span></a>
                           
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye" style="color: #e99d23"></i><span class="hide-menu">Scores</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="app-calendar.html">Calendar</a></li>
                                <li><a href="app-chat.html">Chat app</a></li>
                                <li><a href="app-ticket.html">Support Ticket</a></li>
                                <li><a href="app-contact.html">Contact / Employee</a></li>
                                <li><a href="app-contact2.html">Contact Grid</a></li>
                                <li><a href="app-contact-detail.html">Contact Detail</a></li>
                            </ul>
                        </li>

                        <li class="nav-small-cap">ADMIN SETTINGS</li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-hexagon-multiple"></i><span class="hide-menu">Set up</span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a class="waves-effect waves-dark @if (\Request::is('admin/admin-positions')) active @endif" href="{{url('admin/admin-positions')}}">Positions</a></li>
                           
                                <li><a class="waves-effect waves-dark @if (\Request::is('admin/admin-roles')) active @endif" href="{{url('admin/admin-roles')}}">Roles</a></li>
                            </ul>
                        </li>
                        <li> 
                            <a class="waves-effect waves-dark @if (\Request::is('admin/users')) active @endif" href="{{url('admin/users')}}" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Users</span></a>
                        </li>
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->