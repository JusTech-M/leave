<?php
session_start();
require '../config/db.php';
if ($_SESSION['role'] !== 'admin') die("Access denied.");

// Handle Add Unit
if (isset($_POST['add'])) {
    $unit_name = trim($_POST['unit_name']);
    if ($unit_name) {
        $stmt = $pdo->prepare("INSERT INTO units (unit_name) VALUES (?)");
        $stmt->execute([$unit_name]);
    }
    header("Location: units.php");
    exit;
}

// Handle Edit Unit
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $unit_name = trim($_POST['unit_name']);
    if ($unit_name) {
        $stmt = $pdo->prepare("UPDATE units SET unit_name=? WHERE id=?");
        $stmt->execute([$unit_name, $id]);
    }
    header("Location: units.php");
    exit;
}

// Handle Delete Unit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM units WHERE id=?");
    $stmt->execute([$id]);
    header("Location: units.php");
    exit;
}

// Fetch all units
$units = $pdo->query("SELECT * FROM units ORDER BY unit_name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Units</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav>
  <a href="dashboard.php">Dashboard</a>
  <a href="../public/logout.php">Logout</a>
</nav>

<div class="container">
  <h2>Manage Organisation Units</h2>

  <!-- Add Unit -->
  <form method="post" style="margin-bottom:20px;">
    <input type="text" name="unit_name" placeholder="Enter unit name" required>
    <button type="submit" name="add">Add Unit</button>
  </form>

  <!-- Unit List -->
  <table>
    <thead>
      <tr><th>ID</th><th>Unit Name</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php foreach ($units as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td>
          <!-- Edit form inline -->
          <form method="post" style="display:flex; gap:5px;">
            <input type="hidden" name="id" value="<?= $u['id'] ?>">
            <input type="text" name="unit_name" value="<?= htmlspecialchars($u['unit_name']) ?>" required>
            <button type="submit" name="edit">Update</button>
            <a class="btn" href="?delete=<?= $u['id'] ?>" onclick="return confirm('Delete this unit?');">Delete</a>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
