# Bidrubeh Municipality — Saved Work v1.9.89
Date: 2026-09-24 | Theme: bidrubeh-municipality v1.9.89

## 1. Paths
- Local source: `C:\Users\mzh\Desktop\news\bidrubeh-municipality\`
- Shippable ZIP: `C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip` (295124 bytes, prefix `bidrubeh-municipality/`)
- Live theme: `/var/www/html/wp-content/themes/bidrubeh-municipality/` (stylesheet=bidrubeh-municipality, v1.9.89)
- Docker: `wp-app` (http://localhost:8080), `wp-mysql`, phpmyadmin (:8081). No wp-cli. Deploy via `docker cp` + `docker exec php -l` + `chown www-data`.
- History: `BIDRUBEH_FULL_HISTORY.md` (§109–110 = mobile order + rename batches)

## 2. Completed this session
### v1.9.88 — Mobile: loop-card above categories
- Root cause: desktop `.content-grid>.sidebar{order:-1}` put sidebar first on mobile single-column.
- `style.css @media(max-width:960px)`: `.content-grid>div{order:1}` + `.content-grid>.sidebar{order:2}` — news details above sidebar; desktop RTL unchanged.
- Verified live: order rule served. ZIP 295044 bytes.

### v1.9.89 — Comments at bottom on mobile + Category rename (current)
- `single.php`: `comments_template()` moved out of `article.loop-card` into `.bd-single-comments` grid child; grid `bd-single-grid` added.
- `style.css`: desktop `.bd-single-grid` explicit placement (sidebar col1, main col2-row1, comments col2-row2); mobile orders main(1) → sidebar(2) → comments(3).
- Category label: fallback `دسته‌بندی اخبار` → `دسته‌بندی` in `sidebar.php`; live `widget_categories[2].title` renamed via `/tmp/fixcat89.php` (widget stored in DB).
- Verified live: comments wrapper + order rule served, widget title دسته‌بندی, php -l clean. ZIP 295124 bytes.

## 3. Entry path (user question)
- Mobile order: resize ≤960px on archive/single/index/search/page — main card first, sidebar second, comments last (single only)
- Category label: sidebar widget title reads «دسته‌بندی»; to edit go Appearance > Widgets > Categories title
- Note: live Categories widget comes from DB `widget_categories`, not `sidebar.php` fallback — rename needs DB update if widget reset

## 4. How to use / resume
1. `docker ps`, open http://localhost:8080/ (`?nocache=N` if `?ver=` lags one deploy).
2. Edit local → `docker cp <file> wp-app:/var/www/html/wp-content/themes/bidrubeh-municipality/...` → `php -l` → `chown -R www-data:www-data` → hard-refresh.
3. Rebuild ZIP: `.\scripts\build-theme.ps1` (validates header + archive layout).
4. Log to `BIDRUBEH_FULL_HISTORY.md`; save snapshots as `BIDRUBEH_SAVED_vX.md`.
5. Verify from host port 8080 (in-container `curl localhost/` returns 301/empty).

## 5. Key code refs
- `functions.php`: `BIDRUBEH_VER=1.9.89`
- `single.php:2,18`: `.bd-single-grid` + `.bd-single-comments` wrapper
- `sidebar.php:3`: fallback title `دسته‌بندی`
- `style.css`: `Version: 1.9.89`; `.bd-single-grid` desktop rules (~246-248); mobile orders (~412-417)
- `README.md` + `LIARA-DEPLOY.md`: version refs 1.9.89

## 6. Open / next
- Real phone/address/logo, sample posts/thumbs.
- Test contact/contact-ajax on public IP (Docker IP shared).
- Optional: photo posts, more tourism posts (overlap-free rotation needs 8+).

(End of file - total 6 sections)
