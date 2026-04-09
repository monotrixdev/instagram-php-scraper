<?php
declare(strict_types=1);

class Ig {

  private string $cookiesFile;
  private string $lsdFile;
  private const DEFAULT_CSRF = 'ab6R1FozzRj5yTK8v2029pxfnowzeQb9';
  private const DEFAULT_LSD = 'aDG7-vRrK2hKcgJ1sI5ZSe';

  public function __construct(string $cookiesFile = '') {
    $this->cookiesFile = $cookiesFile ?: __DIR__ . '/../storage/cookies.txt';
    $this->lsdFile = __DIR__ . '/../storage/lsd.dart';

    if (!file_exists($this->cookiesFile)) {
        file_put_contents($this->cookiesFile, '');
    }
  }

  /**
   * Log messages for debugging
   */
  private function log(string $message): void {
    // In production, use a proper logger like Monolog
    error_log('[Ig Scraper] ' . $message);
  }
  
  public function resp(int $code, array $json): void {
    http_response_code($code);
    header('Content-type: application/json; charset: utf-8');
    echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
  }
  private function post(string $username): array {
        $variables = json_encode([
        'data' => [
            'count' => 12,
            'include_reel_media_seen_timestamp' => true,
            'include_relationship_info' => true,
            'latest_besties_reel_media' => true,
            'latest_reel_media' => true,
        ],
        'username' => $username,
        '__relay_internal__pv__PolarisImmersiveFeedChainingEnabledrelayprovider' => false,
    ]);

    $postData = [
        'av' => '17841466981815064',
        '__d' => 'www',
        '__user' => '0',
        '__a' => '1',
        '__req' => '5',
        'dpr' => '1',
        '__ccg' => 'GOOD',
        '__rev' => '1036896837',
        '__hsi' => '7626377414065125174',
        'fb_api_caller_class' => 'RelayModern',
        'fb_api_req_friendly_name' => 'PolarisProfilePostsQuery',
        'server_timestamps' => 'true',
        'variables' => $variables,
        'doc_id' => '27500569486209613',
    ];
    return $postData;
  }
  private function headers(string $username): array {
    $csrf = $this->getCookieValue('csrftoken') ?: self::DEFAULT_CSRF;
    $lsd = $this->getLSD() ?: self::DEFAULT_LSD;
    return [
    'authority: www.instagram.com',
    'accept: */*',
    'accept-language: en-US,en;q=0.9',
    'content-type: application/x-www-form-urlencoded',
    'origin: https://www.instagram.com',
    'referer: https://www.instagram.com/' . $username . '/?__pwa=1',
    'sec-ch-prefers-color-scheme: dark',
    'sec-ch-ua: "Chromium";v="137", "Not/A)Brand";v="24"',
    'sec-ch-ua-full-version-list: "Chromium";v="137.0.7337.0", "Not/A)Brand";v="24.0.0.0"',
    'sec-ch-ua-mobile: ?1',
    'sec-ch-ua-model: "2201117SI"',
    'sec-ch-ua-platform: "Android"',
    'sec-ch-ua-platform-version: "13.0.0"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
    'x-asbd-id: 359341',
    'x-bloks-version-id: f0fd53409d7667526e529854656fe20159af8b76db89f40c333e593b51a2ce10',
    'x-csrftoken: ' . $csrf,
    'x-fb-friendly-name: PolarisProfilePostsQuery',
    'x-fb-lsd: ' . $lsd,
    'x-ig-app-id: 936619743392459',
    'x-root-field-name: xdt_api__v1__feed__user_timeline_graphql_connection',
      ];
  }
  private function getUsername(string $url): ?string {
    $url = trim($url);
    if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
      return null;
    }
    if (!preg_match('#instagram\.com/([^/?]+)#i', $url, $matches)) {
      return null;
    }
    $username = $matches[1];
    if (strlen($username) < 1 || strlen($username) > 30 || !preg_match('/^[a-zA-Z0-9._]+$/', $username)) {
      return null;
    }
    return $username;
  }
  private function getCookieValue(string $name): ?string {
    if (!file_exists($this->cookiesFile)) {
      return null;
    }

    $lines = file($this->cookiesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
      if ($line === '' || str_starts_with($line, '#')) {
        continue;
      }
      $parts = preg_split('/\t/', $line);
      if (count($parts) >= 7 && $parts[5] === $name) {
        return trim($parts[6]);
      }
    }
    return null;
  }
  private function getLSD(): ?string {
    if (file_exists($this->lsdFile) && filesize($this->lsdFile) > 0) {
      $cached = trim(file_get_contents($this->lsdFile));
      $this->log("Using cached LSD: " . substr($cached, 0, 10) . "...");
      return $cached;
    }
    $this->log("Fetching fresh LSD from Instagram");
    $headers = [
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
      'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
      'Accept-Language: en-US,en;q=0.9',
    ];
    $ch = curl_init('https://www.instagram.com/');
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_COOKIEJAR => $this->cookiesFile,
      CURLOPT_COOKIEFILE => $this->cookiesFile,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  //  curl_close($ch);
    if ($httpCode !== 200 || !$response) {
      $this->log("Failed to fetch LSD, HTTP code: $httpCode");
      return null;
    }
    if (preg_match('/"LSD",\[\],{"token":"([^"]+)"}/', $response, $matches)) {
      $lsd = $matches[1];
      file_put_contents($this->lsdFile, $lsd);
      $this->log("Fetched and cached new LSD");
      return $lsd;
    }
    $this->log("LSD token not found in response");
    return null;
  }
  private function durl(string $url, array $headers, array $query, bool $useCookies = false) {
    // Add small delay to avoid rate limiting
    usleep(500000); // 0.5 seconds
    $ch = curl_init($url);
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($query),
    ];
    if ($useCookies) {
        $options[CURLOPT_COOKIEFILE] = $this->cookiesFile;
        $options[CURLOPT_COOKIEJAR]  = $this->cookiesFile;
    }
    curl_setopt_array($ch, $options);
    $res = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($res === false) {
        $error = curl_error($ch);
     //   curl_close($ch);
        $this->log("Curl error: $error");
        throw new Exception("Request failed: $error");
    }
   // curl_close($ch);
    return $res;
}
  private function turl(string $url, array $headers, bool $useCookies = false)
{
    $ch = curl_init($url);
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 30,
    ];
    if ($useCookies) {
        $options[CURLOPT_COOKIEJAR]  = $this->cookiesFile;
        $options[CURLOPT_COOKIEFILE] = $this->cookiesFile;
    }
    curl_setopt_array($ch, $options);
    $res = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($res === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return $this->resp(500, ['error' => $error]);
    }
 #   curl_close($ch);
    if ($status !== 200 || empty($res)) {
        return $this->resp($status, ['error' => 'empty response curl']);
    }
    return $res;
}

