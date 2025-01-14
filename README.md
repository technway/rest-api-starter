<h1>REST API Starter</h1>

A headless WordPress starter theme optimized for REST API functionality only.

---

- [Description](#description)
  - [Key Features:](#key-features)
- [Get Started](#get-started)
  - [Installation](#installation)
  - [Required Plugins](#required-plugins)
  - [Environment Setup](#environment-setup)
    - [Step 1: Install Dependencies](#step-1-install-dependencies)
    - [Step 2: Create the `.env` File](#step-2-create-the-env-file)
    - [Step 3: Configure `wp-config.php`](#step-3-configure-wp-configphp)
- [Usage](#usage)
  - [Example API Endpoints:](#example-api-endpoints)
  - [Authentication Example (Using JWT):](#authentication-example-using-jwt)
- [Features](#features)
- [Documentation](#documentation)
- [License](#license)

---

## Description

**REST API Starter** is a specialized WordPress theme designed to function purely as a headless REST API endpoint. It strips away all frontend rendering and traditional WordPress theme features, focusing solely on providing a clean, efficient REST API interface for your WordPress content.

### Key Features:
- Operates as a headless WordPress installation.
- Removes unnecessary frontend functionality.
- Optimized for REST API performance.
- Redirects all frontend requests to the REST API endpoint.
- Lightweight, secure, and extensible.

**Tested with:**
- **PHP v8.2.4**
- **WordPress v6.7.1**

---

## Get Started

### Installation

1. Clone the repository or download the zip file of this theme.
2. (Optional) Rename the theme folder. And to update all theme references, run the provided rename script:
   ```bash
   php ./scripts/rename-theme.php "NEW Theme Name"
   ```
   This will automatically update all theme references.
3. Upload the theme to the `wp-content/themes/` directory.
4. Activate the theme via the WordPress admin panel: **Appearance > Themes**.
5. Ensure your WordPress installation is properly configured for REST API access.

---

### Required Plugins

Install the following plugin for authentication:

- **[JWT Authentication for WP REST API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/):**
  Required for securing your API endpoints with JWT tokens.

---

### Environment Setup

#### Step 1: Install Dependencies

Run the following command in the theme directory to install Composer dependencies:
```bash
composer install
```

#### Step 2: Create the `.env` File

1. Duplicate `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Replace the `JWT_AUTH_SECRET_KEY` value with a strong random string. You can use [this tool](https://api.wordpress.org/secret-key/1.1/salt/) to generate one.

Example `.env` file:
```env
JWT_AUTH_SECRET_KEY=your-strong-secret-key
JWT_AUTH_CORS_ENABLE=true
```

#### Step 3: Configure `wp-config.php`

Add the following code snippet to your `wp-config.php` file:

```php
/* Add any custom values between this line and the "stop editing" line. */

$theme_path = __DIR__ . '/wp-content/themes/rest-api-starter';

if (file_exists($theme_path . '/vendor/autoload.php')) {
    require_once $theme_path . '/vendor/autoload.php';

    // Load environment variables from .env
    $dotenv = Dotenv\Dotenv::createImmutable($theme_path);
    $dotenv->load();

    // Use an environment variable for the JWT secret key
    define('JWT_AUTH_SECRET_KEY', $_ENV['JWT_AUTH_SECRET_KEY']);
    define('JWT_AUTH_CORS_ENABLE', $_ENV['JWT_AUTH_CORS_ENABLE']);
}

/* That's all, stop editing! Happy publishing. */
```

If this setup doesn’t work, you can hardcode the secret key directly (not recommended for security reasons):

```php
/* Add any custom values between this line and the "stop editing" line. */

define('JWT_AUTH_SECRET_KEY', 'your_secret_key_here');
define('JWT_AUTH_CORS_ENABLE', true);

/* That's all, stop editing! Happy publishing. */
```

---

## Usage

This theme is designed to be used purely as a backend API. Once installed:

1. All frontend requests will be redirected to `/wp-json`.
2. Use the WordPress REST API to interact with your site content.

### Example API Endpoints:
- `GET /wp-json/wp/v2/posts` - Retrieve posts.
- `GET /wp-json/wp/v2/pages` - Retrieve pages.
- `GET /wp-json/wp/v2/media` - Retrieve media items.

### Authentication Example (Using JWT):
1. Obtain a token:
   ```bash
   POST /wp-json/jwt-auth/v1/token
   {
       "username": "your-username",
       "password": "your-password"
   }
   ```
2. Use the token for authenticated requests:
   ```bash
   GET /wp-json/wp/v2/posts
   Authorization: Bearer <your-token>
   ```

---

## Features

- Disabled frontend rendering.
- Removed unnecessary WordPress frontend features.
- Clean and optimized codebase for API-focused development.

---

## Documentation

For detailed WordPress REST API documentation, visit:
[WordPress REST API Handbook](https://developer.wordpress.org/rest-api/)

---

## License

This project is licensed under the GNU General Public License v2 or later - see the [LICENSE](LICENSE) file for details.

---

Made with ❤️ by [Technway](https://technway.biz)