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
						{{-- <h3 class="mb-0">Light table</h3> --}}
					</div>
                    <!-- Light table -->
					<div class="table-responsive pb-3">
                        {{ $dataTable->table() }}
					</div>
				</div>
			</div>
        </div>
    </div>
@endsection
@push('js')
    {{ $dataTable->scripts() }}
@endpush