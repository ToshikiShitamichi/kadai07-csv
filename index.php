<?php
var_dump($_POST);
// exit();
?>












<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予定表</title>
    <!-- GoogleFont読み込み -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <!-- CSS読み込み -->
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="schedule-input">
        <form action="./index.php" method="post">
            <div>
                <label for="input-schedule">予定</label>
                <input type="text" name="input-schedule" id="input-schedule" placeholder="予定を入力" required>
            </div>

            <div class="df">
                <div>
                    <label for="input-date">日付</label>
                    <input type="date" name="input-date" id="input-date" required>
                </div>

                <div>
                    <label for="start-time">開始時刻</label>
                    <input type="time" name="start-time" id="start-time" required>
                </div>
                ～
                <div>
                    <label for="end-time">終了時刻</label>
                    <input type="time" name="end-time" id="end-time" required>
                </div>

                <div>
                    <button type="submit">追加</button>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="schedule-output">
        <div class="main">
            <div class="month">
                <button id="pre_month"><span class="material-symbols-outlined">
                        chevron_left
                    </span></button>
                <span id="current-month"></span>
                <button id="next_month"><span class="material-symbols-outlined">
                        chevron_right
                    </span></button>
            </div>
            <table class="schedule" border="1">
                <thead>
                    <tr>
                        <td>
                            <p class="weekday">日</p>
                        </td>
                        <td>
                            <p class="weekday">月</p>
                        </td>
                        <td>
                            <p class="weekday">火</p>
                        </td>
                        <td>
                            <p class="weekday">水</p>
                        </td>
                        <td>
                            <p class="weekday">木</p>
                        </td>
                        <td>
                            <p class="weekday">金</p>
                        </td>
                        <td>
                            <p class="weekday">土</p>
                        </td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="sidebar">
            <div class="sidebar-day">
                <p class="sidebar-date">12月1日</p>
                <p>
                    <span class="sidebar-time">13:00-17:00</span>
                    <span class="sidebar-content">授業</span>
                </p>
            </div>
            <div class="sidebar-day">
                <p class="sidebar-date">12月2日</p>
                <p>
                    <span class="sidebar-time">9:00-12:00</span>
                    <span class="sidebar-content">アルバイト</span>
                </p>
                <p>
                    <span class="sidebar-time">13:00-17:00</span>
                    <span class="sidebar-content">P2Pトレーニング</span>
                </p>
            </div>
        </div>
    </div>

    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- JS読み込み -->
    <script src="./js/main.js"></script>
</body>

</html>