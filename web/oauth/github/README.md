# GitHub OAuth

## Setup
1. Follow [this documentation](https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/creating-an-oauth-app) to create an 'OAuth App'. Pass value for:
- Homepage URL as `https://php-playground.ddev.site`
- Authorization Callback URL as `https://php-playground.ddev.site/oauth/github/callback.php`
2. Rename `template.env` file to `.env` file and replace the dummy values with appropriate values.

## The Flow
1. [Authenticate user with OAuth App for authorization code](https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/authenticating-to-the-rest-api-with-an-oauth-app) with [available scopes](https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/scopes-for-oauth-apps#available-scopes)
2. [Exchange Authorizatoin Code for Access Token](https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/authenticating-to-the-rest-api-with-an-oauth-app#providing-a-callback)
3. Access Github via API endpoints and Access Token following [GitHub REST API documentation](https://docs.github.com/en/rest)
4. Manage/Revoke Authorizations at https://github.com/settings/applications while testing your implementation

