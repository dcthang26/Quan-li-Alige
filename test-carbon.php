<?php
require __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;

// Lấy ngày hiện tại
$now = Carbon::now();
echo "Thời gian hiện tại: " . $now . "\n";

// Cộng thêm 7 ngày
$nextWeek = $now->addDays(7);
echo "Sau 7 ngày: " . $nextWeek->toDateTimeString() . "\n";

// Hiển thị ngày sinh nhật còn bao lâu nữa
$birthday = Carbon::createFromDate(2006, 06, 28);
echo "Còn " . $birthday->diffForHumans() . " nữa là đến sinh nhật.\n";
