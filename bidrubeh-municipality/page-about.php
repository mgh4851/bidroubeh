<?php
/* Template Name: درباره ما */
get_header();
while(have_posts()): the_post();
?>
<section class="section">
  <div class="wrap">
    <div class="bd-about-grid">
      <div class="bd-about-text card">
        <div class="section-title"><h2>معرفی شهرداری بیدروبه</h2></div>
        <div><?php the_content(); ?></div>
      </div>
      <div class="bd-about-side">
        <div class="card bd-about-card">
          <h3><span class="bd-card-ico"><?php echo bidrubeh_icon('phone'); ?></span>تماس سریع</h3>
          <p><span class="bd-row-ico"><?php echo bidrubeh_icon('phone'); ?></span>تلفن: <b><?php echo esc_html(get_theme_mod('bd_phone','061-00000000')); ?></b></p>
          <p><span class="bd-row-ico"><?php echo bidrubeh_icon('mail'); ?></span>ایمیل: <b><?php echo esc_html(get_theme_mod('bd_email','info@bidrubeh.ir')); ?></b></p>
          <p><span class="bd-row-ico"><?php echo bidrubeh_icon('pin'); ?></span>نشانی: <?php echo esc_html(get_theme_mod('bd_address','خوزستان، بیدروبه، ساختمان شهرداری مرکزی')); ?></p>
          <p><span class="bd-row-ico"><?php echo bidrubeh_icon('desk'); ?></span>سامانه پاسخگویی: <b><?php echo esc_html(get_theme_mod('bd_hotline','۱۳۷')); ?></b></p>
        </div>
        <div class="card bd-about-card">
          <h3><span class="bd-card-ico"><?php echo bidrubeh_icon('chart'); ?></span>آمار شهر</h3>
          <div class="bd-about-nums">
            <div><b><?php echo esc_html(get_theme_mod('bd_population','۲۵٬۰۰۰+')); ?></b><span>جمعیت</span></div>
            <div><b><?php echo esc_html(get_theme_mod('bd_area','۱۸ کیلومتر مربع')); ?></b><span>وسعت</span></div>
            <div><b><?php echo esc_html(get_theme_mod('bd_about_num3_val','۱۲')); ?></b><span><?php echo esc_html(get_theme_mod('bd_about_num3_label','پارک و بوستان')); ?></span></div>
            <div><b><?php echo esc_html(get_theme_mod('bd_about_num4_val','۳۰+')); ?></b><span><?php echo esc_html(get_theme_mod('bd_about_num4_label','پروژه فعال')); ?></span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-title" style="margin-top:26px"><h2>مأموریت و ارزش‌ها</h2></div>
    <div class="info-grid">
      <?php foreach(bidrubeh_missions() as $m): ?>
      <div class="info-card"><h3><?php echo esc_html($m['t']); ?></h3><p><?php echo esc_html($m['d']); ?></p></div>
      <?php endforeach; ?>
    </div>
    <div class="section-title" style="margin-top:26px"><h2>مسیر خدمت</h2></div>
    <ol class="bd-timeline">
      <?php foreach(bidrubeh_timeline() as $s): ?>
      <li><b><?php echo esc_html($s['t']); ?></b><span><?php echo esc_html($s['d']); ?></span></li>
      <?php endforeach; ?>
    </ol>
    <p style="text-align:center;margin-top:26px">
      <a class="bd-send-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>"><span>تماس با ما</span></a>
      <a class="bd-send-btn" href="<?php echo esc_url(home_url('/#news')); ?>" style="margin-right:10px"><span>مشاهده اخبار</span></a>
    </p>
  </div>
</section>
<?php endwhile; get_footer(); ?>
