<?php
require __DIR__ . '/../../../../../../vendor/autoload.php'; // Adjust the path to the autoload file

use Symfony\Component\HttpFoundation\JsonResponse;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('MAILCHIMP_API_KEY');
$listId = getenv('MAILCHIMP_LIST_ID');
$dc = getenv('MAILCHIMP_DC');

$email = $_POST['email'];

$url = "https://$dc.api.mailchimp.com/3.0/lists/$listId/members/";

$postData = json_encode([
  'email_address' => $email,
  'status' => 'subscribed',
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
  $response = new JsonResponse(['message' => 'Thank you for subscribing!'], 200);
} else {
  $response = new JsonResponse(['message' => 'There was an error. Please try again.'], 400);
}

$response->send();
