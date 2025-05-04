# WP API Bridge

**Contributors:** Temi Kolawole  
**Tags:** wordpress, api, rest, caching, wpml, polylang, headless, custom post types, acf, yoast  
**Requires at least:** WordPress 5.0  
**Tested up to:** WordPress 5.8  
**Requires PHP:** 7.0+  
**Stable tag:** 1.0  

---

## Description

**WP API Bridge** is a WordPress plugin that exposes a set of REST API endpoints, allowing external frontend applications (such as React, Vue, Angular, static site generators, or mobile apps) to consume WordPress content.

This plugin is ideal for headless WordPress setups, where WordPress serves purely as a backend content management system (CMS), while the frontend is powered by modern JavaScript frameworks or mobile applications.

---

## Features

- Exposes WordPress content via REST API:
  - Posts
  - Pages
  - Custom Post Types (CPTs)
  - Taxonomies
  - Menus
- Caching for faster API responses and better performance
- Supports [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/) data
- Supports [Yoast SEO](https://yoast.com/wordpress/plugins/seo/) metadata
- Multilingual content support via [WPML](https://wpml.org/) and [Polylang](https://polylang.pro/)

---

## Installation

1. Upload the plugin to your WordPress site:  
   `wp-content/plugins/wp-api-bridge/`

2. Activate the plugin from your WordPress admin dashboard.

3. The following REST API endpoints will become available:

| Endpoint | Description |
|----------|-------------|
| `/wp-json/wp-api-bridge/v1/posts` | Get all posts |
| `/wp-json/wp-api-bridge/v1/post/{slug}` | Get a single post by slug |
| `/wp-json/wp-api-bridge/v1/pages` | Get all pages |
| `/wp-json/wp-api-bridge/v1/page/{slug}` | Get a single page by slug |
| `/wp-json/wp-api-bridge/v1/cpt/{custom_post_type}` | Get entries for a custom post type |
| `/wp-json/wp-api-bridge/v1/taxonomies` | Get all taxonomies |
| `/wp-json/wp-api-bridge/v1/menus` | Get registered menus |

---

## Changelog

### 1.0
- Initial release.
- Exposes REST API endpoints for posts, pages, custom post types, taxonomies, and menus.
- Caching support for improved performance.
- ACF and Yoast SEO metadata support.
- Multilingual support with WPML and Polylang.

---

## License

GPLv2 or later. See [LICENSE](LICENSE) for details.
