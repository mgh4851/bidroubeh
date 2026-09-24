# Bidrubeh Municipality — Saved Work v1.9.7
Date: 2026-09-22 | Theme: bidrubeh-municipality v1.9.7

## 1. Paths
- Local source: `C:\Users\mzh\Desktop\news\bidrubeh-municipality\`
- Shippable ZIP: `C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip` (246883 bytes, prefix `bidrubeh-municipality/`, 23 files)
- Live theme: `/var/www/html/wp-content/themes/bidrubeh-municipality/` (stylesheet=bidrubeh-municipality)
- Docker: `wp-app` (http://localhost:8080), `wp-mysql`, phpmyadmin (:8081). No wp-cli. Deploy via `docker cp` + `docker exec php -l` + `chown www-data`.
- History: `BIDRUBEH_FULL_HISTORY.md` (§24-27 = this session)

## 2. Completed this session
### v1.9.4 — Categories + Latest News to right
- `sidebar.php`: added دسته‌بندی اخبار (`wp_list_categories show_count`) above آخرین اخبار fallback.
- `front-page.php #news`: Categories + Latest News in right column (RTL first col), اطلاعیه‌ها left.
- `style.css`: `.content-grid{1fr 2fr} .sidebar{order:-1}`, `.bd-news-layout{1.6fr 1fr}`.

### v1.9.5 — Removed `bd-news-side`
- Dropped wrapper div. Direct grid children: `.bd-cats-col` / `.bd-latest-col` / `.bd-notices-col` with explicit placement. Mobile resets to auto.
- Verified 0× `bd-news-side` live.

### v1.9.6 — Removed homepage Categories card
- Removed `.card bd-cats-col` from `front-page.php`. Simplified to latest (col1) + notices (col2).
- Verified 0× `bd-cats-col` / دسته‌بندی on live home3.html. Sidebar Categories retained.

### v1.9.7 — Dynamic bars (current)
- `functions.php`: section «نوارهای پیشرفت» + 8 settings (`bd_bar1..4_title` / `bd_bar1..4_pct`, clamp 0-100) + `bidrubeh_bars()`.
- `front-page.php`: hardcoded 4 bars → `foreach(bidrubeh_bars())` with `bidrubeh_fa_digits(p).٪` + `width:p%`.
- Defaults: رضایت از خدمات 88 / پاسخگویی ۱۳۷ 92 / توسعه فضای سبز 76 / خدمات غیرحضوری 84.

## 3. Entry path (user question)
- Bars: WP-Admin → نمایش → سفارشی‌سازی → نوارهای پیشرفت (Appearance → Customize → Progress Bars)
- Other: تنظیمات شهرداری (phone/email/address/population/area/hotline/notice cat+count)

## 4. How to use / resume
1. `docker ps`, open http://localhost:8080/
2. Edit local file → `docker cp <file> wp-app:/var/www/html/wp-content/themes/bidrubeh-municipality/...` → `docker exec wp-app php -l ...` → `chown -R www-data:www-data` → hard-refresh.
3. Rebuild ZIP: `python C:\Users\mzh\AppData\Local\Temp\opencode\mkzip.py`
4. Change bars: Customizer → نوارهای پیشرفت → Publish. Empty title = bar hidden.
5. Verify: homepage bars render 4× `.bar` with Persian ٪; notices/Jalali; slider; mobile stacking.

## 5. Key code refs
- `functions.php`: `bidrubeh_bars()`, `customize_register` (§bidrubeh_bars), `BIDRUBEH_VER=1.9.7`
- `front-page.php:~84-88`: bars loop; `#news`: `.bd-latest-col` + `.bd-notices-col`
- `style.css`: `.bd-news-layout`, `.bar .fill`, `.content-grid>.sidebar{order:-1}`
- `sidebar.php`: Categories + Latest News fallback widgets

## 6. Open / next
- Real phone/address/logo, replace sample posts/thumbs.
- Optional: make bars count configurable, add 5th bar, or reuse `bidrubeh_bars()` in `page-about.php`.
