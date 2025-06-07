<?php

require_once 'utility.php';

if (isset($_GET['code'])) {
  getAccessTokenAndSaveInCookie($_GET['code']);
}
else {
  echo "Something went wrong. Unable to get authorization code from GitHub.";
}

