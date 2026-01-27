          <div class="sidebar">
              <!-- Sidebar user panel -->
              <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column">
                  <div class="d-flex align-items-center" style="cursor: pointer;" onclick="toggleUserDropdown()">
                      <div class="image">
                          <img src="<?php echo e(asset('AdminLTE-3.2.0/dist/img/avatar02.png')); ?>" class="img-circle elevation-2"
                              alt="User Image" style="width: 40px; height: 40px;">
                      </div>
                      <div class="ml-2 text-white font-weight-bold">
                          <?php echo e(Auth::user()->name); ?>

                      </div>
                  </div>
                  <!-- Custom dropdown -->
                  <div id="user-dropdown-menu" class="mt-2 bg-dark rounded shadow-sm d-none" style="padding: 10px;">
                      <!-- Profile Link -->
                      <a href="#" data-toggle="modal" data-target="#profileModal"
                          class="d-flex align-items-center bg-secondary text-white mb-2 p-2 rounded">
                          <i class="fas fa-user-cog mr-2"></i> <span>Profile</span>
                      </a>
                      <!-- Logout Button Styled Like Profile -->
                      <form method="POST" action="<?php echo e(route('logout')); ?>">
                          <?php echo csrf_field(); ?>
                          <button type="submit"
                              class="d-flex align-items-center w-100 text-danger border-0 p-2 rounded"
                              style="text-align: left;">
                              <i class="fas fa-sign-out-alt mr-2"></i> <span>Logout</span>
                          </button>
                      </form>
                  </div>
              </div>

              <!-- SidebarSearch Form -->
              <div class="form-inline">
                  <div class="input-group" data-widget="sidebar-search">
                      <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                          aria-label="Search">
                      <div class="input-group-append">
                          <button class="btn btn-sidebar">
                              <i class="fas fa-search fa-fw"></i>
                          </button>
                      </div>
                  </div>
              </div>

              <!-- Sidebar Menu -->
              <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                      data-accordion="false">
                      <li class="nav-item">
                          <a href="/dashboard" class="nav-link <?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-home"></i>
                              <p>
                                  Beranda
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="/siswa" class="nav-link <?php echo e(Request::is('siswa') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-users"></i>
                              <p>
                                  Siswa
                              </p>
                          </a>
                      </li>
                      <li
                          class="nav-item <?php echo e(Request::is('bukutahunan') ? 'menu-open' : ''); ?> <?php echo e(Request::is('bukuharian') ? 'menu-open' : ''); ?>">
                          <a href="#"
                              class="nav-link <?php echo e(Request::is('bukutahunan') ? 'active' : ''); ?> <?php echo e(Request::is('bukuharian') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-book"></i>
                              <p>
                                  Buku
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/bukuharian"
                                      class="nav-link <?php echo e(Request::is('bukuharian') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Buku Harian</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/bukutahunan"
                                      class="nav-link <?php echo e(Request::is('bukutahunan') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Buku Tahunan</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      
                      <li
                          class="nav-item <?php echo e(Request::is('peminjamanharian') ? 'menu-open' : ''); ?> <?php echo e(Request::is('pengembalianharian') ? 'menu-open' : ''); ?>">
                          <a href="#"
                              class="nav-link <?php echo e(Request::is('peminjamanharian') ? 'active' : ''); ?> <?php echo e(Request::is('pengembalianharian') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-table"></i>
                              <p>
                                  Data Harian
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/peminjamanharian"
                                      class="nav-link <?php echo e(Request::is('peminjamanharian') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Data Peminjaman</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/pengembalianharian"
                                      class="nav-link <?php echo e(Request::is('pengembalianharian') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Data Pengembalian</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li
                          class="nav-item <?php echo e(Request::is('peminjamantahunan') ? 'menu-open' : ''); ?> <?php echo e(Request::is('pengembaliantahunan') ? 'menu-open' : ''); ?>">
                          <a href="#"
                              class="nav-link <?php echo e(Request::is('peminjamantahunan') ? 'active' : ''); ?> <?php echo e(Request::is('pengembaliantahunan') ? 'active' : ''); ?>">
                              <i class="nav-icon far fa-calendar"></i>
                              <p>
                                  Data Tahunan
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/peminjamantahunan"
                                      class="nav-link <?php echo e(Request::is('peminjamantahunan') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Data Peminjaman</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/pengembaliantahunan"
                                      class="nav-link <?php echo e(Request::is('pengembaliantahunan') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Data Pengembalian</p>
                                  </a>
                              </li>
                          </ul>
                      <li
                          class="nav-item <?php echo e(Request::is('kelas/7a') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7b') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7c') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7d') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7e') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7f') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7g') ? 'menu-open' : ''); ?>

            <?php echo e(Request::is('kelas/7ia') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ib') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ic') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7id') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ie') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7if') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ig') ? 'menu-open' : ''); ?>

            <?php echo e(Request::is('kelas/9a') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9b') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9c') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9d') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9e') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9f') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9g') ? 'menu-open' : ''); ?>">
                          <a href="#"
                              class="nav-link <?php echo e(Request::is('kelas/7a') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7b') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7c') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7d') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7e') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7f') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7g') ? 'active' : ''); ?>

                <?php echo e(Request::is('kelas/7ia') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7ib') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7ic') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7id') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7ie') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7if') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/7ig') ? 'active' : ''); ?>

                <?php echo e(Request::is('kelas/9a') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/9b') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/9c') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/9d') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/9e') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/9f') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/9g') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-school"></i>
                              <p>
                                  Kelas
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li
                                  class="nav-item <?php echo e(Request::is('kelas/7a') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7b') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7c') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7d') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7e') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7f') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7g') ? 'menu-open' : ''); ?>">
                                  <a href="#" class="nav-link">
                                      <i class="nav-icon far fa-folder"></i>
                                      <p>
                                          VII / 7
                                          <i class="fas fa-angle-left right"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7a"
                                              class="nav-link  <?php echo e(Request::is('kelas/7a') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas A</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7b"
                                              class="nav-link <?php echo e(Request::is('kelas/7b') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas B</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7c"
                                              class="nav-link <?php echo e(Request::is('kelas/7c') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas C</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7d"
                                              class="nav-link <?php echo e(Request::is('kelas/7d') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas D</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7e"
                                              class="nav-link <?php echo e(Request::is('kelas/7e') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas E</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7f"
                                              class="nav-link <?php echo e(Request::is('kelas/7f') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas F</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/7g"
                                              class="nav-link <?php echo e(Request::is('kelas/7g') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas G</p>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li
                                  class="nav-item <?php echo e(Request::is('kelas/7ia') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ib') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ic') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7id') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ie') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7if') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/7ig') ? 'menu-open' : ''); ?>">
                                  <a href="#" class="nav-link">
                                      <i class="nav-icon far fa-folder"></i>
                                      <p>
                                          VIII / 8
                                          <i class="fas fa-angle-left right"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8a"
                                              class="nav-link <?php echo e(Request::is('kelas/7ia') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas A</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8b"
                                              class="nav-link <?php echo e(Request::is('kelas/7ib') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas B</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8c"
                                              class="nav-link <?php echo e(Request::is('kelas/7ic') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas C</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8d"
                                              class="nav-link <?php echo e(Request::is('kelas/7id') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas D</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8e"
                                              class="nav-link <?php echo e(Request::is('kelas/7ie') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas E</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8f"
                                              class="nav-link <?php echo e(Request::is('kelas/7if') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas F</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/8g"
                                              class="nav-link <?php echo e(Request::is('kelas/7ig') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas G</p>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li
                                  class="nav-item <?php echo e(Request::is('kelas/9a') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9b') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9c') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9d') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9e') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9f') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/9g') ? 'menu-open' : ''); ?>">
                                  <a href="#" class="nav-link">
                                      <i class="nav-icon far fa-folder"></i>
                                      <p>
                                          IX / 9
                                          <i class="fas fa-angle-left right"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9a"
                                              class="nav-link <?php echo e(Request::is('kelas/9a') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas A</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9b"
                                              class="nav-link <?php echo e(Request::is('kelas/9b') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas B</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9c"
                                              class="nav-link <?php echo e(Request::is('kelas/9c') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas C</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9d"
                                              class="nav-link <?php echo e(Request::is('kelas/9d') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas D</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9e"
                                              class="nav-link <?php echo e(Request::is('kelas/9e') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas E</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9f"
                                              class="nav-link <?php echo e(Request::is('kelas/9f') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas F</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/9g"
                                              class="nav-link <?php echo e(Request::is('kelas/9g') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas G</p>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                      </li>
                      <li
                          class="nav-item <?php echo e(Request::is('catatanharian') ? 'menu-open' : ''); ?> <?php echo e(Request::is('catatantahunan') ? 'menu-open' : ''); ?>">
                          <a href="#"
                              class="nav-link  <?php echo e(Request::is('catatanharian') ? 'active' : ''); ?> <?php echo e(Request::is('catatantahunan') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-pencil-alt"></i>
                              <p>
                                  Catatan Denda
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/catatanharian"
                                      class="nav-link <?php echo e(Request::is('catatanharian') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Harian</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="/catatantahunan"
                                      class="nav-link <?php echo e(Request::is('catatantahunan') ? 'active' : ''); ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Tahunan</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li class="nav-header"
                          style="color: #6c757d; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                          Lainnya</li>
                      <li class="nav-item">
                          <a href="<?php echo e(route('periode.index')); ?>"
                              class="nav-link <?php echo e(Request::is('periode*') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-calendar-alt"></i>
                              <p>
                                  Periode Tahun Ajaran
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="/penandatangan"
                              class="nav-link <?php echo e(Request::is('penandatangan') || Request::is('penandatangan/*') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-user-tie"></i>
                              <p>
                                  Penandatangan
                              </p>
                          </a>
                      </li>
                  </ul>
              </nav>
              <!-- /.sidebar-menu -->
          </div>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>