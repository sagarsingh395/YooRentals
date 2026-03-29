<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <i class="bi bi-people-fill me-1"></i> User List
        </h3>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <form class="d-flex" style="max-width: 250px;">
                <div class="input-group input-group-sm">
                    <input type="text" id="searchInput" class="form-control border-start-0 border-end-0"
                        placeholder=" Email / Phone">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa fa-search text-muted"></i>
                    </span>

                </div>
            </form>

            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php if (is_privilege(1, 2)) { ?>
                        <a href="<?= base_url('admin/add_user') ?>" class="btn btn-primary"><i
                                class="mdi mdi-account-plus"></i> Add User</a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="card">
        <?php if (session()->getFlashdata('message')): ?>
        <?php
            $type = session()->getFlashdata('type');
            $alertClass = ($type === 'success') ? 'alert-success' : 'alert-danger';
            ?>
        <div id="flashMessage" class="alert <?= $alertClass ?> alert-dismissible fade show small" role="alert">
            <?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <script>
        setTimeout(() => {
            let alert = document.getElementById('flashMessage');
            if (alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 4000);
        </script>
        <?php endif; ?>
        <div class="table-responsive">
            <table id="userTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) {
                        $n = 1;
                        foreach ($users as $list) {
                            $status = '<span class="badge badge-opacity-danger">Inactive</span>';
                            if ($list->status) {
                                $status = '<span class="badge badge-opacity-success">Active</span>';
                            }
                    ?>

                    <tr>
                        <td><?= $n++; ?></td>
                        <td><img src="<?= base_url(DP_PATH . $list->image) ?>" alt="image" width="60px" height="60px">
                        </td>
                        <td><?= $list->name ?></td>
                        <td><?= $list->email ?></td>
                        <td><?= $list->phone ?></td>
                        <td>
                            <?php if ($list->status): ?>
                            <span class="badge bg-success rounded-pill">
                                <i class="bi bi-check-circle me-1"></i>Active
                            </span>
                            <?php else: ?>
                            <span class="badge bg-danger rounded-pill">
                                <i class="bi bi-x-circle me-1"></i>Inactive
                            </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (is_privilege(1, 4)) { ?>
                            <a href="<?= base_url('admin/view_user/' . $list->user_id) ?>"
                                class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> View</a>
                            <?php }
                                    if (is_privilege(1, 3)) { ?>
                            <a href="<?= base_url('admin/edit_user/' . $list->user_id) ?>"
                                class="btn btn-info btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <?php }
                                    if (is_privilege(1, 5)) { ?>
                            <a href="<?= base_url('admin/delete_user/' . $list->user_id) ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?')">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php }
                    } else {
                        echo '<tr><td colspan="6" class="text-danger text-center">No record available</td></tr>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#userTable tbody tr");
    let found = false;

    let notFoundRow = document.getElementById("notFoundRow");
    if (notFoundRow) notFoundRow.remove();

    if (filter === "") {
        rows.forEach(row => {
            row.style.display = "";
            row.classList.remove("table-danger");
        });
        return;
    }

    rows.forEach(row => {
        row.classList.remove("table-danger");
        let email = row.cells[3].textContent.toLowerCase();
        let phone = row.cells[4].textContent.toLowerCase();

        if (email.includes(filter) || phone.includes(filter)) {
            if (!found) {
                row.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
            row.classList.add("table-danger");
            row.style.display = "";
            found = true;
        } else {
            row.style.display = "none";
        }
    });

    // User not found
    if (!found) {
        let tbody = document.querySelector("#userTable tbody");
        let nf = document.createElement("tr");
        nf.id = "notFoundRow";
        nf.innerHTML = `<td colspan="6" class="text-center text-danger">
                            <i class="fas fa-user-slash"></i> User Not Found
                        </td>`;
        tbody.appendChild(nf);
    }
});
</script>

<?= $this->endSection() ?>