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
                          class="nav-item <?php echo e(Request::is('kelas/viia') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viib') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viic') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viid') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viie') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viif') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viig') ? 'menu-open' : ''); ?>

            <?php echo e(Request::is('kelas/viiia') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiib') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiic') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiid') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiie') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiif') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiig') ? 'menu-open' : ''); ?>

            <?php echo e(Request::is('kelas/ixa') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixb') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixc') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixd') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixe') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixf') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixg') ? 'menu-open' : ''); ?>">
                          <a href="#"
                              class="nav-link <?php echo e(Request::is('kelas/viia') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viib') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viic') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viid') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viie') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viif') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viig') ? 'active' : ''); ?>

                <?php echo e(Request::is('kelas/viiia') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viiib') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viiic') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viiid') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viiie') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viiif') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/viiig') ? 'active' : ''); ?>

                <?php echo e(Request::is('kelas/ixa') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/ixb') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/ixc') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/ixd') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/ixe') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/ixf') ? 'active' : ''); ?> <?php echo e(Request::is('kelas/ixg') ? 'active' : ''); ?>">
                              <i class="nav-icon fas fa-school"></i>
                              <p>
                                  Kelas
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li
                                  class="nav-item <?php echo e(Request::is('kelas/viia') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viib') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viic') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viid') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viie') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viif') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viig') ? 'menu-open' : ''); ?>">
                                  <a href="#" class="nav-link">
                                      <i class="nav-icon far fa-folder"></i>
                                      <p>
                                          VII
                                          <i class="fas fa-angle-left right"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viia"
                                              class="nav-link  <?php echo e(Request::is('kelas/viia') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas A</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viib"
                                              class="nav-link <?php echo e(Request::is('kelas/viib') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas B</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viic"
                                              class="nav-link <?php echo e(Request::is('kelas/viic') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas C</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viid"
                                              class="nav-link <?php echo e(Request::is('kelas/viid') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas D</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viie"
                                              class="nav-link <?php echo e(Request::is('kelas/viie') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas E</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viif"
                                              class="nav-link <?php echo e(Request::is('kelas/viif') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas F</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viig"
                                              class="nav-link <?php echo e(Request::is('kelas/viig') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas G</p>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li
                                  class="nav-item <?php echo e(Request::is('kelas/viiia') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiib') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiic') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiid') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiie') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiif') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/viiig') ? 'menu-open' : ''); ?>">
                                  <a href="#" class="nav-link">
                                      <i class="nav-icon far fa-folder"></i>
                                      <p>
                                          VIII
                                          <i class="fas fa-angle-left right"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiia"
                                              class="nav-link <?php echo e(Request::is('kelas/viiia') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas A</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiib"
                                              class="nav-link <?php echo e(Request::is('kelas/viiib') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas B</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiic"
                                              class="nav-link <?php echo e(Request::is('kelas/viiic') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas C</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiid"
                                              class="nav-link <?php echo e(Request::is('kelas/viiid') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas D</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiie"
                                              class="nav-link <?php echo e(Request::is('kelas/viiie') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas E</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiif"
                                              class="nav-link <?php echo e(Request::is('kelas/viiif') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas F</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/viiig"
                                              class="nav-link <?php echo e(Request::is('kelas/viiig') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas G</p>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li
                                  class="nav-item <?php echo e(Request::is('kelas/ixa') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixb') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixc') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixd') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixe') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixf') ? 'menu-open' : ''); ?> <?php echo e(Request::is('kelas/ixg') ? 'menu-open' : ''); ?>">
                                  <a href="#" class="nav-link">
                                      <i class="nav-icon far fa-folder"></i>
                                      <p>
                                          IX
                                          <i class="fas fa-angle-left right"></i>
                                      </p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixa"
                                              class="nav-link <?php echo e(Request::is('kelas/ixa') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas A</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixb"
                                              class="nav-link <?php echo e(Request::is('kelas/ixb') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas B</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixc"
                                              class="nav-link <?php echo e(Request::is('kelas/ixc') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas C</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixd"
                                              class="nav-link <?php echo e(Request::is('kelas/ixd') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas D</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixe"
                                              class="nav-link <?php echo e(Request::is('kelas/ixe') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas E</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixf"
                                              class="nav-link <?php echo e(Request::is('kelas/ixf') ? 'active' : ''); ?>">
                                              <i class="far fa-circle nav-icon"></i>
                                              <p>Kelas F</p>
                                          </a>
                                      </li>
                                  </ul>
                                  <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                          <a href="/kelas/ixg"
                                              class="nav-link <?php echo e(Request::is('kelas/ixg') ? 'active' : ''); ?>">
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
                      <li class="nav-header" style="color: #6c757d; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Lainnya</li>
                      <li class="nav-item">
                          <a href="/penandatangan" class="nav-link <?php echo e(Request::is('penandatangan') || Request::is('penandatangan/*') ? 'active' : ''); ?>">
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