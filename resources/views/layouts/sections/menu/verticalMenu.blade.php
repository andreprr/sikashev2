<!-- Sidebar Start -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="/" class="text-nowrap logo-img my-2 text-center">
        <img class="bg-primary rounded w-50" src="{{ asset('images/logos/logo-app.png') }}" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        @foreach ($menuData[0]->menu as $menu)
        @php
          $permission = (isset($menu->permission) && !empty($menu->permission)) ? (array)$menu->permission : [];
        @endphp
        
        @can($permission)
    {{-- adding active and open class if child is active --}}

    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">{{ $menu->menuHeader }}</span>
            </li>
    @else

    {{-- active menu method --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'selected';
    }
    elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'selected open';
    }
    }
    }
    else{
    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'selected open';
    }
    }

    }
    @endphp

    {{-- main menu --}}
    <li class="sidebar-item {{$activeClass}}">      
        @if(isset($menu->url)) 
            <a href="{{ url($menu->url) }}" class="sidebar-link">
          @else
            <a href="javascript:void(0)" class="{{ isset($menu->submenu) ? 'sidebar-link has-arrow' : 'sidebar-link' }}" aria-expanded="false"
            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif
            >
          @endif
          <span>
              <i class="{{ $menu->icon }}"></i>
            </span>
            <span class="hide-menu">{{ isset($menu->name) ? __($menu->name) : '' }}</span>
          </a>
          {{-- submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
      @endisset
        </li>
    </li>
    @endif
    @endcan($permission)
    @endforeach

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->