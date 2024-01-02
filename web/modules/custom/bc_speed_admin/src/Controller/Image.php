<?php
namespace Drupal\bc_speed_admin\Controller;

Class Image
{
    private static $url = 'https://api.speedadmin.dk/';

    public static function getRequest($id=null, $contentType) {

        $response = null;

        if (!empty($id)) {

          $key = \Drupal::config('bc_speed_admin.settings')->get('apikey');

          $curl = curl_init(self::$url . '/v1/blobs/' . $id);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          $headers = array(
              'Content-Type: ' . $contentType ?? 'application/octet-stream',
              'Authorization: ' . $key
          );

          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
          curl_setopt($curl, CURLOPT_TIMEOUT, 3);

          $response = curl_exec($curl);

        }

        return $response;

    }

}

