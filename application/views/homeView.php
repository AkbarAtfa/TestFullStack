<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body>
    <button id="refresh">Refresh</button>
    <button id="addUserBtn">Tambah User</button>
    <a href="<?= base_url('profile') ?>">Profil</a>
    <a style="margin-right: 0;" href="<?= base_url('logout') ?>">Logout</a>

    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>


    <!-- Modal -->
    <div id="userModal" style="display:none;">
        <form id="userForm">
            <input type="hidden" name="id" id="userId">
            <label>Username</label><br>
            <input type="text" name="username" id="username"><br>
            <label>Nama</label><br>
            <input type="text" name="name" id="name"><br>
            <label>Password</label><br>
            <input type="password" name="password" id="password"><br><br>
            <label>Role</label><br>
            <select name="role_id" id="role_id">
                <?php foreach ($role as $role): ?>
                    <option value="<?= $role->id ?>"><?= $role->name ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <button type="submit">Simpan</button>
            <button type="button" id="batal">Batal</button>
        </form>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var table;
    $(document).ready(function() {
        table = $('#userTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('user/get_users') ?>",
                "type": "GET"
            }
        });
    });


    // refresh button
    $('#refresh').click(function() {
        table.ajax.reload();
    });

    // Add User button
    $('#addUserBtn').click(function() {
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModal').show();
    });

    // cancel User button
    $('#batal').click(function() {
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModal').hide();
    });

    // Submit form: CREATE (POST) or UPDATE (PUT)
    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        var id = $('#userId').val();
        var url = id ?
            "<?php echo base_url('user') ?>/" + id // PUT for update
            :
            "<?php echo base_url('user') ?>"; // POST for create
        var method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(res) {
                $('#userModal').hide();
                table.ajax.reload();
            },
            error: function(xhr) {
                let error = JSON.parse(xhr.responseText);
                Swal.fire('Gagal!', error.message, 'error');
            }
        });
    });

    // DELETE
    $(document).on('click', '.deleteBtn', function() {
        if (confirm("Yakin hapus user?")) {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url('user') ?>/" + id,
                type: 'DELETE',
                success: function() {
                    table.ajax.reload();
                }
            });
        }
    });


    // Edit
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "<?php echo base_url('user/get_user') ?>/" + id,
            method: "GET",
            dataType: "json",
            success: function(data) {
                $('#userId').val(data.id);
                $('#username').val(data.username);
                $('#name').val(data.name);
                if (data.role_id) {
                    $("select").val(data.role_id);
                }
                $('#password').val(''); // kosongkan
                $('#userModal').show();
            }
        });
    });
</script>

</html>