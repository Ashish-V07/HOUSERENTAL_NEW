<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(to right, #f0f4f8, #c0c9d7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555;
        }

        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="password"]:focus {
            border-color: #5a9bd4;
            box-shadow: 0 0 5px rgba(90, 155, 212, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, #5a9bd4, #3a8ec3);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background: linear-gradient(to right, #3a8ec3, #5a9bd4);
            transform: translateY(-2px);
        }

        #message {
            text-align: center;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 14px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form id="changePasswordForm">
            <div class="input-group">
                <label for="oldPassword">Old Password</label>
                <input type="password" id="oldPassword" name="oldPassword" required>
            </div>
            <div class="input-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="input-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit">Change Password</button>
        </form>
        <div id="message"></div>
    </div>

    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const oldPassword = document.getElementById('oldPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const messageDiv = document.getElementById('message');

            if (newPassword !== confirmPassword) {
                messageDiv.textContent = 'New password and confirm password do not match!';
                messageDiv.className = 'error';
                return;
            }

            // Simulating password change
            messageDiv.textContent = 'Password changed successfully!';
            messageDiv.className = 'success';

            // Here you can add your AJAX call to change the password in your database
        });
    </script>
</body>
</html>
