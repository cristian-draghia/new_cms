<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '2f74dc966d049940004e',
    'cbb6b370de7945f79002',
    '1220623',
    $options
  );

  $data['message'] = 'Exemple';
  $pusher->trigger('channel-1', 'event-1', $data);
?>