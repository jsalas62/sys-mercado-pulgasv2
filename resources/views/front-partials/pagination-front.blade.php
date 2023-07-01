
<div class="pagination">
@if ($paginator->hasPages())
    <ul>
    @if ($paginator->onFirstPage())
        <li style="pointer-events: none;"><a href="#"><i class="fa fa-caret-left" style="color:#858796;"></i></a></li>
    @else 
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior"><i class="fa fa-caret-left"></i></a></li>
    @endif

    @foreach ($elements as $element)

        @if (is_string($element))
            <li style="pointer-events: none;"><a href="#">{{ $element }}</a></li>
        @endif

        @if (is_array($element))

            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active" style="pointer-events: none;"><a href="#">{{$page}}</a></li>
                @else 
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif 
            @endforeach

        @endif

    @endforeach

    @if ($paginator->hasMorePages())
        <li class="next"><a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
    @else 
        <li class="next" style="pointer-events: none;"><a href="#"><i class="fa fa-caret-right" style="color:#858796;"></i></a></li>        
    @endif


@endif

</div>