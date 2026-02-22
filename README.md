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
- Cookie-based session handling
- Mobile browser simulation
- Structured error handling
- Scalable folder architecture

---

# 📂 Project Structure

```
instagram-php-scraper/
│
├── public/
│   └── index.php          # API entry point
│
├── src/
│   └── ig.php             # Core scraping class
│
├── storage/
│   └── cookies.txt        # Session cookies
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

Check cURL installation:

```bash
php -m | grep curl
```

---

# ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/monotrixdev/instagram-php-scraper.git
cd instagram-php-scraper
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
  "data": {
    "id": "3734316810046251491",
    "shortcode": "DPS9Vp9k6Hj",
    "media": {
      "type": "video",
      "media_type": 2,
      "caption": null,
      "photos_hd": [],
      "videos_hd": [
        "https://instagram-cdn-video.mp4"
      ]
    },
    "engagement": {
      "likes": 1513441,
      "comment_count": 5171
    },
    "author": {
      "id": "53460637277",
      "username": "username",
      "full_name": "Full Name",
      "avatar_hd": "https://instagram-cdn-avatar.jpg",
      "is_verified": true
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
  "data": {
    "id": "123456789",
    "username": "username",
    "full_name": "Full Name",
    "biography": "User bio",
    "followers": 15000,
    "following": 500,
    "posts": 120,
    "profile_pic": "https://...",
    "hd_profile_pic": "https://...",
    "is_verified": true,
    "posts_data": []
  }
}
```

---

# 🧩 Simple PHP Usage

You can use the scraper class directly inside any PHP file.

## Include the class

```php
require 'src/ig.php';

$ig = new ig();
```

## Get Profile

```php
require 'src/ig.php';

$ig = new ig();
$profile = $ig->getProfile("https://www.instagram.com/username/");

print_r($profile);
```

## Get Post

```php
require 'src/ig.php';

$ig = new ig();
$post = $ig->getPost("https://www.instagram.com/reel/DPS9Vp9k6Hj/");

print_r($post);
```

Simple and clean.

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

# 🧠 How It Works

- Sends mobile browser headers
- Extracts embedded JSON from Instagram pages
- Parses GraphQL response data
- Structures media URLs
- Stores session cookies inside `/storage`
- Returns predictable JSON output

---

# 🛡 Disclaimer

This project is intended for educational and research purposes.

Instagram may update internal APIs at any time.  
Users are responsible for complying with platform terms and policies.

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