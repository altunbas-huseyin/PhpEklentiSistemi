<?php
// Eklenen menülerin tutulduğu dizi
$menu = array();
/**
 * Menü'ye yeni bir link daha ekler.
 * 
 * @param string $slug ( benzersiz olması gerekir )
 * @param string $href ( sayfa adresi )
 * @param string $name ( başlığı
 * @param integer $position
*/
function add_menu( $slug = '' , $href = '' , $name = '' , $position = 0 )
{
	global $menu;
	while( isset($menu[$position]) )
	{
		$position++;
	}
	
	if( !isset($menu[$slug]) )
	{
		$ext = pathinfo( $href , PATHINFO_EXTENSION );
		if( $ext != 'php' )
		{
			$href = 'page.php?action=' . $href;
		}
		
		$menu[$position] = array('position' => $position ,'slug' => $slug , 'href' => $href , 'name' => $name);
	}
}

/**
 * Menüyü hazırlar 
*/
function get_admin_menu()
{
	global $menu;
	ksort($menu);
	if( is_array($menu) && count($menu) > 0 )
	{
		$output = '<ul class="list">';
		foreach( $menu as $slug => $nav )
		{
			if( preg_match('#page.php#i' , $nav['href'] ) && !empty($_SERVER['QUERY_STRING']) )
			{
				$active  = strpos( $nav['href'] , $_SERVER['QUERY_STRING'] ) !== FALSE ? ' active' : ' passive'; 
			}
			else
			{
				$active  = strpos( $_SERVER['PHP_SELF'] , $nav['href'] ) !== FALSE ? ' active' : ' passive'; 
			}
			
			$output .= '<li class="'.$nav['slug'].$active.'"><a href="'.$nav['href'].'">'.$nav['name'].'</a></li>';
		}		
		$output .= '</ul>';
		
		return $output;
	}
}
