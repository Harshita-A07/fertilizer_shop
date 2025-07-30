<?php
// Load access token generator
require_once 'get_token.php';  // You’ll create this file next

$projectId = 'agribot-ntig'; // ← replace with your actual Dialogflow project ID
$credentialsPath = __DIR__ . '/credentials.json'; // path to the downloaded JSON

$accessToken = getAccessToken($credentialsPath);

if (!$accessToken) {
  echo "Failed to generate access token.";
  exit;
}

$userMessage = $_POST['message'] ?? '';
if (!$userMessage) {
  echo "Empty message.";
  exit;
}

$sessionId = uniqid(); // or use a fixed session
$url = "https://dialogflow.googleapis.com/v2/projects/$projectId/agent/sessions/$sessionId:detectIntent";

$data = [
  'queryInput' => [
    'text' => [
      'text' => $userMessage,
      'languageCode' => 'en'
    ]
  ]
];

$options = [
  'http' => [
    'method' => 'POST',
    'header' => "Authorization: Bearer $accessToken\r\n" .
                "Content-Type: application/json\r\n",
    'content' => json_encode($data)
  ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

$result = json_decode($response, true);
$reply = $result['queryResult']['fulfillmentText'] ?? "Sorry, I didn’t understand.";
echo $reply;
?>
