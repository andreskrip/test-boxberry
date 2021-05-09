<?php

require 'src\Services\DB.php';

use Services\DB;

try {
    createTables();
} catch (Exception $e) {
    echo $e->getMessage();
}

/**
 * Создание таблиц для хранения данных о пациентах
 * @throws Exception
 */
function createTables(): void
{
    // формируем запрос на создание таблиц с учётом частых запросов
    $sql = '
    CREATE TABLE IF NOT EXISTS `patients` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(64)
    ) ENGINE=INNODB; 

    CREATE TABLE IF NOT EXISTS `patient_indicators` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `patient_id` INT NOT NULL,
        `blood_pressure` VARCHAR(7),
        `heart_rate` TINYINT UNSIGNED,
        `measurement_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX `heart_rate_blood_pressure_measurement_date_index` (`heart_rate`,`blood_pressure`,`measurement_date`),
        CONSTRAINT `fk_patient` 
            FOREIGN KEY (`patient_id`) 
            REFERENCES `patients`(`id`)
            ON UPDATE CASCADE ON DELETE CASCADE 
    ) ENGINE=INNODB;
    ';

    // выполняем запрос
    DB::getInstance()->query($sql);
}