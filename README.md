# 📸 Instagram PHP Scraper API

![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-active-success)

A structured, production-oriented Instagram scraping API built using pure PHP and cURL.

This project allows developers to extract structured Instagram data including profiles, posts, reels, HD media URLs, and engagement metrics — all returned in clean JSON format.

No external libraries required.

---

# ✨ Features

- Full Instagram user profile extraction
- HD profile picture retrieval
- Post image & video extraction
- Reel support
- Carousel media support
- Clean REST-style JSON responses
- Cookie-based authenticated session handling
- Mobile browser simulation
- Structured error handling
- Scalable folder architecture
- Lightweight and dependency-free

---

# 📂 Project Structure

```
instagram-php-scraper/
│
├── public/
│   └── index.php          # API entry point
│
├── src/
│   └── Ig.php             # Core scraping class
│
├── storage/
│   └── cookies.txt        # Required session cookies
│
├── .gitignore
└── README.md
```

Clean separation between routing and business logic.

---

# 📦 Requirements

- PHP 8.0+
- cURL enabled
- OpenSSL enabled
- Valid Instagram session cookies

Check cURL installation:

```bash
php -m | grep curl
```

---

# 🔐 Session & Authentication (Important)

This scraper requires a valid logged-in Instagram browser session.

You must export your Instagram cookies from a logged-in browser and place them inside:

```
storage/cookies.txt
```

Without valid cookies:

- Instagram may return login HTML instead of JSON
- Requests may fail with 403 errors
- Media extraction may break
- Empty or invalid responses may be returned

Cookies may expire. Refresh them if requests start failing.

---

# ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/monotrixdev/instagram-php-scraper.git
cd instagram-php-scraper
```

Create storage folder if not exists:

```bash
mkdir storage
touch storage/cookies.txt
```

Start local server:

```bash
php -S localhost:8004 -t public
```

---

# 📡 API Usage

Base URL:

```
http://localhost:8004/?type=post&url=INSTAGRAM_URL
```

Supported types:

- `type=post`
- `type=profile`

---

# 🖼 Example: Fetch Post

Request:

```
http://localhost:8004/?type=post&url=https://www.instagram.com/reel/DPS9Vp9k6Hj/
```

---

# ✅ Example Success Response

```json
{
  "status": "success",
  "code": 200,
  "message": "Post data retrieved successfully.",
  "data": {
    "post": {
      "id": "1111111111111111111",
      "shortcode": "EXAMPLE123",
      "media_type": 8,
      "type": "carousel",
      "title": null,
      "caption": "Sample caption for documentation purposes.",
      "created_at": 1700000000,
      "likes_count": 120,
      "comments_count": 15,
      "visibility": {
        "is_private": false,
        "is_embeds_disabled": false,
        "is_unpublished": false
      }
    },
    "author": {
      "id": "2222222222222222222",
      "username": "example_user",
      "full_name": "Example User",
      "avatar_url": "https://example.com/avatar.jpg",
      "is_verified": false
    },
    "media": {
      "images": [
        "https://example.com/photo1.jpg",
        "https://example.com/photo2.jpg",
        "https://example.com/photo3.jpg"
      ],
      "videos": []
    }
  }
}
```

---

# 👤 Example: Fetch Profile

Request:

```
http://localhost:8004/?type=profile&url=https://www.instagram.com/username/
```

---

# 📊 Profile Response Example

```json
{
  "status": "success",
  "code": 200,
  "message": "User profile retrieved successfully.",
  "data": {
    "user": {
      "id": "1234567890",
      "username": "example_user",
      "full_name": "Example User",
      "biography": "This is a sample biography for documentation purposes.",
      "profile_picture_url": "https://example.com/profile.jpg",
      "is_verified": false,
      "followers_count": 10000,
      "following_count": 150,
      "posts_count": 25
    },
    "posts": [
      {
        "id": "9876543210_1234567890",
        "shortcode": "ABC123XYZ",
        "caption": "Sample caption for documentation.",
        "created_at": 1700000000,
        "likes_count": 500,
        "comments_count": 25,
        "media": {
          "images": [
            "https://example.com/image1.jpg",
            "https://example.com/image2.jpg"
          ],
          "videos": [
            "https://example.com/video1.mp4"
          ]
        }
      }
    ]
  }
}
```

---

# 🧩 Simple PHP Usage (Cookies Required)

Always initialize with cookie path:

```php
require 'src/Ig.php';

