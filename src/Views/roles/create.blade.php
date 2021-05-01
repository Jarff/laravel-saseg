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
                        <h6 class="heading-small text-muted mb-4">Información</h6>
					</div>
                    <!-- Light table -->
                    <div class="card-body">
                        <form action="{{ route('panel.roles.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                            {{ csrf_field() }}
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">* Nombre</label>
                                            <input type="text" name="name" id="name" class="form-control" required autocomplete="off" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-4">
                                    @if ((isset($modulos)) && (count($modulos) > 0))
                                        @foreach ($modulos as $modulo)
                                            <div class="col-lg-4">
                                                <h3>{{ $modulo['name'] }}</h3>
                                                @if ((isset($modulo['permissions']) && (count($modulo['permissions']) > 0)))
                                                    @foreach ($modulo['permissions'] as $permission)
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="{{ $permission['name'] }}" name="permission[{{ $permission['name'] }}]" checked value="true">
                                                            <label class="custom-control-label" for="{{ $permission['name'] }}">{{ $permission['display_name'] }}</label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                        
                                    @endif
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