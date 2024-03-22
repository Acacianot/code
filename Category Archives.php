<?php
function my_custom_translations( $strings ) {
$text = array(

'Category Archives:' => '',

);
$strings = str_ireplace( array_keys( $text ), $text, $strings );
return $strings;
}
add_filter( 'gettext', 'my_custom_translations', 20 );

?>