<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$submenu->nome}}<span class="caret"></span></a>
    <ul class="dropdown-menu">
@foreach($submenu->submenu as $item)
    @if(isset($item->submenu))
    {!! View::make('layouts.submenu', ['submenu' => $item]) !!}
    @else
        <li><a href="{{url($item->acao)}}">{{$item->nome}}</a></li>
    @endif
@endforeach
    </ul>
</li>
