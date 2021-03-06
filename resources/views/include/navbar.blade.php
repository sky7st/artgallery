<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'ArtGallery') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="{{route('pages.work.index')}}" class="nav-link">Works</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pages.artist.index')}}" class="nav-link">Artists</a>
                </li>
                
                @auth
                    <li>
                        @role('artist')
                            <a href="{{ "/artist/".auth()->user()->artist()->first()->id }}" class="nav-link">My Page</a>
                        @else

                        @endrole
                    </li>
                    @if(Gate::check('view self enquiry') || Gate::check('view all enquiry'))
                        <li>
                            <a href="{{ route('pages.enquiry.index') }}" class="nav-link">
                                @role('customer')
                                    My Enquiry
                                @else
                                    All Enquiry
                                @endrole
                            </a>
                        </li>
                    @endif
                    @role('saler|admin')
                        <li class="nav-item">
                            <a href="{{route('pages.report.self_sold')}}" class="nav-link">My Sold</a>
                        </li>
                    @endrole
                    @role('admin')
                        <li class="nav-item">
                            <a href="{{route('pages.report.saler_index')}}" class="nav-link">Salers Report</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pages.report.customer_index')}}" class="nav-link">All Customers</a>
                        </li>
                    @endrole
                @endauth
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">About</a>
                </li> --}}
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto navbar-right">
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else
                    {{-- <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
                    <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Role</a></li>
                    <li><a class="nav-link" href="{{ route('products.index') }}">Manage Product</a></li> --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>


                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                
            </ul>
        </div>
    </div>
</nav> 
