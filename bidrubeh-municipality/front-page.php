<?php
get_header();
$bd_phone = trim((string)get_theme_mod('bd_phone',''));
$bd_hotline = trim((string)get_theme_mod('bd_hotline','۱۳۷'));
$bd_primary_phone = $bd_phone!=='' ? $bd_phone : $bd_hotline;
$bd_primary_dial = preg_replace('/[^0-9]/','',bidrubeh_fa_to_en($bd_primary_phone));
$bd_address = trim((string)get_theme_mod('bd_address',''));
$bd_hours = trim((string)get_theme_mod('bd_office_hours','شنبه تا چهارشنبه، ۷:۳۰ تا ۱۴:۳۰'));
$bd_contact = get_page_by_path('contact-us');
$bd_contact_url = $bd_contact ? get_permalink($bd_contact) : home_url('/contact-us/');
$bd_about = get_page_by_path('about-us');
$bd_about_url = $bd_about ? get_permalink($bd_about) : home_url('/about-us/');
$bd_notice_term = get_category_by_slug(trim((string)get_theme_mod('bd_notice_cat','etelaeieh')));
$bd_notice_archive_url = $bd_notice_term ? get_category_link($bd_notice_term) : '#news';
$bd_news_term = get_category_by_slug('akhbar');
$bd_news_archive_url = $bd_news_term ? get_category_link($bd_news_term) : home_url('/category/akhbar/');
$bd_slides = bidrubeh_slider_posts();
$bd_mini_notice_args = bidrubeh_notice_query_args();
$bd_mini_notice_args['posts_per_page'] = 5;
$bd_mini_notices = get_posts($bd_mini_notice_args);
$bd_mini_news_args = ['posts_per_page'=>5,'post_type'=>'post','post_status'=>'publish','ignore_sticky_posts'=>1,'no_found_rows'=>true,'orderby'=>'date','order'=>'DESC'];
$bd_mini_news_exclude = bidrubeh_latest_news_exclude();
if($bd_mini_news_exclude) $bd_mini_news_args['category__not_in'] = $bd_mini_news_exclude;
$bd_mini_news = get_posts($bd_mini_news_args);
?>

