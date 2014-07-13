<?php 
include('loader.php');

// Filtreleme yapmak için
add_filter('title' , function($title){
	return 'Değiştirdim - ' . $title;
});

// Örnek bir kanca atalım
add_action('content' , function(){
	echo 'My content';
});

// Filtreyi silmek için
// remove_filter('title');

// Kancayı silmek için
// remove_action('content');

$title = apply_filters('title' , 'Site Title');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo $title; ?></title>
</head>
	<body>
		<?php do_action('content'); ?>
	</body>
</html>