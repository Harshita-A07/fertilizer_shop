<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Access - AgriShop</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to left, #d8f0ce, #92d5a2ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      text-align: center;
      width: 350px;
    }

    h2 {
      margin-bottom: 20px;
      color: #274a29ff;
    }

    .button-group a button {
      background-color: #2e7d32;
      color: white;
      padding: 12px 30px;
      margin: 10px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .button-group a button:hover {
      background-color: #1b5e20;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Welcome to AgriShop</h2>
    <p>Select your action:</p>
    <div class="button-group">
      <a href="user/login.html"><button>Login</button></a>
      <a href="user/user_signup.php"><button>Sign Up</button></a>
    </div>
  </div>
</body>
</html>
