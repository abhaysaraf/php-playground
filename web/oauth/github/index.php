<?php include './utility.php'; ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
</head>

<body>
  <h1><?php echo $title; ?></h1>

  <?php if(!isset($_COOKIE['oauth_github_access_token'])): ?>
    <button>
      <a href=<?php echo $githubAuthorizationUrl; ?>>Login with GitHub</a>
    </button>
  <?php else: ?>
    <strong>Autorization done, user details accessed successfully:</strong><br />
    <?php getAccessToUserDetails($_COOKIE['oauth_github_access_token']); ?>
  <?php endif; ?>
  
</body>
</html>