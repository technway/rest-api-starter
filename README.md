<div align="center">

![rest-api-starter-logo](https://i.ibb.co/mFwHYYR/rest-api-starter-logo.png)

<h1>REST API Starter</h1>

A lightweight WordPress theme designed to function purely as a **headless REST API** endpoint. It strips away all frontend rendering and traditional WordPress theme features, focusing solely on providing a clean, efficient REST API interface for your WordPress content.

[![WordPress](https://img.shields.io/badge/WordPress-6.7-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.2+-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-GPL--2.0-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

</div>

---

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
  - [API Testing](#api-testing)
- [Documentation](#documentation)
- [License](#license)
- [Support](#support)
- [Credits](#credits)


### Key Features:
- Lightweight WordPress theme.
- Clean and optimized codebase for API-focused development.
- Removed unnecessary WordPress frontend features.
- Disabled frontend rendering.
- Redirects all frontend requests to the REST API endpoint.

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

---

### Required Plugins

If your API requires authentication, install the following plugin:

- **[JWT Authentication for WP REST API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/)**:
  This plugin secures your API endpoints with JWT tokens.

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

### API Testing
The `testing-api` directory contains ready-to-use HTTP request files for testing the API endpoints. These tests are designed to work with VS Code's REST Client extension.

For detailed information about the API tests, see [testing-api.md](testing-api/testing-api.md).

---

## Documentation

For detailed WordPress REST API documentation, visit:
[WordPress REST API Handbook](https://developer.wordpress.org/rest-api/)

---

## License
This theme is licensed under the GNU General Public License v2 or later (GPL-2.0). See the [LICENSE](LICENSE) file for details.

---

## Support
For support and contributions, visit the [Technway GitHub repository](https://github.com/technway/graphql-starter).

---

## Credits
The Rest API Starter Theme is built with ❤️ and maintained by **[Technway](https://technway.biz)**.

Contributions are welcome! Feel free to fork the repository and submit pull requests.
