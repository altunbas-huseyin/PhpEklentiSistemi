<?php 
include('loader.php'); 
include('template/header.php');
$content = apply_filters('content' , 'Bu içerik değiştirilebilir yada bu cümle içerisinde ki bazı kelimeler , harfler değiştirelebilir.');
?>
<div class="content-box">
	<p><?php echo $content; ?></p>
</div>
<?php include('template/footer.php'); ?>
