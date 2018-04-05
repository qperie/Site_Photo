create database if not exists site_photo character set utf8 collate utf8_unicode_ci;
use site_photo;

grant all privileges on site_photo.* to 'site_photo_user'@'localhost' identified by 'secret';