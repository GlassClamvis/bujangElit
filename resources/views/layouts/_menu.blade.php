  <!--- Menu -->
  <ul class="menu">
      <li class="menu-title">Home</li>

      <li class="menu-item">
          <a href="{{ url('/') }}" class="menu-link">
              <span class="menu-icon">
                  <i class="fe-anchor"></i>
              </span>
              <span class="menu-text"> Landing </span>
          </a>
      </li>
      <li class="menu-item">
          <a href="{{ route('welcome') }}" class="menu-link">
              <span class="menu-icon">
                  <i class="fe-airplay"></i>
              </span>
              <span class="menu-text"> Dashboard </span>
          </a>
      </li>
      @can('permission-list')
          <li class="menu-item">
              <a href="{{ route('permission.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="material-symbols-outlined" style="font-size: 20px;">rule</i>
                  </span>
                  <span class="menu-text"> Permission </span>
              </a>
          </li>
      @endcan

      @can('role-list')
          <li class="menu-item">
              <a href="{{ route('roles.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="material-symbols-outlined" style="font-size: 20px;">rule_folder</i>
                  </span>
                  <span class="menu-text"> Role </span>
              </a>
          </li>
      @endcan

      @can('menu-list')
          <li class="menu-item">
              <a href="{{ route('menu.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="material-symbols-outlined" style="font-size: 20px;">menu</i>
                  </span>
                  <span class="menu-text"> Menu </span>
              </a>
          </li>
      @endcan

      @can('jenisMedia-list')
          <li class="menu-item">
              <a href="{{ route('jenisMedia.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="fe-disc"></i>
                  </span>
                  <span class="menu-text"> Jenis Media </span>
              </a>
          </li>
      @endcan

      @can('unit-list')
          <li class="menu-item">
              <a href="{{ route('unit.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="fe-command"></i>
                  </span>
                  <span class="menu-text"> Unit </span>
              </a>
          </li>
      @endcan

      @can('user-list')
          <li class="menu-item">
              <a href="{{ route('pengguna.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="fe-user"></i>
                  </span>
                  <span class="menu-text"> Pengguna </span>
              </a>
          </li>
      @endcan

      @can('kategori-list')
          <li class="menu-item">
              <a href="{{ route('kategori.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="mdi mdi-label-variant-outline me-1"></i>

                  </span>
                  <span class="menu-text"> Kategori </span>
              </a>
          </li>
      @endcan

      @can('penerbit-list')
          <li class="menu-item">
              <a href="{{ route('penerbit.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="mdi mdi-book-open-page-variant"></i>
                  </span>
                  <span class="menu-text"> Penerbit </span>
              </a>
          </li>
      @endcan

      @can('buku-list')
          <li class="menu-item">
              <a href="{{ route('buku.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="fe-book"></i>
                  </span>
                  <span class="menu-text"> Buku </span>
              </a>
          </li>
      @endcan

      @can('jurnal-list')
          <li class="menu-item">
              <a href="{{ route('jurnal.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="mdi mdi-book"></i>
                  </span>
                  <span class="menu-text"> Jurnal </span>
              </a>
          </li>
      @endcan

      @can('berita-list')
          <li class="menu-item">
              <a href="{{ route('berita.index') }}" class="menu-link">
                  <span class="menu-icon">
                      <i class="mdi mdi-newspaper"></i>
                  </span>
                  <span class="menu-text"> berita </span>
              </a>
          </li>
      @endcan
  </ul>
  <!--- End Menu -->
