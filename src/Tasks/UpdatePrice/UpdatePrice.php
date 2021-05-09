<?php

require 'src\Services\DB.php';

use Services\DB;

$start = microtime(true);
try {
    //createTable();
    //fillTable();
    updateTable();
} catch (Exception $e) {
    echo $e->getMessage();
}
echo 'Время выполнения скрипта: ' . round(microtime(true) - $start, 3) . ' sec.';

/**
 * Создание таблицы продуктов
 * @throws Exception
 */
function createTable(): void
{
    // формируем запрос
    $sql = 'CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(11) NOT NULL,
    `name` TINYTEXT,
    `price` FLOAT(9,2) DEFAULT 0.00,
    `color` TINYTEXT,
    UNIQUE KEY `id` (`id`)
)  ENGINE=INNODB;';

    // выполняем запрос
    DB::getInstance()->query($sql);
}

/**
 * Заполнение таблицы 1+ млн. записей
 * @throws Exception
 */
function fillTable(): void
{
    // формируем запрос
    $sql = '
    SET autocommit=0; 
    SET unique_checks=0;
    SET foreign_key_checks=0;
    INSERT INTO `products` VALUES ' . generateTableData(1100000) . ';
    SET unique_checks=1;
    SET foreign_key_checks=1;
    COMMIT;
    ';

    // выполняем запрос
    DB::getInstance()->query($sql);
}

/**
 * Обновление данных таблицы согласно условию:
 * Товарам с color=red цену уменьшить на 5%,
 * Товарам с color=green, увеличить цену на 10%
 * @throws Exception
 */
function updateTable(): void
{
    // формируем запрос
    $sql = '
    UPDATE products 
    SET price = 
        CASE 
            WHEN color = "Red" THEN price*0.95 
            WHEN color = "Green" THEN price*1.1 
        END
    WHERE color IN ("Red", "Green");
    ';

    // выполняем запрос
    DB::getInstance()->query($sql);
}

/**
 * Генерация данных для заполнения таблицы
 * @param int $count [optional] Кол-во строк, которое нужно сгенерировать
 * @return string
 */
function generateTableData(int $count = 2): string
{
    $result = [];

    for ($x = 1; $x <= $count; $x++) {
        $result[] = '(' . $x . ',"Товар",' . (float)rand(199, 1999) / 100 . ',"' . getRandomColor() . '")';
    }

    return implode(',', $result);
}

/**
 * Получение случайного значения цвета для товара
 * @return string
 */
function getRandomColor(): string
{
    $colors = [
        'Almond', 'Amethyst', 'Apricot', 'Aqua', 'Aquamarine', 'Aureolin', 'Avocado', 'Azure', 'Bazaar', 'Beaver', 'Beige', 'Bisque', 'Bistre', 'Black', 'Blond', 'Blue', 'Blush', 'Bole', 'Bone', 'Brass', 'Bronze', 'Buff', 'Burgundy', 'Camel', 'Capri', 'Cardinal', 'Carmine', 'Carnelian', 'Ceil', 'Celadon', 'Champagne', 'Charcoal', 'Cherry', 'Cinnamon', 'Cobalt', 'Coffee', 'Copper', 'Coral', 'Cordovan', 'Corn', 'Cornsilk', 'Cream', 'Crimson', 'Cyan', 'Denim', 'Desert', 'Ebony', 'Emerald', 'Flame', 'Fuchsia', 'Fulvous', 'Ginger', 'Gold', 'Gray', 'Green', 'Indigo', 'Iris', 'Isabelline', 'Ivory', 'Jade', 'Jasmine', 'Lava', 'Lavender', 'Lemon', 'Lilac', 'Linen', 'Liver', 'Magenta', 'Magnolia', 'Malachite', 'Manatee', 'Melon', 'Mint', 'Mustard', 'Ochre', 'Olive', 'Orchid', 'Peach', 'Pear', 'Pearl', 'Persimmon', 'Pink', 'Platinum', 'Plum', 'Prune', 'Pumpkin', 'Purple', 'Quartz', 'Raspberry', 'Red', 'Regalia', 'Rose', 'Ruby', 'Rufous', 'Rust', 'Saffron', 'Salmon', 'Sand', 'Sangria', 'Sapphire', 'Scarlet', 'Seashell', 'Sepia', 'Silver', 'Snow', 'Straw', 'Sunglow', 'Sunset', 'Tan', 'Tangelo', 'Taupe', 'Teal', 'Terracotta', 'Tomato', 'Topaz', 'Turquoise', 'Ultramarine', 'Umber', 'Vanilla', 'Veronica', 'Violet', 'Wenge', 'Wheat', 'White', 'Wine', 'Yellow'
    ];

    return array_rand(array_flip($colors));
}
