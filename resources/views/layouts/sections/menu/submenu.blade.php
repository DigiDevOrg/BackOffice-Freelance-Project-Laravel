<ul class="menu-sub">
  @if (isset($menu))
      @foreach ($menu as $submenu)
          {{-- active menu method --}}
          @php
              $activeClass = null;
              $active = 'active open';
              $currentRouteName = Route::currentRouteName();

              if ($currentRouteName === $submenu->slug) {
                  $activeClass = 'active';
              } elseif (isset($submenu->submenu)) {
                  if (gettype($submenu->slug) === 'array') {
                      foreach ($submenu->slug as $slug) {
                          if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                              $activeClass = $active;
                          }
                      }
                  } else {
                      if (str_contains($currentRouteName, $submenu->slug) and strpos($currentRouteName, $submenu->slug) === 0) {
                          $activeClass = $active;
                      }
                  }
              }
          @endphp

          @if ($submenu->name === 'Selling Categories' && Auth::user()->name === 'Admin')
              <li class="menu-item {{ $activeClass }}">
                  <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0);' }}"
                      class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                      @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                      @isset($submenu->icon)
                          <i class="{{ $submenu->icon }}"></i>
                      @endisset
                      <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                  </a>

                  {{-- submenu --}}
                  @isset($submenu->submenu)
                      @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                  @endisset
              </li>
          @elseif ($submenu->name !== 'Selling Categories')
              <li class="menu-item {{ $activeClass }}">
                  <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0);' }}"
                      class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                      @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                      @isset($submenu->icon)
                          <i class="{{ $submenu->icon }}"></i>
                      @endisset
                      <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                  </a>

                  {{-- submenu --}}
                  @isset($submenu->submenu)
                      @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                  @endisset
              </li>
          @endif
      @endforeach
  @endif
</ul>