<section class="bd-home-lead" aria-label="معرفی بیدروبه">
  <div class="wrap bd-home-lead-grid">
    <div class="bd-home-slider">
      <?php if($bd_slides): ?>
      <h1 class="bd-sr-only">شهرداری بیدروبه</h1>
      <div class="bd-slider" id="bdSlider" data-speed="<?php echo (int)bidrubeh_slider_speed(); ?>">
        <div class="bd-slides">
          <?php foreach($bd_slides as $si=>$sp): setup_postdata($GLOBALS['post']=$sp); ?>
          <article class="bd-slide<?php echo $si===0?' active':''; ?>" aria-hidden="<?php echo $si===0?'false':'true'; ?>"<?php echo $si===0?'':' inert'; ?>>
            <a href="<?php the_permalink(); ?>">
              <?php if(has_post_thumbnail()) the_post_thumbnail('large',['class'=>'bd-slide-img','sizes'=>'(max-width: 900px) 100vw, 65vw']); else echo '<span class="bd-slide-img bd-slide-ph"></span>'; ?>
              <span class="bd-slide-cap"><span class="bd-slide-cap-in"><strong><?php the_title(); ?></strong></span></span>
            </a>
          </article>
          <?php endforeach; wp_reset_postdata(); ?>
        </div>
        <?php if(count($bd_slides)>1): ?>
        <button class="bd-arrow bd-prev" type="button" aria-label="اسلاید قبلی"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg></button>
        <button class="bd-arrow bd-next" type="button" aria-label="اسلاید بعدی"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 5-7 7 7 7"/></svg></button>
        <div class="bd-dots" role="group" aria-label="انتخاب اسلاید"></div>
        <?php endif; ?>
      </div>
      <?php else: ?>
      <div class="bd-home-slider-empty">
        <h1>شهری نزدیک به مردم</h1>
        <p>خبرها، اطلاعیه‌ها و دیدنی‌های بیدروبه را در یک جا دنبال کنید.</p>
      </div>
      <?php endif; ?>
    </div>
    <div class="bd-home-side">
      <section class="bd-mini-panel bd-mini-notices" aria-label="اطلاعیه‌های اخیر">
        <div class="bd-mini-head"><h2>اطلاعیه‌ها</h2><?php if($bd_notice_term): ?><a href="<?php echo esc_url($bd_notice_archive_url); ?>">همه اطلاعیه‌ها ←</a><?php endif; ?></div>
        <?php if($bd_mini_notices): ?>
        <div class="bd-mini-slider" id="bdNoticeSlider" data-speed="<?php echo (int)bidrubeh_slider_speed(); ?>">
          <div class="bd-mini-viewport">
            <?php foreach($bd_mini_notices as $bd_i=>$bd_post): ?>
            <article class="bd-mini-slide<?php echo $bd_i===0?' active':''; ?>" aria-hidden="<?php echo $bd_i===0?'false':'true'; ?>"<?php echo $bd_i===0?'':' inert'; ?>>
              <a class="bd-mini-notice-link" href="<?php echo esc_url(get_permalink($bd_post)); ?>">
                <?php if(has_post_thumbnail($bd_post->ID)) echo get_the_post_thumbnail($bd_post->ID,'medium',['class'=>'bd-mini-notice-img','alt'=>'']); else echo '<span class="bd-mini-notice-icon" aria-hidden="true">'.bidrubeh_icon('news').'</span>'; ?>
                <span class="bd-mini-copy"><small><?php echo esc_html(bidrubeh_jdate($bd_post)); ?></small><strong><?php echo esc_html(get_the_title($bd_post)); ?></strong></span>
              </a>
            </article>
            <?php endforeach; ?>
          </div>
          <div class="bd-mini-footer"><span class="bd-mini-counter" aria-live="off">۱ از <?php echo esc_html(bidrubeh_fa_digits(count($bd_mini_notices))); ?></span><?php if(count($bd_mini_notices)>1): ?><div class="bd-mini-controls"><button class="bd-mini-prev" type="button" aria-label="اطلاعیه قبلی"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg></button><button class="bd-mini-next" type="button" aria-label="اطلاعیه بعدی"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 5-7 7 7 7"/></svg></button></div><?php endif; ?></div>
        </div>
        <?php else: ?><p class="bd-mini-empty">اطلاعیه‌ای منتشر نشده است.</p><?php endif; ?>
      </section>
      <section class="bd-mini-panel bd-mini-news" aria-label="آخرین خبرها">
        <div class="bd-mini-head"><h2>آخرین اخبار</h2><a href="<?php echo esc_url($bd_news_archive_url); ?>">همه خبرها ←</a></div>
        <?php if($bd_mini_news): ?>
        <div class="bd-mini-slider" id="bdNewsSlider" data-speed="<?php echo (int)bidrubeh_slider_speed(); ?>">
          <div class="bd-mini-viewport">
            <?php foreach($bd_mini_news as $bd_i=>$bd_post): ?>
            <article class="bd-mini-slide<?php echo $bd_i===0?' active':''; ?>" aria-hidden="<?php echo $bd_i===0?'false':'true'; ?>"<?php echo $bd_i===0?'':' inert'; ?>>
              <a class="bd-mini-news-link" href="<?php echo esc_url(get_permalink($bd_post)); ?>">
                <?php if(has_post_thumbnail($bd_post->ID)) echo get_the_post_thumbnail($bd_post->ID,'medium',['class'=>'bd-mini-news-img']); else echo '<span class="bd-mini-news-img bd-mini-news-ph" aria-hidden="true">'.bidrubeh_icon('news').'</span>'; ?>
                <span class="bd-mini-copy"><small><?php echo esc_html(bidrubeh_jdate($bd_post)); ?></small><strong><?php echo esc_html(get_the_title($bd_post)); ?></strong></span>
              </a>
            </article>
            <?php endforeach; ?>
          </div>
          <div class="bd-mini-footer"><span class="bd-mini-counter" aria-live="off">۱ از <?php echo esc_html(bidrubeh_fa_digits(count($bd_mini_news))); ?></span><?php if(count($bd_mini_news)>1): ?><div class="bd-mini-controls"><button class="bd-mini-prev" type="button" aria-label="خبر قبلی"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg></button><button class="bd-mini-next" type="button" aria-label="خبر بعدی"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 5-7 7 7 7"/></svg></button></div><?php endif; ?></div>
        </div>
        <?php else: ?><p class="bd-mini-empty">خبری منتشر نشده است.</p><?php endif; ?>
      </section>
    </div>
  </div>
