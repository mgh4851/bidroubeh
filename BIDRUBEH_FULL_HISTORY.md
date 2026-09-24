# Bidrubeh Municipality — Full Task History & Production Package
Date: 2026-09-24 | Theme v1.9.26 | Local: http://localhost:8080 | Source: C:\Users\mzh\Desktop\news\bidrubeh-municipality\

## 0. Environment baseline
- Docker: wp-app (wordpress:7.0 / PHP 8.3), wp-mysql (mysql:8.0), phpmyadmin (:8081)
- Site locale fa_IR, RTL, title شهرداری بیدروبه
- No wp-cli, no unzip in container. Used `docker cp` + `docker exec php /tmp/*.php`. Temp scripts in C:\Users\mzh\AppData\Local\Temp\opencode\
- Live: theme v1.9.26, plugin wp-parsidate active only, permalink /%postname%/, .htaccess rewrite OK, AllowOverride All, timezone Asia/Tehran

## 1. Initial Point news theme (superseded)
- Inspected pointYekan-hamyarwp.zip (Point 2.1.0, RTL+fa_IR+Yekan).
- Activated `point`, set blogname پایگاه خبری پارسی, 7 cats (siasi,eghtesadi,varzeshi,fanavari,farhangi,ejtemaei,vizheh), 10 sample posts, menus, red #c0392b, thumbs via GD, trending/feature mods.
- Replaced later by municipal theme.

## 2. Municipal theme v1.0.0 (shiraz.ir-like)
- Fetched https://shiraz.ir/ structure: hero, e-services grid (8), news/notices, about+bars, info cards, stats band, zones.
- Built fresh theme `bidrubeh-municipality`: style.css, functions.php, header/footer, front-page, index/single/page/archive/search/404/sidebar/comments, js/main.js, screenshot.png.
- Menus: primary/footer; sidebars: sidebar-1, footer-1/2; Customizer تنظیمات شهرداری (phone,email,address,hero_title,hero_sub,population,area,hotline).
- Packaged ZIP with prefix `bidrubeh-municipality/` via mkzip.py. Installed via php ZipArchive to /var/www/html/wp-content/themes/bidrubeh-municipality/. Activated, seeded municipal cats (akhbar,etelaeieh,khadamat,omran,farhangi) + 6 posts, menu منوی شهرداری.

## 3. Homepage rework (slider/thumbs, remove services+cats)
- Removed #services section entirely.
- Added #slider: WP_Query 5 latest, arrows/dots, 5s autoplay in js/main.js, CSS .bd-slider.
- News → .news-grid 3-col thumbnails (front-page, index, archive, search, sidebar).
- Removed category displays: header fallback → Home/News/About/Contact; footer fallback; stripped category menu items; sidebar no wp_list_categories; single/index meta no the_category.
- Deployed, rebuilt ZIP.

## 4. Jalali + IranSans v1.1.0
- Added bidrubeh_g2j(), bidrubeh_fa_digits(), bidrubeh_jdate(), filters get_the_date/get_comment_date (frontend only).
- Downloaded IRANSansWeb + Bold woff2/woff/ttf from github akiarostami/iransans → assets/fonts/, @font-face in style.css, font-family IRANSans first.
- Verified dates ۱۴۰۵/۰۶/۳۰, font 200. Rebuilt ZIP.

## 5. Dynamic notices v1.2.0
- Replaced hardcoded اطلاعیه‌های مهم with WP_Query bidrubeh_notice_query_args() (cat=bd_notice_cat default etelaeieh, count=bd_notice_count default 4).
- Customizer added bd_notice_cat + bd_notice_count. Fallback static list if empty. Seeded 2 extra notices → 4 total. Rebuilt ZIP.

## 6. Notes file
- Created BIDRUBEH_NOTES.md resume doc (later merged into this file).

## 7. Plugin audit + editor fix
- Found active: woocommerce, pinterest/reddit/snapchat-for-woocommerce; inactive: akismet, hello.
- Deactivated all, rm -rf plugin dirs (WP deleter needs FTP). Cleaned Woo pages/options. Installed wp-parsidate.latest-stable.zip via manual download → /tmp → ZipArchive → activate_plugin().
- Editor root cause: .htaccess empty + apache AllowOverride None → /wp-json/ 404 → Gutenberg fail. Fixed: sed AllowOverride All, graceful reload, wrote WP rewrite block to .htaccess, permalinks /%postname%/. /wp-json/ 200, draft create/edit test OK. Created DEPLOY-BIDRUBEH.md (later merged into section 23).

## 8. Slider photo (post 74)
- addphoto.php: GD 1200x675 green/gold cover → media_handle_sideload → set_post_thumbnail(74, att) → bidrubeh-cover-74.jpg. Verified in slider + grid HTML.

## 9. WhatsApp comments v1.3.0–v1.3.4
- v1.3.0: bidrubeh_comment() callback, .bd-bubble white/green, form grid, gradient submit.
- Fixed double-Jalali (theme+parsidate): bidrubeh_parsidate_active() via active_plugins, theme defers, added bidrubeh_pdate() wrapper, replaced get_the_date calls.
- v1.3.1: Persian counts (دیدگاه‌ها (۲), آخرین اخبار (۱۸)), bidirectional comments_label, fixed invalid ol>div → proper li.bd-comment-item, Persian digits all dates.
- v1.3.2–v1.3.4: restored soft chat bg #f4f0e8+dots, rebuilt bubbles (.bd-msg rows, tails, ticks, admin/پاسخ badges, time inside), removed avatars, fixed alt='Array' bug, wp_list_categories filter → Persian digits, mobile rules.
- Cleaned test comments. Rebuilt ZIP each time.

## 10. Final production package v1.3.4
- Theme v1.3.4, 22 files incl. fonts. ZIP 239115 bytes.
- Deploy: fresh WP fa_IR → Post-name permalinks → upload ZIP → activate → install wp-parsidate → General/Timezone Tehran → ensure etelaeieh cat → About/Contact pages + Primary menu → Customize → posts with Featured Images → test all.

## 11. Solar calendar v1.4.0 (later removed in v1.5.0)
- Added bidrubeh_j2g(), bidrubeh_j_is_leap(), bidrubeh_j_days_in_month(), bidrubeh_calendar_events() (21 مناسبت‌ها), bidrubeh_render_calendar() using Asia/Tehran DateTime.
- Verified: شهریور ۱۴۰۵, today ۳۱ highlighted. Rebuilt ZIP 241215 bytes.

## 12. Header occasion + Contact page v1.5.0
- Removed full calendar grid; kept compact header badges bidrubeh_header_occasion (today date + event) in topbar.
- Created Contact page /contact-us/ (ID 110) with [bidrubeh_contact] form (name/phone/message, mails admin, saves private bidrubeh_msg CPT). Linked in primary (31) + footer (26) menus.
- Verified header badge + form render. Rebuilt ZIP 240973 bytes.

