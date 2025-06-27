<?php
// user_module.php – Intentionally buggy for testing

session_start();

// Database connection (no error handling, hardcoded credentials    )
$conn = new mysqli("localhost", "root", "", "testdb");
if ($conn->connect_error) {
    die("DB Error");
}

// 🚨 1. Insecure login system
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ❌ SQL Injection possible
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        echo "Welcome, $username!";
    } else {
        echo "Login failed.";
    }
}

// 🚨 2. Profile Update without auth checks
if (isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    // ❌ No sanitization, open to XSS and SQL injection
    $updateSQL = "UPDATE users SET email='$email', bio='$bio' WHERE username='" . $_SESSION['user'] . "'";
    $conn->query($updateSQL);

    echo "Profile updated.";
}

// 🚨 3. File upload (no validation)
if (isset($_POST['upload'])) {
    $file = $_FILES['file'];
    $target = "uploads/" . basename($file["name"]);

    // ❌ No checks for file type, size, or path traversal
    move_uploaded_file($file["tmp_name"], $target);
    echo "File uploaded.";
}

// 🚨 4. Logout (no CSRF token)
if (isset($_GET['logout'])) {
    session_destroy();
    echo "Logged out.";
}

// 🚨 5. No input validation throughout
?>

<html>
<body>
    <h2>Login</h2>
    <form method="POST">
        Username: <input name="username"><br>
        Password: <input name="password"><br>
        <button name="login">Login</button>
    </form>

    <h2>Update Profile</h2>
    <form method="POST">
        Email: <input name="email"><br>
        Bio: <textarea name="bio"></textarea><br>
        <button name="update_profile">Update</button>
    </form>

    <h2>Upload File</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file"><br>
        <button name="upload">Upload</button>
    </form>

    <a href="?logout=true">Logout</a>
</body>
</html>

