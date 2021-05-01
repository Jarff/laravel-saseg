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
                        <h6 class="heading-small text-muted mb-4">Actualizar contraseña</h6>
					</div>
                    <!-- Light table -->
                    <div class="card-body">
                        <form action="{{ route('panel.admins.update.password', ['id' => $user->id]) }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="password">* Nueva Contraseña</label>
                                            <input type="password" name="new_password" id="password" class="form-control" required autocomplete="off">
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
@endsection