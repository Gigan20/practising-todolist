<?php
$log = [];
session_start();
if (!isset($_SESSION["username"])) {
    header("location: ./login.php");
}
if (file_exists("usertasks.txt")) {
    $data = file_get_contents("usertasks.txt");
    $data = unserialize($data);
    $log[] = "data received";
} else {
    file_put_contents("usertasks.txt", "");
    $log[] = "file made";
}
if (empty($data)) {
    $data = [];
    $log[] = "\$data is empty";
}
if (isset($_POST["date"]) || isset($_POST["status"]) || isset($_POST["taskname"]) || isset($_POST["progress"])) {
    $log[] = "some data sent";
    if (!empty($_POST["date"]) && !empty($_POST["status"]) && !empty($_POST["taskname"]) && !empty($_POST["progress"])) {
        $log[] = "all data sent";
        $log[] = $_POST;
        $task = ["taskname" => $_POST["taskname"], "status" => $_POST["status"], "progress" => $_POST["progress"], "taskname" => $_POST["taskname"], "date" => $_POST["date"], "user" => $_SESSION["username"]];
        $data[] = $task;
        $serialize = serialize($data);
        file_put_contents("usertasks.txt", $serialize);
    } else {
        $result = "Please fill in all required entries.";
    }
}
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

    .log {
        color: #fff;
        overflow: auto;
        backdrop-filter: blur(15px);
        background: #0009;
        margin: .5rem;
        padding: 1rem;
        border-radius: 5px;
        width: 300px;
        font-family: monospace;
        height: calc(400px - 2rem);
    }

    .log h1 {
        font-size: 13px;
        text-align: left;
        width: 100%;
        margin-left: -1rem;
        margin: none;
        padding: 0 1rem;
    }

    body {
        background: url("https://s34.picofile.com/file/8490306050/bg.jpg"), #eff;
        background-size: cover;
        background-repeat: no-repeat;
        padding: 0 .5rem;
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
        overflow: hidden auto;
        background: #fffc;
        width: 100%;
        height: 400px;
        margin: .25rem;
        border-radius: 5px;
        box-shadow: #0001 2px 2px 2px;
        padding: 0 1rem;
        backdrop-filter: blur(10px);
    }

    .tasks h1 {
        margin-bottom: .3rem;
        font-size: 20px;
        margin-left: .5rem;
    }

    .counters {
        margin: 1rem 0;
        display: flex;
    }

    .counter {
        border-radius: 5px;
        background: #0001;
        height: 40px;
        display: flex;
        align-items: center;
        padding: 1rem;
        justify-content: space-between;
        font-weight: 600;
        width: 100%;
        margin: .3rem;
    }

    span.num {
        font-size: 40px;
        font-weight: 700;
        padding: 0 .5rem;
        color: #000a;
    }

    .task {
        border-radius: 5px;
        height: 40px;
        display: flex;
        align-items: center;
        overflow: hidden;
        padding: 1rem;
        justify-content: space-between;
        font-weight: 600;
        width: calc(100% / 3 - 2.6rem);
        float: left;
        position: relative;
        margin: .3rem;
    }

    .task div,
    .task span {
        z-index: 1;
    }

    .progress {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 0;
        background: #0001;
    }

    .task h1 {
        font-size: 16px;
        padding: 0;
        margin: 0;
    }

    .task h2 {
        font-size: 14px;
        font-weight: 400;
        opacity: .7;
        padding: 0;
        margin: 0;
    }

    .task button {
        position: absolute;
        bottom: calc(50% - 15px);
        right: .5rem;
        background: none;
        border: none;
        padding: .3rem .5rem;
        opacity: 0;
        cursor: pointer;
        transform: translateY(35px);
    }

    .task:hover button {
        opacity: .7;
        transform: translateY(0px);
    }

    button:hover {
        opacity: 1 !important;
    }

    .task:hover span {
        transform: translateX(-70px);
    }

    input {
        background: #0000000a;
        border-radius: 5px;
        width: calc(100% - 2rem);
        padding: .4rem 1rem;
        outline: none;
        border: none;
    }

    input[type="number"] {
        border-radius: 5px 5px 0 0;
    }

    .progressbar {
        background: #0002;
        border-radius: 0 0 5px 5px;
        width: 100%;
        height: 3px;
        outline: none;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .progressedbar {
        background: #0006;
        top: 0;
        bottom: 0;
        left: 0;
        position: absolute;
    }

    input[type="radio"] {
        display: none;
        width: 20px;
    }

    label {
        border-radius: 5px;
        background: #0001;
        height: 40px;
        display: flex;
        align-items: center;
        overflow: hidden;
        padding: 1rem;
        justify-content: space-between;
        font-weight: 600;
        width: calc(100% / 4 - 2.6rem);
        float: left;
        position: relative;
        margin: .3rem;
        cursor: pointer;
    }

    input:checked+label {
        background: #0002;
    }

    legend {
        margin-top: .4rem;
    }

    button {
        border: none;
        background: #0001;
        padding: .4rem 1rem;
        border-radius: 50px;
        margin-top: 1rem;
        display: inline-flex;
        cursor: pointer;
        margin-bottom: 1rem;
    }

    button:hover {
        transform: scale(1.05);
    }

    button:active {
        transform: scale(.95);
    }

    .flexbox {
        display: flex;
    }

    .flexbox div:not(.progressbar):not(.progressedbar) {
        width: calc(100% / 3 - 1rem);
        padding: .5rem;
        display: block;
    }

    .loader {
        border-radius: 30px;
        padding: 0;
        width: 13px;
        display: inline-block;
        margin-left: -17px;
        border: 2px #0004 solid;
        border-right-color: #000;
        height: 13px;
        opacity: 0;
        animation: loadanim .5s forwards, rotate 1s linear infinite;
    }

    @keyframes loadanim {
        to {
            opacity: 1;
            margin-left: .3rem;
        }
    }

    @keyframes rotate {
        to {
            transform: rotate(1turn);
        }
    }

    form {
        width: 100%;
    }

    p {
        margin: 0;
        margin-bottom: -36px;
        display: inline-block;
        font-size: 14px;
        text-align: center;
        background: #f00a;
        position: absolute;
        top: -1rem;
        right: 1rem;
        color: #fff;
        border-radius: 100px;
        padding: .4rem 1rem;
        filter: blur(15px);
        opacity: 0;
        transform: scale(.8);
        animation: erranim forwards 5s 1s;
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
            top: 1rem;
            transform: scale(1);
        }

        90% {
            margin: 0;
            top: -1rem;
            margin-bottom: -31px;
            filter: blur(15px);
            opacity: 0;
            transform: scale(.8);
        }
    }

    .low {
        display: none;
    }

    @media screen and (max-width:1100px) {

        .flexbox {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
        }

        .flexbox div:not(.progressbar):not(.progressedbar) {
            width: calc(100% / 2 - 1rem);
        }

        label {
            width: calc(100% / 2 - 2.6rem);
        }
    }

    @media screen and (max-width:900px) {
        body{
            padding:0;
        }
        .flexbox {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
        }

        .flexbox div:not(.progressbar):not(.progressedbar) {
            width: calc(100% - 1rem);
        }

        label {
            width: calc(100% - 2.6rem);
        }

        .dashboard {
            min-width: 75px;
            width: 75px;
        }

        .dashboard,
        .tasks {
            height: calc(100vh - .5rem);
        }

        .dashboard a span {
            display: none;
        }

        .dashboard .profile {
            width: 100%;
            padding: 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 75px;
        }

        .dashboard .full {
            display: none;
        }

        .dashboard .low {
            display: inline;
        }

        .dashboard h2 {
            display: none;
        }

        .dashboard a svg {
            margin: 0;
        }

        .dashboard a {
            padding: .5rem 0;
            text-align: center;
        }
    }
