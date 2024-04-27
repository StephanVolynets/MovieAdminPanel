<!--  NOT BEING USED (I WAS TESTING)
    <?php
require_once 'includes/db.php';
require_once 'includes/sessions.php';


$session_messages = array();
process_session_params($db, $session_messages);

if (is_user_logged_in() && is_user_admin($db)) {
    header('Location: admin_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <!-- Add your CSS and other meta tags here -->
</head>
<body>
    <h1>Admin Login</h1>
    <?php echo login_form('admin_login.php', $session_messages); ?>
</body>
</html> -->
