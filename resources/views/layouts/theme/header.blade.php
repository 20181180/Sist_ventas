<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">
        <ul class="navbar-item flex-row">
            <li class="nav-item theme-logo">
                <a href="index.html">
                    <img src="assets/img/icon.png" class="navbar-logo" alt="logo">
                    <span style="font-weight: bold;font-size: 18px;">MERIJOMECHATRONIC</span>
                </a>
            </li>
        </ul>

        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3" y2="6"></line>
                <line x1="3" y1="12" x2="3" y2="12"></line>
                <line x1="3" y1="18" x2="3" y2="18"></line>
            </svg></a>

        <livewire:search-controller>
            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset('storage/users/' . Auth::user()->image)}}" alt="admin-profile" class="img-fluid">
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
                        @guest
                        @if (Route::has('login'))

                        @endif
                        @else
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="{{asset('storage/users/' . Auth::user()->image)}}" class="img-fluid mr-2" alt="avatar">
                                <div class="media-body">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p>Perfil: {{ Auth::user()->profile }}</p>

                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{url('datos')}} ">
                                <i class="fas fa-user"></i>
                                <span>Perfil De Empresa</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Cerrar Sesion</span>
                            </a>
                            <form action="{{route('logout')}}" method="POST" id="logout-form">
                                @csrf
                            </form>
                        </div>
                        @endguest
                    </div>
                </li>
            </ul>
    </header>
</div>