<?php

/**
 * Напишите PHP скрипт в который через GET передаются две даты,
 * а скрипт должен рассчитать сколько вторников было между ними.
 */
try {
    if (isset($_GET['start']) && isset($_GET['end'])) {
        echo countWeekdays($_GET['start'], $_GET['end'], 'Tuesday');
    } else {
        throw new Exception('Не переданы даты');
    }
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

/**
 * Подсчёт дней недели в промежутке дат
 * @param string $startDate
 * @param string $endDate
 * @param string $weekday
 * @return int
 * @throws Exception
 */
function countWeekdays(string $startDate, string $endDate, string $weekday): int
{
    // создаем объекты DateTime из переданных дат
    $startDate = date_create($startDate);
    $endDate = date_create($endDate . ' 23:59:59');

    if ($startDate > $endDate) {
        throw new Exception('Конечная дата не может быть раньше начальной');
    }

    // находим ближайший искомый день недели
    $closestWeekday = $startDate->modify($weekday);

    // вычисляем кол-во дней между этим днем и конечной датой
    $diffInDays = $endDate->diff($closestWeekday)->days;

    // результатом будет кол-во недель в интервале + 1
    return (int)($diffInDays / 7) + 1;
}