## 13. Dynamic new-pages dropdown v1.6.0
- bidrubeh_new_pages() (published pages NOT in primary menu, matched by ID + URL) + wp_nav_menu_items filter appending dropdown with hover/focus + touch toggle (js/main.js).
- Dynamic header fallback bidrubeh_menu_fallback(). Styled .sub-menu + mobile rules.
- Verified: تست/برگه نمونه under dropdown; contact-us excluded. Rebuilt ZIP 241661 bytes.

## 14. Contact UX v1.7.0 — premium button, one-at-a-time, auto-clear
- Styled .bd-send-btn (gradient, shine, hover lift, disabled). .bd-sent-ok + .bd-lock-box cards + pop animation.
- One pending message per visitor (fingerprint user ID or IP+UA); admin opening message auto-marks bd_read=1 + read_at (meta boxes + ✅/⏳ column).
- Form clears via redirect ?bd_sent=1. Verified SEND→BLOCK→UNLOCK. Rebuilt ZIP 243211 bytes.

## 15. Phone-based block v1.8.0
- Block key = normalized mobile (bidrubeh_norm_phone: FA/AR→EN, +98/0098/9→09). bidrubeh_unread_by_phone() counts DISTINCT unread per phone.
- Blocked submit → lock card + disabled button. Live AJAX check while typing (bidrubeh_check_phone): ⚠/✓ + .bd-phone-status styles.
- Backfilled bd_phone_norm. Verified COUNT=1, FA-variant match, AFTER-READ=0. Rebuilt ZIP 244337 bytes.

## 16. News meta alignment v1.8.1
- Latest News cards: date + comment count in .meta-row flex (shared line-height 1.8), separator span. Rebuilt ZIP 244388 bytes.

## 17. Dropdown renamed v1.8.2 → v1.8.3
- «برگه‌ها ▾» → «Menu ▾» → «منو ▾» in wp_nav_menu_items filter. Rebuilt ZIP 244381 bytes.

## 18. Hero merged into header v1.9.0
- Removed standalone .hero; header shows compact hero (search) on front page only, green gradient via body.home. Padding 56px→14px. Rebuilt ZIP 244727 bytes.

## 19. Topbar merged + submenu fix v1.9.1
- Topbar → .header-topline slim strip in header; brand 56px→44px.
- Submenu white-on-white on home → forced dark ink !important. Rebuilt ZIP 244847 bytes.

## 20. Brand bigger + hc-text removed v1.9.2
- .brand-name 19px→28px, .brand-sub 11.5px→13px. Removed .hc-text block + CSS. Rebuilt ZIP 244673 bytes.

## 21. About page + hero-stats removed v1.9.3
- Removed .hero-stats from header (+ CSS).
- New page-about.php (Template: درباره ما): hero + breadcrumb, intro + side cards (contact/stats), mission info-grid, 4-step timeline, CTA buttons. New CSS .bd-about-*, .bd-timeline.
- Created page 125 /about-us/; linked homepage button; menu items 70/40 → /about-us/. Rebuilt ZIP 246267 bytes (23 files).

## 22. Snapshot at v1.9.3 (historical)
- Slug bd_notice_cat=etelaeieh, count=4; Jalali via parsidate/fallback; Persian digits; منو ▾ auto-dropdown; phone-blocked contact; pages 110/125; menus 31/26.
- Workflow: edit local → docker cp → chown www-data → php -l → hard-refresh. Rebuild: python mkzip.py.

## 23. Production deploy
1. PHP 8.1+, MySQL 8, Apache + mod_rewrite, AllowOverride All.
2. Fresh WP fa_IR; Permalinks = Post name; verify /wp-json/ 200.
3. Upload bidrubeh-municipality.zip → Activate. 4. Install + Activate wp-parsidate.
5. General: title شهرداری بیدروبه, timezone Tehran, date Y/m/d.
6. Ensure etelaeieh category. 7. Pages: درباره ما (/about-us/) + تماس با ما (/contact-us/ + shortcode) + سوالات متداول (/faq/); assign Primary menu.
8. Customize all sections. 9. Posts with Featured Images. 10. Test all. 11. Hardening: remove hello/akismet, no WooCommerce, backups + SSL.

## 24. Sidebar layout v1.9.4
- sidebar.php: دسته‌بندی اخبار above آخرین اخبار. .content-grid 1fr 2fr + .sidebar{order:-1}; .bd-news-layout 1.6fr/1fr. Rebuilt ZIP 246564 bytes.

## 25. Removed bd-news-side wrapper v1.9.5
- Direct grid children with explicit placement; mobile auto-stack. Verified 0× bd-news-side. Rebuilt ZIP 246615 bytes.

## 26. Removed homepage Categories card v1.9.6
- Removed .bd-cats-col; latest + notices two-col. Verified 0× bd-cats-col. Rebuilt ZIP 246520 bytes.

## 27. Dynamic bars via Customizer v1.9.7
- Section «نوارهای پیشرفت» (bd_bar1–4 _title/_pct, clamp 0–100) + bidrubeh_bars(). front-page bars → foreach loop with ٪ label. Defaults 88/92/76/84. Rebuilt ZIP 246883 bytes.

## 28. Footer socials Eitaa/Bale/Rubika v1.9.8
- bidrubeh_social_url() (ID/@ID/phone/FA-digits/full URL → canonical; empty=hidden) + bidrubeh_socials() + bidrubeh_social_links() (new-tab). bidrubeh_icon() + SVGs. Customizer «شبکه‌های اجتماعی» (bd_eitaa/bd_bale/bd_rubika).
- footer.php: .bd-socials under contact info, only when ≥1 set. CSS 40px pills + hover lift.
- Verified ID/phone/URL resolve; empty→hidden. Rebuilt ZIP 247913 bytes.

## 29. Official social logos v1.9.9
- Replaced hand-drawn SVGs with official art: assets/social/eitaa.png (180px), bale.png (164px), rubika.png (48px from favicon .ico). bidrubeh_social_img() + img in links; CSS white 40px pills cover.
- Deployed, php -l clean, render verified. Rebuilt ZIP 279391 bytes (26 files).

## 30. Social click fix v1.9.10
- Added rel=noopener,noreferrer + draggable=false; CSS z-index:2, pointer-events:auto on link / none on img (prevents drag swallowing click).
- Root cause: markup correct; @bid test IDs → 404 looked dead. Demo IDs eitaa/bale/rubika (all 200 OK) verified live hrefs. Rebuilt ZIP 279457 bytes.

## 31. Dynamic zone-grid v1.9.11
- Customizer «نواحی و محلات» (bd_zone1..8 _title/_desc; empty=hidden) + bidrubeh_zones() (zone1 phone auto-replaced with bd_phone).
- front-page hardcoded 4 .zone → foreach loop, same markup/CSS.
- Verified: default 4, +zone5→5, remove→4; live 4× .zone. Rebuilt ZIP 279728 bytes.

