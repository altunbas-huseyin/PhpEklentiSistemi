Php Eklenti Sistemi Uygulaması
=====================
Sistemin kurulumu için **config.php** dosyasını açıp sadece veritabanı ayarlarınızı yapmanız yeterlidir.

*Örnek:*
```php
<?php
define('DB_HOST' , 'localhost'); // Host Adresi
define('DB_USER' , 'root' ); // Veritabanı kullanıcı adı
define('DB_PASS' , '' ); // Veritabanı şifresi
define('DB_DATA' , 'hook'); // Veritabanı adı
?>
```

Örnek Uygulama Dosyası
---------
Kullanım şekilleri ve örnek bir eklenti.
```php
<?php
/**
 * Plugin Name: Genel Ayarlar
 * Author Name: Batuhan AYDIN
 * Author Mail: batuhanyusufaydin[et]gmail[dot]com
 * Description: Bu eklenti aracılığı ile site ayarlarınızı düzenleyebilirsiniz.
*/

// Eklenti aktif hale getiriliyorsa yapılacak işlem
function my_install_plugin()
{
	add_option('site_title' , 'Site Başlığınız');
	add_option('site_keywords' , 'Site Etiketleri');
	add_option('site_description' , 'Site Açıklaması');
}
active_plugin(__FILE__ , 'my_install_plugin');

// Eklenti pasif hale  getiriliyorsa yapılacak işlem
function my_uninstall_plugin()
{
	delete_option('site_title');
	delete_option('site_keywords');
	delete_option('site_description');
}
deactive_plugin(__FILE__ , 'my_uninstall_plugin');

/**
 * Örnek Filtreleme 
*/
function my_title($title = '')
{
	return 'Başlığı Değiştirdim - ' . $title;
}
add_filter('page_title' , 'my_title');

/**
 * 3. Sıraya Örnek bir menü ekleyelim
*/
function my_menu()
{
	add_menu('myplugin' , 'my_function' , 'Site Ayarlarım' , $pos = 3);
}
add_action('set_menu' , 'my_menu');

/**
 * Css kodları için kanca atılabilir bir fonksiyon oluşturmuştum
 * template/header.php içerisinde "add_head" diye onu burada kullanabiliriz.
*/
function my_stylesheet()
{
	?>
	<style type="text/css">
	div.line {font-size: 11px}
	input[type=text] , textarea {font-size: 11px}
	div.line span {display: inline-block; width: 150px}
	</style>
	<?php
}
add_action('add_head' , 'my_stylesheet');


// Bu fonksiyon çağırıldığında yapılacak olan işlemler
function my_function()
{
	if( $_POST )
	{
		$update = array('site_title' , 'site_keywords' , 'site_description' );
		foreach( $_POST as $key => $val )
		{
			if( in_array($key , $update) )
			{
				update_option($key , $val);
			}
		}
		
		$message = '<div class="success">Ayarlar başarı ile güncellendi.</div>';
	}
	?>
	<div class="content-box">
		<p>Merhaba bu eklenti aracılığı ile site ayarlarınızı düzenleyebilirsiniz..</p>
		<form action="" method="post">
			<div class="line">
				<span>Site Başlığı : </span>
				<input type="text" name="site_title" value="<?php echo get_option('site_title'); ?>"/>
			</div>
			<div class="line">
				<span>Site Etiketler : </span>
				<input type="text" name="site_keywords" value="<?php echo get_option('site_keywords'); ?>"/>
			</div>
			<div class="line">
				<span>Site Açıklama</span>
				<textarea name="site_description" cols="30" rows="4"><?php echo get_option('site_description'); ?></textarea>
			</div>
			<div class="line">
				<input type="submit" name="" value="Ayarları Güncelle"/>
			</div>
		</form>
	</div>
	<?php
}
?>
```
