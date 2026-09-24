<?php
/* Template Name: سوالات متداول */
get_header();
while(have_posts()): the_post();
?>
<section class="section">
  <div class="wrap">
    <div class="card">
      <div class="section-title"><h2>سوالات متداول</h2></div>
      <?php $faqs=bidrubeh_faqs(); if($faqs): ?>
      <div class="bd-faq" id="bdFaq">
        <?php foreach($faqs as $f): ?>
        <div class="bd-faq-item">
          <button class="bd-faq-q" type="button" aria-expanded="false"><span><?php echo esc_html($f['q']); ?></span><span class="bd-faq-plus">+</span></button>
          <div class="bd-faq-a"><p><?php echo esc_html($f['a']); ?></p></div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <p>هنوز سوالی ثبت نشده است.</p>
      <?php endif; ?>
      <p style="text-align:center;margin-top:22px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
        <a class="bd-send-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>"><span>تماس با ما</span></a>
        <a class="btn" href="<?php echo esc_url(home_url('/#news')); ?>">مشاهده اخبار</a>
      </p>
    </div>
  </div>
</section>
<?php endwhile; get_footer(); ?>
