<?php
// User Messages
$session_messages = array();
$signup_messages = array();

// cookie duration expiration time in seconds
define('SESSION_COOKIE_DURATION', 60 * 60 * 1); // 1 hour = 60 sec * 60 min * 1 hr

// find user's record from user_id
function find_user($db, $user_id)
{
  $records = exec_sql_query(
    $db,
    "SELECT * FROM users WHERE id = :user_id;",
    array(':user_id' => $user_id)
  )->fetchAll();
  if ($records) {
    // users are unique, there should only be 1 record
    return $records[0];
  }
  return NULL;
}

// find user's record from session hash
function find_session($db, $session)
{
  if (isset($session)) {
    $records = exec_sql_query(
      $db,
      "SELECT * FROM sessions WHERE session = :session;",
      array(':session' => $session)
    )->fetchAll();
    if ($records) {
      // sessions are unique, so there should only be 1 record
      return $records[0];
    }
  }
  return NULL;
}

// provide a function alternative to  $current_user
function current_user()
{
  global $current_user;
  return $current_user;
}

// Did the user log in?
function is_user_logged_in()
{
  global $current_user;

  // if $current_user is not NULL, then a user is logged in!
  return ($current_user != NULL);
}

// is the user an admin
function is_user_admin($db)
{
  global $current_user;
  if ($current_user === NULL) {
    return False;
  }

  $records = exec_sql_query(
    $db,
    "SELECT is_admin FROM users WHERE (id = :user_id);",
    array(':user_id' => $current_user['id'])
  )->fetchAll();
  if ($records && $records[0]['is_admin']) {
    return True;
  } else {
    return False;
  }
}

// login with username and password
function password_login($db, &$messages, $username, $password)
{
  global $current_user;
  global $sticky_login_username;

  $username = trim($username);
  $password = trim($password);
  $sticky_login_username = $username;

  if (isset($username) && isset($password)) {
    // Does this username even exist in our database?
    $records = exec_sql_query(
      $db,
      "SELECT * FROM users WHERE username = :username;",
      array(':username' => $username)
    )->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $user = $records[0];

      // Check password against hash in DB
      if (password_verify($password, $user['password'])) {
        // Generate session
        $session = session_create_id();

        // Store session ID in database
        $result = exec_sql_query(
          $db,
          "INSERT INTO sessions (user_id, session, last_login) VALUES (:user_id, :session, datetime());",
          array(
            ':user_id' => $user['id'],
            ':session' => $session
          )
        );
        if ($result) {
          // Success, session stored in DB

          // Send this back to the user.
          setcookie("session", $session, time() + SESSION_COOKIE_DURATION, '/');

          error_log("  login via password successful");
          $current_user = $user;
          return $current_user;
        } else {
          array_push($messages, "Log in failed.");
        }
      } else {
        array_push($messages, "Invalid username or password.");
      }
    } else {
      array_push($messages, "Invalid username or password.");
    }
  } else {
    array_push($messages, "No username or password given.");
  }

  error_log("  failed to login via password");
  $current_user = NULL;
  return $current_user;
}

// login via session cookie
function cookie_login($db, $session)
{
  global $current_user;

  // Did we find the existing session?
  if ($session) {

    // has the session expired?
    $login_expiration = new DateTime($session['last_login']);
    $login_expiration->modify('+ ' . SESSION_COOKIE_DURATION . ' seconds');
    $current_datetime = new DateTime();
    if ($login_expiration >= $current_datetime) {
      // session has not expired

      $current_user = find_user($db, $session['user_id']);

      // update the last login in the DB
      exec_sql_query(
        $db,
        "UPDATE sessions SET last_login = datetime() WHERE (id = :session_id);",
        array(':session_id' => $session['id'])
      );

      // Renew the cookie for 1 more hour
      setcookie("session", $session['session'], time() + SESSION_COOKIE_DURATION, '/');

      error_log("  login via cookie successful");
      return $current_user;
    } else {
      // session has expired
      error_log("  session expired");
      logout($db, $session);


    }
  }

  error_log("  failed to login via cookie");
  $current_user = NULL;
  return NULL;
}

// logout
function logout($db, $session)
{
  if ($session) {
    // Delete session from database.
    // Note: You probably also need a "cron" job that cleans up expired sessions.
    exec_sql_query(
      $db,
      "DELETE FROM sessions WHERE (session = :session_id);",
      array(':session_id' => $session['session'])
    );
  }

  // Remove the session from the cookie and force it to expire (go back in time).
  setcookie('session', '', time() - SESSION_COOKIE_DURATION, '/');

  // $current_user keeps track of logged in user, set to NULL to forget.
  global $current_user;
  $current_user = NULL;

  error_log("  logout successful");

  // Send the user back to the login page
  header('Location: /');
  exit();
}

// render login form
function login_form($action, $messages)
{
  global $sticky_login_username;
  ob_start();
?>
  <ul class="login">
    <?php
    foreach ($messages as $message) {
      echo "<li class=\"feedback\"><strong>" . htmlspecialchars($message) . "</strong></li>\n";
    } ?>
  </ul>

  <form class="login" action="<?php echo htmlspecialchars($action) ?>" method="post" novalidate>
    <div class="label-input">
      <label for="username">Username:</label>
      <input id="username" type="text" name="login_username" value="<?php echo htmlspecialchars($sticky_login_username ?? ""); ?>" required />
    </div>

    <div class="label-input">
      <label for="password">Password:</label>
      <input id="password" type="password" name="login_password" required />
    </div>

    <div class="align-right">
      <button name="login" type="submit">Sign In</button>
    </div>
  </form>
<?php
  $html = ob_get_clean();
  return $html;
}

// Check for login, logout requests. Or check to keep the user logged in.
function process_session_params($db, &$messages)
{
  // Is there a session? If so, find it!
  $session = NULL;
  if (isset($_COOKIE["session"])) {
    $session_hash = $_COOKIE["session"];

    $session = find_session($db, $session_hash);
  }

  if (isset($_GET['logout']) || isset($_POST['logout'])) { // Check if we should logout the user
    error_log("  attempting to logout...");
    logout($db, $session);
  } else if (isset($_POST['login'])) { // Check if we should login the user
    error_log("  attempting to login with username and password...");
    password_login($db, $messages, $_POST['login_username'], $_POST['login_password']);
  } else if ($session) { // check if logged in already via cookie
    error_log("  attempting to login via cookie...");
    cookie_login($db, $session);
  }
}

// alias for process_session_params
function process_login_params($db, &$messages)
{
  process_session_params($db, $messages);
}
?>
