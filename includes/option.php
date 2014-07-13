<?php
/**
 * Ayarlar tablosuna yeni bir ayar eklemek i�in kullan�l�r
 * $key anahtar de�eri olarak kullan�l�r 
 * �rnek Kullan�m :
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
 * Ayarlar tablosunda ki belirli bi de�eri g�ncellemek i�in kullan�l�r.
 * �rnek Kullan�m :
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
 * Ayarlar tablosunda ki belirli bir ayar� almak i�in kullan�l�r
 * E�er de�er yok ise false de�erini d�nd�r�r.
 * �rnek Kullan�m :
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
 * Ayarlar tablosunda ki belirli bi ayar� silmeye yarar..
 * delete_option('key'); 
 * ��kt� : true / false
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