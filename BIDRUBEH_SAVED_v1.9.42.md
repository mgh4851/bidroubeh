# Bidrubeh Municipality — Saved Work v1.9.42
Date: 2026-09-24 | Theme: bidrubeh-municipality v1.9.42

## 1. Paths
- Local source: `C:\Users\mzh\Desktop\news\bidrubeh-municipality\`
- Shippable ZIP: `C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip` (286916 bytes, prefix `bidrubeh-municipality/`, 27 files)
- Live theme: `/var/www/html/wp-content/themes/bidrubeh-municipality/` (stylesheet=bidrubeh-municipality)
- Docker: `wp-app` (http://localhost:8080), `wp-mysql`, phpmyadmin (:8081). No wp-cli. Deploy via `docker cp` + `docker exec php -l` + `chown www-data`.
- History: `BIDRUBEH_FULL_HISTORY.md` (§59-63 = this session)

## 2. Completed this session
### v1.9.38 — Slider text filter
- `functions.php`: `bd_slider_filter` setting + `bidrubeh_slider_filter_words()` + `bidrubeh_slider_is_blocked()` (mb_stripos) + hooks; `bidrubeh_slider_posts()` filters marked + backfill.
- Verified: آزمون|تست → block 1/0, 5 slides, 0 leaks.

### v1.9.39 — All-Posts slider filter
- `functions.php`: `restrict_manage_posts` dropdown `bd_slider=yes/no` + `pre_get_posts` meta filter + اسلایدر column (✅/—/⚠).
- Verified: mark-32 yes=1/no=14, cleaned after.

### v1.9.40 — Full-width slider
- `front-page.php`: full-bleed (no .wrap), image `full` + `sizes=100vw`, caption inner capped.
- `style.css`: `.bd-slider-full` (`clamp(300px,42vw,560px)`, 560px cap ≥1600px, `overflow:hidden`).

### v1.9.41 — Dynamic slider speed
- `functions.php`: `bd_slider_speed` (default 5, 0=stop, clamp 0–60) + `bidrubeh_slider_speed()`.
- `front-page.php`: `#bdSlider data-speed`; `js/main.js`: `restart()` reads attr.
- Verified: `data-speed=5` live.

### v1.9.42 — Header blends + menu redesign (current)
- `style.css`: `.site-header` + `.header-main` now `var(--bd-bg)`; topline solid `#0a3d2d`; removed home green gradient, 0× `body.home`.
- Menu: white 18px card, dual gold indicators (::before top + ::after underline), hover lift + gradient + shadow, active green gradient.
- Verified live: CSS served, header markup present, php -l clean.

## 3. Entry path (user question)
- Text filter: سفارشی‌سازی → تنظیمات شهرداری → فیلتر متن اسلایدر
- Admin list: نوشته‌ها → dropdown همه — اسلایدر / در اسلایدر / خارج از اسلایدر + column
- Speed: same section → سرعت اسلایدر (ثانیه), تعداد اسلایدها

## 4. How to use / resume
1. `docker ps`, open http://localhost:8080/
2. Edit local → `docker cp <file> wp-app:/var/www/html/wp-content/themes/bidrubeh-municipality/...` → `php -l` → `chown -R www-data:www-data` → hard-refresh.
3. Rebuild ZIP: `python C:\Users\mzh\AppData\Local\Temp\opencode\mkzip.py`
4. Verify: full-bleed slider, `data-speed` attr, filter words, admin dropdown, header bg matches `--bd-bg`.

## 5. Key code refs
- `functions.php`: `BIDRUBEH_VER=1.9.42`, slider filter/speed helpers, admin filter hooks
- `front-page.php:3-4`: `.bd-slider-full` + `#bdSlider data-speed`
- `style.css`: header (54-92), `.bd-slider-full` (118-134), `Version: 1.9.42`
- `js/main.js:33-40`: `data-speed` logic

## 6. Open / next
- Real phone/address/logo, sample posts/thumbs.
- Optional: transition effect choice, pause-on-hover toggle.
