# 📸 Instagram PHP Scraper API - Extract Instagram Data with PHP

![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-active-success)
![Version](https://img.shields.io/badge/version-1.0.0-orange)

**Instagram Scraper PHP** | **Instagram API PHP** | **Extract Instagram Profiles** | **Instagram Data Scraper** | **PHP Instagram Crawler**

A professional, production-ready Instagram scraping API built with pure PHP and cURL. Extract Instagram user profiles, posts, reels, HD media URLs, and engagement metrics in clean JSON format. Perfect for developers building Instagram data extraction tools, social media analytics, or content aggregation platforms.

**Keywords:** Instagram scraper, PHP Instagram API, Instagram data extraction, Instagram profile scraper, Instagram posts scraper, Instagram reels scraper, PHP cURL scraper, Instagram automation, social media scraping.

---

## 🚀 Introduction

The **Instagram PHP Scraper API** is a lightweight, dependency-free solution for scraping Instagram data programmatically. Built for developers who need reliable Instagram data extraction without complex setups or external libraries.

### Why Choose This Instagram Scraper?
- **Pure PHP**: No Composer dependencies, just PHP 8.0+ and cURL
- **Authenticated Scraping**: Uses real browser cookies for reliable data access
- **Structured Data**: Clean JSON responses with all Instagram media details
- **Production Ready**: Error handling, logging, and automatic token management
- **SEO Optimized**: Find this project easily on Google with optimized keywords

### What You Can Scrape
- User profiles (bio, followers, following, verification status)
- Profile pictures (HD versions)
- Posts, reels, and stories
- Carousel media (multiple images/videos)
- Engagement metrics (likes, comments, views)
- Media URLs (HD quality)

---

## ✨ Features

- ✅ **Full Profile Extraction**: Get complete Instagram user data
- ✅ **HD Media URLs**: Retrieve high-quality images and videos
- ✅ **Reel Support**: Extract Instagram reels and stories
- ✅ **Carousel Handling**: Process multi-media posts
- ✅ **Cookie Authentication**: Secure session-based scraping
- ✅ **Mobile Simulation**: Mimics real mobile browser behavior
- ✅ **Error Recovery**: Automatic token refresh and retry logic
- ✅ **REST API**: Clean JSON responses for easy integration
- ✅ **Rate Limiting**: Built-in delays to prevent blocking
- ✅ **Logging**: Debug-friendly error logging
- ✅ **No Dependencies**: Pure PHP implementation

---

## 📋 Requirements

- **PHP 8.0+** with cURL extension enabled
- **Web Server**: Apache/Nginx or XAMPP for local development
- **Instagram Account**: For cookie extraction (see guide below)
- **Storage Permissions**: Write access to `storage/` directory

---

## 🛠️ Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/monotrixdev/instagram-php-scraper.git
   cd instagram-php-scraper
   ```

2. **Set Up Web Server**
   - Place in your web root (e.g., `htdocs/` for XAMPP)
   - Ensure PHP has cURL: `php -m | grep curl`

3. **Extract Cookies** (See detailed guide below)

4. **Test Installation**
   ```bash
   # Visit in browser
   http://localhost/instagram-php-scraper/public/index.php?type=profile&url=https://www.instagram.com/instagram/
   ```

---

## 📖 Usage Guide

### Basic API Usage

```php
// Include the scraper
require_once 'src/Ig.php';

// Initialize with cookies
$scraper = new Ig();

// Scrape a profile
$result = $scraper->getProfile('https://www.instagram.com/username/');
echo json_encode($result, JSON_PRETTY_PRINT);
```

### API Endpoints

#### Get User Profile
```
GET /public/index.php?type=profile&url=https://www.instagram.com/username/
```

**Response:**
```json
{
  "status": "success",
  "code": 200,
  "message": "User profile retrieved successfully.",
  "data": {
    "user": {
      "id": "123456789",
      "username": "instagram",
      "full_name": "Instagram",
      "biography": "Capturing and sharing the world's moments",
      "profile_pic": "https://...",
      "hd_profile_pic": "https://...",
      "verified": true,
      "followers": 500000000,
      "following": 100,
      "posts": 10000,
      "external_url": "https://instagram.com",
      "bio_links": [...]
    },
    "posts": [...]
  }
}
```

#### Get Post Data
```
GET /public/index.php?type=post&url=https://www.instagram.com/p/ABC123/
```

---

## 🍪 How to Extract Instagram Cookies

**Important:** Instagram requires authentication for reliable scraping. Follow these steps to extract valid cookies:

### Method 1: Browser Developer Tools (Recommended)

1. **Open Instagram in Browser**
   - Go to https://www.instagram.com
   - Log in to your account

2. **Open Developer Tools**
   - Press `F12` or right-click → "Inspect"
   - Go to "Network" tab

3. **Refresh the Page**
   - Press `F5` to reload Instagram
   - Look for requests to `instagram.com`

4. **Extract Cookies**
   - Click on any `instagram.com` request
   - Go to "Headers" → "Request Headers"
   - Find the `cookie:` header
   - Copy the entire cookie string

5. **Save to File**
   - Create `storage/cookies.txt`
   - Paste the cookie string
   - Format: One cookie per line (Netscape format preferred)

### Method 2: Browser Extensions

Use extensions like "Cookie-Editor" for Chrome/Firefox:
1. Install extension
2. Visit instagram.com (logged in)
3. Export cookies as Netscape format
4. Save to `storage/cookies.txt`

### Required Cookies
- `sessionid` - Your login session
- `csrftoken` - CSRF protection token
- `ds_user_id` - User ID
- `ig_did` - Device ID

### Cookie Format Example
```
# Netscape HTTP Cookie File
instagram.com	TRUE	/	FALSE	1735689600	sessionid	ABC123...
instagram.com	TRUE	/	FALSE	1735689600	csrftoken	DEF456...
```

**Security Note:** Never share your cookies publicly. Use a dedicated Instagram account for scraping.

---

## 📂 Project Structure

```
instagram-php-scraper/
│
├── public/
│   ├── index.php          # Main API endpoint (REST interface)
│   └── test.php           # Development testing script
│
├── src/
│   └── Ig.php             # Core scraping engine class
│
├── storage/
│   ├── cookies.txt        # Instagram session cookies (required)
│   ├── lsd.dart           # Cached LSD token (auto-generated)
│   └── List.txt           # Change log and updates
│
├── .gitignore             # Git ignore rules
├── LICENSE                # MIT License
└── README.md              # This documentation
```

### File Descriptions
- **`public/index.php`**: REST API entry point handling requests
- **`src/Ig.php`**: Main scraper class with all extraction logic
- **`storage/cookies.txt`**: Your Instagram authentication cookies
- **`storage/lsd.dart`**: Auto-cached Instagram LSD token

---

## 🎯 Use Cases

### Social Media Analytics
Build dashboards tracking Instagram engagement, follower growth, and content performance.

### Content Aggregation
Create platforms that collect and display Instagram content from multiple accounts.

### Research & Monitoring
Academic research on social media trends, influencer analysis, or brand monitoring.

### Marketing Tools
Competitor analysis, hashtag tracking, and campaign performance measurement.

### Personal Projects
Backup your own Instagram data, create personal archives, or build custom viewers.

### Business Applications
- Influencer marketing platforms
- Social media management tools
- Content curation services
- Brand monitoring systems

---

## 🔧 Configuration

### Environment Setup
```php
// In your PHP files
ini_set('display_errors', 0); // Production
error_reporting(E_ALL); // Development
```

### Custom Cookie Path
```php
$scraper = new Ig('/path/to/custom/cookies.txt');
```

### Logging
Logs are written to PHP error log. Check your `php_error.log` for debugging.

---

## 🤝 Contributing

We welcome contributions! Please:

1. Fork the repository
2. Create a feature branch
3. Add tests for new features
4. Submit a pull request

### Development Guidelines
- Follow PSR-12 coding standards
- Add PHPDoc comments
- Test with different Instagram accounts
- Respect rate limits

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

**Permissions:** Commercial use, modification, distribution, private use.

**Limitations:** No liability, no warranty.

---

## 👨‍💻 Author & Support

**Developer:** Sabbir Ahmed
**GitHub:** [@monotrixdev](https://github.com/monotrixdev/)
**Email:** sabbirahmedx999@gmail.com

### Support
- 🐛 **Bug Reports:** [GitHub Issues](https://github.com/monotrixdev/instagram-php-scraper/issues)
- 💡 **Feature Requests:** [GitHub Discussions](https://github.com/monotrixdev/instagram-php-scraper/discussions)
- 📧 **Contact:** sabbirahmedx999@gmail.com for business inquiries or custom development

### SEO Keywords & Discovery
**Search Terms:** instagram scraper php, php instagram api, instagram data extraction, instagram profile scraper, instagram posts scraper, instagram reels scraper, php curl scraper, instagram automation, social media scraping, instagram crawler, extract instagram data, instagram api alternative, php web scraper, instagram downloader, instagram media scraper.

**Author:** Sabbir Ahmed - Instagram Scraper Developer
**Project:** instagram-php-scraper - Professional Instagram Data Extraction Tool

---

## ⚠️ Disclaimer

This tool is for educational and research purposes only. Respect Instagram's Terms of Service and robots.txt. Use responsibly and don't overload their servers. The developer is not responsible for misuse.

**Last Updated:** April 2026

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