CREATE DATABASE IF NOT EXISTS ronis_test_task_tarkaev;
USE ronis_test_task_tarkaev;
CREATE TABLE IF NOT EXISTS users(id int AUTO_INCREMENT, user_login varchar(30), user_password varchar(255), user_email varchar(255), user_status varchar(15), user_ip varchar(15), date_reg varchar(10), user_delete int(1), PRIMARY KEY(id));
CREATE TABLE IF NOT EXISTS info_users(id int AUTO_INCREMENT, user_id int, user_firstname varchar(30), user_lastname varchar(30), user_sex char(1), day_of_born int(2), month_of_born int(2), year_of_born int(4), PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES users(id));
CREATE TABLE IF NOT EXISTS banners(id int AUTO_INCREMENT, banner_name varchar(50), banner_status varchar(10), banner_url_protocol varchar(10), banner_url_link text, banner_img text, banner_position int, banner_date varchar(20), PRIMARY KEY(id));
INSERT INTO `users` (`id`, `user_login`, `user_password`, `user_email`, `user_status`, `user_ip`, `date_reg`, `user_delete`) VALUES
(1, 'admin', '$2y$10$fQtONrY0HCgaGHgaX9oNueCXlGkv.JqLSb4hbeZ47nxkgw026XVhq', 'admin@localhost.com', 'admin', '127.0.0.1', '07-06-2018', NULL);
INSERT INTO `info_users` (`id`, `user_id`, `user_firstname`, `user_lastname`, `user_sex`, `day_of_born`, `month_of_born`, `year_of_born`) VALUES
(1, 1, 'Firstname', 'Lastname', 'm', 1, 1, 1900);
INSERT INTO `banners` (`id`, `banner_name`, `banner_status`, `banner_url_protocol`, `banner_url_link`, `banner_img`, `banner_position`, `banner_date`) VALUES
(1, 'Баннер 1', 'on', 'http', 'google.com', 'images/banners/1528371584_665649414.jpeg', 1, '2018-06-07 14:39:44'),
(2, 'Баннер 2', 'on', 'http', 'google.com', 'images/banners/1528371621_5706787.jpeg', 2, '2018-06-07 14:40:21'),
(3, 'Баннер 3', 'on', 'http', 'google.com', 'images/banners/1528371648_951904296.jpeg', 3, '2018-06-07 14:40:48'),
(4, 'Баннер 4', 'on', 'http', 'google.com', 'images/banners/1528371668_759307861.jpeg', 4, '2018-06-07 14:41:08'),
(5, 'Баннер 5', 'on', 'http', 'google.com', 'images/banners/1528371684_671386.jpeg', 5, '2018-06-07 14:41:24'),
(6, 'Баннер 6', 'on', 'http', 'google.com', 'images/banners/1528371712_856170654.jpeg', 6, '2018-06-07 14:41:52');