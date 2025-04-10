<h2>Profil Saya</h2>

<?php if ($this->session->flashdata('success')): ?>
    <div style="color: green;">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div style="color: red;">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php echo validation_errors('<div style="color:red;">', '</div>'); ?>

<?php if (!empty($upload_error)): ?>
    <div style="color: red;"><?php echo $upload_error; ?></div>
<?php endif; ?>

<a href="<?= base_url('home') ?>">Kembali</a>

<form action="<?php echo base_url('profile/update'); ?>" method="post" enctype="multipart/form-data">
    <p>
        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $user->username; ?>" readonly>
    </p>
    <p>
        <label>Nama:</label><br>
        <input type="text" name="name" value="<?php echo set_value('name', $user->name); ?>" required>
    </p>
    <p>
        <label>Foto:</label><br>
        <input type="file" name="photo" id="photoInput"><br>
        <?php
        $url = base_url($user->photo ?: 'uploads/profile/default.png');
        $url = str_replace('/index.php', '', $url);
        ?>
        <img id="preview" src="<?= $url ?>" width="120" style="margin-top:10px;">
    </p>
    <button type="submit">Simpan Perubahan</button>
</form>

<script>
    document.getElementById('photoInput').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    };
</script>