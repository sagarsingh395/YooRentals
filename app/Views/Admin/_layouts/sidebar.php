<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <?php /*<li class="nav-item">
<a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
<span class="menu-title">Basic UI Elements</span>
<i class="menu-arrow"></i>
<i class="mdi mdi-crosshairs-gps menu-icon"></i>
</a>
<div class="collapse" id="ui-basic">
<ul class="nav flex-column sub-menu">
<li class="nav-item">
<a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
</li>
<li class="nav-item">
<a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
</li>
<li class="nav-item">
<a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
</li>
</ul>
</div>
</li>
<li class="nav-item">
<a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
<span class="menu-title">Icons</span>
<i class="mdi mdi-contacts menu-icon"></i>
</a>
<div class="collapse" id="icons">
<ul class="nav flex-column sub-menu">
<li class="nav-item">
<a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a>
</li>
</ul>
</div>
</li>
<li class="nav-item">
<a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
<span class="menu-title">Forms</span>
<i class="mdi mdi-format-list-bulleted menu-icon"></i>
</a>
<div class="collapse" id="forms">
<ul class="nav flex-column sub-menu">
<li class="nav-item">
<a class="nav-link" href="pages/forms/basic_elements.html">Form Elements</a>
</li>
</ul>
</div>
</li>
<li class="nav-item">
<a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
<span class="menu-title">Charts</span>
<i class="mdi mdi-chart-bar menu-icon"></i>
</a>
<div class="collapse" id="charts">
<ul class="nav flex-column sub-menu">
<li class="nav-item">
<a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a>
</li>
</ul>
</div>
</li>
<li class="nav-item">
<a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
<span class="menu-title">Tables</span>
<i class="mdi mdi-table-large menu-icon"></i>
</a>
<div class="collapse" id="tables">
<ul class="nav flex-column sub-menu">
<li class="nav-item">
<a class="nav-link" href="pages/tables/basic-table.html">Basic table</a>
</li>
</ul>
</div>
</li> */ ?>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <span class="menu-title">Authentication</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-lock menu-icon"></i>
      </a>

      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">

          <!-- Users List -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/users') ?>">
              Users List
            </a>
          </li>

          <!-- 🔥 Member List Dropdown Start -->
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#memberSubMenu" aria-expanded="false">
              Member List
              <i class="menu-arrow"></i>
            </a>

            <div class="collapse" id="memberSubMenu">
              <ul class="nav flex-column ms-3">

                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('admin/members') ?>">
                    All Members
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('admin/active-members') ?>">
                    Active Members
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('admin/inactive-members') ?>">
                    Inactive Members
                  </a>
                </li>

              </ul>
            </div>
          </li>
          <!-- 🔥 Member List Dropdown End -->

          <!-- Logout -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/logout') ?>" onclick="return confirm('Are You Sure?')">
              Logout
            </a>
          </li>

        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Settings</span>
        <i class="mdi mdi-file-document-box menu-icon"></i>
      </a>
    </li>
  </ul>
</nav>