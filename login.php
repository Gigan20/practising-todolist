<?php
session_start();
sleep(2);
if(isset($_SESSION["username"])){
    header("location: ./account.php");
}
$data = file_get_contents("users.txt");
$data = unserialize($data);
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $log[]= "data received";
    if (strlen($_POST["username"]) >= 5 && strlen($_POST["password"]) >= 8) {
        $log[]= "no str err";
        foreach ($data as $user) {
            if ($_POST["username"] == $user["username"] && $_POST["password"] == $user["password"]) {
                $_SESSION["username"] = $user["username"];
                $_SESSION["password"] = $user["password"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["lastname"] = $user["lastname"];
                $log[]= "user logged in";
                header("location: ./account.php");
                break;
            }
        }
        if(!isset($_SESSION["username"])){
        $result = "the password or username is incorrect";
        $log[]= "username not found err";}
    } else {
    $result = "your password or username isnt enterd currectly";
    $log[]= "str err";
} }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<style>
@import url("https://fonts.googleapis.com/css2?family=SN+Pro:ital,wght@0,200..900;1,200..900&display=swap");
::selection {
  background: #00f1;
}
* {
  font-family: "SN Pro";
  transition: 0.3s;
}

body {
  background: url("https://s34.picofile.com/file/8490306050/bg.jpg"),#eff;
  background-size: cover;
  background-repeat: no-repeat;
  padding: 0;
  margin: 0;
  overflow: hidden;
  min-height: 100vh;
  background-position: center center;
}
.flex{
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
.loaded {
  animation: bganim forwards 1s 1s;
}
@keyframes bganim {
  to {
    backdrop-filter: blur(10px) brightness(1.1);
  }
}
form {
  width: 100%;
}
.box {
  width: 100%;
  transform: scale(1.2);
  opacity: 0;
  filter: blur(15px);
}
.loaded .box {
  animation: anim forwards 1s 1.2s;
}
@keyframes anim {
  to {
    filter: blur(0);
    opacity: 1;
    transform: scale(1);
  }
}

h1 {
  padding: 0 1rem;
  text-align: center;
  margin: 0;
  font-size: 30px;
  margin-bottom: 0.5rem;
}

input {
  background: #fffc;
  border-radius: 5px;
  padding: 0.4rem 1rem;
  box-shadow: #0001 2px 2px 2px;
  outline: none;
  border: none;
}

button {
  border: none;
  background: #fffa;
  padding: 0.4rem 1rem;
  border-radius: 50px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.btndiv {
  margin-top: 1rem;
}
.loader {
  border-radius: 30px;
  padding: 0;
  width: 11px;
  display: inline-block;
  margin-left: -15px;
  border: 2px #0004 solid;
  border-right-color: #000;
  height: 11px;
  opacity: 0;
  animation: loadanim 0.5s forwards, rotate 1s linear infinite;
}
@keyframes loadanim {
  to {
    opacity: 1;
    margin-left: 0.3rem;
  }
}
@keyframes rotate {
  to {
    transform: rotate(1turn);
  }
}
button:hover,
a:hover {
  transform: scale(1.05);
}

button:active,
a:active {
  transform: scale(0.95);
}

legend {
  margin-top: 0.4rem;
}

p {
  margin: 0;
  margin-bottom: -31px;
  display: inline-block;
  font-size: 14px;
  text-align: center;
  background: #f00a;
  color: #fff;
  border-radius: 100px;
  padding: 0.4rem 1rem;
  filter: blur(15px);
  opacity: 0;
  transform: scale(0.8);
}
.loaded p {
  animation: erranim forwards 5s 3s;
}
a {
  font-size: 14px;
  color: #000;
  padding: 0 0 0 1rem;
  display: inline-block;
  text-decoration: none;
}

@keyframes erranim {
  10%,
  80% {
    margin: 0 0 1rem 0;
    filter: blur(0);
    opacity: 1;
    transform: scale(1);
  }
  90% {
    margin: 0;
    margin-bottom: -31px;
    filter: blur(15px);
    opacity: 0;
    transform: scale(0.8);
  }
}

.loadnotice {
  width: 300px;
  transition: 1s;
  text-align: center;
  top: calc(50% - 15px);
  left: calc(50% - 150px - 1rem);
  position: fixed;
}
.loaded .loadnotice {
  transform: scale(1.2);
  opacity: 0;
  filter: blur(15px);
}


    <?php if (isset($_POST["username"]) && isset($_POST["password"])): ?>body,
    .box {
        animation: none;
    }

    .box {
        filter: blur(0);
        opacity: 1;
        transform: scale(1);
    }

    body {
        backdrop-filter: blur(10px);
}

    <?php endif; ?>
</style>

<body class="flex">
    <h1 class="loadnotice">please wait</h1>
    <div class="box">
        <?php if (!empty($result)): ?><p><?php echo $result; ?></p><?php endif; ?>
        <h1>welcome to todolist.com</h1>
        <form method="post" action="" class="flex">
            <div><legend>username</legend>
            <input type="username" name="username"></div>
            <div><legend>password</legend>
            <input type="password" name="password"></div>
            <div class="btndiv"><button type="submit" onclick="load()">login</button><a href="/signin.php">i don't have an account</a></div>
        </form>
    </div>
</body>
<script>
    document.body
    function load(){
        const button = document.querySelector("button");
        button.innerHTML = "login<div class=\"loader\"></div>";
    }
    function load(){const button = document.querySelector("button");button.innerHTML = "login<div class=\"loader\"></div>";}
window.addEventListener('load', () => {document.body.classList.add('loaded');});
    </script>
</html>
