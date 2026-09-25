</main>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div>
      <h4><span class="bd-foot-ico"><?php echo bidrubeh_icon('bank'); ?></span><?php bloginfo('name'); ?></h4>
      <p style="font-size:14px"><?php bloginfo('description'); ?></p>
      <p class="bd-foot-contact">
        <span class="bd-foot-row"><span class="bd-foot-row-ico"><?php echo bidrubeh_icon('pin'); ?></span><?php echo esc_html(get_theme_mod('bd_address','خوزستان، بیدروبه، ساختمان شهرداری مرکزی')); ?></span>
        <?php $bd_foot_phone=trim((string)get_theme_mod('bd_phone','')); if($bd_foot_phone!==''): ?><span class="bd-foot-row"><span class="bd-foot-row-ico"><?php echo bidrubeh_icon('phone'); ?></span><span dir="ltr"><?php echo esc_html($bd_foot_phone); ?></span></span><?php endif; ?>
        <?php $bd_foot_email=trim((string)get_theme_mod('bd_email','')); if($bd_foot_email!==''): ?><span class="bd-foot-row"><span class="bd-foot-row-ico"><?php echo bidrubeh_icon('mail'); ?></span><?php echo esc_html($bd_foot_email); ?></span><?php endif; ?>
      </p>
      <?php $soc=bidrubeh_social_links(); if($soc!==''){ echo '<div class="bd-socials">'.$soc.'</div>'; } ?>
    </div>
    <div>
      <?php if(is_active_sidebar('footer-1')) dynamic_sidebar('footer-1'); else { ?>
        <h4><span class="bd-foot-ico"><?php echo bidrubeh_icon('link'); ?></span><?php echo esc_html(get_theme_mod('bd_footer1_title','پیوندها')); ?></h4>
        <ul class="bd-foot-links"><?php foreach(bidrubeh_footer_links() as $l){ echo '<li><a href="'.esc_url($l['u']).'"><span class="bd-foot-link-ico">‹</span>'.esc_html($l['t']).'</a></li>'; } ?></ul>
      <?php } ?>
    </div>
    <div>
      <?php if(is_active_sidebar('footer-2')) dynamic_sidebar('footer-2'); else { ?>
        <h4><span class="bd-foot-ico"><?php echo bidrubeh_icon('bolt'); ?></span><?php echo esc_html(get_theme_mod('bd_footer2_title','دسترسی سریع')); ?></h4>
        <?php wp_nav_menu(['theme_location'=>'footer','container'=>false,'menu_class'=>'bd-foot-links','fallback_cb'=>function(){ echo '<ul class="bd-foot-links"><li><a href="#news"><span class="bd-foot-link-ico">‹</span>اخبار</a></li><li><a href="#"><span class="bd-foot-link-ico">‹</span>درباره ما</a></li><li><a href="#"><span class="bd-foot-link-ico">‹</span>حریم خصوصی</a></li></ul>'; }]); ?>
      <?php } ?>
    </div>
  </div>
  <div class="copyright">کلیه حقوق متعلق به <?php bloginfo('name'); ?> است.</div>
</footer>
<button id="bdToTop" class="bd-to-top" type="button" aria-label="بازگشت به بالا">↑</button>
<?php wp_footer(); ?>
</body>
</html>
