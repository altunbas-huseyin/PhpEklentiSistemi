<?php
ob_start();
session_start();

// Hatalar
error_reporting( E_ALL &~ E_NOTICE ); 

// Dosyalarımızın bulunduğu yol
define('BASEPATH' , dirname(__FILE__));

// Ayar Dosyamız
include( BASEPATH . '/config.php' );

// Veritabanı bağlantısı
$link = mysql_connect(DB_HOST , DB_USER , DB_PASS);
mysql_select_db( DB_DATA , $link ) or die ( mysql_error() );
mysql_query("SET NAMES 'UTF8'");

// Gereken Dosyalar
include( BASEPATH . '/includes/functions.php' );
include( BASEPATH . '/includes/php-hooks.php' );
include( BASEPATH . '/includes/option.php' );
include( BASEPATH . '/includes/plugin.php' );
include( BASEPATH . '/includes/menu.php' );

// Aktif olan eklentileri çağırır
load_active_plugins();
// Normal sistemde olan sayfaları ekleyelim..
do_action('set_menu');
add_menu('homepage' , 'index.php' , 'Anasayfa' , $pos = 1 );
add_menu('plugins'  , 'plugins.php' , 'Eklentiler' , $pos = 2);
add_menu('logout'   , 'logout.php'  , 'Çıkış Yap' , $pos = 10);
?>
