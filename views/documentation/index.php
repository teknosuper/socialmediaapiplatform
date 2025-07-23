<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { padding-top: 20px; }
        .container { max-width: 960px; }
        .endpoint-card { margin-bottom: 20px; }
        .endpoint-card .card-header { font-weight: bold; }
        .param-list { list-style-type: none; padding-left: 0; }
        .param-list li { margin-bottom: 5px; }
        .param-list strong { display: inline-block; width: 100px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Social Media API Documentation</h1>

        <div class="endpoint-card card">
            <div class="card-header bg-primary text-white">GET /api</div>
            <div class="card-body">
                <p>A simple health check endpoint.</p>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-success text-white">GET /api/ig/profilesearch</div>
            <div class="card-body">
                <p>Searches for Instagram profiles based on a query.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>q</strong>: <code>string</code> (Required) - The username or search query.</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-success text-white">GET /api/ig/profiledetail/:username</div>
            <div class="card-body">
                <p>Retrieves detailed information for a specific Instagram profile.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:username</strong>: <code>string</code> (Path Parameter, Required) - The Instagram username.</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-success text-white">GET /api/ig/mediafeeds/:accountid</div>
            <div class="card-body">
                <p>Retrieves media feeds (posts) for a given Instagram account ID.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:accountid</strong>: <code>string</code> (Path Parameter, Required) - The Instagram account ID.</li>
                    <li><strong>cursor</strong>: <code>string</code> (Query Parameter, Optional) - A cursor for pagination to fetch the next set of media.</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-success text-white">GET /api/ig/getfollowers/:accountid</div>
            <div class="card-body">
                <p>Retrieves followers for a given Instagram account ID.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:accountid</strong>: <code>string</code> (Path Parameter, Required) - The Instagram account ID.</li>
                    <li><strong>cursor</strong>: <code>string</code> (Query Parameter, Optional) - A cursor for pagination.</li>
                    <li><strong>first</strong>: <code>number</code> (Query Parameter, Optional) - Number of followers to fetch (default: 20).</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-success text-white">GET /api/ig/getfollowing/:accountid</div>
            <div class="card-body">
                <p>Retrieves accounts that a given Instagram account ID is following.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:accountid</strong>: <code>string</code> (Path Parameter, Required) - The Instagram account ID.</li>
                    <li><strong>cursor</strong>: <code>string</code> (Query Parameter, Optional) - A cursor for pagination.</li>
                    <li><strong>first</strong>: <code>number</code> (Query Parameter, Optional) - Number of accounts to fetch (default: 20).</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-warning text-dark">POST /api/ig/setcookie</div>
            <div class="card-body">
                <p>Stores Instagram cookie data in the database.</p>
                <h6>Request Body (JSON):</h6>
                <ul class="param-list">
                    <li><strong>username_instagram</strong>: <code>string</code> (Required) - The Instagram username associated with the cookie.</li>
                    <li><strong>email_instagram</strong>: <code>string</code> (Optional) - The Instagram email associated with the cookie.</li>
                    <li><strong>cookie</strong>: <code>string</code> (Required) - The Instagram cookie string.</li>
                    <li><strong>cookies_status</strong>: <code>string</code> (Optional) - The status of the cookie (e.g., 'active', 'expired').</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-info text-white">GET /api/ig/getcookie/:username</div>
            <div class="card-body">
                <p>Retrieves Instagram cookie data for a specific username from the database.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:username</strong>: <code>string</code> (Path Parameter, Required) - The Instagram username to retrieve the cookie for.</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-secondary text-white">GET /administrator</div>
            <div class="card-body">
                <p>Accesses the admin GUI for managing Instagram cookies.</p>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-secondary text-white">GET /administrator/api/cookies</div>
            <div class="card-body">
                <p>Retrieves all Instagram cookie entries from the database.</p>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-secondary text-white">POST /administrator/api/cookies</div>
            <div class="card-body">
                <p>Creates a new Instagram cookie entry in the database.</p>
                <h6>Request Body (JSON):</h6>
                <ul class="param-list">
                    <li><strong>username_instagram</strong>: <code>string</code> (Required)</li>
                    <li><strong>email_instagram</strong>: <code>string</code> (Optional)</li>
                    <li><strong>cookie</strong>: <code>string</code> (Required)</li>
                    <li><strong>cookies_status</strong>: <code>string</code> (Optional)</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-secondary text-white">PUT /administrator/api/cookies/:id</div>
            <div class="card-body">
                <p>Updates an existing Instagram cookie entry by ID.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:id</strong>: <code>number</code> (Path Parameter, Required) - The ID of the cookie entry to update.</li>
                </ul>
                <h6>Request Body (JSON):</h6>
                <ul class="param-list">
                    <li><strong>username_instagram</strong>: <code>string</code> (Required)</li>
                    <li><strong>email_instagram</strong>: <code>string</code> (Optional)</li>
                    <li><strong>cookie</strong>: <code>string</code> (Required)</li>
                    <li><strong>cookies_status</strong>: <code>string</code> (Optional)</li>
                </ul>
            </div>
        </div>

        <div class="endpoint-card card">
            <div class="card-header bg-secondary text-white">DELETE /administrator/api/cookies/:id</div>
            <div class="card-body">
                <p>Deletes an Instagram cookie entry by ID.</p>
                <h6>Parameters:</h6>
                <ul class="param-list">
                    <li><strong>:id</strong>: <code>number</code> (Path Parameter, Required) - The ID of the cookie entry to delete.</li>
                </ul>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>