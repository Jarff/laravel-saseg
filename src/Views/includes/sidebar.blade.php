<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scrollbar-inner">
	<!-- Brand -->
	<div class="sidenav-header d-flex align-items-center">
		<a class="navbar-brand" href="javascript:void(0)">
			<img src="{{ asset('assets/images/logo.png') }}" class="navbar-brand-img" alt="...">
		</a>
		<div class=" ml-auto ">
			<!-- Sidenav toggler -->
			<div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
			  <div class="sidenav-toggler-inner">
				<i class="sidenav-toggler-line"></i>
				<i class="sidenav-toggler-line"></i>
				<i class="sidenav-toggler-line"></i>
			  </div>
			</div>
		</div>
	</div>
	<div class="navbar-inner">
		<!-- Collapse -->
		<div class="collapse navbar-collapse" id="sidenav-collapse-main">
			<!-- Nav items -->
			<ul class="navbar-nav">
				@can(PermissionKey::Apartado['permissions']['menu']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/apartados*')) ? 'active' : '' }}" href="{{ route('panel.apartados.index') }}">
							<i class="ni ni-single-copy-04 text-default"></i>
							<span class="nav-link-text">Apartados</span>
						</a>
					</li>
				@endcan
				<li class="nav-item">
					<a class="nav-link {{ (request()->is('admin/events/cursos*')) ? 'active' : '' }}" href="{{ route('panel.events.index', ['type' => 'cursos']) }}">
						<i class="ni ni-book-bookmark text-default"></i>
						<span class="nav-link-text">Cursos</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ (request()->is('admin/events/campamentos*')) ? 'active' : '' }}" href="{{ route('panel.events.index', ['type' => 'campamentos']) }}">
						<i class="ni ni-bus-front-12 text-default"></i>
						<span class="nav-link-text">Campamentos</span>
					</a>
				</li>
				@can(PermissionKey::Gallery['permissions']['menu']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/galeria*')) ? 'active' : '' }}" href="{{ route('panel.gallery.index') }}">
							<i class="ni ni-album-2 text-default"></i>
							<span class="nav-link-text">Galería</span>
						</a>
					</li>
				@endcan
				@can(PermissionKey::Admin['permissions']['show_sidebar']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/cuentas*')) ? 'active' : '' }}" href="#navbar-cuentas" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('admin/cuentas*')) ? 'true' : 'false' }}" aria-controls="navbar-cuentas">
							<i class="ni ni-single-02 text-default"></i>
							<span class="nav-link-text">Administración</span>
						</a>
						<div class="collapse {{ (request()->is('admin/cuentas*')) ? 'show' : '' }}" id="navbar-cuentas">
							<ul class="nav nav-sm flex-column">
								@can(PermissionKey::Admin['permissions']['index']['name'])
									<li class="nav-item">
										<a class="nav-link {{ (request()->is('admin/cuentas/usuarios*')) ? 'active' : '' }}" href="{{ route('panel.admins.index') }}">
											<span class="nav-link-text">Usuarios</span>
										</a>
									</li>
								@endcan
								@can(PermissionKey::Role['permissions']['index']['name'])
									<li class="nav-item">
										<a class="nav-link {{ (request()->is('admin/cuentas/roles*')) ? 'active' : '' }}" href="{{ route('panel.roles.index') }}">
											<span class="nav-link-text">Roles</span>
										</a>
									</li>
								@endcan
							</ul>
						</div>
					</li>
				@endcan
			</ul>
		</div>
	</div>
	</div>
</nav>