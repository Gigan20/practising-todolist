<?php
session_start();
$count=["lost"=> 0,"in_queue"=> 0,"in_progress"=> 0,"done"=> 0];
if(!isset($_SESSION["username"])){
    header("location: ./login.php");
}
$data = file_get_contents("usertasks.txt");
$data = unserialize($data);
if(!empty($data)){
if(isset($_POST["taskid"])){
    unset($data[$_POST["taskid"]]);
    $serialize=serialize($data);
    file_put_contents("usertasks.txt",$serialize);
}
foreach($data as $index=> $task){
    if($task["user"] == $_SESSION["username"]){
        $usertask[$index]=$task;
    }
}
if(!empty($usertask)){
foreach ($usertask as $task){
    switch($task["status"]):
        case "done":
    ++$count["done"];
    break;
        case "in_progress":
    ++$count["in_progress"];
    break;
        case "in_queue":
    ++$count["in_queue"];
    break;
        case "lost":
    ++$count["lost"];
    break;
    endswitch;
}}}
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
        vertical-align: middle;
    }

    body {
        background: url("http://localhost/phplearning/bg.jpg"), #eff;
        background-size: cover;
        background-repeat: no-repeat;
        padding: 0 1rem;
        margin: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        min-height: 100vh;
        animation: bganim forwards 1s 1s;
        background-position: center center;
        animation: bganim forwards 1s 1s;
        background-position: center center;
    }

    .dashboard {
        overflow: hidden;
        background: #fffc;
        min-width: 250px;
        width: 250px;
        height: 400px;
        margin: .25rem;
        border-radius: 5px;
        box-shadow: #0001 2px 2px 2px;
        padding: 0;
        backdrop-filter: blur(10px);
    }

    .dashboard a {
        padding: .5rem 1rem;
        font-size: 14px;
        width: auto;
        color: #000;
        display: block;
        text-decoration: none;
        margin: .3rem 1rem;
        border-radius: 5px;
        background: #0000000a;
    }

    .dashboard svg {
        vertical-align: middle;
        padding: 0;
        margin: 0;
        margin-right: .5rem;
    }

    .dashboard span {
        vertical-align: middle;
    }

    .dashboard a:hover {
        background: #0001;
    }

    .dashboard a:active {
        transform: scale(.95);
    }

    .profile {
        display: flex;
        align-items: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 100px;
        padding: 0 2rem;
        margin-bottom: 1rem;
        border-bottom: 1.5px solid #0001;
    }

    .profile h1 {
        font-size: 20px;
        font-weight: 800;
        margin: 0 0;
    }

    .profile h2 {
        font-size: 13px;
        font-weight: 400;
        opacity: .7;
        margin: 0 0;
    }

    .tasks {
        overflow: hidden;
        background: #fffc;
        width: 100%;
        height: 400px;
        margin: .25rem;
        border-radius: 5px;
        box-shadow: #0001 2px 2px 2px;
        padding: 0 1rem;
        backdrop-filter: blur(10px);
    }
    .tasks h1{
        margin:.1rem 0;
        font-size:20px;
        margin-left:.5rem;
    }
    .counters{
        margin:1rem 0;
        display: flex;
    }
    .counter{
        border-radius:5px;
        background: #0001;
        height: 40px;
        display: flex;
        align-items: center;
        padding:1rem;
        justify-content: space-between;
        font-weight: 600;
        width:100%;
        margin:.3rem;
    }
    span.num{
        font-size:40px;
        font-weight: 700;
        padding:0 .5rem;
        color:#000a;
    }
    .task{
        border-radius:5px;
        background: #0001;
        height: 40px;
        display: flex;
        align-items: center;
        overflow: hidden;
        padding:1rem;
        justify-content: space-between;
        font-weight: 600;
        width:calc(100% / 3 - 2.6rem);
        float:left;
        position: relative;
        margin:.3rem; 
    }
    .task div,.task span,.task form{
        z-index:1;
    }
    .progress{
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        z-index:0;
        background:#0001;
    }
    .task h1{
        font-size:16px;
        padding:0;
        margin:0;
    }
    .task h2{
        font-size:14px;
        font-weight: 400;
        opacity:.7;
        padding:0;
        margin:0;
    }
    .task button{
        background:none;
        border:none;
        margin:0;
        padding:0;
        cursor: pointer;
            }

    .task:hover span{
        transform: translateX(-70px);
    }
    .task h3{
        position: absolute;
        bottom:.2rem;
        left:1rem;
        background:none;
        border:none;
        padding:none;
        margin:0;
        font-size:12px;
    }
    .lost{
        background:#f003;
    }
    .done{
        background:#0f03;
    }
    .in_queue{
        background:#00f1;
    }
    .in_progress{
        background:#0001;
;
    }
    form{
        position: absolute;
        bottom:calc(50% - 15px);
        right:.5rem;
        background:none;
        border:none;
        padding:.3rem .5rem;
        opacity:0;
        cursor: pointer;
        transform:translateY(35px);
    }
        .task:hover form{
        opacity:.7;
        transform:translateY(0px);
    }
    form:hover{
        opacity:1!important;
    }
    p {
        margin:0;
        margin-bottom:-36px;
        display: inline-block;
        font-size: 14px;
        text-align: center;
        background: #f00a;
        position:absolute;
        top:-1rem;
        right:1rem;
        color: #fff;
        border-radius: 100px;
        padding: .4rem 1rem;
        filter: blur(15px);
        opacity: 0;
        transform: scale(.8);
        animation: erranim forwards 5s 1s;
    }
    @keyframes erranim {
        10%,80% {
            margin: 0 0 1rem 0;
            filter: blur(0);
            opacity: 1;
            top:1rem;
            transform: scale(1);
        }
        90% {
            margin:0;
            top:-1rem;
            margin-bottom:-31px;
            filter: blur(15px);
            opacity: 0;
            transform: scale(.8);
        }
    }
