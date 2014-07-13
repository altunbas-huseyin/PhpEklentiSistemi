<?php
/**
 * Ayarlar tablosuna yeni bir ayar eklemek için kullanýlýr
 * $key anahtar deðeri olarak kullanýlýr 
 * Örnek Kullaným :
 * add_option('base_url' , 'http://localhost/' );
 *
 * @param string $key
 * @param string $val
 * @return mixed
*/
function add_option( $key = '' , $val = '' )
{
	if( $value = get_option($key) )
	{
		return $value;
	}
	else
	{
		mysql_query("INSERT INTO options SET option_key = '$key' , option_val = '$val'");
	}
}


/**
 * Ayarlar tablosunda ki belirli bi deðeri güncellemek için kullanýlýr.
 * Örnek Kullaným :
 * update_option( 'my_key' , 'my_value' );
 *
 * @param string $key
 * @param string $val;
*/
function update_option( $key = '' , $val = '' )
{
	mysql_query("UPDATE options SET option_val = '$val' WHERE option_key = '$key'");
	return mysql_affected_rows();	
}

/**
 * Ayarlar tablosunda ki belirli bir ayarý almak için kullanýlýr
 * Eðer deðer yok ise false deðerini döndürür.
 * Örnek Kullaným :
 * get_option('base_url'); => http://localhost/
 *
 * @param string $key
 * @return mixed
*/
function get_option( $key = '' , $val = '' )
{
	$query = mysql_query("SELECT option_val FROM options WHERE option_key = '$key'");
	if( mysql_affected_rows() )
	{
		return mysql_result( $query , 0 );
	}
	return false;
}

/**
 * Ayarlar tablosunda ki belirli bi ayarý silmeye yarar..
 * delete_option('key'); 
 * Çýktý : true / false
 * 
 * @param string $key
 * @return integer
*/
function delete_option( $key = '' )
{
	mysql_query("DELETE FROM options WHERE option_key = '$key'");
	return mysql_affected_rows();
	
}
?>