</style>
<!-- <pre class="log"><h1>log check</h1><?php print_r($log); ?></pre> -->
<div class="dashboard">
    <div class="profile">
        <div class="user_info">
            <h1><span class="full"><?php echo $_SESSION["name"] . " " . $_SESSION["lastname"]; ?></span><span class="low"><?php echo substr($_SESSION["name"], 0, 1) . "." . substr($_SESSION["lastname"], 0, 1); ?></span></h1>
            <h2><?php echo $_SESSION["username"]; ?></h2>
        </div>
    </div>
    <a href="./account.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
            <path d="M530-636.34v-147.31q0-15.66 10.43-26Q550.86-820 566.27-820h217.62q15.42 0 25.76 10.35 10.35 10.34 10.35 26v147.31q0 15.65-10.43 25.99Q799.14-600 783.73-600H566.11q-15.42 0-25.76-10.35Q530-620.69 530-636.34ZM140-496v-288.01q0-15.3 10.43-25.64Q160.86-820 176.27-820h217.62q15.42 0 25.76 10.35Q430-799.3 430-784v288.01q0 15.3-10.43 25.64Q409.14-460 393.73-460H176.11q-15.42 0-25.76-10.35Q140-480.7 140-496Zm390 320v-288.01q0-15.3 10.43-25.64Q550.86-500 566.27-500h217.62q15.42 0 25.76 10.35Q820-479.3 820-464v288.01q0 15.3-10.43 25.64Q799.14-140 783.73-140H566.11q-15.42 0-25.76-10.35Q530-160.7 530-176Zm-390-.35v-147.31q0-15.65 10.43-25.99Q160.86-360 176.27-360h217.62q15.42 0 25.76 10.35Q430-339.31 430-323.66v147.31q0 15.66-10.43 26Q409.14-140 393.73-140H176.11q-15.42 0-25.76-10.35-10.35-10.34-10.35-26ZM200-520h170v-240H200v240Zm390 320h170v-240H590v240Zm0-460h170v-100H590v100ZM200-200h170v-100H200v100Zm170-320Zm220-140Zm0 220ZM370-300Z" />
        </svg><span>dashboard</span></a>
    <a href="./newtask.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
            <path d="M458.62-148.63Q450-157.25 450-170v-280H170q-12.75 0-21.37-8.63-8.63-8.63-8.63-21.38 0-12.76 8.63-21.37Q157.25-510 170-510h280v-280q0-12.75 8.63-21.37 8.63-8.63 21.38-8.63 12.76 0 21.37 8.63Q510-802.75 510-790v280h280q12.75 0 21.37 8.63 8.63 8.63 8.63 21.38 0 12.76-8.63 21.37Q802.75-450 790-450H510v280q0 12.75-8.63 21.37-8.63 8.63-21.38 8.63-12.76 0-21.37-8.63Z" />
        </svg><span>new task</span></a>
    <a href="./exit.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
            <path d="M212.31-140Q182-140 161-161q-21-21-21-51.31v-535.38Q140-778 161-799q21-21 51.31-21h238.08q12.76 0 21.38 8.62 8.61 8.61 8.61 21.38t-8.61 21.38q-8.62 8.62-21.38 8.62H212.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v535.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h238.08q12.76 0 21.38 8.62 8.61 8.61 8.61 21.38t-8.61 21.38q-8.62 8.62-21.38 8.62H212.31Zm492.38-310H393.85q-12.77 0-21.39-8.62-8.61-8.61-8.61-21.38t8.61-21.38q8.62-8.62 21.39-8.62h310.84l-76.92-76.92q-8.31-8.31-8.5-20.27-.19-11.96 8.5-21.27 8.69-9.31 21.08-9.62 12.38-.3 21.69 9l123.77 123.77q10.84 10.85 10.84 25.31 0 14.46-10.84 25.31L670.54-330.92q-8.92 8.92-21.19 8.8-12.27-.11-21.58-9.42-8.69-9.31-8.38-21.38.3-12.08 9-20.77l76.3-76.31Z" />
        </svg><span>logout</span></a>