</style>
<div class="dashboard">
    <div class="profile">
        <div class="user_info">
            <h1><?php echo $_SESSION["name"] . " " . $_SESSION["lastname"]; ?></h1>
            <h2><?php echo $_SESSION["username"]; ?></h2>
        </div>
    </div>
    <a href="./account.php""><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
            <path d="M530-636.34v-147.31q0-15.66 10.43-26Q550.86-820 566.27-820h217.62q15.42 0 25.76 10.35 10.35 10.34 10.35 26v147.31q0 15.65-10.43 25.99Q799.14-600 783.73-600H566.11q-15.42 0-25.76-10.35Q530-620.69 530-636.34ZM140-496v-288.01q0-15.3 10.43-25.64Q160.86-820 176.27-820h217.62q15.42 0 25.76 10.35Q430-799.3 430-784v288.01q0 15.3-10.43 25.64Q409.14-460 393.73-460H176.11q-15.42 0-25.76-10.35Q140-480.7 140-496Zm390 320v-288.01q0-15.3 10.43-25.64Q550.86-500 566.27-500h217.62q15.42 0 25.76 10.35Q820-479.3 820-464v288.01q0 15.3-10.43 25.64Q799.14-140 783.73-140H566.11q-15.42 0-25.76-10.35Q530-160.7 530-176Zm-390-.35v-147.31q0-15.65 10.43-25.99Q160.86-360 176.27-360h217.62q15.42 0 25.76 10.35Q430-339.31 430-323.66v147.31q0 15.66-10.43 26Q409.14-140 393.73-140H176.11q-15.42 0-25.76-10.35-10.35-10.34-10.35-26ZM200-520h170v-240H200v240Zm390 320h170v-240H590v240Zm0-460h170v-100H590v100ZM200-200h170v-100H200v100Zm170-320Zm220-140Zm0 220ZM370-300Z" />
        </svg><span>dashboard</span></a>
    <a href="./newtask.php""><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
            <path d="M458.62-148.63Q450-157.25 450-170v-280H170q-12.75 0-21.37-8.63-8.63-8.63-8.63-21.38 0-12.76 8.63-21.37Q157.25-510 170-510h280v-280q0-12.75 8.63-21.37 8.63-8.63 21.38-8.63 12.76 0 21.37 8.63Q510-802.75 510-790v280h280q12.75 0 21.37 8.63 8.63 8.63 8.63 21.38 0 12.76-8.63 21.37Q802.75-450 790-450H510v280q0 12.75-8.63 21.37-8.63 8.63-21.38 8.63-12.76 0-21.37-8.63Z" />
        </svg><span>new task</span></a>
    <a href="./exit.php""><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
            <path d="M212.31-140Q182-140 161-161q-21-21-21-51.31v-535.38Q140-778 161-799q21-21 51.31-21h238.08q12.76 0 21.38 8.62 8.61 8.61 8.61 21.38t-8.61 21.38q-8.62 8.62-21.38 8.62H212.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v535.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h238.08q12.76 0 21.38 8.62 8.61 8.61 8.61 21.38t-8.61 21.38q-8.62 8.62-21.38 8.62H212.31Zm492.38-310H393.85q-12.77 0-21.39-8.62-8.61-8.61-8.61-21.38t8.61-21.38q8.62-8.62 21.39-8.62h310.84l-76.92-76.92q-8.31-8.31-8.5-20.27-.19-11.96 8.5-21.27 8.69-9.31 21.08-9.62 12.38-.3 21.69 9l123.77 123.77q10.84 10.85 10.84 25.31 0 14.46-10.84 25.31L670.54-330.92q-8.92 8.92-21.19 8.8-12.27-.11-21.58-9.42-8.69-9.31-8.38-21.38.3-12.08 9-20.77l76.3-76.31Z" />
        </svg><span>logout</span></a>
