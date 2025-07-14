<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.05);
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
      text-align: center;
      width: 320px;
    }

    h2 {
      color: #fff;
      margin-bottom: 20px;
    }

    button {
      width: 75%;
      padding: 12px;
      background-color:rgb(105, 177, 197);
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      margin-top: 20px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background-color: #007fa6;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login/Register</h2>

    <br>
    <form action="admin/admin_login.html" method="post">
      <button type="submit">Admin Login</button>
    </form>
    <br>
    <form action="admin/admin_register.html" method="get">
      <button type="submit">Admin Register</button>
    </form>
  </div>

</body>
</html>