## 32. Persian digits in numeric fields v1.9.12
- Root cause: type=number + absint rejected ۰-۹ (browser blocks, server zeroes).
- Fix: bidrubeh_fa_to_en() + bidrubeh_sanitize_num(); bd_notice_count + bd_bar*_pct → type=text inputmode=numeric with Persian hint. Verified ۴→4, ۸۸→88. Rebuilt ZIP 279809 bytes.

## 33. Auto-convert typed digits v1.9.13
- Note: English-only typing = Windows keyboard layout (Win+Space → فارسی), not the theme.
- Added customize_controls_enqueue_scripts inline script: 0-9 keystrokes in notice_count/bar_pct auto-convert to ۰-۹ live; server accepts both. Verified. Rebuilt ZIP 280026 bytes.

## 34. Dynamic info-grid v1.9.14
- Customizer «کارت‌های اطلاعاتی» (bd_info1..6: title+desc+3×(num+label); empty=hidden) + bidrubeh_info_cards().
- front-page hardcoded 3 .info-card → foreach loop. Verified: 3→+card4→4→remove→3. Rebuilt ZIP 280399 bytes.

## 35. Dynamic stats-band v1.9.15
- تنظیمات شهرداری += bd_stat3_val/label (۲۴ ساعته/پاسخگویی ۱۳۷) + bd_stat4_val/label (۹۰٪/شاخص رضایت); stats-band cells 3/4 → get_theme_mod. All 4 stats editable. Verified set/reset. Rebuilt ZIP 280504 bytes.

## 36. Dynamic About page v1.9.16
- Was: bd-about-nums half-dynamic; about info-grid + bd-timeline hardcoded.
- Customizer «صفحه درباره ما» (num3/4 val+label; mission1..4; tl1..6; empty=hidden) + bidrubeh_missions() + bidrubeh_timeline().
- page-about.php: nums → theme_mods; mission grid + timeline → foreach loops. Verified missions 3→4→3, timeline 4→5→4. Rebuilt ZIP 280824 bytes.

## 37. Dynamic FAQ page + homepage buttons v1.9.17
- Customizer «سوالات متداول» (bd_faq1..10 q+a; empty q=hidden) + bidrubeh_faqs() with 4 defaults.
- New page-faq.php (Template: سوالات متداول): hero + .bd-faq accordion (single-open, smooth max-height, + rotates, aria-expanded). CTA row bottom.
- style.css .bd-faq* + .bd-cta-band. js/main.js accordion handler before slider early-return (works off-slider pages).
- front-page «سوالی دارید؟» teaser: سوالات متداول + تماس با ما side-by-side.
- Created page 138 /faq/ (template page-faq.php); auto-appears under منو ▾ unless added to Primary.
- Verified 4 FAQs, /faq/ 12 markers, home teaser 6 markers. Rebuilt ZIP 282737 bytes (27 files).

## 38. About news button matches contact v1.9.18
- page-about.php: مشاهده اخبار btn → bd-send-btn (same premium gradient). Verified 2× bd-send-btn live. Rebuilt ZIP 282739 bytes.

## 39. Main-nav redesign v1.9.19
- style.css: pill nav bar (glass blur, 99px radius, shadow); links with animated gold underline + lift; active = green gradient (gold on home); smooth fade/slide dropdown; pill menu-toggle with hover.
- Mobile: stacked cards, dark-green glass on home, underlines off. Deployed, verified 33 nav markers live. ZIP 283106 bytes.

## 40. Recent Posts widget thumbnails v1.9.20
- Sidebar uses WP core Recent Posts widget (sidebar-1: categories-2 + recent-posts-2, title آخرین اخبار ×5) — no thumbs by default.
- widget_display_callback filter intercepts WP_Widget_Recent_Posts → renders .bd-recent-list rows: 64×48 thumb (only if has_post_thumbnail) + title. CSS flex rows + rounded thumbs.
- Fallback sidebar.php already had thumbs; homepage (front-page.php) has no sidebar — untouched.
- Verified on single post: 1 list, 5 thumbs. ZIP 283549 bytes.

## 41. Photo reports section v1.9.21
- Reference: andimeshk.ir/rha/ گزارش‌های تصویری (featured + side cards with badge/title/date).
- functions.php: bd_photo_cat (gozaresh-tasviri) + bd_photo_count (4) in تنظیمات شهرداری + bidrubeh_photo_query_args(); photo_count added to FA-digit auto-convert.
- front-page.php: #photos below slider — featured main card + side list, empty-cat fallback to latest posts, archive button only when category exists.
- style.css: .bd-photo-* layout (2-col desktop, stacked mobile). Created live category گزارش تصویری (ID 33, empty → fallback shows latest 4).
- Verified: 1 section, 1 main, 3 side items, 4 badges live. ZIP 284348 bytes.

## 42. Photo-grid 3-col rework v1.9.22
- #photos changed from featured+side layout to 3-col grid: photo on top, caption below. Default count 4→3 (helper + fallback + setting). Mobile 1-col, tablet 2-col.
- Verified live: 1 section, 1 grid, 3 cards. ZIP 284022 bytes.

## 43. Tourist attractions slider v1.9.23
- New #attractions section below News: photo slider (arrows/dots, 5s autoplay via shared initSlider) — image 5:4 aspect-ratio + caption underneath.
- Dynamic via جاذبه‌های گردشگری category (bd_attract_cat=tourist-attractions, bd_attract_count=5, editable); archive button only when category exists; section hidden when empty. Created live category ID 34.
- main.js: hero slider logic refactored to initSlider(id,sel); used for bdSlider + bdAttract. attract_count added to FA-digit auto-convert.
- Verified with 3 seeded test posts (thumbs from media library): 1 section, 1 slider, 3 slides, 3 imgs, dots — then cleaned up (section hides when empty, correct).
- ZIP 284584 bytes.

## 44. Attractions 3:2 + animation v1.9.24
- Aspect 5:4 → 3:2; added slide-in + slow zoom animation. Deployed + verified.
- WARNING: test cleanup permanently deleted real post 58 «آغاز عملیات بهسازی معابر اصلی بیدروبه» (force-delete bypassed trash; no revision/meta remains, unrecoverable). Lesson: cleanup scripts must match only test titles/IDs, never a whole category.

## 45. Soliloquy-style caption bar v1.9.25
- Attractions slides → card look: 3:2 image, green gradient caption bar below with white centered title (Soliloquy-style), max-width 760px, kept slide/zoom animation.
- Verified live + seeded cleanup (only موقت IDs deleted; real posts 59/60 preserved). ZIP 284697 bytes.

## 46. Attractions 3cm full-width strip v1.9.26
- Slider → filmstrip: full viewport width (bleed via 50vw margins), fixed 3cm height, images side-by-side (flex, cover), title overlay gradient bottom, hover zoom animation. No arrows/dots (all visible at once).
- Verified live: 1 section, 1 row, 2 cells (real posts 59/60). ZIP 284653 bytes.

