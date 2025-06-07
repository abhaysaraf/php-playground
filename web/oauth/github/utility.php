<?php

use Dotenv\Dotenv;
use GuzzleHttp\Client;

require_once '../../../vendor/autoload.php';

// Page title.
$title = 'OAuth | GitHub';

// Creates a Dotenv loader instance in current directory.
// And loads variables into $_ENV, prevents overwriting existing env vars.
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load(); // var_dump($_ENV);

// Github login button link with space separated scopes.
$scope = [
  'read:user',
  'user:email',
];
$githubAuthorizationUrl = 'https://github.com/login/oauth/authorize';
$githubAuthorizationUrl .= '?scope=' . implode('%20', $scope);
$githubAuthorizationUrl .= '&client_id=' . $_ENV['CLIENT_ID_GITHUB'];

// Get Access Token in exchange of Authorization code.
function getAccessTokenAndSaveInCookie($authorizationCode) {
  $accessTokenUrl = 'https://github.com/login/oauth/access_token';
  $params = [
    'client_id' => $_ENV['CLIENT_ID_GITHUB'],
    'client_secret' => $_ENV['CLIENT_SECRET_GITHUB'],
    'code' => $authorizationCode,
  ];
  $headers = [
    'Accept' => 'application/json',
  ];

  // Ready to make HTTP request.
  $client = new Client();
  try {
    $response = $client->post($accessTokenUrl, [
      'form_params' => $params,
      'headers' => $headers,
    ]);
  }
  catch(\Exception $e) {
    echo "Exception occured: " . $e->getMessage();
  }

  $statusCode = $response->getStatusCode();
  $body = json_decode($response->getBody()->getContents());

  // Server response okay and access token was not expired
  if ($statusCode == 200 && !isset($body->error)) {
    $accessToken = $body->access_token;

    // Set cookie for 60 seconds.
    setcookie('oauth_github_access_token', $accessToken, time() + 60, '', '', FALSE, TRUE);
    header('Location: ' . '/oauth/github/index.php');
  }
  else {
    var_dump($body);
  }

}

function getAccessToUserDetails($accessToken) {
  $client = new Client();

  // Documentation: https://docs.github.com/en/rest
  $apiUrl = 'https://api.github.com/user';
  $apiUrl = 'https://api.github.com/user/emails';

  $headers = [
    'Accept' => 'application/vnd.github+json',
    'Authorization' => 'Bearer '. $accessToken,
  ];

  try {
    $response = $client->get($apiUrl, [
      'headers' => $headers,
    ]);
  }
  catch(\Exception $e) {
    echo "Exception occured: " . $e->getMessage();
  }

  $statusCode = $response->getStatusCode();
  $body = json_decode($response->getBody()->getContents());

  if ($statusCode == 200 && !isset($body->error)) {
    var_dump($body);
  }

}