</section>

<section class="section bd-section-soft" id="photos">
  <div class="wrap">
    <div class="section-title"><div><h2>گزارش‌های تصویری</h2></div><?php $bd_photo_term=get_category_by_slug(trim((string)get_theme_mod('bd_photo_cat','gozaresh-tasviri'))); if($bd_photo_term): ?><a class="bd-text-link" href="<?php echo esc_url(get_category_link($bd_photo_term)); ?>">همه گزارش‌ها ←</a><?php endif; ?></div>
    <?php $bd_photo_q=new WP_Query(bidrubeh_photo_query_args()); ?>
    <?php if($bd_photo_q->have_posts()): ?>
    <div class="bd-photo-grid">
      <?php while($bd_photo_q->have_posts()): $bd_photo_q->the_post(); ?>
      <a class="bd-photo-card" href="<?php the_permalink(); ?>">
        <?php if(has_post_thumbnail()) the_post_thumbnail('large',['class'=>'bd-photo-card-img']); else echo '<span class="bd-photo-card-img bd-photo-ph"></span>'; ?>
        <span class="bd-photo-card-body"><strong><?php the_title(); ?></strong><small><?php echo esc_html(bidrubeh_pdate('Y/m/d')); ?></small></span>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else: ?><p class="bd-empty">گزارش تصویری هنوز منتشر نشده است.</p><?php endif; ?>
  </div>
</section>

<?php $bd_attractions=bidrubeh_tourism_cards(); $bd_attract_term=bidrubeh_tourism_term(); if($bd_attractions!==''): ?>
<section class="section" id="attractions">
  <div class="wrap">
    <div class="section-title"><div><h2>جاذبه‌های بیدروبه</h2></div><?php if($bd_attract_term): ?><a class="bd-text-link" href="<?php echo esc_url(get_category_link($bd_attract_term)); ?>">همه جاذبه‌ها ←</a><?php endif; ?></div>
    <?php echo $bd_attractions; ?>
  </div>
</section>
<?php endif; ?>

<section class="section bd-section-soft" id="news">
  <div class="wrap">
    <div class="section-title"><div><h2>آخرین اخبار</h2></div><a class="bd-text-link" href="<?php echo esc_url($bd_news_archive_url); ?>">همه خبرها ←</a></div>
    <?php $bd_news_args=['posts_per_page'=>3,'ignore_sticky_posts'=>1]; $bd_exclude=bidrubeh_latest_news_exclude(); if($bd_exclude) $bd_news_args['category__not_in']=$bd_exclude; $bd_news_q=new WP_Query($bd_news_args); ?>
    <?php if($bd_news_q->have_posts()): ?>
    <div class="news-grid bd-home-news">
      <?php while($bd_news_q->have_posts()): $bd_news_q->the_post(); ?>
      <a class="news-thumb-card" href="<?php the_permalink(); ?>">
        <?php if(has_post_thumbnail()) the_post_thumbnail('medium_large',['class'=>'news-thumb-img']); else echo '<span class="news-thumb-img news-thumb-ph"></span>'; ?>
        <span class="news-thumb-body"><small class="meta"><?php echo esc_html(bidrubeh_pdate('')); ?></small><strong><?php the_title(); ?></strong></span>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else: ?><p class="bd-empty">هنوز خبری منتشر نشده است.</p><?php endif; ?>
  </div>
