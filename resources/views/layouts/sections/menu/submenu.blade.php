<ul aria-expanded="false" class="collapse first-level">
  @if (isset($menu))
  @foreach ($menu as $submenu)
  @php
    $permissionsub = (isset($submenu->permission) && !empty($submenu->permission)) ? (array)$submenu->permission : [];
  @endphp
  
  @can($permissionsub)

  {{-- active menu method --}}
  @php
  $activeClass = null;
  $active = 'active open';
  $currentRouteName = Route::currentRouteName();

  if ($currentRouteName === $submenu->slug) {
  $activeClass = 'active';
  }
  elseif (isset($submenu->submenu)) {
  if (gettype($submenu->slug) === 'array') {
  foreach($submenu->slug as $slug){
  if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
  $activeClass = $active;
  }
  }
  }
  else{
  if (str_contains($currentRouteName,$submenu->slug) and strpos($currentRouteName,$submenu->slug) === 0) {
  $activeClass = $active;
  }
  }
  }
  @endphp

  <li class="sidebar-item {{$activeClass}}">
    <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}" class="{{ isset($submenu->submenu) ? 'sidebar-link active' : 'sidebar-link' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
    <div class="round-16 d-flex align-items-center justify-content-center">
              <i class="ti ti-circle"></i>
            </div>  
    @if (isset($submenu->icon))
      <span>
              <i class="{{ $menu->icon }}"></i>
            </span>
      
            @endif
            <span class="hide-menu">{{ isset($submenu->name) ? __($submenu->name) : '' }}</span>
    </a>

    {{-- submenu --}}
    @if (isset($submenu->submenu))
    @include('layouts.sections.menu.submenu',['menu' => $submenu->submenu])
    @endif
  </li>
  @endcan
  @endforeach
  @endif
</ul>
