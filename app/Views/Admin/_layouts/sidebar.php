<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <?php
        $request = \Config\Services::request();
        $uri = $request->getUri();
        $segment1 = $uri->getSegment(1);
        $segment2 = $uri->getSegment(2);

        if ($segment1 == 'authentication-failed') {
            helper('custom');
        }
        ?>

        <?php if (is_privilege(1) || is_privilege(2) || is_privilege(6) || is_privilege(7)) : ?>
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <!-- Services -->
            <?php
            $serviceOpen = in_array($segment2, ['service', 'room-service']) ? 'show' : '';
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $serviceOpen ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#service">
                    <span class="menu-title">Services</span>
                    <i class="menu-arrow"></i>
                    <i class="fa fa-institution menu-icon"></i>
                </a>
                <div class="collapse <?= $serviceOpen ?>" id="service">
                    <ul class="nav flex-column sub-menu">
                        <?php if (is_privilege(7)) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment2 == 'service') ? 'active' : '' ?>"
                                    href="<?= base_url('admin/service') ?>">
                                    Service List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment2 == 'room-service') ? 'active' : '' ?>"
                                    href="<?= base_url('admin/room-service') ?>">
                                    Room List
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
            <!-- Authentication -->
            <?php
            $authOpen = in_array($segment2, ['users', 'user-group']) ? 'show' : '';
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $authOpen ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#auth">
                    <span class="menu-title">Authentication</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-lock menu-icon"></i>
                </a>
                <div class="collapse <?= $authOpen ?>" id="auth">
                    <ul class="nav flex-column sub-menu">

                        <?php if (is_privilege(2)) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment2 == 'user-group') ? 'active' : '' ?>"
                                    href="<?= base_url('admin/user-group') ?>">
                                    User Group
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (is_privilege(1)) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment2 == 'users') ? 'active' : '' ?>"
                                    href="<?= base_url('admin/users') ?>">
                                    Users List
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/logout') ?>"
                                onclick="return confirm('Are You Sure?')">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        <?php endif; ?>

        <!-- Settings -->
        <?php if (is_privilege(6)) : ?>
            <li class="nav-item">
                <a class="nav-link <?= ($segment2 == 'setting') ? 'active' : '' ?>" href="<?= base_url('admin/setting') ?>">
                    <span class="menu-title">Settings</span>
                    <i class="fa fa-cog menu-icon"></i>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</nav>