</section>

<section class="section bd-city-story">
  <div class="wrap bd-city-story-grid">
    <div>
      <h2>بیدروبه را بیشتر بشناسیم</h2>
      <p>بیدروبه با محله‌ها، مردم و چشم‌اندازهای خود هویت ویژه‌ای دارد. این بخش دریچه‌ای برای آشنایی با شهر و فعالیت‌های شهرداری است.</p>
      <a class="bd-text-link" href="<?php echo esc_url($bd_about_url); ?>">درباره بیدروبه <span aria-hidden="true">←</span></a>
    </div>
    <div class="bd-city-story-art" aria-hidden="true"><span>بیدروبه</span><small>شهر ما، خانه ما</small></div>
  </div>
</section>

<section class="section bd-municipal-info" id="municipality">
  <div class="wrap">
    <div class="section-title bd-municipal-head"><div><h2>اطلاعات شهرداری</h2><p class="bd-municipal-intro">راه‌های ارتباط و اطلاعات مراجعه به شهرداری بیدروبه</p></div></div>
    <div class="bd-municipal-grid">
      <div class="bd-municipal-card bd-municipal-card-contact bd-municipal--contact">
        <div class="bd-municipal-card-heading"><span class="bd-municipal-icon" aria-hidden="true"><?php echo bidrubeh_icon('mail'); ?></span><h3>ارتباط با شهرداری</h3></div>
        <p>پرسش‌ها و درخواست‌های خود را با ما در میان بگذارید.</p>
        <?php $bd_email=trim((string)get_theme_mod('bd_email','')); if($bd_email!==''): ?><a class="bd-municipal-mail" href="<?php echo esc_url('mailto:'.$bd_email); ?>"><?php echo esc_html($bd_email); ?></a><?php endif; ?>
        <a class="bd-municipal-btn" href="<?php echo esc_url($bd_contact_url); ?>">تماس با ما <span aria-hidden="true">←</span></a>
      </div>
      <div class="bd-municipal-card bd-municipal--address">
        <div class="bd-municipal-card-heading"><span class="bd-municipal-icon" aria-hidden="true"><?php echo bidrubeh_icon('pin'); ?></span><h3>نشانی شهرداری</h3></div>
        <p><?php echo $bd_address!==''?esc_html($bd_address):'نشانی در حال تکمیل است.'; ?></p>
      </div>
      <div class="bd-municipal-card bd-municipal--phone">
        <div class="bd-municipal-card-heading"><span class="bd-municipal-icon" aria-hidden="true"><?php echo bidrubeh_icon('phone'); ?></span><h3>تلفن شهرداری</h3></div>
        <?php if($bd_primary_phone!==''): ?><a class="bd-municipal-phone" href="<?php echo esc_url('tel:'.$bd_primary_dial); ?>" dir="ltr"><?php echo esc_html($bd_primary_phone); ?></a><?php endif; ?>
        <?php if($bd_phone!=='' && $bd_hotline!=='' && $bd_phone!==$bd_hotline): ?><a class="bd-municipal-badge" href="<?php echo esc_url('tel:'.preg_replace('/[^0-9]/','',bidrubeh_fa_to_en($bd_hotline))); ?>">سامانه شهروندان <?php echo esc_html($bd_hotline); ?></a><?php endif; ?>
      </div>
      <div class="bd-municipal-card bd-municipal--hours">
        <div class="bd-municipal-card-heading"><span class="bd-municipal-icon" aria-hidden="true"><?php echo bidrubeh_icon('clock'); ?></span><h3>ساعات کاری</h3></div>
        <p><?php echo $bd_hours!==''?esc_html($bd_hours):'برای اطلاع از ساعات کاری با شهرداری تماس بگیرید.'; ?></p>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
