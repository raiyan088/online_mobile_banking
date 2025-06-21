<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $c_id = intval($_POST['c_id']);

    if (isset($_POST['toggle_status'])) {
        $sql = "SELECT status FROM account WHERE c_id = $c_id";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $current_status = $row['status'];

            if ($current_status == 'PENDING') {
                $new_status = 'ACTIVE';
            } else if ($current_status == 'ACTIVE') {
                $new_status = 'DEACTIVE';
            } else {
                $new_status = 'ACTIVE';
            }

            $update = "UPDATE account SET status = '$new_status' WHERE c_id = $c_id";
            mysqli_query($conn, $update);
        }
    }

    if (isset($_POST['delete_account'])) {
        $delete = "DELETE FROM account WHERE c_id = $c_id";
        mysqli_query($conn, $delete);

        $delete = "DELETE FROM customer WHERE c_id = $c_id";
        mysqli_query($conn, $delete);
    }

    header("Location: manager.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manager Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      margin-top: 50px;
    }
    .table {
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th {
      background: #343a40;
      color: white;
    }
    .btn-status {
      margin-right: 5px;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #343a40;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Manager Dashboard</h2>
  <?php
    $result = mysqli_query($conn, "SELECT * FROM account ORDER BY date DESC");
  ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Create At</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        while($row = mysqli_fetch_assoc($result)) { 
          $c_id = $row['c_id'];
          $customer = mysqli_query($conn, "SELECT name FROM customer WHERE c_id=$c_id");
          if ($customer && $customer->num_rows > 0) {
            $customer_row = $customer->fetch_assoc();
          }
      ?>
      <tr>
        <td><?= $row['acc_no'] ?></td>
        <td><?= $customer_row['name'] ?></td>
        <td><?= $row['date'] ?></td>
        <td><span class="badge badge-<?php
          if ($row['status'] == 'PENDING') echo 'warning';
          else if ($row['status'] == 'ACTIVE') echo 'success';
          else echo 'warning';
        ?>"><?= $row['status'] ?></span></td>
        <td>
          <form method="post" action="manager.php" style="display:inline-block;">
            <input type="hidden" name="c_id" value="<?= $row['c_id'] ?>">
            <button class="btn btn-sm btn-info btn-status" type="submit" name="toggle_status"><?php
            if ($row['status'] == 'PENDING') echo 'ACTIVE';
            else if ($row['status'] == 'ACTIVE') echo 'DE-ACTIVE';
            else echo 'ACTIVE';
            ?></button>
          </form>
          <form method="post" action="manager.php" style="display:inline-block;">
            <input type="hidden" name="c_id" value="<?= $row['c_id'] ?>">
            <button class="btn btn-sm btn-danger" type="submit" name="delete_account" onclick="return confirm('Are you sure you want to delete this account?')">Delete</button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>
