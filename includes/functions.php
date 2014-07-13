<?php
/**
 * Dizi nesne veya her hangi bir çıktıyı pre tagları arasında görüntülenmesini sağlar.
 * Örnek kullanım : dump( $var = array('foo' => 'bar') ); 
 * 
 * @param mixed $var
*/
function dump( $var = '' )
{
	if( func_num_args() > 1 )
	{
		call_user_func_array( $var , func_get_args() );
	}
	else
	{
		echo '<pre>'.print_r( $var , TRUE ) .'</pre>';
	}
}

/**
 * Yönlendirme Fonksiyonu
 *
 * @param string  $url
 * @param integer $time
*/
function redirect( $url = '' , $time = 0 )
{
	if( $time > 0 )
	{
		header('Refresh:'.$time.';URL='.$url);
	}
	else
	{
		header('Location:' . $url );
	}
}

/**
 * Verinin serialize fonksiyonundan geçip geçmediğine bakar
*/
function is_serialized( $data ) {
    // if it isn't a string, it isn't serialized
    if ( !is_string( $data ) )
        return false;
    $data = trim( $data );
    if ( 'N;' == $data )
        return true;
    if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
        return false;
    switch ( $badions[1] ) {
        case 'a' :
        case 'O' :
        case 's' :
            if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                return true;
            break;
        case 'b' :
        case 'i' :
        case 'd' :
            if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                return true;
            break;
    }
    return false;
}