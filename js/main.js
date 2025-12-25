// 今日の日付を取得
const today = new Date()
// 現在表示中のカレンダー
let current_day = ""
// JSONに保存されたカレンダー
let schedule = ""

/**
 * 基準日に沿ってカレンダーを表示する関数
 * @param {Date} target_day カレンダー作成基準日
 */
function create_table(target_day, schedule) {
    // 月の1日
    const first = new Date(target_day.getFullYear(), target_day.getMonth(), 1);
    // 月の最終日
    const lastDate = new Date(target_day.getFullYear(), target_day.getMonth() + 1, 0).getDate();
    // 月の1日の曜日
    const startWeekday = first.getDay();

    // 画面の表示月更新
    $("#current-month").text(`${target_day.getMonth() + 1}月`);
    // カレンダーHTML初期化
    $(".schedule tbody").html("");
    let table_h = ""

    let day = 1
    // 週ループ
    for (i = 0; i < 6; i++) {
        table_h += `<tr>`
        // 日ループ
        for (j = 0; j < 7; j++) {
            const target_day2 = new Date(target_day.getFullYear(), target_day.getMonth(), day, today.getHours(), today.getMinutes(), today.getSeconds(), today.getMilliseconds())

            if ((i * 7 + j < startWeekday) || (day > lastDate)) {
                // 前月・次月にかかる部分は省略
                table_h += `<td class="schedule-td"></td>`
            } else if (target_day2.getTime() === today.getTime()) {

                // 今日の日付と同じ場合はCSS適用
                table_h += `<td id=${target_day.getFullYear()}${(target_day.getMonth() + 1).toString().padStart(2, "0")}${day.toString().padStart(2, "0")} class="schedule-td today"><p class="schedule-date">${day}</p></td>`
                day++
            } else {
                table_h += `<td id=${target_day.getFullYear()}${(target_day.getMonth() + 1).toString().padStart(2, "0")}${day.toString().padStart(2, "0")} class="schedule-td"><p class="schedule-date">${day}</p></td>`
                day++
            }
        }
        table_h += `</tr>`

        // 6週がない場合は省略
        if (day > lastDate) {
            break
        }
    }
    // HTML表示
    $(".schedule tbody").html(table_h);
}

// アクセス時に今月のカレンダーを作成
$(window).on("load", function () {
    // 表示中の月を更新
    current_day = today.getTime()
    // JSONに保存されたスケジュールを取得
    schedule = JSON.parse($("#script").attr("data-param"));
    // カレンダー作成
    create_table(today, schedule)

    console.log(schedule);

    $(".sidebar").text(schedule[0].date);

});

// 前月のカレンダーに更新
$("#pre_month").on("click", function () {
    // 表示中の月を取得
    let pre_month = new Date(current_day)
    // 前月に移動
    pre_month.setMonth(pre_month.getMonth() - 1)
    // 表示中の月を更新
    current_day = pre_month.getTime()
    // カレンダー作成
    create_table(pre_month, schedule)
});

// 次月のカレンダーに更新
$("#next_month").on("click", function () {
    // 表示中の月を取得
    let next_month = new Date(current_day)
    // 前月に移動
    next_month.setMonth(next_month.getMonth() + 1)
    // 表示中の月を更新
    current_day = next_month.getTime()
    // カレンダー作成
    create_table(next_month, schedule)
});