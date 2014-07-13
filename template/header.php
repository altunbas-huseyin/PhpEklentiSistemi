<?php if( !defined('BASEPATH') ) exit('-1'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo isset($title) ? $title . ' - ' : ''; ?> Php ile eklenti yapımı Batuhan AYDIN</title>
	<style type="text/css">
	body , ul, li , h1,h2,h3,h4,h5,h6 , p{margin: 0; padding: 0}
	body {font: 12px/24px Georgia; background-color: #efefef}
	.content {width: 800px; margin: 10px auto; background-color: #fff; border: 1px solid #ccc; padding: 10px; border-radius: 3px}
	.left-blok {display: inline-block; width: 130px; float: left; border-right: 1px solid #efefef;}
	.left-blok ul.list {margin-left: 20px}
	.content-box {width: 650px; float: right}
	ul.list li {}
	ul.list li a {color: #444; text-decoration: none}
	ul.list li a:hover {text-decoration: underline}
	ul.list li.active a {font-weight: bold}
	.clear {clear: both}
	hr {border: 1px solid #ccc}
	.table {text-align: center; width: 100%; border-radius: 3px; border: 1px solid #ccc}
	.table thead tr td {border-bottom: 1px solid #444; background-color: #efefef; padding: 4px 14px; font-weight: bold; }
	.table tbody tr td {border-bottom: 1px solid #ccc}
	span.author {font-weight: bold; display: block}
	span.description {display: block}
	span.url a {color: #888888}
	</style>
	<?php do_action('add_head'); ?>
</head>
	<body>
	<div class="content">
		<h3><?php echo apply_filters('page_title' , 'PHP İLE EKLENTİLİ GELİŞTİREBİLİR SİSTEM UYGULAMASI'); ?></h3>
		<hr />
		<div class="left-blok">
			<?php echo get_admin_menu(); ?>
		</div>