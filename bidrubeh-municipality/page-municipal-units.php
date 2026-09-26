<?php
/* Template Name: واحدهای شهرداری */
get_header();
while(have_posts()): the_post(); $units=bidrubeh_municipal_units(); ?>
<section class="bd-units-hero"><div class="wrap"><a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی / شهرداری بیدروبه</a><h1><?php the_title(); ?></h1><p>آشنایی با واحدهای شهرداری بیدروبه و ساختار مجموعه</p></div></section>
<section class="section bd-units-section"><div class="wrap">
  <div class="bd-org-chart" aria-label="چارت واحدهای شهرداری">
    <div class="bd-org-root"><span class="bd-org-root-icon" aria-hidden="true"><?php echo bidrubeh_icon('bank'); ?></span><h2><?php echo esc_html(get_theme_mod('bd_units_root','شهرداری بیدروبه')); ?></h2><span>واحدهای زیرمجموعه</span></div>
    <?php if($units): ?><ul class="bd-org-branches">
    <?php foreach($units as $index=>$unit): ?>
      <li><article class="bd-org-card"><div class="bd-org-card-heading"><span class="bd-org-icon" aria-hidden="true"><?php echo bidrubeh_icon($unit['icon']); ?></span><h3><?php echo esc_html($unit['title']); ?></h3><span class="bd-org-number" aria-hidden="true"><?php echo esc_html(bidrubeh_fa_digits($index+1)); ?></span></div><?php if($unit['description']!==''): ?><div class="bd-org-description"><?php echo wpautop(esc_html($unit['description'])); ?></div><?php endif; ?></article></li>
    <?php endforeach; ?>
    </ul><?php else: ?><p class="bd-org-empty">اطلاعات واحدها به‌زودی منتشر می‌شود.</p><?php endif; ?>
  </div>
  <div class="bd-units-contact"><span aria-hidden="true"><?php echo bidrubeh_icon('phone'); ?></span><div><h2>ارتباط با واحدهای شهرداری</h2><p>برای ارتباط و پیگیری موضوع خود، از صفحه تماس با ما اقدام کنید.</p></div><a class="btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">تماس با ما ←</a></div>
</div></section>
<?php endwhile; get_footer(); ?>
