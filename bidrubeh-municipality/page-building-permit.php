<?php
/* Template Name: مراحل درخواست پروانه ساختمانی */
get_header();
while(have_posts()): the_post();
  $steps=bidrubeh_permit_steps();
?>
<section class="bd-permit-hero">
  <div class="wrap bd-permit-hero-grid">
    <div><a class="bd-permit-back" href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی / راهنمای شهروندان</a><h1><?php the_title(); ?></h1><p>از آماده‌کردن مدارک تا ثبت درخواست و بررسی کارشناسی؛ مسیر درخواست خود را قدم‌به‌قدم بشناسید.</p><a class="btn" href="#permit-steps">مشاهده مراحل ↓</a></div>
    <div class="bd-permit-emblem" aria-hidden="true"><?php echo bidrubeh_icon('bank'); ?><span>شهرداری بیدروبه</span><small>راهنمای درخواست پروانه</small></div>
  </div>
</section>
<section class="section bd-permit-main" id="permit-steps">
  <div class="wrap bd-permit-layout">
    <div><div class="bd-permit-intro"><h2>مراحل درخواست</h2><span><?php echo esc_html(bidrubeh_fa_digits(count($steps))); ?> مرحله</span></div>
      <ol class="bd-permit-steps">
      <?php foreach($steps as $index=>$step): $number=$index+1; ?>
        <li id="permit-step-<?php echo (int)$number; ?>"><span class="bd-permit-number" aria-hidden="true"><?php echo esc_html(bidrubeh_fa_digits($number)); ?></span><article class="bd-permit-card"><div class="bd-permit-card-top"><span>مرحله <?php echo esc_html(bidrubeh_fa_digits($number)); ?></span><span class="bd-permit-step-icon" aria-hidden="true"><?php echo bidrubeh_icon($step['icon']); ?></span></div><h3><?php echo esc_html($step['title']); ?></h3><?php if($step['description']!==''): ?><div class="bd-permit-description"><?php echo wpautop(esc_html($step['description'])); ?></div><?php endif; ?></article></li>
      <?php endforeach; ?>
      </ol>
      <?php if(!$steps): ?><p class="card">مراحل درخواست به‌زودی توسط شهرداری منتشر می‌شوند.</p><?php endif; ?>
    </div>
    <aside class="bd-permit-aside"><nav class="bd-permit-nav" aria-label="دسترسی به مراحل درخواست"><h2>مسیر درخواست شما</h2><?php foreach($steps as $index=>$step): ?><a href="#permit-step-<?php echo (int)($index+1); ?>"><span><?php echo esc_html(bidrubeh_fa_digits($index+1)); ?></span><?php echo esc_html($step['title']); ?></a><?php endforeach; ?></nav><div class="bd-permit-help"><span aria-hidden="true"><?php echo bidrubeh_icon('phone'); ?></span><h2>نیاز به راهنمایی دارید؟</h2><p>برای پرسش درباره مدارک و پیگیری درخواست، با شهرداری در ارتباط باشید.</p><a href="<?php echo esc_url(home_url('/contact-us/')); ?>">ارتباط با شهرداری ←</a></div></aside>
  </div>
</section>
<?php endwhile; get_footer(); ?>
