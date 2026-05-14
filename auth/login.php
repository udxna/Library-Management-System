<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>LMS Login</title>

    <style>
        body{
            font-family: Arial;
            background:#f0f0f0;
        }

        .login-box{
            width:400px;
            margin:80px auto;
            padding:30px;
            background:#d9f99d;
            border-radius:15px;
        }

        input{
            width:100%;
            padding:12px;
            margin-top:10px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:15px;
            background:#7dd3fc;
            border:none;
        }
    </style>
</head>

<body>

<div class="login-box">

<h1>LMS Login</h1>

<form method="POST">

    <input type="text" name="username" placeholder="Enter Username">

    <input type="password" name="password" placeholder="Enter Password">

    <button type="submit">Login</button>

</form>

</div>

</body>
</html>