# Bidrubeh Municipality — Saved Work v1.9.41
Date: 2026-09-24 | Theme: bidrubeh-municipality v1.9.41

## 1. Paths
- Local source: `C:\Users\mzh\Desktop\news\bidrubeh-municipality\`
- Shippable ZIP: `C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip` (286956 bytes, prefix `bidrubeh-municipality/`, 27 files)
- Live theme: `/var/www/html/wp-content/themes/bidrubeh-municipality/` (stylesheet=bidrubeh-municipality)
- Docker: `wp-app` (http://localhost:8080), `wp-mysql`, phpmyadmin (:8081). No wp-cli. Deploy via `docker cp` + `docker exec php -l` + `chown www-data`.
- History: `BIDRUBEH_FULL_HISTORY.md` (§59-62 = this session)

## 2. Completed this session
### v1.9.38 — Slider text filter
- `functions.php`: `bd_slider_filter` setting + `bidrubeh_slider_filter_words()` + `bidrubeh_slider_is_blocked()` (mb_stripos) + hooks `bidrubeh_slider_filter_words` / `bidrubeh_slider_is_blocked`; `bidrubeh_slider_posts()` over-fetches and filters marked + backfill.
- Verified: آزمون|تست → block 1/0, 5 slides, 0 leaks.

### v1.9.39 — All-Posts slider filter
- `functions.php`: `restrict_manage_posts` dropdown `bd_slider=yes/no` + `pre_get_posts` meta filter + `manage_post_posts_columns` اسلایدر column (✅/—/⚠ مسدود با فیلتر متن).
- Verified: hooks 1/1, mark-32 yes=1/no=14, cleaned after.

### v1.9.40 — Full-width slider
- `front-page.php`: slider section full-bleed (no .wrap), image `large`→`full` + `sizes=100vw`, caption inner capped.
- `style.css`: `.bd-slider-full` (square edges, `clamp(300px,42vw,560px)` height, arrows/dots inset via `max()`, hard 560px cap ≥1600px, `overflow:hidden`).
- Verified: markup + CSS live.

### v1.9.41 — Dynamic slider speed (current)
- `functions.php`: `bd_slider_speed` (default 5, 0=stop, clamp 0–60, FA-digit convert) + `bidrubeh_slider_speed()` + hook.
- `front-page.php`: `#bdSlider data-speed`; `js/main.js`: `restart()` reads `data-speed`.
- Verified live: `data-speed=5` served, JS reads attr, php -l clean.

## 3. Entry path (user question)
- Text filter: WP-Admin → نمایش → سفارشی‌سازی → تنظیمات شهرداری → فیلتر متن اسلایدر (comma words, empty=off)
- Admin list: نوشته‌ها → All Posts → top dropdown همه — اسلایدر / در اسلایدر / خارج از اسلایدر + اسلایدر column
- Speed: سفارشی‌سازی → تنظیمات شهرداری → سرعت اسلایدر (ثانیه) (0=stop)
- Count: same section → تعداد اسلایدها

## 4. How to use / resume
1. `docker ps`, open http://localhost:8080/
2. Edit local file → `docker cp <file> wp-app:/var/www/html/wp-content/themes/bidrubeh-municipality/...` → `docker exec wp-app php -l ...` → `chown -R www-data:www-data` → hard-refresh.
3. Rebuild ZIP: `python C:\Users\mzh\AppData\Local\Temp\opencode\mkzip.py`
4. Verify: homepage slider full-bleed, `data-speed` attr, filter words block, admin dropdown filters list.
5. Live Customizer values: `bd_slider_speed=10? check via php -r get_theme_mod` (currently defaults: speed 5, filter empty).

## 5. Key code refs
- `functions.php`: `BIDRUBEH_VER=1.9.41`, `bidrubeh_slider_filter_words()`, `bidrubeh_slider_is_blocked()`, `bidrubeh_slider_posts()`, `bidrubeh_slider_speed()`, `restrict_manage_posts`/`pre_get_posts` bd_slider, slider column
- `front-page.php:3-4`: `.bd-slider-full` + `#bdSlider data-speed`
- `style.css`: `.bd-slider-full*` (118-134), `Version: 1.9.41`
- `js/main.js:33-40`: `data-speed` restart logic

## 6. Open / next
- Real phone/address/logo, replace sample posts/thumbs.
- Optional: slider transition effect choice (fade/slide), pause-on-hover toggle.
