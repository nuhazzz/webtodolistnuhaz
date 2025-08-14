<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>To-Do List Modern</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>📝 To-Do List</h1>

    <!-- Tombol untuk membuka modal tambah -->
    <div class="button-group">
      <button class="btn btn-add" onclick="openModal('modalTambah')">+ Tambah Tugas</button>
    </div>

    <div class="card-list">
      <?php
      $query = "SELECT * FROM todolist ORDER BY deadline ASC";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) == 0) {
          echo "<p class='empty'>Tidak ada tugas saat ini.</p>";
      } else {
          while ($row = mysqli_fetch_assoc($result)) {
              $status = $row['taskstatus'] == 'close' ? 'Selesai' : 'Belum';
              $badgeClass = $row['taskstatus'] == 'close' ? 'badge-done' : 'badge-open';
              $deadlineFormatted = date('d-m-Y', strtotime($row['deadline']));
              echo "
              <div class='card'>
                <div class='card-title'>{$row['tasklabel']}</div>
                <div class='card-description'>{$row['description']}</div>
                <div class='card-meta'>
                  <span class='badge $badgeClass'>$status</span>
                  <span class='priority {$row['priority']}'>Prioritas: {$row['priority']}</span>
                  <span class='deadline'>Deadline: $deadlineFormatted</span>
                </div>
                <div class='actions'>
                  <button class='btn btn-edit' onclick='openEditModal(" . json_encode($row) . ")'>✏️ Edit</button>
                  <a href='selesai.php?id={$row['taskid']}' class='btn btn-done'>✅ Selesai</a>
                  <a href='hapus.php?id={$row['taskid']}' class='btn btn-delete' onclick=\"return confirm('Hapus tugas ini?')\">🗑️ Hapus</a>
                </div>
              </div>";
          }
      }
      ?>
    </div>
  </div>

  <!-- Modal Tambah Tugas -->
  <div id="modalTambah" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('modalTambah')">&times;</span>
      <h2>Tambah Tugas</h2>
      <form action="tambah.php" method="POST">
        <input type="text" name="tasklabel" placeholder="Nama Tugas" required>
        <textarea name="description" placeholder="Deskripsi Tugas" rows="3"></textarea>
        <select name="priority" required>
          <option value="">Pilih Prioritas</option>
          <option value="high">Tinggi</option>
          <option value="medium">Sedang</option>
          <option value="low">Rendah</option>
        </select>
        <input type="date" name="deadline" required min="<?php echo date('Y-m-d'); ?>">
        <button type="submit" class="btn">Simpan</button>
      </form>
    </div>
  </div>

  <!-- Modal Edit Tugas -->
  <div id="modalEdit" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('modalEdit')">&times;</span>
      <h2>Edit Tugas</h2>
      <form action="edit.php" method="POST">
        <input type="hidden" name="taskid" id="edit-id">
        <input type="text" name="tasklabel" id="edit-label" required>
        <textarea name="description" id="edit-description" rows="3"></textarea>
        <select name="priority" id="edit-priority" required>
          <option value="high">Tinggi</option>
          <option value="medium">Sedang</option>
          <option value="low">Rendah</option>
        </select>
        <input type="date" name="deadline" id="edit-deadline" required min="<?php echo date('Y-m-d'); ?>">
        <button type="submit" class="btn">Update</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(id) {
      document.getElementById(id).style.display = 'block';
    }

    function closeModal(id) {
      document.getElementById(id).style.display = 'none';
    }

    function openEditModal(data) {
      document.getElementById('edit-id').value = data.taskid;
      document.getElementById('edit-label').value = data.tasklabel;
      document.getElementById('edit-description').value = data.description;
      document.getElementById('edit-priority').value = data.priority;
      document.getElementById('edit-deadline').value = data.deadline;
      openModal('modalEdit');
    }

    // Tutup modal jika klik di luar area modal
    window.onclick = function(event) {
      if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
      }
    }
  </script>
</body>
</html>
