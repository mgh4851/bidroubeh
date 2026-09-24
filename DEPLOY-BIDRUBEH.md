# Bidrubeh Municipality — Completed + Production Deploy

## Completed (local Docker http://localhost:8080)
- Theme `bidrubeh-municipality` v1.2.0 RTL Persian, shiraz.ir-style, active.
- Homepage: hero+search, auto slider (5 latest, arrows/dots), news as thumbnails, dynamic اطلاعیه‌های مهم, no e-services, no news categories.
- Jalali dates (۱۴۰۵/۰۶/۳۰) via theme filter; IranSans bundled (woff2/woff/ttf) in assets/fonts.
- Menu = منوی شهرداری (Home/About/Contact); ZIP = C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip.
- Plugins cleaned: deleted WooCommerce + Pinterest/Reddit/Snapchat + Hello + Akismet; installed+active wp-parsidate.
- Editor fixed: AllowOverride None→All, .htaccess rewrite restored, permalinks /%postname%/, /wp-json/ 200, draft edit test OK.

## Production deploy steps
1. Requirements: PHP 8.1+, MySQL 8, Apache + mod_rewrite, AllowOverride All for docroot.
2. Fresh WordPress fa_IR; set Settings > Permalinks = Post name; verify /wp-json/ returns 200.
3. Appearance > Themes > Add New > Upload `bidrubeh-municipality.zip` > Activate.
4. Plugins > Add `wp-parsidate` > Install + Activate (replaces theme Jalali fallback safely).
5. Settings > General: title شهرداری بیدروبه, tagline, timezone Tehran, date format Y/m/d.
6. Posts > Categories: ensure slug `etelaeieh` (اطلاعیه‌ها) exists; publish notices there.
7. Appearance > Menus: create/use menu, assign to Primary (Home/About/Contact pages — create About/Contact pages first and point menu there, currently /).
8. Appearance > Customize > تنظیمات شهرداری: phone, email, address, hero title/sub, population, area, hotline 137, notice cat + count.
9. Posts: add news with Featured Images (slider = 5 latest; thumbs need images).
10. Test: /, slider autoplay/arrows, news thumbs, notices links+Jalali dates, search, 404, mobile menu, font loads (assets/fonts/*.woff2 200).
11. Hardening: delete hello/akismet if present, no WooCommerce, enable backups + SSL, set admin strong password.
