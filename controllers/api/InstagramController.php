<?php

namespace app\controllers\api;

use yii\rest\Controller;
use yii\web\Response;
use app\models\AccountCookies;

class InstagramController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionProfilesearch($q)
    {
        if (empty($q)) {
            return $this->asJson(['success' => false, 'error' => 'Search query (q) is required']);
        }

        $activeCookie = AccountCookies::find()->where(['cookies_status' => 'active', 'service' => 'instagram'])->one();

        if (!$activeCookie) {
            return $this->asJson(['success' => false, 'error' => 'No active Instagram cookie found in the database.']);
        }

        $instagramCookie = $activeCookie->cookie;

        $targetUrl = "https://www.instagram.com/web/search/topsearch/?query=" . urlencode($q) . "&count=10";

        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'x-ig-app-id: 936619743392459',
            'Cookie: ' . $instagramCookie,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return $this->asJson(['success' => false, 'error' => "Failed to fetch Instagram search data. Status: {$httpCode}. Response: " . substr($response, 0, 200)]);
        }

        $data = json_decode($response, true);

        if (isset($data['status']) && $data['status'] === 'ok' && isset($data['users'])) {
            return $this->asJson(['success' => true, 'data' => ['users' => $data['users']]]);
        } else {
            return $this->asJson(['success' => false, 'error' => (isset($data['message']) ? $data['message'] : 'No search results found.')]);
        }
    }

    public function actionProfiledetail($username)
    {
        if (empty($username)) {
            return $this->asJson(['success' => false, 'error' => 'Username is required']);
        }

        $activeCookie = AccountCookies::find()->where(['cookies_status' => 'active', 'service' => 'instagram'])->one();

        if (!$activeCookie) {
            return $this->asJson(['success' => false, 'error' => 'No active Instagram cookie found in the database.']);
        }

        $instagramCookie = $activeCookie->cookie;

        $targetUrl = "https://i.instagram.com/api/v1/users/web_profile_info/?username=" . urlencode($username);

        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'x-ig-app-id: 936619743392459',
            'Cookie: ' . $instagramCookie,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return $this->asJson(['success' => false, 'error' => "Failed to fetch Instagram profile data. Status: {$httpCode}. Response: " . substr($response, 0, 200)]);
        }

        $data = json_decode($response, true);

        if (isset($data['status']) && $data['status'] === 'ok' && isset($data['data']['user'])) {
            return $this->asJson(['success' => true, 'data' => ['user' => $data['data']['user']]]);
        } else {
            return $this->asJson(['success' => false, 'error' => (isset($data['message']) ? $data['message'] : 'Failed to retrieve user profile.')]);
        }
    }

    public function actionMediafeeds($accountid, $cursor = null)
    {
        if (empty($accountid)) {
            return $this->asJson(['success' => false, 'error' => 'Account ID is required']);
        }

        $activeCookie = AccountCookies::find()->where(['cookies_status' => 'active', 'service' => 'instagram'])->one();

        if (!$activeCookie) {
            return $this->asJson(['success' => false, 'error' => 'No active Instagram cookie found in the database.']);
        }

        $instagramCookie = $activeCookie->cookie;

        $mediaQueryId = '17880160963012870';
        $mediaCount = 12;

        $mediaUrl = "https://www.instagram.com/graphql/query/?query_id={$mediaQueryId}&id={$accountid}&first={$mediaCount}";
        if ($cursor) {
            $mediaUrl .= "&after={$cursor}";
        }

        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'x-ig-app-id: 936619743392459',
            'Cookie: ' . $instagramCookie,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $mediaUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return $this->asJson(['success' => false, 'error' => "Failed to fetch Instagram media data. Status: {$httpCode}. Response: " . substr($response, 0, 200)]);
        }

        $data = json_decode($response, true);

        if (isset($data['data']['user']['edge_owner_to_timeline_media'])) {
            return $this->asJson(['success' => true, 'data' => ['media' => $data['data']['user']['edge_owner_to_timeline_media']]]);
        } else {
            return $this->asJson(['success' => false, 'error' => (isset($data['message']) ? $data['message'] : 'No media feeds found.')]);
        }
    }

    public function actionGetfollowers($accountid, $cursor = null, $first = 20)
    {
        if (empty($accountid)) {
            return $this->asJson(['success' => false, 'error' => 'Account ID is required']);
        }

        $activeCookie = AccountCookies::find()->where(['cookies_status' => 'active', 'service' => 'instagram'])->one();

        if (!$activeCookie) {
            return $this->asJson(['success' => false, 'error' => 'No active Instagram cookie found in the database.']);
        }

        $instagramCookie = $activeCookie->cookie;

        $queryId = '17851374694183129';

        $targetUrl = "https://www.instagram.com/graphql/query/?query_id={$queryId}&id={$accountid}&first={$first}";
        if ($cursor) {
            $targetUrl .= "&after={$cursor}";
        }

        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'x-ig-app-id: 936619743392459',
            'Cookie: ' . $instagramCookie,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return $this->asJson(['success' => false, 'error' => "Failed to fetch Instagram followers data. Status: {$httpCode}. Response: " . substr($response, 0, 200)]);
        }

        $data = json_decode($response, true);

        if (isset($data['data']['user']['edge_followed_by'])) {
            return $this->asJson(['success' => true, 'data' => ['followers' => $data['data']['user']['edge_followed_by']]]);
        } else {
            return $this->asJson(['success' => false, 'error' => (isset($data['message']) ? $data['message'] : 'No followers data found.')]);
        }
    }

    public function actionGetfollowing($accountid, $cursor = null, $first = 20)
    {
        if (empty($accountid)) {
            return $this->asJson(['success' => false, 'error' => 'Account ID is required']);
        }

        $activeCookie = AccountCookies::find()->where(['cookies_status' => 'active', 'service' => 'instagram'])->one();

        if (!$activeCookie) {
            return $this->asJson(['success' => false, 'error' => 'No active Instagram cookie found in the database.']);
        }

        $instagramCookie = $activeCookie->cookie;

        $queryId = '17874545323001329';

        $targetUrl = "https://www.instagram.com/graphql/query/?query_id={$queryId}&id={$accountid}&first={$first}";
        if ($cursor) {
            $targetUrl .= "&after={$cursor}";
        }

        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'x-ig-app-id: 936619743392459',
            'Cookie: ' . $instagramCookie,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return $this->asJson(['success' => false, 'error' => "Failed to fetch Instagram following data. Status: {$httpCode}. Response: " . substr($response, 0, 200)]);
        }

        $data = json_decode($response, true);

        if (isset($data['data']['user']['edge_follow'])) {
            return $this->asJson(['success' => true, 'data' => ['following' => $data['data']['user']['edge_follow']]]);
        } else {
            return $this->asJson(['success' => false, 'error' => (isset($data['message']) ? $data['message'] : 'No following data found.')]);
        }
    }

    public function actionSetcookie()
    {
        $request = \Yii::$app->request;
        $params = $request->getBodyParams();
        $username_instagram = $params['username_instagram'] ?? null;
        $email_instagram = $params['email_instagram'] ?? null;
        $cookie = $params['cookie'] ?? null;
        $cookies_status = $params['cookies_status'] ?? null;

        if (empty($username_instagram) || empty($cookie)) {
            return $this->asJson(['success' => false, 'error' => 'username_instagram and cookie are required']);
        }

        $accountCookie = new AccountCookies();
        $accountCookie->service = 'instagram'; // Assuming service is always instagram for this API
        $accountCookie->username = $username_instagram;
        $accountCookie->email = $email_instagram;
        $accountCookie->cookie = $cookie;
        $accountCookie->cookies_status = $cookies_status;

        if ($accountCookie->save()) {
            return $this->asJson(['success' => true, 'message' => 'Cookie data saved successfully']);
        } else {
            return $this->asJson(['success' => false, 'error' => 'Failed to save cookie data', 'errors' => $accountCookie->errors]);
        }
    }

    public function actionGetcookie($username)
    {
        if (empty($username)) {
            return $this->asJson(['success' => false, 'error' => 'username is required']);
        }

        $accountCookie = AccountCookies::find()->where(['username' => $username, 'service' => 'instagram'])->one();

        if ($accountCookie) {
            return $this->asJson(['success' => true, 'data' => $accountCookie]);
        } else {
            return $this->asJson(['success' => false, 'message' => 'Cookie data not found for this username']);
        }
    }
}