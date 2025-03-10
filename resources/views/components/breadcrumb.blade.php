<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-custom-icon">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
            <i class="breadcrumb-icon icon-base bx bx-chevron-right align-middle"></i>
        </li>

        @foreach ($breadcrumbs as $breadcrumb)
        @if (!$loop->last)
        <li class="breadcrumb-item">
            <a href="{{ route($breadcrumb['route']) }}">{{ $breadcrumb['label'] }}</a>
            <i class="breadcrumb-icon icon-base bx bx-chevron-right align-middle"></i>
        </li>
        @else
        <li class="breadcrumb-item active">{{ $breadcrumb['label'] }}</li>
        @endif
        @endforeach
    </ol>
</nav>