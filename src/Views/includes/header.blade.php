<div class="header bg-default pb-6">
    <div class="container-fluid">
        <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-12 col-12">
                <h6 class="h2 text-white d-inline-block mb-0">{{ $title }}</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        @if ((isset($breadcrumb)) && (count($breadcrumb) > 0))
                            @foreach ($breadcrumb as $b)
                                @if (isset($b['disabled']))
                                    @if (!$b['disabled'])
                                        <li class="breadcrumb-item {{ ((isset($b['active'])) && ($b['active'])) ? 'active' : '' }}">
                                            @if (isset($b['params']))
                                                <a href="{{ (isset($b['route'])) ? route($b['route'], $b['params']) : '' }}">{{ $b['title'] }}</a>
                                            @else
                                                <a href="{{ (isset($b['route'])) ? route($b['route']) : '' }}">{{ $b['title'] }}</a>
                                            @endif
                                        </li>
                                    @endif
                                @else
                                    <li class="breadcrumb-item {{ ((isset($b['active'])) && ($b['active'])) ? 'active' : '' }}">
                                        @if (isset($b['params']))
                                            @if (isset($b['route']))
                                                <a href="{{ (isset($b['route'])) ? route($b['route'], $b['params']) : '' }}">{{ $b['title'] }}</a>
                                            @else
                                                {{ $b['title'] }}
                                            @endif
                                        @else
                                            @if (isset($b['route']))
                                                <a href="{{ (isset($b['route'])) ? route($b['route']) : '' }}">{{ $b['title'] }}</a>
                                            @else
                                                {{ $b['title'] }}
                                            @endif
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="col-lg-12 col-12">
                @if ((isset($buttons)) && (count($buttons) > 0))
                    @foreach ($buttons as $item)    
                        @if (isset($item['params']))
                            <a href="{{ route($item['route'], $b['params']) }}" class="btn btn-lg btn-secondary">{{ $item['title'] }}</a>    
                        @else
                            <a href="{{ route($item['route']) }}" class="btn btn-lg btn-secondary"><i class="ni ni-fat-add"></i> {{ $item['title'] }}</a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text"><strong>Correcto!</strong> {{ session('success') }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $k => $error)
                <div class="alert alert-danger" role="alert">
                    <strong>Ups!</strong> {{ $error }}
                </div>
            @endforeach
        @endif
    </div>
</div>