# Bidrubeh Municipality — Saved Work v1.9.87
Date: 2026-09-24 | Theme: bidrubeh-municipality v1.9.87

## 1. Paths
- Local source: `C:\Users\mzh\Desktop\news\bidrubeh-municipality\` (29 files)
- Shippable ZIP: `C:\Users\mzh\Desktop\news\bidrubeh-municipality.zip` (296304 bytes, prefix `bidrubeh-municipality/`)
- Live theme: `/var/www/html/wp-content/themes/bidrubeh-municipality/` (stylesheet=bidrubeh-municipality, v1.9.87)
- Docker: `wp-app` (http://localhost:8080), `wp-mysql`, phpmyadmin (:8081). No wp-cli. Deploy via `docker cp` + `docker exec php -l` + `chown www-data`.
- History: `BIDRUBEH_FULL_HISTORY.md` (§67–108 = removal/feature batches through footer icons)

## 2. Completed this session (v1.9.47 → v1.9.87)
### Layout / header / footer
- v1.9.47: removed `bd-about-hero` from About/FAQ + CSS (breadcrumb/crumb rules gone).
- v1.9.48: removed `brand-name/sub` (site name confirmed شهرداری بیدروبه, not Market Dynamic).
- v1.9.49–50: Customizer «لوگوی سایت» — `bd_logo/w/h` upload + `bd_sanitize_logo()` URL-vs-ID fix; renders in `.header-main .brand`.
- v1.9.53: centered `main-nav`, added left slogan slot `bd_slogan/w/h` + dashed «شعار سال» placeholder.
- v1.9.56–57: shiraz.ir glass-pill menu remake → reverted height, green links, white dropdown, `منو ▾` → Other Pages → `صفحات دیگر` (v1.9.58) → dropdown removed entirely (v1.9.62), single CSS caret (v1.9.60).
- v1.9.67: tb-links adds «گزارش تصویری» → /#photos + «جاذبه‌های گردشگری» → /#attractions (اخبار → home_url /#news).
- v1.9.68/72: `header-topline` sticky → fixed (top:0, z-100, body padding offsets, admin-bar 32/46px).
- v1.9.73: `#bdToTop` ↑ button (400px show, smooth scroll); v1.9.79 moved to right side.
- v1.9.82: footer titles + 6 links dynamic via «پیوندهای فوتر» (`bidrubeh_footer_links()`, verified-200 defaults).
- v1.9.87 (current): footer icons — `bidrubeh_icon()` += link/bolt/bank; headings `.bd-foot-ico`; contact rows pin/phone/mail; link lists ‹ markers.

### Homepage sections
- Tourism: random-4 rotation on `slider_speed` (v1.9.46), `hidden` CSS fix (v1.9.51), fade (v1.9.52), no-repeat 8+ (v1.9.54); tags-first related + thumbnail cards (v1.9.71/72 batch).
- Order: slider → photos (24px gap, v1.9.55) → swapped to slider → photos → news (v1.9.65/87-batch).
- Info cards centered `.nums` (v1.9.86).

### Comments (v1.9.69–84)
- One pending per IP/device per post; 403 Persian lock message; `pre_comment_approved` forces hold (admins exempt).
- Approval-only visibility (`comments_array` + `pre_get_comments`, admins see holds); lock releases on approve/delete (bd_lock_check fix).
- Reply quote «پاسخ به X:» + 80-char excerpt; ✓✓ ticks removed; bubble tails redrawn as top spikes.
- 10-char minimum (Persian 403, minlength=10); save-info checkbox restored + prefill (cookie verified); Persian setCustomValidity (نام/ایمیل/متن); دیدگاه‌ها/بازتاب‌ها admin columns; new posts default closed.

### Contact Us (v1.9.81–85)
- 11-digit `09` strict validation; IP/device block alongside phone (`bidruneh_unread_by_ip`, by=phone|ip); success banner only while unread; 10-char minimum; per-field Persian errors + custom-validity JS.

### Socials
- v1.9.59: WhatsApp/Telegram/Instagram (svg, png→svg fallback, wa.me intl handling) via «شبکه‌های اجتماعی».

## 3. Entry path (user question)
- Logo/slogan: سفارشی‌سازی → لوگوی سایت → تصویر/پهنا/ارتفاع لوگو + شعار سال
- Speed/rotation: تنظیمات شهرداری → سرعت اسلایدر (ثانیه, 0=stop)
- Footer: پیوندهای فوتر → titles + 6 links; شبکه‌های اجتماعی → 6 networks
- Posts: نوشته‌ها → اسلایدر/دیدگاه‌ها/بازتاب‌ها columns; new posts closed by default
- Comments: Dashboard → Comments (approve/delete releases lock); Contact messages: پیام‌های تماس (open = read)

## 4. How to use / resume
1. `docker ps`, open http://localhost:8080/ (`?nocache=N` if `?ver=` lags one deploy).
2. Edit local → `docker cp <file> wp-app:/var/www/html/wp-content/themes/bidrubeh-municipality/...` → `php -l` → `chown -R www-data:www-data` → hard-refresh.
3. Rebuild ZIP: `python C:\Users\mzh\AppData\Local\Temp\opencode\mkzip.py`
4. Log to `BIDRUBEH_FULL_HISTORY.md`; save snapshots as `BIDRUBEH_SAVED_vX.md`.
5. Verify from host port 8080 (in-container `curl localhost/` returns 301/empty).

## 5. Key code refs
- `functions.php`: `BIDRUBEH_VER=1.9.87`; `bidrubeh_header_occasion()` (date+event only); comment FP/IP/block/approve/visibility/lock-fix; contact fp/phone/ip/unread/send/lock/sent-only; footer links; related tags→cats→latest; socials + whatsapp; slider/text-filter/speed; `bidrubeh_icon()` (+mail/pin/chart/link/bolt/bank).
- `header.php:13,17-34`: tb-links (4 anchors), brand logo, slogan slot.
- `footer.php`: icon badges + contact rows + link lists + `#bdToTop`.
- `front-page.php`: slider → photos → news → attractions → about/bars → info → stats → zones → FAQ.
- `comments.php`: approved-only list + closed/blocked/form states + consent checkbox + Persian validity JS.
- `single.php:12`: اخبار مرتبط thumbnail cards.
- `style.css`: header/topline fixed, shiraz-pill menu (green), slogan, tour fade, related cards, foot icons, to-top, comments bg/spacing/tails, `Version: 1.9.87`.
- `js/main.js`: slider init, tour no-repeat + fade, to-top show/scroll.

## 6. Open / next
- Real phone/address/logo, sample posts/thumbs.
- Test contact/contact-ajax on public IP (current Docker IP 172.18.0.1 shared).
- Optional: photo posts (visual pool = 1, scales to 4), more tourism posts (overlap-free rotation needs 8+).
