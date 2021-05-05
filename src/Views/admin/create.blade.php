@extends('vendor.panel.layouts.app')
@section('content')
    <!-- Header -->
    @include('vendor.panel.includes.header')
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
				<div class="card">
				<!-- Card header -->
					<div class="card-header border-0">
                        {{-- <h3 class="mb-0">Nuevo usuario</h3> --}}
                        <h6 class="heading-small text-muted mb-4">Información del usuario</h6>
					</div>
                    <!-- Light table -->
                    <div class="card-body">
                        <form action="{{ route('panel.admins.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                            {{ csrf_field() }}
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="dropzone-avatar" class="form-control-label">Avatar</label>
                                            <input class="form-control unfocus" type="text" name="avatar" id="avatar" value="{{ old('avatar') }}" data-asset="{{ asset('') }}" required>
                                            <a href="#modal-media" data-dropzone="image" data-reference="dropzone-avatar" data-toggle="modal" data-target="#modal-media" class="btn btn-default float-right mt-1">Escoger del multimedia</a>
                                            <div id="dropzone-avatar" data-route="{{ route('images.store') }}" data-target="#avatar" class="dropzone" style="border:0px">
                                                <div class="dz-default dz-message">Seleccionar archivo</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="role">* Rol</label>
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="">Selecciona una opción</option>
                                                @if ((isset($roles)) && (count($roles) > 0))
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">sin contenido...</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">* Nombre</label>
                                            <input type="text" name="name" id="name" class="form-control" required autocomplete="off" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">* Email</label>
                                            <input type="email" id="email" name="email" class="form-control" required autocomplete="off" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="password">* Contraseña</label>
                                            <input type="password" name="password" id="password" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="confirm-password">* Confirmar contraseña</label>
                                            <input type="password" name="confirm_password" id="confirm-password" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button class="btn btn-default">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
        </div>
    </div>
    @include('vendor.panel.includes.media')
@endsection