</div>
<div class="tasks">
    <h1>new task</h1>
    <?php if (!empty($result)): ?><p><?php echo $result; ?></p><?php endif; ?>
    <form action="" method="post">
        <div class="flexbox">
            <div>
                <legend>task name</legend>
                <input type="text" name="taskname">
            </div>
            <div>
                <legend>Progress percentage</legend>
                <input type="number" oninput="updateProgress(this.value)" max="100" min="0" name="progress">
                <div class="progressbar">
                    <div class="progressedbar"></div>
                </div>
            </div>
            <div>
                <legend>task date</legend>
                <input type="date" min="2026-01-01" name="date">
            </div>
        </div>
        <div>
            <legend>status</legend>
            <input type="radio" id="status1" name="status" value="in_queue"><label for="status1">in queue</label>
            <input type="radio" id="status2" name="status" value="in_progress"><label for="status2">In progress</label>
            <input type="radio" id="status3" name="status" value="done"><label for="status3">done</label>
            <input type="radio" id="status4" name="status" value="lost"><label for="status4">lost</label>
        </div>
        <button onclick="load()">submit</button>
    </form>
</div>
</body>
<script>
    const bar = document.querySelector(".progressedbar");
    bar.style.width = 0 + "%";

    function load() {
        const button = document.querySelector("button");
        button.innerHTML = button.innerHTML + "<div class=\"loader\"></div>";
    }

    function updateProgress(value) {
        if (value > 100) value = 100;
        if (value < 0) value = 0;

        const bar = document.querySelector(".progressedbar");
        bar.style.width = value + "%";
    }
</script>

</html>