$ig = new Ig(__DIR__ . '/storage/cookies.txt');
```

---

## Get Profile

```php
require 'src/Ig.php';

$ig = new Ig(__DIR__ . '/storage/cookies.txt');
$profile = $ig->getProfile("https://www.instagram.com/username/");

print_r($profile);
```

---

## Get Post

```php
require 'src/Ig.php';

$ig = new Ig(__DIR__ . '/storage/cookies.txt');
$post = $ig->getPost("https://www.instagram.com/reel/DPS9Vp9k6Hj/");

print_r($post);
```

Do not use:

```php
$ig = new Ig();
```

The scraper depends on authenticated session handling.

---

# 📡 API Response Format

All responses follow a consistent structure.

Success:

```json
{
  "status": "success",
  "code": 200,
  "data": {}
}
```

Error:

```json
{
  "status": "error",
  "code": 400,
  "message": "Invalid Instagram URL"
}
```

Standard HTTP status codes are used.

---

# ⚠️ Common Issues

• Empty JSON response  
→ Usually caused by expired or invalid cookies.

• Redirect to login page  
→ Session not valid.

• 403 Forbidden  
→ IP blocked or cookies expired.

• Slow response  
→ Consider caching or proxy rotation.

Always verify:

- cookies.txt exists
- File permissions allow read/write
- cURL is enabled
- Session is still active

---

# 🧠 How It Works

- Uses authenticated Instagram session cookies
- Sends mobile browser headers
- Extracts embedded JSON from Instagram pages
- Parses GraphQL response data
- Structures media URLs
- Stores session cookies inside `/storage`
- Returns predictable JSON output

---

# 🚀 Why Use This API?

- No third-party SDK dependencies
- Pure PHP implementation
- Lightweight and fast
- Easy integration into existing backend systems
- Structured JSON for frontend apps
- Production-oriented architecture

---

# ⚡ Production Recommendations

For scaling and deployment:

- Enable OPcache
- Add caching layer (Redis or file-based)
- Implement API key authentication
- Add rate limiting
- Add request logging
- Use proxy rotation for heavy usage

---

# 🛡 Disclaimer

This project is intended for educational and research purposes.

Instagram may update internal APIs at any time.  
Users are responsible for complying with platform terms and policies.

---

# 📜 License

MIT License

---

<div align="center">
<img src="https://capsule-render.vercel.app/api?type=rect&color=0:111111,100:1f1f1f&height=120&section=footer&text=Instagram%20PHP%20Scraper&fontColor=ffffff&fontSize=24" />
</div>

---

<div align="center">
<img src="https://capsule-render.vercel.app/api?type=waving&color=0:1e1e1e,100:2c2c2c&height=160&section=footer&text=Sabbir%20Ahmed&fontSize=32&fontColor=ffffff&animation=fadeIn" />
</div>

---

## 👨‍💻 Author

<div align="center">

### Sabbir Ahmed  
Backend Developer · PHP Engineer · API Architect

<img src="https://img.shields.io/badge/PHP-Expert-777bb4?style=for-the-badge&logo=php&logoColor=white" />
<img src="https://img.shields.io/badge/Backend-Architecture-black?style=for-the-badge" />
<img src="https://img.shields.io/badge/API-Development-4CAF50?style=for-the-badge" />

<br>

<a href="https://t.me/what_t_fuck_9">
  <img src="https://img.shields.io/badge/Telegram-Connect-0088cc?style=for-the-badge&logo=telegram&logoColor=white">
</a>

</div>

---

<div align="center">
<sub>
This project is independently designed and maintained with a focus on clean architecture, structured API responses, and production-ready backend development.
</sub>
</div>