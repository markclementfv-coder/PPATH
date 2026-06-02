<?php
// 1. Establish Database Connection & Session
$conn = new mysqli('localhost', 'root', '', 'ppath');
session_start();

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Handle form submission over standard HTTP POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $mode = isset($_POST['auth_mode']) ? $_POST['auth_mode'] : 'login';
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Clean plain-text string

    if (!empty($email) && !empty($password)) {
        
        if ($mode === 'signup') {
            // ==================== SIGN UP LOGIC ====================
            $firstname = mysqli_real_escape_string($conn, trim($_POST['firstname']));
            $lastname = mysqli_real_escape_string($conn, trim($_POST['lastname']));

            if (!empty($firstname) && !empty($lastname)) {
                $checkQuery = "SELECT * FROM admin WHERE email = '$email' LIMIT 1";
                $checkResult = mysqli_query($conn, $checkQuery);

                if (!$checkResult) {
                    $db_error = mysqli_real_escape_string($conn, mysqli_error($conn));
                    echo "<script>alert('Database Error: $db_error');</script>";
                } elseif (mysqli_num_rows($checkResult) > 0) {
                    echo "<script type='text/javascript'> alert('Email address is already registered!'); </script>";
                } else {
                    // REMOVED HASHING: Storing raw text directly into the database
                    $insertQuery = "INSERT INTO admin (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password')";
                    
                    if (mysqli_query($conn, $insertQuery)) {
                        $_SESSION['userId'] = mysqli_insert_id($conn);
                        $_SESSION['userName'] = $firstname;

                        echo "<script type='text/javascript'> alert('Registration successful!'); window.location='dashboard.php'; </script>";
                        die;
                    } else {
                        $db_error = mysqli_real_escape_string($conn, mysqli_error($conn));
                        echo "<script type='text/javascript'> alert('Registration failed. MySQL Error: $db_error'); </script>";
                    }
                }
            } else {
                echo "<script type='text/javascript'> alert('Please provide your first and last name to register.'); </script>";
            }

        } else {
            // ==================== LOG IN LOGIC ====================
            $query = "SELECT * FROM admin WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                // CHANGED: Direct match operator instead of password_verify()
                if ($password === $user_data['password']) {
                    $_SESSION['userId'] = $user_data['id'] ?? $user_data['accNumber'] ?? 1;
                    $_SESSION['userName'] = $user_data['firstname'];

                    echo "<script type='text/javascript'> alert('Login successful!'); window.location='dashboard.php'; </script>";
                    die;
                }
            }
            echo "<script type='text/javascript'> alert('Wrong username or password'); </script>";
        }
    } else {
        echo "<script type='text/javascript'> alert('Please enter the information needed!!!'); </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPATH Portal | Sign In or Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="auth-card">
        
        <div class="tab-group">
            <button id="tab-login" type="button" onclick="switchMode('login')" class="tab active">
                Log In
            </button>
            <button id="tab-signup" type="button" onclick="switchMode('signup')" class="tab">
                Sign Up
            </button>
        </div>

        <form id="auth-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="auth-form">
            
            <input type="hidden" name="auth_mode" id="auth-mode" value="login">

            <div id="field-name" class="form-group hidden">
                <div style="display: flex; gap: 10px; width: 100%;">
                    <div style="flex: 1;">
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" id="input-first" class="form-input" placeholder="John">
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" id="input-last" class="form-input" placeholder="Doe">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" required class="form-input" placeholder="you@example.com">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-input" placeholder="••••••••">
            </div>

            <button type="submit" id="submit-btn" class="submit-btn">
                Log In
            </button>
        </form>

    </div>

    <script>
        function switchMode(mode) {
            document.getElementById('auth-mode').value = mode;
            
            const tabLogin = document.getElementById('tab-login');
            const tabSignup = document.getElementById('tab-signup');
            const fieldName = document.getElementById('field-name');
            const inputFirst = document.getElementById('input-first');
            const inputLast = document.getElementById('input-last');
            const submitBtn = document.getElementById('submit-btn');

            if (mode === 'login') {
                tabLogin.classList.add('active');
                tabSignup.classList.remove('active');
                fieldName.classList.add('hidden');
                inputFirst.removeAttribute('required');
                inputLast.removeAttribute('required');
                submitBtn.innerText = "Log In";
            } else {
                tabLogin.classList.remove('active');
                tabSignup.classList.add('active');
                fieldName.classList.remove('hidden');
                inputFirst.setAttribute('required', 'true');
                inputLast.setAttribute('required', 'true');
                submitBtn.innerText = "Create Account";
            }
        }
    </script>
</body>
</html>
