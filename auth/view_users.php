<div class="table-wrapper">

  <h2 class="text-white mb-3">
    <i class="bi bi-people-fill"></i> Registered Users
  </h2>

  <div class="table-responsive">
    <table class="table table-hover align-middle glass-table">
      <thead>
        <tr>
          <th>User ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Password</th>
          <th>Email</th>
          <th class="text-center">Manage User</th>
        </tr>
      </thead>

      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
          <tr>
            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td class="password-cell"><?php echo htmlspecialchars($row['password']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>

            <td class="text-center action-buttons">
              <a href="update_user.php?user_id=<?php echo urlencode($row['user_id']); ?>" 
                 class="btn btn-edit btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
              </a>

              <a href="delete_user.php?user_id=<?php echo urlencode($row['user_id']); ?>" 
                 class="btn btn-delete btn-sm"
                 onclick="return confirm('Are you sure you want to delete this user?');">
                <i class="bi bi-trash-fill"></i> Delete
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</div>