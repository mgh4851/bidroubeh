<?php
/* Template Name: درباره ما */
get_header();
while(have_posts()): the_post();
  $bd_about_zones = bidrubeh_zones();
  $bd_about_missions = bidrubeh_missions();
  $bd_about_info = bidrubeh_info_cards(true);
  $bd_about_phone = trim((string)get_theme_mod('bd_phone',''));
  $bd_about_email = trim((string)get_theme_mod('bd_email',''));
  $bd_about_address = trim((string)get_theme_mod('bd_address',''));
  $bd_about_hotline = trim((string)get_theme_mod('bd_hotline','۱۳۷'));
  $bd_about_hours = trim((string)get_theme_mod('bd_office_hours','شنبه تا چهارشنبه، ۷:۳۰ تا ۱۴:۳۰'));
  $bd_about_contact = get_page_by_path('contact-us');
  $bd_about_contact_url = $bd_about_contact ? get_permalink($bd_about_contact) : home_url('/contact-us/');
?>
<section class="bd-about-hero">
  <div class="wrap">
    <h1>درباره بیدروبه</h1>
    <p>از پیشینه شهر تا محله‌های آن؛ بیدروبه را نزدیک‌تر بشناسید.</p>
    <?php if($bd_about_zones): ?><a class="bd-text-link bd-about-hero-link" href="#zones">آشنایی با محله‌ها ←</a><?php endif; ?>
  </div>
</section>

<section class="section bd-about-overview">
  <div class="wrap bd-about-grid">
    <article class="card bd-about-text">
      <div class="section-title"><div><h2>معرفی بیدروبه</h2></div></div>
      <div class="bd-about-prose"><?php the_content(); ?></div>
    </article>
    <aside class="bd-about-side" aria-label="اطلاعات تماس شهرداری">
      <div class="card bd-about-card">
        <h2>راه‌های ارتباط</h2>
        <?php if($bd_about_phone!==''): $bd_about_dial=preg_replace('/[^0-9]/','',bidrubeh_fa_to_en($bd_about_phone)); ?>
        <div class="bd-about-detail"><span class="bd-row-ico"><?php echo bidrubeh_icon('phone'); ?></span><div><small>تلفن شهرداری</small><a href="<?php echo esc_url('tel:'.$bd_about_dial); ?>" dir="ltr"><?php echo esc_html($bd_about_phone); ?></a></div></div>
        <?php endif; ?>
        <?php if($bd_about_hotline!==''): $bd_about_hotline_dial=preg_replace('/[^0-9]/','',bidrubeh_fa_to_en($bd_about_hotline)); ?>
        <div class="bd-about-detail"><span class="bd-row-ico"><?php echo bidrubeh_icon('desk'); ?></span><div><small>پاسخگویی شهروندان</small><a href="<?php echo esc_url('tel:'.$bd_about_hotline_dial); ?>" dir="ltr"><?php echo esc_html($bd_about_hotline); ?></a></div></div>
        <?php endif; ?>
        <?php if($bd_about_email!==''): ?>
        <div class="bd-about-detail"><span class="bd-row-ico"><?php echo bidrubeh_icon('mail'); ?></span><div><small>ایمیل</small><a href="<?php echo esc_url('mailto:'.$bd_about_email); ?>"><?php echo esc_html($bd_about_email); ?></a></div></div>
        <?php endif; ?>
        <?php if($bd_about_address!==''): ?>
        <div class="bd-about-detail"><span class="bd-row-ico"><?php echo bidrubeh_icon('pin'); ?></span><div><small>نشانی</small><span><?php echo esc_html($bd_about_address); ?></span></div></div>
        <?php endif; ?>
        <?php if($bd_about_hours!==''): ?>
        <div class="bd-about-detail"><span class="bd-row-ico"><?php echo bidrubeh_icon('bank'); ?></span><div><small>ساعات کاری</small><span><?php echo esc_html($bd_about_hours); ?></span></div></div>
        <?php endif; ?>
        <a class="btn bd-about-contact-btn" href="<?php echo esc_url($bd_about_contact_url); ?>">تماس با ما</a>
      </div>
    </aside>
  </div>
</section>

<?php if($bd_about_zones): ?>
<section class="section bd-about-zones" id="zones">
  <div class="wrap">
    <div class="section-title"><div><h2>نواحی و محلات</h2></div></div>
    <p class="bd-section-intro">با محله‌های ثبت‌شده بیدروبه آشنا شوید. اطلاعات این بخش از تنظیمات شهرداری در سایت به‌روز می‌شود.</p>
    <div class="bd-about-zone-grid">
      <?php foreach($bd_about_zones as $bd_zone): ?>
      <article class="bd-about-zone">
        <h3><?php echo esc_html(bidrubeh_fa_digits($bd_zone['t'])); ?></h3>
        <?php if($bd_zone['d']!==''): ?><p><?php echo esc_html($bd_zone['d']); ?></p><?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if($bd_about_info): ?>
<section class="section bd-about-information" aria-label="کارت‌های اطلاعاتی شهرداری">
  <div class="wrap">
    <div class="section-title"><div><h2>اطلاعات شهر و شهرداری</h2></div></div>
    <div class="bd-about-info-grid">
      <?php foreach($bd_about_info as $bd_info_index=>$bd_info): ?>
      <article class="bd-about-info-card">
        <div class="bd-about-info-heading"><span aria-hidden="true"><?php echo bidrubeh_icon(['bank','map','chart'][$bd_info_index%3]); ?></span><h3><?php echo esc_html($bd_info['t']); ?></h3></div>
        <?php if($bd_info['d']!==''): ?><p><?php echo esc_html($bd_info['d']); ?></p><?php endif; ?>
        <?php if($bd_info['n']): ?><dl class="bd-about-info-numbers">
          <?php foreach($bd_info['n'] as $bd_info_number): ?><div><dt><?php echo esc_html($bd_info_number['l']); ?></dt><dd><?php echo esc_html(bidrubeh_fa_digits($bd_info_number['v'])); ?></dd></div><?php endforeach; ?>
        </dl><?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if($bd_about_missions): ?>
<section class="section bd-about-mission">
  <div class="wrap">
    <div class="section-title"><div><h2>مأموریت و ارزش‌ها</h2></div></div>
    <div class="info-grid">
      <?php foreach($bd_about_missions as $bd_mission): ?>
      <div class="info-card"><h3><?php echo esc_html($bd_mission['t']); ?></h3><p><?php echo esc_html($bd_mission['d']); ?></p></div>
      <?php endforeach; ?>
    </div>
    <div class="bd-about-actions">
      <a class="btn" href="<?php echo esc_url($bd_about_contact_url); ?>">ارتباط با شهرداری</a>
      <a class="bd-text-link" href="<?php echo esc_url(home_url('/#news')); ?>">مشاهده اخبار شهر ←</a>
    </div>
  </div>
</section>
<?php endif; ?>
<?php endwhile; get_footer(); ?>
