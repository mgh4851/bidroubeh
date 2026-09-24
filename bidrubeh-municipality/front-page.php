<?php get_header(); ?>

<?php $sposts=bidrubeh_slider_posts((int)get_theme_mod('bd_slider_count',5)); if(!empty($sposts)): ?>
<section class="section bd-slider-full" id="slider" style="padding:0">
  <div class="bd-slider" id="bdSlider" data-speed="<?php echo (int)bidrubeh_slider_speed(); ?>">
      <div class="bd-slides">
        <?php foreach($sposts as $si=>$sp): setup_postdata($GLOBALS['post']=$sp); ?>
            <div class="bd-slide<?php echo 0===$si?' active':''; ?>">
              <a href="<?php the_permalink(); ?>">
                <?php if(has_post_thumbnail()) { the_post_thumbnail('full',['class'=>'bd-slide-img','sizes'=>'100vw']); } else { echo '<span class="bd-slide-img bd-slide-ph"></span>'; } ?>
                <span class="bd-slide-cap"><span class="bd-slide-cap-in"><strong><?php the_title(); ?></strong></span></span>
              </a>
            </div>
          <?php endforeach; wp_reset_postdata(); ?>
      </div>
      <button class="bd-arrow bd-prev" type="button" aria-label="قبلی">‹</button>
      <button class="bd-arrow bd-next" type="button" aria-label="بعدی">›</button>
      <div class="bd-dots" role="tablist"></div>
  </div>
</section>
<?php endif; ?>

<section class="section" id="photos" style="padding-top:24px">
  <div class="wrap">
    <div class="section-title"><h2>گزارش‌های تصویری</h2><?php $pterm=get_category_by_slug(trim((string)get_theme_mod('bd_photo_cat','gozaresh-tasviri'))); if($pterm){ echo '<a class="btn" href="'.esc_url(get_category_link($pterm)).'">آرشیو گزارش‌ها</a>'; } ?></div>
    <?php
    $pq=new WP_Query(bidrubeh_photo_query_args());
    if(!$pq->have_posts()) $pq=new WP_Query(['posts_per_page'=>(int)get_theme_mod('bd_photo_count',3),'ignore_sticky_posts'=>1,'no_found_rows'=>true]);
    if($pq->have_posts()):
    ?>
    <div class="bd-photo-grid">
      <?php while($pq->have_posts()): $pq->the_post(); ?>
      <a class="bd-photo-card" href="<?php the_permalink(); ?>">
        <?php if(has_post_thumbnail()) { the_post_thumbnail('large',['class'=>'bd-photo-card-img']); } else { echo '<span class="bd-photo-card-img bd-photo-ph"></span>'; } ?>
        <span class="bd-photo-card-body"><strong><?php the_title(); ?></strong><small><?php echo esc_html(bidrubeh_pdate('Y/m/d')); ?></small></span>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<section class="section" id="news" style="padding-top:0">
  <div class="wrap two-col bd-news-layout">
    <div class="card bd-latest-col">
      <h3 class="widget-heading"><span>آخرین اخبار</span><?php $at=get_category_by_slug('akhbar'); if($at){ echo '<a class="btn btn-sm" href="'.esc_url(get_category_link($at)).'">آرشیو اخبار</a>'; } ?></h3>
      <?php
      $lqargs=['posts_per_page'=>6,'ignore_sticky_posts'=>1]; $lex=bidrubeh_latest_news_exclude(); if(!empty($lex)) $lqargs['category__not_in']=$lex;
      $q=new WP_Query($lqargs);
      if($q->have_posts()): echo '<div class="news-grid">';
        while($q->have_posts()): $q->the_post(); ?>
          <a class="news-thumb-card" href="<?php the_permalink(); ?>">
            <?php if(has_post_thumbnail()) { the_post_thumbnail([400,260],['class'=>'news-thumb-img']); } else { echo '<span class="news-thumb-img news-thumb-ph"></span>'; } ?>
            <span class="news-thumb-body">
              <strong><?php the_title(); ?></strong>
              <small class="meta meta-row"><span class="bd-date"><?php echo esc_html(bidrubeh_pdate('')); ?></span><span class="bd-sep">|</span><span class="bd-comment-count"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a8 8 0 0 1-8 8H5l-2 2V12a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8z"/></svg><?php echo esc_html(bidrubeh_comments_label()); ?></span></small>
            </span>
          </a>
        <?php endwhile;
        echo '</div>'; wp_reset_postdata();
      else: ?>
        <ul class="notice-list">
          <li>سامانه ۱۳۷ شهرداری بیدروبه آماده دریافت درخواست‌های شهروندان است.</li>
          <li>مهلت پرداخت عوارض نوسازی با تخفیف خوش‌حسابی اعلام شد.</li>
          <li>برنامه هفتگی جمع‌آوری پسماند خشک محلات منتشر شد.</li>
        </ul>
      <?php endif; ?>
    </div>
    <div class="card bd-notices-col">
      <h3 class="widget-heading"><span>اطلاعیه‌های مهم</span><?php $nt=get_category_by_slug(trim((string)get_theme_mod('bd_notice_cat','etelaeieh'))); if($nt){ echo '<a class="btn btn-sm" href="'.esc_url(get_category_link($nt)).'">آرشیو اطلاعیه‌ها</a>'; } ?></h3>
      <?php
      $nargs=bidrubeh_notice_query_args();
      $nargs['posts_per_page']=5;
      $nq=new WP_Query($nargs);
      if($nq->have_posts()): ?>
        <ul class="bd-notice-list">
          <?php while($nq->have_posts()): $nq->the_post(); ?>
            <li><a class="bd-notice-row" href="<?php the_permalink(); ?>">
              <?php if(has_post_thumbnail()) { the_post_thumbnail([160,120],['class'=>'bd-notice-thumb']); } else { echo '<span class="bd-notice-thumb bd-notice-ph"></span>'; } ?>
              <span class="bd-notice-body"><strong><?php the_title(); ?></strong><small class="meta"><?php echo esc_html(bidrubeh_jdate()); ?></small></span>
            </a></li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      <?php else: ?>
        <p class="bd-empty" style="font-size:13px;color:var(--bd-muted);margin:0">اطلاعیه‌ای ثبت نشده است.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

    <?php $agal=bidrubeh_tourism_cards(); $aterm=bidrubeh_tourism_term(); if($agal!==''): ?>
