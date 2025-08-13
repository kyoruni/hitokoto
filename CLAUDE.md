# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.
必ず日本語で回答してください。

## Project Overview

hitokoto is a personal blog-style system that works without a database.
It is built with PHP 8.3.

- Designed for single-user use; no multi-user functionality required
- Posts are written in Markdown and displayed as HTML
- Images are stored in public/images/YYYY (separated by year)
- Post data is saved as JSON files under data/posts, one file per post (organized into year/month directories)
- Article IDs are sequential numbers
- Separate layouts for top page, list view, and detail view
- Includes a default theme (with future support for theme switching planned)

## Coding standard
- Please write function names and variable names in camelCase.

## Architecture

### Core Structure
- **config.php**: Main configuration file containing site settings, admin password, theme selection, and posts per page limit
- **core/post.php**: Core functionality for retrieving recent post IDs and loading post data from JSON files
- **public/index.php**: Entry point that loads configuration, fetches recent posts, and renders the home theme
- **data/**: JSON-based data storage
  - **posts/**: Hierarchical storage by year/month (e.g., 2025/08/1.json)
  - **timeline/recent.json**: Array of recent post IDs in chronological order
- **views/themes/**: Theme system with pluggable templates

### Data Flow
1. **public/index.php** loads config and gets recent post limit
2. **get_recent_paths()** reads timeline/recent.json for latest post IDs
3. **get_posts()** loads individual post JSON files and validates required fields
4. Theme template is dynamically loaded based on config setting

### Post Data Structure
Posts are stored as JSON files with these required fields:
- `id`: Unique identifier
- `created`: ISO 8601 timestamp with timezone
- `body_html`: Rendered HTML content
- Additional optional fields: `updated`, `body_markdown`

### Theme System
- Themes are stored in **views/themes/{theme_name}/**
- Each theme has a **theme.json** with metadata (name, description, author)
- Template files: **home.php** (main view), **detail.php**, **list.php**
- Currently only home.php is actively used in the application flow

## Development

### Start the development server

```
cd public
php -S localhost:8000
```

### File Organization
- Configuration is centralized in config.php
- Data persistence uses JSON files in hierarchical directory structure
- Templates follow a theme-based architecture for customization

## Planned File Structure

```
hitokoto/
├─ config.php                      … Initial settings (site name, password, etc.)
├─ .htaccess                       … Root settings (URL rewriting, etc.)
│
├─ public/                         … Public directory
│   ├─ index.php                   … Top page (latest posts list)
│   ├─ posts/
│   │   ├─ index.php               … All posts list (with pagination)
│   │   └─ show.php                … Post detail page
│   ├─ admin/                      … Admin panel
│   │   ├─ login.php               … Login form
│   │   ├─ logout.php              … Logout
│   │   ├─ dashboard.php           … Admin dashboard (list, edit, delete posts)
│   │   ├─ editor.php              … New post / edit form
│   │   ├─ upload.php              … Image upload
│   │   └─ settings.php            … Settings (theme selection, etc.)
│   ├─ assets/                     … Common CSS/JS (non-theme-specific)
│   └─ images/                     … Uploaded files
│       └─ 2025/
│           ├─ img001.jpg
│           └─ img002.png
│
├─ views/                          … Display templates
│   └─ themes/
│       └─ default/
│           ├─ home.php            … Layout for top page
│           ├─ list.php            … Layout for list page
│           ├─ detail.php          … Layout for detail page
│           ├─ assets/
│           │   └─ style.css
│           └─ theme.json          … Theme information (name, description, etc.)
│
├─ core/                           … Common logic
│   ├─ auth.php                    … Authentication (password & session management)
│   ├─ post.php                    … Save/retrieve posts (JSON read/write)
│   ├─ indexer.php                 … Timeline index management
│   ├─ markdown.php                … Markdown → HTML conversion
│   ├─ csrf.php                    … CSRF token generation/validation
│   └─ utils.php                   … Common functions
│
└─ data/                           … Stored data (non-public, blocked via .htaccess)
    ├─ last_id.txt                  … Last used post ID (for sequential numbering)
    ├─ timeline/                    … Index for post lists
    │   ├─ index-2025-08.json       … IDs and dates for August 2025
    │   └─ recent.json              … Latest 200 post IDs
    ├─ tags/                        … Tag reverse index (tag → list of IDs)
    │   └─ pokemon.json
    └─ posts/                       … Post content (one file per post)
        └─ 2025/
            └─ 08/
                ├─ 43.json
                └─ 44.json
```

## Important Notes
- Do not create a new branch; work in the current branch.
- Do not make commits; the user will handle them manually.