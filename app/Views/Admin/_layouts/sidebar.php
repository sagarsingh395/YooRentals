<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <?php
        $request = \Config\Services::request();
        $uri = $request->getUri();
        $segment1 = $uri->getSegment(1);
        $segment2 = $uri->getSegment(2);
        if ($segment1 == 'authentication-failed') {
            helper('custom');
        }

        // $adminmodel = model('App\Models\Admin_model', false);
        // echo "Group ID: " . session('group_id') . " | Status: " . is_privilege(1);
        ?>

        <?php if (is_privilege(1) || is_privilege(2) || is_privilege(3)) :
            $collapsed = 'collapsed';
            $show = '';
            if (in_array($segment2, ['users', 'user-group', 'members', 'active-members', 'inactive-members'])) {
                $collapsed = '';
                $show = 'show';
            }
        ?>
            <li class="nav-item">
                <a class="nav-link <?= $collapsed ?>" data-bs-toggle="collapse" href="#auth"
                    aria-expanded="<?= ($show == 'show') ? 'true' : 'false' ?>" aria-controls="auth">
                    <span class="menu-title">Authentication</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-lock menu-icon"></i>
                </a>

                <div class="collapse <?= $show ?>" id="auth">
                    <ul class="nav flex-column sub-menu">

                        <?php if (is_privilege(2)) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment2 == 'user-group') ? 'active' : '' ?>"
                                    href="<?= base_url('admin/user-group') ?>"> User Group</a>
                            </li>
                        <?php endif; ?>

                        <?php if (is_privilege(1)) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment2 == 'users') ? 'active' : '' ?>"
                                    href="<?= base_url('admin/users') ?>">Users List</a>
                            </li>
                        <?php endif; ?>

                        <?php if (is_privilege(3)) : ?>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#memberSubMenu" aria-expanded="false">
                                    Member List <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="memberSubMenu">
                                    <ul class="nav flex-column ms-3">
                                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/members') ?>">All
                                                Members</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="<?= base_url('admin/active-members') ?>">Active Members</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="<?= base_url('admin/inactive-members') ?>">Inactive Members</a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/logout') ?>"
                                onclick="return confirm('Are You Sure?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
        <?php if (is_privilege(6)) : ?>
            <li class="nav-item">
                <a class="nav-link <?= ($segment2 == 'setting') ? 'active' : '' ?>" href="<?= base_url('admin/setting') ?>">
                    <span class="menu-title">Settings</span>
                    <i class="mdi mdi-file-document-box menu-icon"></i>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</nav>