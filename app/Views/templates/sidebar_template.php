<div class="sb-sidenav-menu">
    <!-- <?php
            // foreach ($menus as $menu) : 
            ?>
            <div class="sb-sidenav-menu-heading"><?php
                                                    // $menu['menu']; 
                                                    ?></div>
            <?php
            // $subMenus = $db->table('submenu_user')->where('id_menu', $menu['id'])->get()->getResultArray() 
            ?>
            <?php
            // foreach ($subMenus as $subMenu) : 
            ?>
                <a class="nav-link" href="<?php
                                            // $subMenu['url']; 
                                            ?>">
                    <div class="sb-nav-link-icon"><i class="<?php
                                                            //  $subMenu['icon']; 
                                                            ?>"></i></div>
                    <?php
                    //  $subMenu['sub_menu']; 
                    ?>
                </a>
            <?php
            // endforeach 
            ?>
        <?php
        // endforeach; 
        ?> -->
    <div class="nav">
        <div class="sb-sidenav-menu-heading">Dasboard</div>
        <a class="nav-link  <?= ($title == 'YM | Dashboard') ? 'active' : ''; ?>" href="/home">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div>
            Dasboard
        </a>
        <?php if (session()->get('role') === 'staff program') : ?>
            <div class="sb-sidenav-menu-heading">Master</div>

            <a class="nav-link <?= ($title == 'YM  | Data Staff') ? 'active' : ''; ?>" href="/admin/staff">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie">></i></div>
                Data Staff
            </a>
            <a class="nav-link  <?= ($title == 'YM  | Data guru') ? 'active' : ''; ?>" href="/admin/guru">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div>
                Data guru
            </a>
            <a class="nav-link <?= ($title == 'YM  | Data Siswa') ? 'active' : ''; ?>" href="/admin/siswa">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div>
                Data siswa
            </a>
            <a class="nav-link collapsed <?= ($title == 'YM  | Data level' || $title == 'YM  | Data Kegiatan' || $title == 'YM  | Data Sanggar') ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#masterDataLainnya" aria-expanded="false" aria-controls="masterDataLainnya">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Lainnya
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?= ($title == 'YM  | Data level' || $title == 'YM  | Data Kegiatan' || $title == 'YM  | Data Sanggar') ? 'show' : ''; ?>" id="masterDataLainnya" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link <?= ($title == 'YM  | Data Kegiatan') ? 'active' : ''; ?>" href="/admin/kegiatan">Data Kegiatan</a>
                    <a class="nav-link <?= ($title == 'YM  | Data Level') ? 'active' : ''; ?>" href="/admin/level">Data Level</a>
                    <a class="nav-link <?= ($title == 'YM  | Data Sanggar') ? 'active' : ''; ?>" href="/admin/sanggar">Data Sanggar</a>
                </nav>
            </div>

        <?php endif ?>
        <div class="sb-sidenav-menu-heading">Aktifitas</div>
        <?php if (session()->get('role') === 'guru') : ?>
            <a class="nav-link collapsed <?= ($title == 'YM | Kegiatan' || $title == 'YM | Laporan Kegiatan') ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Kegiatan
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?= ($title == 'YM | Kegiatan' || $title == 'YM | Laporan Kegiatan') ? 'show' : ''; ?>" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link <?= ($title == 'YM | Laporan Kegiatan') ? 'active' : ''; ?>" href="/kegiatan/laporan">Laporan Kegiatan</a>
                    <a class="nav-link <?= ($title == 'YM | Kegiatan') ? 'active' : ''; ?>" href="/kegiatan">Peserta</a>
                </nav>
            </div>
        <?php endif ?>
        <?php if (session()->get('role') === 'staff program') : ?>
            <a class="nav-link collapsed <?= ($title == 'YM | Laporan Kehadiran' || $title == 'YM | Laporan Kegiatan') ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="false" aria-controls="laporan">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Laporan
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?= ($title == 'YM | Laporan Kehadiran' || $title == 'YM | Laporan Kegiatan') ? 'show' : ''; ?>" id="laporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link <?= ($title == 'YM | Laporan Kehadiran') ? 'active' : ''; ?>" href="/kehadiran/">Laporan Kehadiran</a>
                    <a class="nav-link <?= ($title == 'YM | Laporan Kegiatan') ? 'active' : ''; ?>" href="/kegiatan/laporan">Laporan Kegiatan</a>
                </nav>
            </div>
        <?php endif ?>
        <?php if (session()->get('role') === 'guru') : ?>
            <a class="nav-link collapsed <?= ($title == 'YM  | Konfirmasi Kehadiran' || $title == 'YM  | Kehadiran') ? 'active' : ''; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#kehadiran" aria-expanded="false" aria-controls="kehadiran">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Kehadiran
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?= ($title == 'YM  | Konfirmasi Kehadiran' || $title == 'YM  | Kehadiran') ? 'show' : ''; ?>" id="kehadiran" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link <?= ($title == 'YM  | Konfirmasi Kehadiran') ? 'active' : ''; ?>" href="/kehadiran/konfirmasi_kehadiran">Konfirmasi Kehadiran</a>
                    <a class="nav-link <?= ($title == 'YM  | Kehadiran') ? 'active' : ''; ?>" href="/kehadiran">kehadiran</a>
                </nav>
            </div>
        <?php endif ?>
        <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
            Kehadiran
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                    Authentication
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="login.html">Login</a>
                        <a class="nav-link" href="register.html">Register</a>
                        <a class="nav-link" href="password.html">Forgot Password</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                    Error
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="401.html">401 Page</a>
                        <a class="nav-link" href="404.html">404 Page</a>
                        <a class="nav-link" href="500.html">500 Page</a>
                    </nav>
                </div>
            </nav>
        </div> -->
        <!-- <div class="sb-sidenav-menu-heading">Addons</div>
        <a class="nav-link" href="charts.html">
            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Charts
        </a>
        <a class="nav-link" href="tables.html">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Tables
        </a> -->
    </div>
</div>
<!-- <div class="sb-sidenav-footer">
    <div class="small">Logged in as:</div>
    Start Bootstrap
</div> -->