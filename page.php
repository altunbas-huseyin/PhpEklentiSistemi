<?php
include('loader.php');
include('template/header.php');

// Çağırılacak fonksiyonun adı
$action = $_GET['action'];

// Kontrol
if( function_exists($action) )
{
	call_user_func( $action );
}
else
{
	?>
	<div class="content-box">
		Sistemde böyle bir sayfa görünmüyor ?
	</div>
	<?php
}

include('template/footer.php'); ?>