## 47. Consolidated current state v1.9.26
- Theme live /var/www/html/wp-content/themes/bidrubeh-municipality/ v1.9.26. Local C:\Users\mzh\Desktop\news\bidrubeh-municipality\. ZIP bidrubeh-municipality.zip (284653 bytes, 27 files: +page-faq.php + assets/social/*.png).
- Files: 404, archive, comments, footer (socials), front-page (slider, photos, news, attractions, about+bars, info-grid, stats-band, zones, FAQ teaser), functions (all helpers), header, index, page, page-about, page-faq, screenshot, search, sidebar, single, style.css, js/main.js, assets/fonts + assets/social.
- Key funcs: bidrubeh_fa_to_en, bidrubeh_sanitize_num, bidrubeh_social_img/url/socials/links, bidrubeh_menu_page_ids/new_pages/fallback, calendar/occasion, msg_fp/norm_phone/unread_by_phone, contact shortcode/AJAX, comment, fa_digits/g2j/parsidate/pdate/jdate, bars, zones, info_cards, missions, timeline, faqs, comments_label, news_count, notice_args, photo_args, attract_args, recent-posts thumbs filter, icon, services.
- Customizer: تنظیمات شهرداری (phone/email/address/hero/population/area/hotline, notice cat+count, photo cat+count, attract cat+count, stat3/4), شبکه‌های اجتماعی (eitaa/bale/rubika), نواحی و محلات (1..8), کارت‌های اطلاعاتی (1..6), نوارهای پیشرفت (1..4), صفحه درباره ما (nums/missions/timeline), سوالات متداول (1..10).
- Categories: etelaeieh (اطلاعیه‌ها), gozaresh-tasviri (گزارش تصویری, ID 33), tourist-attractions (جاذبه‌های گردشگری, ID 34).
- Pages: 110 تماس با ما, 125 درباره ما, 138 سوالات متداول, test pages. Menus 31/26.
- Workflow: edit → docker cp → chown www-data → php -l → hard-refresh. Rebuild: python mkzip.py.
- Open/next: real phone/address/logo, sample posts/thumbs, optional sticky slider cat.

## 48. News/notices cleanup v1.9.27
- front-page.php: removed bd-count span from آخرین اخبار heading; removed مشاهده آخرین اخبار button from notices card.
- Notices → .bd-notice-list rows: 96×72 thumb (featured image or green gradient placeholder) + 2-line clamped title + Jalali date; hover lift/border; fallback items same layout.
- Verified live: 0× bd-count, 4× notice rows/thumbs, button gone. ZIP 284816 bytes.

## 49. Equal-height news/notices + always 5 notices v1.9.28
- style.css: .bd-news-layout align-items:stretch; notices-col flex column; notice-list flex:1 with rows stretching to fill (matches latest-col height). Mobile resets to block.
- front-page.php: notices query forced to 5 (category posts first, backfilled with latest posts if fewer); fallback static list → 5 items.
- functions.php: bd_notice_count default 4→5 (helper + Customizer).
- Verified live: 5× notice rows/thumbs, stretch+flex CSS served. ZIP 285018 bytes.

## 50. Exclude photo reports from slider v1.9.29
- front-page.php slider query adds category__not_in for bd_photo_cat (default gozaresh-tasviri) so گزارش‌های تصویری never appear in #bdSlider.
- Verified php -l clean. ZIP 285106 bytes.

## 51. Archive buttons on news + notices v1.9.30
- front-page.php: widget-headings now flex row with small .btn: آخرین اخبار → آرشیو اخبار (category akhbar); اطلاعیه‌های مهم → آرشیو اطلاعیه‌ها (bd_notice_cat, default etelaeieh). Buttons hidden if category missing.
- style.css: .widget-heading flex space-between; new .btn-sm compact style.
- Verified live: 1× آرشیو اخبار, 1× آرشیو اطلاعیه‌ها. ZIP 285217 bytes.

## 52. Attractions showcase slider v1.9.31
- front-page.php: filmstrip → showcase slider #bdAttract (large 440px image, gradient shade, gold badge, title, excerpt, date pill + CTA button, arrows, dots + Persian fraction, clickable thumbnail strip below).
- style.css: .bd-attr-* showcase styles (fade + slow zoom, glass pills, thumb active gold ring, mobile rules). main.js: thumbnails/counter sync, pause-on-hover, Persian digits.
- Verified live: 1 slider, 4 slides, 4 thumbs, 4 badges. ZIP 286210 bytes.

## 53. Attractions via SB Simple Photo Gallery v1.9.32
- Installed + activated sb-simple-photo-gallery 3.1.0 (block plugin: Grid/Masonry/Justified/Mosaic + lightbox). Local copy: C:\Users\mzh\Desktop\news\sb-simple-photo-gallery.zip.
- functions.php: bidrubeh_attract_layout() + bidrubeh_attract_gallery() (thumbs → spg_render_block with titles as captions, mosaic/3col/lightbox); new Customizer چیدمان گالری جاذبه‌ها (bd_attract_layout); SB assets enqueued on front page.
- front-page.php: custom showcase slider replaced by SB gallery output; section hidden when empty.
- style.css: old .bd-attr-* slider CSS replaced with SB gallery theme styling. main.js: attract slider wiring removed.
- Verified live: SB gallery + 4 items, old slider 0, assets loaded. ZIP 285763 bytes.
- Production: upload sb-simple-photo-gallery.zip via Plugins > Add New > Upload, then Activate.

## 54. Slider marks + latest backfill v1.9.33
- functions.php: اسلایدر صفحه اصلی meta box (bd_in_slider checkbox on post edit) + save handler; bidrubeh_slider_posts() (marked first newest-first, backfilled with latest excluding photo-reports); bidrubeh_slider_exclude(); new Customizer تعداد اسلایدها (bd_slider_count, default 5, FA-digit convert).
- front-page.php: slider uses bidrubeh_slider_posts() helper.
- Verified: 0 marked → latest 5; mark 32 → 32 first + 4 latest, cleaned after; live 5 slides. ZIP 286298 bytes.

## 55. Latest News excludes photos/attractions/notices v1.9.34
- functions.php: bidrubeh_latest_news_exclude() (photo + attract + notice category IDs from Customizer with defaults).
- front-page.php: latest-news query adds category__not_in.
- Verified: EX=33,34,28; 6 latest contain no excluded cats; live 6 cards. ZIP 286420 bytes.

## 56. Dynamic tourism gallery (andimeshk-style) v1.9.35
- Removed SB Simple Photo Gallery dependency (deactivated; theme no longer enqueues/calls it; gallery works standalone).
- functions.php: bidrubeh_tourism_term() resolves category by name جاذبه‌های گردشگری (both ی variants) with slug fallback; bidrubeh_tourism_query_args() (all published, newest first); bidrubeh_tourism_cards() (featured image + title + excerpt + مشاهده بیشتر → permalink per post, graceful no-thumb); [tourism_gallery] shortcode.
- front-page.php: attractions section uses bidrubeh_tourism_cards() + dynamic term name/archive link; hidden when empty.
- style.css: .bd-tour-* compact RTL cards (white, border, radius, light shadow, 150px cover, hover lift/zoom); grid 4/3/2/1 responsive.
- Verified: 3 live cards with real titles/links/excerpts, shortcode matches, works with SB plugin deactivated. ZIP 286330 bytes.

## 57. Simplified tourism items v1.9.36
- functions.php: bidrubeh_tourism_cards() now outputs linked image + overlay title only (no bd-tour-card/body/desc/more).
- style.css: .bd-tour-item (image with gradient title overlay, hover lift/zoom).
- Verified live: 0× card/more/desc, 3× tour items. ZIP 286152 bytes.

## 58. Removed homepage search v1.9.37
- header.php: removed hero-compact search form block (front-page only). Search results page still works via direct URL.
- style.css: removed all orphaned .hero/.hero-search/.hero-compact CSS (header, hero, mobile rules).
- Verified live: 0× hero-compact/hero-search in HTML and CSS. ZIP 285744 bytes.

## 59. Slider text filter v1.9.38
- Customizer تنظیمات شهرداری += فیلتر متن اسلایدر (bd_slider_filter): comma/، separated words, empty=no filter.
- functions.php: bidrubeh_slider_filter_words() + bidrubeh_slider_is_blocked() (mb_stripos on title) + hooks bidrubeh_slider_filter_words / bidrubeh_slider_is_blocked; bidrubeh_slider_posts() filters both marked pool and backfill, over-fetches to keep count.
- Verified live: words آزمون|تست → block=1/0, 5 slides, 0 leaks; php -l clean. ZIP 286135 bytes.

## 60. All-Posts slider filter v1.9.39
- functions.php: restrict_manage_posts dropdown (bd_slider=yes/no) on post list + pre_get_posts meta filter + اسلایدر column (✅/—/⚠ مسدود با فیلتر متن).
- Verified: hooks 1/1, column present, mark-32 query yes=1/no=14, cleaned after. ZIP 286593 bytes.

## 61. Full-width slider v1.9.40
- front-page.php: slider section full-bleed (no .wrap), image size large→full + sizes=100vw, caption inner capped.
- style.css: .bd-slider-full (square edges, clamp(300px,42vw,560px) height, arrows/dots kept inside via max() margins, hard 560px cap ≥1600px) — no horizontal overflow (overflow:hidden).
- Verified live: markup + CSS served, php -l clean. ZIP 286765 bytes.

## 62. Dynamic slider speed v1.9.41
- Customizer تنظیمات شهرداری += سرعت اسلایدر (bd_slider_speed, default 5s, 0=stop, clamp 0–60, FA-digit convert) + bidrubeh_slider_speed() + bidrubeh_slider_speed hook.
- front-page.php: #bdSlider data-speed attr; main.js restart() reads data-speed (0 = no autoplay).
- Verified live: data-speed=5 served, JS reads data-speed, php -l clean. ZIP 286956 bytes.

## 63. Header blends + menu redesign v1.9.42
- style.css: `.site-header` + `.header-main` now `var(--bd-bg)` (matches site), removed home green gradient + white box; topline solid `#0a3d2d`.
- Menu: white 18px card, dual gold indicators (::before top bar + ::after underline), hover lift + gradient bg + shadow, active = green gradient + white top bar; mobile solid white, body.home overrides removed.
- Verified live: new CSS served, header markup present, php -l clean. ZIP 286916 bytes.

## 64. Remove slider date v1.9.43
- front-page.php: removed `<small>bidrubeh_pdate()</small>` from `.bd-slide-cap`.
- Verified live: 0× `<small>` in slider block, php -l clean. ZIP 286915 bytes.

## 65. Marked-only slider v1.9.44
- functions.php: `bidrubeh_slider_posts()` backfill removed — returns only `bd_in_slider=1` posts (still respects photo-cat exclusion + text filter).
- front-page.php: slider section hidden when empty (no marked posts).
- Verified live: 0 marked → empty slider; mark one → appears; cleaned after. ZIP 286794 bytes.

## 66. Category-only notices v1.9.45
- functions.php: `bidrubeh_notice_query_args()` resolves slug→term_id; missing/empty slug → `post__in=[0]` (never back-fills).
- front-page.php: removed latest-posts backfill + static fallback → empty state message only.
- Verified live: 1 notice, 0 leaks, bad slug → 0. ZIP 286569 bytes.

## 67. Random-4 tourism rotation + widget exclusion v1.9.46
- functions.php: `bidrubeh_tourism_cards()` fetches up to 20, `shuffle()`, outputs pool with only first 4 visible (`hidden` on rest), `#bdTourGrid data-speed=bidrubeh_slider_speed()`; `widget_posts_args` filter excludes tourism term; custom `widget_display_callback` Recent-Posts query adds `category__not_in`.
- sidebar.php fallback آخرین اخبار adds `category__not_in` tourism.
- js/main.js: `#bdTourGrid` picks random 4 every `data-speed` seconds (0 = no rotation).
- Verified live: 6 total / 4 visible, grid + JS served, widget excludes 34, recent leaks 0, php -l clean. ZIP 287026 bytes.

## 68. Remove bd-about-hero from all pages v1.9.47
- page-about.php + page-faq.php: removed `<section class="bd-about-hero">` banner (breadcrumb + h1 + subtitle); pages now start directly with `.section` content.
- style.css: removed `.bd-about-hero` (gradient banner, h1, p) + `.bd-crumb` rules; `.bd-about-grid` margin-top:-34px overlap → 0; removed orphan mobile `margin-top:0` override.
- functions.php + style.css header: Version/BIDRUBEH_VER 1.9.46 → 1.9.47.
- Verified live: theme grep 0× bd-about-hero / 0× bd-crumb in all files; /about-us/ + /faq/ render 0× hero; php -l clean. ZIP 286627 bytes.

## 69. Remove brand texts v1.9.48
- Brand check: site name = شهرداری بیدروبه, NOT "Market Dynamic".
- header.php: removed `.brand-name` (bloginfo name) + `.brand-sub` (bloginfo description) spans + `<br>`; brand link now shows logo mark only.
- style.css: removed `.brand-name`/`.brand-sub` rules.
- Version/BIDRUBEH_VER 1.9.47 → 1.9.48.
- Verified live: header.php + style.css 0× brand-name/brand-sub; php -l clean. ZIP 286565 bytes.

## 70. Custom brand logo upload + dimensions v1.9.49
- Customizer new section «لوگوی سایت» (bidrubeh_brand, priority 29): image upload bd_logo (WP_Customize_Image_Control, attachment ID) + bd_logo_w (default 150px) + bd_logo_h (default 60px), FA-digit convert + numeric hints.
- header.php brand link: uploaded logo → `<img class="brand-logo">` at custom width/height; empty → default SVG brand-mark fallback.
- style.css: `.brand-logo` (block, contain, radius).
- Version/BIDRUBEH_VER 1.9.48 → 1.9.49.
- Verified live: section + controls wired, fallback intact, php -l clean. ZIP 287063 bytes.

## 71. Brand logo URL-vs-ID fix v1.9.50
- Root cause: bd_logo sanitize absint cast live URL value to 0 → header fell back to SVG icon.
- functions.php: new bidrubeh_sanitize_logo() (URL passthrough or absint); bd_logo default 0→''.
- header.php: resolves bd_logo as URL directly or attachment ID → full URL.
- Version/BIDRUBEH_VER 1.9.49 → 1.9.50.
- Verified live: php -l clean, upload swaps in .header-main .brand. ZIP 287129 bytes.

## 72. Tourism hidden-items CSS fix v1.9.51
- Root cause: `.bd-tour-item{display:block}` overrode the `hidden` attribute → all items stayed visible and rotation appeared frozen.
- style.css: added `.bd-tour-item[hidden]{display:none}`.
- Note: `curl http://localhost/` inside wp-app returns 301/empty — verify from host via `http://localhost:8080/` instead.
- Verified live (host, port 8080): 6× bd-tour-item / 2× hidden, grid data-speed=10, style+main ver=1.9.51. ZIP 287139 bytes.

## 73. Tourism rotation fade animation v1.9.52
- style.css: `.bd-tour-grid` opacity/translate transition + `.bd-tour-fading` state + `bdTourIn` entry keyframes on visible items.
- main.js: rotation tick fades grid out (360ms), swaps random 4, reflows, fades back in.
- Version/BIDRUBEH_VER 1.9.51 → 1.9.52.
- Verified live: style+main ver=1.9.52 served. ZIP 287273 bytes.

## 74. Centered nav + Slogan of the Year slot v1.9.53
- header.php: added `.slogan` span at end of `.header-main` (left side in RTL); uploaded bd_slogan image or dashed «شعار سال» placeholder.
- Customizer «لوگوی سایت» += bd_slogan upload + bd_slogan_w/h (150×60 defaults, FA-digit convert).
- style.css: `.main-nav` flex:1 centered (menu links centered); `.slogan`/`.slogan-img`/`.slogan-ph` styles; header-main wraps; mobile nav full-width + smaller placeholder.
- Version/BIDRUBEH_VER 1.9.52 → 1.9.53.
- Verified live: slogan + slogan-ph served, style ver=1.9.53, php -l clean. ZIP 287639 bytes.

## 75. No-repeat tourism rotation when 8+ items v1.9.54
- main.js: rotation remembers previous set (`prev`); with ≥8 items next 4 are picked only from not-shown ones (fallback fills from prev if pool short); <8 keeps pure random (overlap unavoidable).
- Note: served `?ver=` can lag one deploy behind — re-request `?nocache=1` or reload to confirm.
- Verified live: main.js ver=1.9.54 served, shuffleArr+prev.indexOf present. ZIP 287817 bytes.

## 76. Logical gap slider → photos v1.9.55
- front-page.php: `#photos` padding-top 0 → 24px logical section gap after `.bd-slider-full`.
- Version/BIDRUBEH_VER 1.9.54 → 1.9.55.
- Verified live: front-page.php padding-top:24px. ZIP 287828 bytes.

## 77. Slim header + shiraz.ir-style menu v1.9.56
- header-main: padding 14px→6px, compact logos (brand-mark 44→34px, uploaded logos max-height 40px).
- Menu remodeled on shiraz.ir #menu694: slim glass pill (blur, 100px radius, light border+shadow), navy #003380 links with animated center underline (no boxes/lift), current = underlined navy, caret on parents, pale-gold (#eaddaa) blurred 16px dropdown with fade+slide, mobile stacked with dividers.
- Version/BIDRUBEH_VER 1.9.55 → 1.9.56.
- Verified live: style ver=1.9.56, header-main served. ZIP 287962 bytes.

## 78. Revert header height + green menu + rename v1.9.57
- header-main height reverted (padding 6px→14px, brand-mark 34→44px, slogan placeholder restored, uploaded logos unconstrained).
- Menu links navy→green (var(--bd-primary), hover darker, underline green); dropdown bg pale-gold→white with green links/hover.
- Dropdown label منو ▾ → "Other Pages ▾".
- Version/BIDRUBEH_VER 1.9.56 → 1.9.57.
- Verified live: style ver=1.9.57, "Other Pages" served. ZIP 287934 bytes.

## 79. Translate dropdown label v1.9.58
- "Other Pages ▾" → «صفحات دیگر ▾».
- Version/BIDRUBEH_VER 1.9.57 → 1.9.58.
- Verified live: label served, style ver=1.9.58. ZIP 287935 bytes.

## 80. WhatsApp + Telegram + Instagram socials v1.9.59
- assets/social: whatsapp.svg, telegram.svg, instagram.svg (official Wikimedia art).
- functions.php: bidrubeh_social_img() png→svg fallback; bidrubeh_whatsapp_url() (number→wa.me intl); socials list + Customizer fields for bd_whatsapp/bd_telegram/bd_instagram.
- Version/BIDRUBEH_VER 1.9.58 → 1.9.59.
- Verified live: php -l clean. ZIP 292049 bytes (30 files).

## 81. Remove duplicate dropdown arrow v1.9.60
- Extra arrow was label `▾` + CSS caret triangle → duplicate.
- functions.php: «صفحات دیگر ▾» → «صفحات دیگر» (CSS ::before caret remains as single arrow).
- Version/BIDRUBEH_VER 1.9.59 → 1.9.60.
- Verified live: aria-haspopup label served without ▾, style ver=1.9.60, php -l clean. ZIP 292043 bytes.

## 82. Dynamic footer links + titles v1.9.61
- Customizer new section «پیوندهای فوتر» (priority 37): bd_footer1/2_title + 6× (bd_flinkN_title/_url); defaults use verified-200 URLs (ostan-khz, dolat, leader, khadamat.mardom) + 2 empty.
- functions.php: bidrubeh_footer_links() helper (empty title=hidden, empty URL=#).
- footer.php: fallback columns now loop helper + editable titles.
- Version/BIDRUBEH_VER 1.9.60 → 1.9.61.
- Verified live: real footer URLs served, php -l clean. ZIP 292478 bytes.

## 83. Remove Other Pages dropdown v1.9.62
- Removed wp_nav_menu_items auto-dropdown (صفحات دیگر) + bidrubeh_new_pages()/bidrubeh_menu_page_ids() helpers + JS touch handler + orphaned bd-pages-drop CSS; fallback now Home/News only.
- Version/BIDRUBEH_VER 1.9.61 → 1.9.62.
- Verified live: 0× bd-pages-drop/new_pages, style ver=1.9.62, php -l clean. ZIP 291943 bytes.

## 84. About card icons v1.9.63
- functions.php: bidrubeh_icon() += mail/pin/chart icons.
- page-about.php: تماس سریع heading + 4 rows and آمار شهر heading get gradient badge / circular row icons.
- style.css: .bd-card-ico (32px gradient) + .bd-row-ico (26px circle).
- Version/BIDRUBEH_VER 1.9.62 → 1.9.63.
- Verified live: 2× card + 4× row icons on /about-us/, php -l clean. ZIP 292172 bytes.

## 85. Visual report badge + related posts v1.9.64
- functions.php: bidrubeh_visual_pick() (photo-cat pool, max 4) + bidrubeh_visual_badge() (📷 گزارش تصویری pill with hover dropdown of photo titles) appended in bidrubeh_header_occasion(); bidrubeh_related_posts() (same-category, max 3).
- style.css: .bd-visual-* pill + dropdown (matches sub-menu look) + .bd-related block styles.
- single.php: اخبار مرتبط block (3 links) above comments.
- Version/BIDRUBEH_VER 1.9.63 → 1.9.64.
- Verified live: badge + dropdown served; visual pool COUNT=1 (only 1 photo post exists — scales to 4); related REL59=3. ZIP 292951 bytes.

## 86. Photos moved after News v1.9.65
- front-page.php: `#photos` block moved from above `#news` to below it; slider→news keeps the 24px gap, photos take padding-top:0.
- Version/BIDRUBEH_VER 1.9.64 → 1.9.65.
- Verified live: served news(18835) before photos(27661). ZIP 292955 bytes.

## 87. Photos moved before News (user request) v1.9.65
- front-page.php: swapped blocks → slider → `#photos` (padding-top:24px) → `#news` (padding-top:0); no version bump.
- Verified live: slider → photos → news → attractions served. ZIP 292951 bytes.

## 88. Hide visual badge on homepage v1.9.66
- functions.php: `bidrubeh_header_occasion()` skips `bidrubeh_visual_badge()` on `is_front_page()`; badge stays on other pages.
- Version/BIDRUBEH_VER 1.9.65 → 1.9.66.
- Verified live: 0× bd-visual-wrap on homepage, style ver=1.9.66, php -l clean. ZIP 292961 bytes.

## 89. Topbar photos + attractions links v1.9.67
- header.php: tb-links adds «گزارش تصویری» → /#photos and «جاذبه‌های گردشگری» → /#attractions after News (اخبار → home_url /#news so anchors work site-wide).
- Version/BIDRUBEH_VER 1.9.66 → 1.9.67.
- Verified live: #news/#photos/#attractions served, style ver=1.9.67, php -l clean. ZIP 293028 bytes.

## 90. Sticky header-topline v1.9.68
- style.css: `.header-topline` position:sticky top:0 z-index:100 (+ admin-bar 32px / 46px mobile offsets).
- Version/BIDRUBEH_VER 1.9.67 → 1.9.68.
- Verified live: sticky rule + offsets served, style ver=1.9.68. ZIP 293078 bytes.

## 91. One-comment-at-a-time per device + mandatory approval v1.9.69
- functions.php: bidrubeh_comment_fp() (logged-in user ID or bd_cfp cookie + IP+UA hash); init sets 1yr Secure/HttpOnly bd_cfp; bidrubeh_comment_blocked() counts status=hold with matching bd_fp; comment_post stamps bd_fp; pre_comment_approved forces '0' (public only after admin approves); preprocess_comment 403-dies on blocked; comment_reply_link hidden when blocked. Admins (moderate_comments) exempt.
- comments.php: closed → closed message; blocked → ⏳ pending card instead of form.
- Version/BIDRUBEH_VER 1.9.68 → 1.9.69.
- Verified live: hold → BLOCKED=1, approve → 0, delete → cleaned; form renders on open post (?p=63). Test post 59 has comments closed (expected no form). ZIP 293757 bytes.

## 92. Comment/ping columns + closed-by-default v1.9.70
- functions.php: All Posts table += دیدگاه‌ها (bd_comments) + بازتاب‌ها (bd_pings) columns (✅ باز / ❌ بسته); get_default_comment_status filter forces 'closed' for posts (both comment + pingback) so Quick Edit/new-post checkboxes start unchecked; existing posts untouched. Checking the box per post opens that form (comments_open/pings_open read native status).
- Version/BIDRUBEH_VER 1.9.69 → 1.9.70.
- Verified live: COLS=title,bd_slider,bd_comments,bd_pings; NEW_C/P=closed; post 60 stays open. ZIP 293901 bytes.

## 93. Related topics rework + contact 11-digit phone v1.9.71 (local, shipped in v1.9.72)
- functions.php: bidrubeh_related_posts() tags-first → all-categories → latest fallback (was first-category only); contact validation `strlen<10` → strict `^09\d{9}$` 11-digit.
- single.php + style.css: bd-related-list plain links → 3-col thumbnail cards (thumb + title + Jalali date, hover lift, mobile stack).
- Verified live: tags-first/category-matching reviewed (test posts share cat 34, no tags → correct REL60=3); phone 09123456789 OK, 10/12-digit + landline REJECT.

## 94. Fixed header-topline v1.9.72
- style.css: `.header-topline` sticky → fixed top:0 left:0 right:0 + body padding-top offsets (28px / admin-bar 60px / 74px mobile) so content isn't hidden.
- Version/BIDRUBEH_VER 1.9.70 → 1.9.72.
- Verified live: fixed rule served, style ver=1.9.72, php -l clean, related REL60=3, phone strict. ZIP 294316 bytes.

## 95. Remove visual badge + scroll-to-top button v1.9.73
- functions.php: removed bidrubeh_visual_pick()/bidrubeh_visual_badge() + occasion call (badge gone from all pages).
- footer.php: `#bdToTop` ↑ button; main.js shows after 400px scroll + smooth scroll-to-top; style.css `.bd-to-top` (44px green gradient circle, hover lift).
- Version/BIDRUBEH_VER 1.9.72 → 1.9.73.
- Verified live: 0× bd-visual, bdToTop + assets ver=1.9.73 served, php -l clean. ZIP 294201 bytes.

## 96. Comments spacing + site background v1.9.74
- style.css: `.bd-comments` WhatsApp beige (#f4f0e8 + dots) → `var(--bd-bg)` + `--bd-line` border; added `margin-top:24px` gap from `.bd-related`.
- Version/BIDRUBEH_VER 1.9.73 → 1.9.74.
- Verified live: rule served, style ver=1.9.74. ZIP 294156 bytes.

## 97. IP-based one-pending comment per post v1.9.75
- functions.php: new bidrubeh_comment_ip() + bidrubeh_comment_ip_blocked() (COUNT(*) where comment_post_ID + comment_author_IP + approved='0'); bidrubeh_comment_blocked() now checks IP first, then bd_fp fallback; per-post lock — same IP can comment on other posts.
- Verified live: IP 9.9.9.9 post 60 BLOCKED=1 / post 61=0; approve → 0; preprocess_comment dies with Persian 403; cleaned; style ver=1.9.75. ZIP 294278 bytes.

## 98. Remove stray ticks from comment bubbles v1.9.76
- Stray character was `.bd-ticks` ✓✓ in `bidrubeh_comment()` bubble foot.
- functions.php: removed `<span class="bd-ticks">✓✓</span>`; style.css: removed orphaned `.bd-ticks` rule.
- Version/BIDRUBEH_VER 1.9.75 → 1.9.76.
- Verified live: 0× bd-ticks in theme, style ver=1.9.76, php -l clean. ZIP 294247 bytes.

## 99. Approval-only comment visibility v1.9.77 (shipped in v1.9.78)
- functions.php: comments_array strips non-approved for non-moderators; pre_get_comments (frontend) forces status=approve + clears include_unapproved; admins exempt.
- Verified live: hold insert → public count unchanged, CQ=0, filtered=0, admin sees hold=1; cleaned.

## 100. Reply quote context v1.9.78
- functions.php: bidrubeh_comment() renders .bd-reply-quote («پاسخ به X:» + 80-char excerpt of parent) above reply text.
- style.css: .bd-reply-quote (tinted bg, green right border) + author/text styles.
- Version/BIDRUBEH_VER 1.9.77 → 1.9.78.
- Verified live: php -l clean, ver=1.9.78 on disk. ZIP 294572 bytes.

## 101. Scroll-to-top to right side v1.9.79
- style.css: `.bd-to-top` left:22px → right:22px.
- Version/BIDRUBEH_VER 1.9.78 → 1.9.79.
- Verified live: right:22px rule + ver=1.9.79 served. ZIP 294573 bytes.

## 102. Fix bubble tail rendering v1.9.80
- Root cause: `.bd-bubble::before` side-triangle (right:-7px, one-corner anchored) rendered as a detached speck instead of a tail.
- style.css: tails redrawn as top spikes merged into the bubble edge (top:-6px, right/left:12px, border-bottom triangle in bubble color).
- Version/BIDRUBEH_VER 1.9.79 → 1.9.80.
- Verified live: new tail rules + ver=1.9.80 served. ZIP 294577 bytes.

## 103. IP/device block in Contact Us v1.9.81
- functions.php: new bidrubeh_unread_by_ip() (unread bidrubeh_msg with matching bd_fp); submit path checks phone first, then IP; render path blocks form + shows «این دستگاه» lock when IP has unread; AJAX bidrubeh_check_phone returns by=phone|ip; form fields disabled on load for IP-blocked devices.
- Version/BIDRUBEH_VER 1.9.80 → 1.9.81.
- Verified live: FP test 0→1 with new number (bypass closed) →0 after delete; php -l clean, ver=1.9.81. ZIP 294877 bytes.

## 104. Stuck comment lock fix + 10-char minimum v1.9.83
- Contact pending-only success: render shows bd-sent-ok only while sender still has unread (read/delete → banner gone, form returns).
- Root cause of stuck comment lock: v1.9.77 pre_get_comments forced status=approve on ALL frontend queries, corrupting the internal hold check → inconsistent permanent lock. Fix: bd_lock_check flag skips the rewrite; verified approve→unlock (0), delete→unlock (0).
- Minimum length: comments + contact reject <10 chars (Persian 403), both textareas minlength=10.
- Cleaned leaked lock10 hold comments; shipped pending bidrubeh_visual removal, to-top, related/phone batches under v1.9.72–82 per file headers.
- Version/BIDRUBEH_VER 1.9.82 → 1.9.83.
- Verified live: SHORT rejected, LONG passes, ver=1.9.83 served. ZIP 295011 bytes.

## 105. Comment save-info + Persian validation v1.9.84
- Root cause: custom fields array dropped WP cookies consent + $commenter prefill, so save-info checkbox never appeared.
- comments.php: restored wp_get_current_commenter() prefill + Persian cookies-consent checkbox; comment_form JS setCustomValidity in Persian (نام/ایمیل/متن); functions.php: preprocess_comment Persian errors for empty name/email, invalid email.
- style.css: .comment-form-cookies-consent layout.
- Version/BIDRUBEH_VER 1.9.83 → 1.9.84.
- Verified live: cookie prefill works, Persian dies fire, post 62 form+consent+custom-validity served. ZIP 295411 bytes.

## 106. Contact Persian validation v1.9.85
- Server errors were already Persian; browser native bubbles were English.
- functions.php: split generic empty error into per-field Persian (نام/تلفن/متن); both forms JS setCustomValidity Persian (missing/tooShort/typeMismatch), ids bdName/bdPhone/bdMsg.
- Version/BIDRUBEH_VER 1.9.84 → 1.9.85.
- Verified live: contact form + setCustomValidity served, comment form intact. ZIP 295961 bytes.

## 107. Center info-card nums v1.9.86
- style.css: `.info-card .nums` justify-content:center + text-align:center (items + values).
- Version/BIDRUBEH_VER 1.9.85 → 1.9.86.
- Verified live: centered rule served, style ver=1.9.86. ZIP 295972 bytes.

## 108. Footer icons v1.9.87
- functions.php: bidrubeh_icon() += link/bolt/bank.
- footer.php: headings get .bd-foot-ico badges (bank/link/bolt); contact rows pin/phone/mail; link lists get ‹ markers; fallback quick links updated.
- style.css: .bd-foot-ico/.bd-foot-row(-ico)/.bd-foot-links styles.
- Version/BIDRUBEH_VER 1.9.86 → 1.9.87.
- Verified live: 3× foot-ico + 6× foot-row served, style ver=1.9.87, php -l clean. ZIP 296304 bytes.

## 109. Mobile: loop-card above categories v1.9.88
- Root cause: desktop `.content-grid>.sidebar{order:-1}` put the sidebar (news categories) first in DOM order on mobile's single-column layout.
- style.css @media(max-width:960px): `.content-grid>div{order:1}` + `.content-grid>.sidebar{order:2}` — loop-card (news details) stacks above sidebar on small screens; desktop RTL order unchanged.
- Version/BIDRUBEH_VER 1.9.87 → 1.9.88.
- Verified live: order rule served, php -l clean. ZIP 295044 bytes.

## 110. Comments at bottom on mobile + Category rename v1.9.89
- single.php: `comments_template()` moved out of `article.loop-card` into `.bd-single-comments` grid child (own row col 2 on desktop, ordered last on mobile).
- style.css: `.bd-single-grid` explicit desktop placement; mobile orders main(1) → sidebar(2) → comments(3).
- Category label: fallback `دسته‌بندی اخبار` → `دسته‌بندی`; live `widget_categories[2].title` renamed via script (widget stored in DB, not theme file).
- Version/BIDRUBEH_VER 1.9.88 → 1.9.89.
- Verified live: comments wrapper + order rule served, widget title دسته‌بندی, php -l clean. ZIP 295124 bytes.

(End of file)