private function json(string $arr) {
    $json = json_decode($arr, true);
    $data = $json['data']['xdt_api__v1__feed__user_timeline_graphql_connection']['edges'] ?? [];

    $results = [];
    $all_images = [];
    $all_videos = [];

    foreach ($data as $item) {
        $node = $item['node'];

        $images = [];
        $videos = [];

        if (!empty($node['carousel_media'])) {
            foreach ($node['carousel_media'] as $media) {
                $img = $media['image_versions2']['candidates'][0]['url'] ?? $media['display_uri'] ?? null;
                $vid = $media['video_versions'][0]['url'] ?? null;

                if ($img) {
                    $images[] = $img;
                    $all_images[] = $img;
                }
                if ($vid) {
                    $videos[] = $vid;
                    $all_videos[] = $vid;
                }
            }
        }

        if ($node['media_type'] != 8) {
            $img = $node['image_versions2']['candidates'][0]['url'] ?? $node['display_uri'] ?? null;
            $vid = $node['video_versions'][0]['url'] ?? null;

            if ($img) {
                $images[] = $img;
                $all_images[] = $img;
            }
            if ($vid) {
                $videos[] = $vid;
                $all_videos[] = $vid;
            }
        }

        $results[] = [
            'id' => $node['id'] ?? null,
            'code' => $node['code'] ?? null,
            'caption' => $node['caption']['text'] ?? null,
            'created_at' => $node['caption']['created_at'] ?? $node['taken_at'] ?? null,
            'like_count' => $node['like_count'] ?? 0,
            'comment_count' => $node['comment_count'] ?? 0,
            'images' => $images,
            'videos' => $videos,
        ];
    }
    $main_results = [
        'id' => $data[0]['node']['user']['id']?? null,
        'post_count' => count($results),
        'posts' => $results,
        'all_images' => $all_images,
        'all_videos' => $all_videos,
      ];
    return $main_results;
}
private function profileData(string $id) {
      $variables = json_encode([
        "enable_integrity_filters" => true,
        "id" => $id,
        "render_surface" => "PROFILE",
        "__relay_internal__pv__PolarisCannesGuardianExperienceEnabledrelayprovider" => true,
        "__relay_internal__pv__PolarisCASB976ProfileEnabledrelayprovider" => false,
        "__relay_internal__pv__PolarisRepostsConsumptionEnabledrelayprovider" => false
    ]);

    $postData = [
        'av' => '17841466981815064',
        '__d' => 'www',
        '__user' => '0',
        '__a' => '1',
        '__req' => '1',
        '__hs' => '20499.HYP:instagram_web_pkg.2.1...0',
        'dpr' => '3',
        '__ccg' => 'POOR',
        '__rev' => '1033501349',
        '__comet_req' => '7',
        'fb_api_caller_class' => 'RelayModern',
        'fb_api_req_friendly_name' => 'PolarisProfilePageContentQuery',
        'server_timestamps' => 'true',
        'variables' => $variables,
        'doc_id' => '26762473490008061'
    ];
$headers = [
    'authority: www.instagram.com',
    'accept: */*',
    'accept-language: en-US,en;q=0.9',
    'content-type: application/x-www-form-urlencoded',
    'origin: https://www.instagram.com',
    'referer: https://www.instagram.com/',
    'sec-ch-prefers-color-scheme: dark',
    'sec-ch-ua: "Chromium";v="137", "Not/A)Brand";v="24"',
    'sec-ch-ua-full-version-list: "Chromium";v="137.0.7337.0", "Not/A)Brand";v="24.0.0.0"',
    'sec-ch-ua-mobile: ?1',
    'sec-ch-ua-model: "2201117SI"',
    'sec-ch-ua-platform: "Android"',
    'sec-ch-ua-platform-version: "13.0.0"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
    'x-asbd-id: 359341',
    'x-bloks-version-id: f0fd53409d7667526e529854656fe20159af8b76db89f40c333e593b51a2ce10',
    'x-csrftoken: ' . ($this->getCookieValue('csrftoken') ?: self::DEFAULT_CSRF),
    'x-fb-friendly-name: PolarisProfilePageContentQuery',
    'x-fb-lsd: ' . ($this->getLSD() ?: self::DEFAULT_LSD),
    'x-ig-app-id: 936619743392459',
    'x-root-field-name: xdt_api__v1__profile__profile_page_content',
];
    
  $res = $this->durl("https://www.instagram.com/graphql/query", $headers, $postData, true);
  $data = json_decode($res, true);
  $user = $data['data']['user'] ?? [];

$output = [
    'user' => [
        'id' => $user['id'] ?? null,
        'username' => $user['username'] ?? null,
        'full_name' => $user['full_name'] ?? null,
        'biography' => $user['biography'] ?? null,
        'profile_pic' => $user['profile_pic_url'] ?? null,
        'hd_profile_pic' => $user['hd_profile_pic_url_info']['url'] ?? null,
        'verified' => $user['is_verified'] ?? false,
        'followers' => $user['follower_count'] ?? 0,
        'following' => $user['following_count'] ?? 0,
        'posts' => $user['media_count'] ?? 0,
        'total_clips' => $user['total_clips_count'] ?? 0,
        'account_type' => $user['category'] ?? 'N/A',
        'external_url' => $user['external_url'] ?? null,
        'bio_links' => array_map(function($link) {
            return [
                'title' => $link['title'] ?? null,
                'url' => $link['url'] ?? null,
            ];
        }, $user['bio_links'] ?? []),
        'pronouns' => $user['pronouns'] ?? [],
        'category' => $user['category'] ?? null
    ]
];
return $output;
}
  public function getProfile(string $url) {
    try {
      $results = ['status' => 'error'];
      $username = $this->getUsername($url);

      if ($username === null) {
          $results['code'] = 400;
          $results['message'] = 'Invalid Instagram profile URL';
          return $results;
      }

      $headers = $this->headers($username);
      $query = $this->post($username);
      $data = $this->durl("https://www.instagram.com/graphql/query", $headers, $query, true);
      $images_results = $this->json($data);
      $userId = $images_results['id'] ?? null;

      if (empty($userId) || empty($images_results['posts'])) {
          // Request failed, likely due to invalid tokens, delete cached LSD
          if (file_exists($this->lsdFile)) {
              unlink($this->lsdFile);
          }
          $results['code'] = 500;
          $results['message'] = 'Request failed, tokens may be invalid. Please update cookies.txt';
          return $results;
      }

      if (!empty($userId)) {
        $profileUser = $this->profileData($userId);
        $results['status'] = "success";
        $results['code'] = 200;
        $results['message'] = 'User profile retrieved successfully.';
        $results['data'] = [
          'user' => $profileUser['user'] ?? null,
          'posts' => $images_results['posts'] ?? [],
        ];
        return $results;
      }

      $results['code'] = 404;
      $results['message'] = 'User not found';
      return $results;
    } catch (Exception $e) {
      $this->log("Exception in getProfile: " . $e->getMessage());
      return [
        'status' => 'error',
        'code' => 500,
        'message' => 'Internal server error'
      ];
    }
  }
  private function scrapPostData(string $url) {
    $headers = [
    'User-Agent: Mozilla/5.0 (Linux; Android 11; Mobile)',
    'Accept: text/html',
    'Accept-Language: en-US,en;q=0.9'
];
    if (!$url || !preg_match('~https?://(www\.)?instagram\.com/(p|reel|tv)/~i', $url)) {
    $this->resp(400, ['error' => 'Invalid post url']);
    return;
    }
    $html = $this->turl($url, $headers, true);
    preg_match_all('/<script type="application\/json"[^>]*data-sjs[^>]*>(.*?)<\/script>/s', $html, $m);
    $raw = null;
foreach ($m[1] as $s) {
    if (strpos($s, 'xdt_api__v1__media__shortcode__web_info') !== false) {
        $raw = html_entity_decode($s, ENT_QUOTES);
        break;
    }
}

if (!$raw) $this->resp(404, ['error' => 'media_data_not_found']);

$data = json_decode($raw, true);
if (!$data) $this->resp(500, ['error' => 'json_decode_failed']);

$items =
    $data['require'][0][3][0]['__bbox']['require'][0][3][1]['__bbox']
    ['result']['data']['xdt_api__v1__media__shortcode__web_info']['items'] ?? null;

$item = $items[0] ?? null;
if (!$item) $this->resp(404, ['error' => 'empty_media']);

$typeMap = [1 => 'photo', 2 => 'video', 8 => 'carousel'];

$pickBest = function ($c) {
    usort($c, fn($a, $b) => ($b['width'] ?? 0) <=> ($a['width'] ?? 0));
    return $c[0]['url'] ?? null;
};

$out = [
    'id' => $item['pk'] ?? null,
    'shortcode' => $item['code'] ?? null,
    'media_type' => $item['media_type'] ?? null,
    'type' => $typeMap[$item['media_type']] ?? 'unknown',
    'title' => $item['title'] ?? null,
    'caption' => $item['caption']['text'] ?? null,
    'likes' => $item['like_count'] ?? null,
    'comment_count' => $item['comment_count'] ?? null,
    'visibility' => [
        'is_private' => $item['user']['is_private'] ?? false,
        'is_embeds_disabled' => $item['is_embeds_disabled'] ?? false,
        'is_unpublished' => $item['is_unpublished'] ?? false
    ],
    'profile' => [
        'id' => $item['user']['pk'] ?? null,
        'username' => $item['user']['username'] ?? null,
        'full_name' => $item['user']['full_name'] ?? null,
        'avatar_hd' => $item['user']['hd_profile_pic_url_info']['url'] ?? null,
        'is_verified' => $item['user']['is_verified'] ?? false
    ],
    'photos_hd' => [],
    'videos_hd' => []
];

if (!empty($item['image_versions2']['candidates'])) {
    $out['photos_hd'][] = $pickBest($item['image_versions2']['candidates']);
}

if (!empty($item['video_versions'][0]['url'])) {
    $out['videos_hd'][] = $item['video_versions'][0]['url'];
}

if (!empty($item['carousel_media'])) {
    foreach ($item['carousel_media'] as $m) {
        if (!empty($m['image_versions2']['candidates'])) {
            $out['photos_hd'][] = $pickBest($m['image_versions2']['candidates']);
        }
        if (!empty($m['video_versions'][0]['url'])) {
            $out['videos_hd'][] = $m['video_versions'][0]['url'];
        }
    }
}

$out['photos_hd'] = array_values(array_unique(array_filter($out['photos_hd'])));
$out['videos_hd'] = array_values(array_unique(array_filter($out['videos_hd'])));
return $out;
  }
  public function getPost(string $url) {
    $res = $this->scrapPostData($url);
    if($res['id'] || !empty($res)) {
    return [
        'status'  => 'success',
        'code'    => 200,
        'message' => 'Media retrieved successfully.',
        'data'    => $res
    ];
    } else {
      return [
    'status'  => 'error',
    'code'    => 404,
    'message' => 'Resource not found.'
    ];
    }
  }
}

?>