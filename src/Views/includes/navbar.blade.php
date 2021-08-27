<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center  ml-md-auto ">
          <li class="nav-item d-xl-none">
            <!-- Sidenav toggler -->
            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </div>
          </li>

          
        </ul>
        <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="{{ asset('') }}{{Auth::guard('web')->user()->getFirstMediaUrl('users')}}">
                </span>
                <div class="media-body  ml-2  d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">{{ Auth::guard('web')->user()->name }}</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu  dropdown-menu-right ">
                <a href="{{ route('panel.admins.edit', ['id' => Auth::guard('web')->user()->id]) }}" class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>Mi perfil</span>
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('panel.admins.logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
</nav>
