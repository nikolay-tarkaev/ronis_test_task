<?php

// Подключаем ActiveRecord

require_once '../lib/activerecord/ActiveRecord.php';
require_once '../config/database_connect.php';


// подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

// подключение классов / создание экземпляров классов
require_once 'classes/autoloader_classes.php'; // Автоматическая загрузка классов из "application/classes"
new autoloader_classes;

require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
?>