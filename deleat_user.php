<?php
require "config.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete the user from the database
    $query = $con->prepare("DELETE FROM users WHERE id = ?");
    $query->bind_param("i", $user_id);

    if ($query->execute()) {
        echo "<script>
                alert('User deleted successfully.');
                window.location.href = 'dashbord.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting user: " . $query->error . "');
                window.location.href = 'dashbord.php';
              </script>";
    }
}
?>
