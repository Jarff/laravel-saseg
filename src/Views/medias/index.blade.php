@extends('vendor.panel.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush
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
					<div style="min-height: 600px;height:auto">
                        <div id="fm"></div>
                    </div>
				</div>
			</div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', e => {
            document.querySelector('[title="About"]').classList.add('d-none');
        })
    </script>
@endpush