<section class="section" id="attractions" style="padding-top:0">
  <div class="wrap">
    <div class="section-title"><h2><?php echo $aterm?esc_html($aterm->name):esc_html__('جاذبه‌های گردشگری','bidrubeh'); ?></h2><?php if($aterm){ echo '<a class="btn" href="'.esc_url(get_category_link($aterm)).'">آرشیو جاذبه‌ها</a>'; } ?></div>
    <?php echo $agal; ?>
  </div>
</section>
    <?php endif; ?>

<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="about">
      <div>
        <div class="section-title"><h2>بیدروبه؛ شهری برای زندگی</h2></div>
        <p>شهرداری بیدروبه با رویکرد شفافیت، خدمات غیرحضوری و توسعه متوازن محلات، تلاش می‌کند شهری تمیز، ایمن و سرزنده بسازد. اولویت ما پاسخگویی سریع، نگهداشت فضای سبز، بهسازی معابر و حمایت از فرهنگ و نشاط اجتماعی است.</p>
        <p><a class="btn" href="<?php $ab=get_page_by_path('about-us'); echo $ab?esc_url(get_permalink($ab)):esc_url(home_url('/')); ?>">درباره شهرداری</a></p>
      </div>
      <div>
        <?php foreach(bidrubeh_bars() as $bar): ?>
        <div class="bar"><span class="lbl"><span><?php echo esc_html($bar['t']); ?></span><span><?php echo esc_html(bidrubeh_fa_digits($bar['p']).'٪'); ?></span></span><div class="track"><div class="fill" style="width:<?php echo (int)$bar['p']; ?>%"></div></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="section-title"><h2>بیدروبه در یک نگاه</h2></div>
    <div class="info-grid">
      <?php foreach(bidrubeh_info_cards() as $c): ?>
      <div class="info-card"><h3><?php echo esc_html($c['t']); ?></h3><p><?php echo esc_html($c['d']); ?></p><div class="nums"><?php foreach($c['n'] as $n): ?><div><b><?php echo esc_html($n['v']); ?></b><?php echo esc_html($n['l']); ?></div><?php endforeach; ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="stats-band">
      <div><b><?php echo esc_html(get_theme_mod('bd_population','۲۵٬۰۰۰+')); ?></b><span>جمعیت شهر</span></div>
      <div><b><?php echo esc_html(get_theme_mod('bd_area','۱۸ کیلومتر مربع')); ?></b><span>وسعت شهر</span></div>
      <div><b><?php echo esc_html(get_theme_mod('bd_stat3_val','۲۴ ساعته')); ?></b><span><?php echo esc_html(get_theme_mod('bd_stat3_label','پاسخگویی ۱۳۷')); ?></span></div>
      <div><b><?php echo esc_html(get_theme_mod('bd_stat4_val','۹۰٪')); ?></b><span><?php echo esc_html(get_theme_mod('bd_stat4_label','شاخص رضایت')); ?></span></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="section-title"><h2>نواحی و محلات</h2></div>
    <div class="zone-grid">
      <?php foreach(bidrubeh_zones() as $z): ?>
      <div class="zone"><h4><?php echo esc_html($z['t']); ?></h4><p><?php echo esc_html($z['d']); ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="card" style="text-align:center">
      <h2 style="margin:0 0 6px;font-size:22px;color:var(--bd-primary-2)">سوالی دارید؟</h2>
      <p style="font-size:14px;color:var(--bd-muted);margin:0 0 6px">پاسخ پرسش‌های پرتکرار را بخوانید یا مستقیم با شهرداری در تماس باشید.</p>
      <p class="bd-cta-band">
        <a class="btn" href="<?php $fq=get_page_by_path('faq'); echo $fq?esc_url(get_permalink($fq)):esc_url(home_url('/faq/')); ?>">سوالات متداول</a>
        <a class="bd-send-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>"><span>تماس با ما</span></a>
      </p>
    </div>
  </div>
</section>
<?php get_footer(); ?>
