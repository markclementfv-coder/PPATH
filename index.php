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
