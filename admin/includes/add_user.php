<?php

$message = '';
$message_state = '';
$user_name = '';
$user_email = '';
register_user( $user_name, $user_email, $message, $message_state);

register_user_form( $user_name, $user_email, $message, $message_state );

?>