<?php

if (isset($_GET['startDate']) && isset($_GET['endDate'])) {

    // создаем объекты DateTime из переданных дат
    $startDate = date_create($_GET['startDate']);
    $endDate = date_create($_GET['endDate'] . ' 23:59:59');

    // вычисляем ближайший вторник
    $closestTuesday = $startDate->modify('tuesday');

    // вычисляем кол-во дней между первым вторником и конечной датой
    $diffInDays = $endDate->diff($closestTuesday)->days;

    // результатом будет кол-во недель в интервале + 1
    print_r((int)($diffInDays / 7) + 1);
} else {
    print_r('Не переданы даты GET-параметрами');
}