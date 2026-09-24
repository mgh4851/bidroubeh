# Bidrubeh Municipality — Project Memory
Resume from here. Docker WordPress + custom theme `bidrubeh-municipality` v1.2.0.

## 1. Environment
- Docker: `wp-app` (wordpress:latest, http://localhost:8080), `wp-mysql` (mysql:8), `phpmyadmin` (:8081)
- Site: fa_IR, RTL, title = شهرداری بیدروبه / پرتال رسمی اطلاع‌رسانی و خدمات الکترونیک شهرداری بیدروبه
- Theme live: `/var/www/html/wp-content/themes/bidrubeh-municipality/` (stylesheet=bidrubeh-municipality)
- Local source: `C:\Users\mzh\Desktop\news\bidrubeh-municipality\`
- Shippable ZIP: `C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip` (root folder `bidrubeh-municipality/`, includes fonts)
- Old theme kept: Point Yekan (point) + ecommerce-hub etc.
- Deploy = `docker cp <local file> wp-app:/var/www/html/wp-content/themes/bidrubeh-municipality/...` then `chown -R www-data:www-data`
- PHP lint in container: `docker exec wp-app php -l <file>` (no wp-cli, no unzip in container; use php ZipArchive via /tmp/*.php scripts)
- Temp scripts live in `C:\Users\mzh\AppData\Local\Temp\opencode\` (*.php) and copied to `wp-app:/tmp/` to run.

## 2. What was built (shiraz.ir-style, RTL Persian)
- `style.css` v1.2.0: green/gold municipal look, hero, slider, news thumbnails, about/bars, info cards, stats band, zones, responsive. Font stack = IRANSans first.
- `functions.php`: title-tag, thumbnails (640x400), custom-logo, 2 menus (primary/footer), 3 sidebars, Customizer section تنظیمات شهرداری (bd_phone, bd_email, bd_address, bd_hero_title, bd_hero_sub, bd_population, bd_area, bd_hotline, bd_notice_cat default etelaeieh, bd_notice_count default 4), Jalali helpers `bidrubeh_g2j/bidrubeh_jdate/bidrubeh_fa_digits` + filters `get_the_date` and `get_comment_date` (frontend only), excerpt_length 28.
- `header.php`: topbar (phone/email), brand, menu `primary`, fallback = Home/News/About/Contact (no services).
- `front-page.php`: hero + search + stats, `#slider` (5 latest posts), `#news` = آخرین اخبار 6-thumb grid + اطلاعیه‌های مهم side card, about, info, stats band, zones. No e-services section.
- `js/main.js`: mobile menu toggle + slider (arrows, dots, 5s autoplay).
- Other: index/archive/search = thumbnail grids, single/page/404/comments/sidebar (sidebar has no category list; latest-news thumbs + 137 box), footer (contact + 2 widget areas + fallback links).
- `assets/fonts/`: IRANSansWeb + Bold (woff2/woff/ttf) from github akiarostami/iransans, loaded via @font-face in style.css.
- `screenshot.png`: placeholder.

## 3. User-requested changes log
1. Initial news setup on Point theme (7 cats, 10 posts, red #c0392b) — superseded.
2. New municipal portal like shiraz.ir, name شهرداری بیدروبه, ZIP deliverable.
3. Homepage: ADD slider, REMOVE e-services, REMOVE news menus/categories, news as thumbnails.
4. Dates Gregorian → Solar Hijri (Jalali + Persian digits, e.g. ۱۴۰۵/۰۶/۳۰), font → IranSans (bundled).
5. اطلاعیه‌های مهم → dynamic (this session).

## 4. Dynamic parts (current behavior)
- Slider `#bdSlider`: `WP_Query(posts_per_page=5)`, image = Featured Image (fallback green gradient). Change = Posts → edit → Set featured image. First 5 latest show.
- Latest news grid: `WP_Query(posts_per_page=6)`, thumbnails same rule.
- Notices اطلاعیه‌های مهم: `bidrubeh_notice_query_args()` → category_name=`bd_notice_cat` (default `etelaeieh`), count=`bd_notice_count` (default 4). Title linked + Jalali date. Falls back to 4 hardcoded lines only if category empty. Manage: Posts > Categories slug `etelaeieh` (اطلاعیه‌ها, currently 4 posts), Customizer > تنظیمات شهرداری to change slug/count.
- Menus: `primary` = منوی شهرداری (Home/About/Contact only, news cats removed). Location mapping: `nav_menu_locations[primary]=31`. If menu reverts, re-set location to municipal menu id.
- Dates: all frontend `get_the_date()` → Jalali via filter; templates also call `bidrubeh_jdate()` directly.

## 5. How to resume / verify
1. `docker ps`, open http://localhost:8080/
2. Check: slider with images, news thumbs, notices list = 4 linked اطلاعیه‌ها with Jalali dates, menu = 3 items, font woff2 200 at `/wp-content/themes/bidrubeh-municipality/assets/fonts/IRANSansWeb.woff2`, style.css ver=1.2.0.
3. Edit local source, `docker cp` file(s) to theme path, `php -l`, `chown www-data`, hard-refresh.
4. Rebuild ZIP: `python C:\Users\mzh\AppData\Local\Temp\opencode\mkzip.py` (zips local folder with prefix `bidrubeh-municipality/` + fonts).
5. Seed notices if needed: `/tmp/seednotice.php`; check: `/tmp/checknotice.php`; menu fix: `/tmp/fixmenu.php`.

## 6. Open / next
- Replace sample posts/thumbs, real phone/address/logo, real About/Contact pages (menu links currently home_url('/')).
- Optional: pin slider to sticky or dedicated slider category instead of latest-5.