</div>
<div class="tasks">
    <?php if(isset($result)): ?><p><?php echo $result;?></p><?php endif;?>
    <div class="counters">
        <div class="counter lost"><span>Lost</span><span class="num"><?php echo $count["lost"] ;?></span></div>
        <div class="counter in_progress"><span>In progress</span><span class="num"><?php echo $count["in_progress"] ;?></span></div>
        <div class="counter in_queue"><span>In queue</span><span class="num"><?php echo $count["in_queue"] ;?></span></div>
        <div class="counter done"><span>Done</span><span class="num"><?php echo $count["done"] ;?></span></div>
    </div>
    <h1>your tasks</h1>
    <?php if(!empty($usertask)): foreach($usertask as $id => $task): ?><div class="task <?php echo $task["status"]; ?>"><div class="progress" style="width:<?php echo $task["progress"]; ?>%"></div><div><h1><?php echo $task["taskname"]; ?></h1><h2><?php echo $task["date"]; ?></h2></div><span><?php echo $task["progress"]; ?>%</span><form action="" method="post"><button name="taskid" value="<?php echo $id ?>"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000"><path d="M324.31-164q-26.53 0-45.42-18.89T260-228.31V-696h-22q-11.05 0-18.52-7.42-7.48-7.42-7.48-18.38 0-10.97 7.48-18.58Q226.95-748 238-748h146v-12q0-12.99 9.2-22.19 9.19-9.19 22.18-9.19h129.24q12.99 0 22.18 9.19 9.2 9.2 9.2 22.19v12h146q11.05 0 18.52 7.42 7.48 7.42 7.48 18.38 0 10.97-7.48 18.58Q733.05-696 722-696h-22v467.26q0 27.26-18.89 46T635.69-164H324.31ZM648-696H312v467.69q0 5.39 3.46 8.85t8.85 3.46h311.38q5.39 0 8.85-3.46t3.46-8.85V-696ZM444.54-295.47q7.61-7.48 7.61-18.53v-284q0-11.05-7.41-18.53-7.42-7.47-18.39-7.47-10.96 0-18.58 7.47-7.61 7.48-7.61 18.53v284q0 11.05 7.41 18.53 7.42 7.47 18.39 7.47 10.96 0 18.58-7.47Zm107.69 0q7.61-7.48 7.61-18.53v-284q0-11.05-7.41-18.53-7.42-7.47-18.39-7.47-10.96 0-18.58 7.47-7.61 7.48-7.61 18.53v284q0 11.05 7.41 18.53 7.42 7.47 18.39 7.47 10.96 0 18.58-7.47ZM312-696v480-480Z"/></svg><span>delete</span></button></form></div><?php endforeach;endif;?></div>
    </body>
    <script>
        function load() {
            const button = document.querySelector("button");
            button.innerHTML = "login<div class=\"loader\"></div>";
        }
    </script>

</html>