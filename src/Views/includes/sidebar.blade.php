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
			<!-- Administrador de archivos -->
			<h6 class="navbar-heading p-0 text-muted">
				<span class="docs-normal">Administrador de archivos</span>
			</h6>
			<hr class="my-2">
			<ul class="navbar-nav mb-5">
				@can(PermissionKey::Image['permissions']['show_sidebar']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/medias')) ? 'active' : '' }}" href="{{ route('panel.medias.index') }}">
							<i class="ni ni-archive-2 text-default"></i>
							<span class="nav-link-text">Biblioteca multimedia</span>
						</a>
					</li>
				@endcan
			</ul>

			<!-- Website -->
			<h6 class="navbar-heading p-0 text-muted">
				<span class="docs-normal">Website</span>
			</h6>
			<hr class="my-2">
			<ul class="navbar-nav mb-5">
				<li class="nav-item">
					<a class="nav-link {{ (request()->is('admin/noticias*')) ? 'active' : '' }}" href="{{ route('panel.noticias.index') }}">
						<i class="ni ni-books text-default"></i>
						<span class="nav-link-text">Noticias</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						<i class="ni ni-books text-default"></i>
						<span class="nav-link-text">Example link 2</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						<i class="ni ni-box-2 text-default"></i>
						<span class="nav-link-text">Example link 3</span>
					</a>
				</li>
			</ul>

			<!-- Panel -->
			<h6 class="navbar-heading p-0 text-muted">
				<span class="docs-normal">Administración</span>
			</h6>
			<hr class="my-2">
			<ul class="navbar-nav">
				@can(PermissionKey::Admin['permissions']['index']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/cuentas/usuarios*')) ? 'active' : '' }}" href="{{ route('panel.admins.index') }}">
							<i class="ni ni-single-02 text-default"></i>
							<span class="nav-link-text">Usuarios</span>
						</a>
					</li>
					@endcan
					@can(PermissionKey::Role['permissions']['index']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/cuentas/roles*')) ? 'active' : '' }}" href="{{ route('panel.roles.index') }}">
							<i class="ni ni-key-25 text-default"></i>
							<span class="nav-link-text">Roles</span>
						</a>
					</li>
				@endcan
				{{-- @can(PermissionKey::Setting['permissions']['show_sidebar']['name'])
					<li class="nav-item">
						<a class="nav-link {{ (request()->is('admin/medias')) ? 'active' : '' }}" href="{{ route('panel.medias.index') }}">
							<i class="ni ni-album-2 text-default"></i>
							<span class="nav-link-text">Biblioteca multimedia</span>
						</a>
					</li>
				@endcan --}}
			</ul>
		</div>
	</div>
	</div>
</nav>
