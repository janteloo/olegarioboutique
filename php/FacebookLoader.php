<?php
  require_once __DIR__ . '/Facebook/vendor/autoload.php'; // change path as needed

  $MAX_PHOTOS = 6;

  $fb = new \Facebook\Facebook([
    'app_id' => '129766397682660',
    'app_secret' => 'c97f2e4dc3e98efcfa5604299285cf6c',
    'default_graph_version' => 'v2.10',
    //'default_access_token' => '{access-token}', // optional
  ]);

  $response = $fb->get('/OlegarioBoutiqueUy/photos?type=uploaded&limit=' .$MAX_PHOTOS. '', $fb->getApp()->getAccessToken());
  $mapPhotos = [];
  foreach ($response->getDecodedBody()['data'] as $item) {
    $name = null;
    $id = $item['id'];
    if(array_key_exists('name', $item)) {
       $name = $item['name'];
    }
    $mapPhotos[$id] = $name;
  }

  $index = 0;
  $imagesReturn = [];
  foreach(array_keys($mapPhotos) as $key) {
      if($index < $MAX_PHOTOS) {
        $responseImage = $fb->get('/'.$key. '/picture?type=normal&redirect=false', $fb->getApp()->getAccessToken());
        $imageValue = $responseImage->getGraphUser()['url'];
        $imagesReturn[$index] = array ('url' => $imageValue, 
                                      'description' => $mapPhotos[$key]);
        $index++;
      } else {
        break;
      }
  }

  echo json_encode($imagesReturn)

?>