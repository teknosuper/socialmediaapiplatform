# Social Media API Documentation

## GET /api

A simple health check endpoint.

## GET /api/ig/profilesearch

Searches for Instagram profiles based on a query.

### Parameters:

*   **q**: `string` (Required) - The username or search query.

## GET /api/ig/profiledetail/:username

Retrieves detailed information for a specific Instagram profile.

### Parameters:

*   **:username**: `string` (Path Parameter, Required) - The Instagram username.

## GET /api/ig/mediafeeds/:accountid

Retrieves media feeds (posts) for a given Instagram account ID.

### Parameters:

*   **:accountid**: `string` (Path Parameter, Required) - The Instagram account ID.
*   **cursor**: `string` (Query Parameter, Optional) - A cursor for pagination to fetch the next set of media.

## GET /api/ig/getfollowers/:accountid

Retrieves followers for a given Instagram account ID.

### Parameters:

*   **:accountid**: `string` (Path Parameter, Required) - The Instagram account ID.
*   **cursor**: `string` (Query Parameter, Optional) - A cursor for pagination.
*   **first**: `number` (Query Parameter, Optional) - Number of followers to fetch (default: 20).

## GET /api/ig/getfollowing/:accountid

Retrieves accounts that a given Instagram account ID is following.

### Parameters:

*   **:accountid**: `string` (Path Parameter, Required) - The Instagram account ID.
*   **cursor**: `string` (Query Parameter, Optional) - A cursor for pagination.
*   **first**: `number` (Query Parameter, Optional) - Number of accounts to fetch (default: 20).

## POST /api/ig/setcookie

Stores Instagram cookie data in the database.

### Request Body (JSON):

*   **username_instagram**: `string` (Required) - The Instagram username associated with the cookie.
*   **email_instagram**: `string` (Optional) - The Instagram email associated with the cookie.
*   **cookie**: `string` (Required) - The Instagram cookie string.
*   **cookies_status**: `string` (Optional) - The status of the cookie (e.g., 'active', 'expired').

## GET /api/ig/getcookie/:username

Retrieves Instagram cookie data for a specific username from the database.

### Parameters:

*   **:username**: `string` (Path Parameter, Required) - The Instagram username to retrieve the cookie for.

## GET /administrator

Accesses the admin GUI for managing Instagram cookies.

## GET /administrator/api/cookies

Retrieves all Instagram cookie entries from the database.

## POST /administrator/api/cookies

Creates a new Instagram cookie entry in the database.

### Request Body (JSON):

*   **username_instagram**: `string` (Required)
*   **email_instagram**: `string` (Optional)
*   **cookie**: `string` (Required)
*   **cookies_status**: `string` (Optional)

## PUT /administrator/api/cookies/:id

Updates an existing Instagram cookie entry by ID.

### Parameters:

*   **:id**: `number` (Path Parameter, Required) - The ID of the cookie entry to update.

### Request Body (JSON):

*   **username_instagram**: `string` (Required)
*   **email_instagram**: `string` (Optional)
*   **cookie**: `string` (Required)
*   **cookies_status**: `string` (Optional)

## DELETE /administrator/api/cookies/:id

Deletes an Instagram cookie entry by ID.

### Parameters:

*   **:id**: `number` (Path Parameter, Required) - The ID of the cookie entry to delete.
