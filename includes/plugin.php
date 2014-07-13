<?php
// Eklenti bilgilerininin tutulduğu dizi
$_plugin  = array();
// Tüm eklentilerin tutulduğu dizi
$_plugins = array();

$active_hook = array();
$deactive_hook = array();
/**
 * plugins klasörü içerisinde ki eklentileri bir diziye aktarır.
 *
 * @param string $opendir
 * @return array ( eklenti dosya yolunu döndürür , set_plugin_data fonksiyonunda işleyebilmek için. )
*/
function get_plugins( $opendir = 'plugins' )
{
	global $_plugins ;
	
	if( $handle = opendir( BASEPATH . '/' . $opendir ) )
	{
		while( $file = readdir( $handle ) )
		{
			if( is_file( $path = BASEPATH . '/' . $opendir . '/' . $file . '/' . $file. '.php' ) )
			{
				$_plugins[] = array('basepath' => $path , 'filepath' => $file . '/'. $file . '.php' );
			}
		}
		
		return $_plugins;
	}
	else
	{
		exit( $opendir . ' okunamiyor.!' );
	}
}


/**
 * Eklenti bilgilerini ayrıştırır ve bir diziye aktarır.
 * $path değişkeni eklenti yolunu alır.
 *
 * @param string $path
 * @return array
*/
function set_plugin_data( $path = '' )
{
	global $_plugin;
	
	if( !is_file( $path['basepath'] ) )
	{
		return FALSE;
	}
	
	
	$file = file_get_contents( $path['basepath'] );
	preg_match('#Plugin Name:(.*)#i' , $file , $name );
	preg_match('#Author Name:(.*)#i' , $file , $author );
	preg_match('#Author Mail:(.*)#i' , $file , $mail );
	preg_match('#Description:(.*)#i' , $file , $desc );
	preg_match('#URL:(.*)#i' , $file , $url );
	
	
	$_plugin = array(
		'path'	 => $path['basepath'],
		'file'	 => $path['filepath'],
		'name' 	 => trim( $name[1] ),
		'author' => trim( $author[1] ),
		'mail'	 => trim( $mail[1] ),
		'desc'	 => trim( $desc[1] ),
		'url'	 => trim( $url[1] ),
	);
}

/**
 * Var olan bir eklentiyi aktif hale getirmek için kullanılır
 * Girilmesi gereken parametre ise
 * eklenti/eklenti.php şeklindedir.
 *
 * @param string $filepath
*/
function set_active_plugin( $filepath = '' )
{
	$filepath = urldecode($filepath);
	
	if( !is_file( BASEPATH . '/plugins/' . $filepath ) )
	{
		return false;
	}
	
	include_once BASEPATH . '/plugins/' . $filepath;
	
	$option = get_option('active_plugins');
	if( !is_serialized( $option ) )
	{
		update_option('active_plugins' , serialize(array()));
		$option = serialize(array());
	}
	
	$option = unserialize($option);
	
	// Install
	if( array_key_exists($filepath , $GLOBALS['active_hook']) )
	{
		if( function_exists( $callfunc = $GLOBALS['active_hook'][$filepath] ) )
		{
			call_user_func( $callfunc );
		}
	}
	
	if( !array_key_exists($filepath , $option) )
	{
		$option[$filepath] = TRUE;
		update_option('active_plugins' , serialize($option));
	}

}

/**
 * Var olan bir eklentiyi pasif hale getirmek için kullanılır
 * Girilmesi gereken parametre ise
 * eklenti/eklenti.php şeklindedir.
 *
 * @param string $filepath
*/
function set_deactive_plugin( $filepath = '' )
{
	$filepath = urldecode($filepath);
	
	$option = get_option('active_plugins');
	if( !is_serialized( $option ) )
	{
		update_option('active_plugins' , serialize(array()));
		$option = serialize(array());
	}
	
	$option = unserialize($option);
	
	if( is_file( BASEPATH . '/plugins/' . $filepath ) )
	{
		include_once BASEPATH . '/plugins/' . $filepath;
	
		// Uninstall
		if( array_key_exists($filepath , $GLOBALS['deactive_hook']) )
		{
			if( function_exists( $callfunc = $GLOBALS['deactive_hook'][$filepath] ) )
			{
				call_user_func( $callfunc );
			}
		}
	}
	
	if( isset($option[$filepath]) )
	{
		unset($option[$filepath]);
		update_option('active_plugins' , serialize($option));
	}
}

/**
 * Eklenti aktif mi değil mi onu öğrenmek için kullanılır.
 * Örnek kullanım : is_active_plugin('batuhanaydin/batuhanaydin.php');
 * 
 * @return boolean
*/
function is_active_plugin( $filepath = '' )
{
	if( empty($filepath) )
	{
		$filepath = plugin_filepath();
	}
	$option = get_option('active_plugins');
	$option = is_serialized( $option ) ? unserialize( $option ) : serialize(array());
	if( isset($option[$filepath]) )
	{
		return TRUE;
	}
	
	return false;
}

/**
 * Eklenti aktif hale getirilirken bi işlem yapılacaksa eğer 
 * Bu fonksiyon kullanılır
 * Örnek Kullanım :
 * active_plugin( __FILE__ , 'my_install_plugin' );
 * @param string $file
 * @param object $call ( Fonksiyon )
*/
function active_plugin( $file , $call = '' )
{
	$filename = pathinfo($file , PATHINFO_FILENAME);
	$GLOBALS['active_hook'][$filename . '/' . $filename . '.php'] = $call;
}

/**
 * Eklenti pasif hale getirilirken bi işlem yapılacaksa eğer 
 * Bu fonksiyon kullanılır
 * Örnek Kullanım :
 * deactive_plugin( __FILE__ , 'my_install_plugin' );
 * @param string $file
 * @param object $call ( Fonksiyon )
*/
function deactive_plugin( $file , $call = '' )
{
	$filename = pathinfo($file , PATHINFO_FILENAME);
	$GLOBALS['deactive_hook'][$filename . '/' . $filename . '.php'] = $call;
}

/**
 * Aktif olan eklentileri sayfaya dahil eder.
 * Her hangi bir parametre almaz.
*/
function load_active_plugins()
{
	$option = get_option('active_plugins');
	if( is_serialized( $option ) )
	{
		$option = unserialize( $option );
		foreach( $option as $key => $i )
		{
			if( is_file( BASEPATH . '/plugins/' . $key ) )
			{
				include_once BASEPATH . '/plugins/' . $key;
			}
		}
	}
}

/**
 * Eklenti okuma fonksiyonları
 * Bu fonksiyonlar eklentinin bilgilerine erişmek için kullanılır
*/
function plugin_basepath()
{
	return $GLOBALS['_plugin']['path'];
}
function plugin_filepath()
{
	return $GLOBALS['_plugin']['file'];
}
function plugin_name()
{
	return $GLOBALS['_plugin']['name'];
}
function plugin_author()
{
	return $GLOBALS['_plugin']['author'];
}
function plugin_mail()
{
	return $GLOBALS['_plugin']['mail'];
}
function plugin_description()
{
	return $GLOBALS['_plugin']['desc'];
}
function plugin_url()
{
	return $GLOBALS['_plugin']['url'];
}
?>