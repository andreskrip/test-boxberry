# Тестовое задание на вакансию PHP-разработчик

1. Вы работаете над проектом умной больницы, где каждый из 1000 пациентов имеет специальный датчик, который раз в 10
   минут передает сведения о пульсе и давлении подопечного. Напишите SQL таблицы для хранения этих данных, учитывая то,
   что один из самых частых запросов к ней будет: выбор всех подопечных у которых после обеда были превышены нормы
   пульса и давления.

2. У вас есть база размером свыше 100гб и более 8млн строк. Вам необходимо добавить 3 новых поля, переименовать одно
   поле, а также добавить два индекса. Опишите, как вы это будете делать?

3. Напишите PHP скрипт в который через GET передаются две даты, а скрипт должен рассчитать сколько вторников было между
   ними.
    - #### src/countWeekdays.php

4. Есть таблица, которая хранит сведения о товарах вида:
    
   ``
   CREATE TABLE `products` (
   `id` int(11) NOT NULL,
   `name` tinytext,
   `price` float(9,2) DEFAULT '0.00',
   `color` tinytext, UNIQUE KEY `id` (`id`)
   ) ENGINE=innoDB;
   ``

| id  | name  | price | color |
| --- | ----- | ----- | ----- |
| 1   | Товар | 10    | green |
| 2   | Товар | 11    | red   |
| 3   | Товар | 35    | red   |

и т.д. товаров более 1млн. Различных цветов более 100.

Перед вами стоит задача, обновить цену в зависимости от цвета товара. Например, товарам с color=red цену уменьшить на
5%, товарам с color=green, увеличить цену на 10% и т.д. Напишите PHP + SQL скрипт как это сделать максимально эффективно
с точки зрения производительности.
