<?php
// ファイルを読み書き可能形式で開く
$file = fopen("data/schedule.json", "c+");
flock($file, LOCK_EX);

// 先頭にカーソルを合わせる(無いとjsonが壊れる可能性があるらしい)
rewind($file);
// ファイル全体を取得
$schedule_json = stream_get_contents($file);
// JSON→連想配列形式に変換
$schedules = json_decode($schedule_json, true);

// リクエストがPOSTの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POSTデータの取得
    $input_schedule = $_POST["input-schedule"];
    $input_date = $_POST["input-date"];
    $start_time = $_POST["start-time"];
    $end_time = $_POST["end-time"];

    // 連想配列に追加
    $schedules[] = [
        "schedule" => $input_schedule,
        "date" => $input_date,
        "start_time" => $start_time,
        "end_time" => $end_time,
    ];

    // 連想配列全体を日付・開始時間順にソート
    usort($schedules, function ($a, $b) {
        if ($a["date"] !== $b["date"]) {
            return $a["date"] > $b["date"];
        } else {
            return $a["start_time"] > $b["start_time"];
        }
    });

    // 連想配列→JSONに変換
    $schedule_json = json_encode($schedules);
    // 先頭にカーソルを合わせる(無いとjsonが壊れる可能性があるらしい)
    rewind($file);
    // ファイルの中身を空にする(無いとjsonが壊れる可能性があるらしい)
    ftruncate($file, 0);

    fwrite($file, $schedule_json);
    flock($file, LOCK_UN);
    fclose($file);

    // リロードし再POSTを防ぐ
    header("Location:index.php");
    exit();
}
flock($file, LOCK_UN);
fclose($file);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON予定表</title>
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
        </div>
    </div>

    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- JS読み込み -->
    <script id="script" src="./js/main.js" data-param='<?php echo $schedule_json ?>'></script>
</body>

</html>