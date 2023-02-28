
@foreach($items as $item)
  <li @lm_attrs($item)  class="nav-item"  @lm_endattrs>
    @if($item->link) <a class="nav-link @if($item->url()==url()->current()) active @endif" @lm_attrs($item->link) @lm_endattrs href="{!! $item->url() !!}">
     <p> {!! $item->title !!}
     @if($item->hasChildren())
     <i class="fas fa-angle-left right"></i>
     @endif   
      </p>
    </a>
    @else
      <p >{!! $item->title !!}</p>
    @endif
    @if($item->hasChildren())
      <ul class="nav nav-treeview">
        @include(config('laravel-menu.views.leftnav-items'),
array('items' => $item->children()))
      </ul>
    @endif
  </li>
  @if($item->divider)
  	<li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
  @endif
@endforeach
