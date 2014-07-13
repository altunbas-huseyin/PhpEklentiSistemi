<?php 
include('loader.php'); 

$title = 'Eklentiler';

// Filtreleme işlemi yapılabilir burada.
// add_filter('page_title' , function($title){ 
	// return $title . ' - Eklenti Yönetimi'; 
// });

add_action('add_head' , function(){
	?>
	<style type="text/css">
	table a.plugin_active{color: green}
	table a.plugin_deactive{color: red}
	</style>
	<?php
});

$action = $_GET['action'];
$filepath = urlencode($_GET['filepath']);

if( $action == 'active' )
{
	set_active_plugin( $filepath );
	redirect('plugins.php');
}

if( $action == 'deactive' )
{
	set_deactive_plugin( $filepath );
	redirect('plugins.php');
}


include('template/header.php');
?>
<div class="content-box">
	<p>Sistemde olan eklentiler listeleniyor..</p>
	<p>Merhaba , burada sistemde olan eklentileri aktif veya pasif hale getirebilirsin.</p>
	<table class="table">
		<thead>
			<tr>
				<td>Eklenti Bilgileri</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach( get_plugins() as $plugin ): set_plugin_data( $plugin ); ?>
			<tr>
				<td>
					<span class="name">
						<?php echo plugin_name(); ?>
						- adlı eklenti şu anda : <?php echo ( is_active_plugin() ? '<font color="green">aktif</font>' : '<font color="red">pasif</font>' ); ?>
					</span>
					<span class="author"><?php echo plugin_author(); ?>
					</span>
					<span class="description"><?php echo plugin_description(); ?></span>
					<span class="url">
						<a target="_blank" href="<?php echo plugin_url(); ?>"><?php echo plugin_url(); ?></a>
					</span>
					- 
					<?php if( is_active_plugin() ){ ?>
					<a href="plugins.php?action=deactive&filepath=<?php echo plugin_filepath(); ?>" class="plugin_active">Pasif Hale Getir</a>
					<?php }else{ ?>
					<a href="plugins.php?action=active&filepath=<?php echo plugin_filepath(); ?>" class="plugin_deactive">Aktif Hale Getir</a>
					<?php } ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php include('template/footer.php'); ?>