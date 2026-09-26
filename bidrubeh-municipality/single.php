<?php get_header(); ?>
<section class="section"><div class="wrap content-grid bd-single-grid">
<div class="bd-single-main">
<?php while(have_posts()): the_post(); ?>
<article class="loop-card">
<h2><?php the_title(); ?></h2>
<div class="meta bd-post-meta"><span><?php echo esc_html(bidrubeh_pdate('Y/m/d')); ?></span><span>نویسنده: <?php the_author(); ?></span><?php echo bidrubeh_post_views_html(); ?></div>
<?php if(has_post_thumbnail()) the_post_thumbnail('large'); ?>
<div><?php the_content(); ?></div>
<div style="margin-top:12px"><?php the_tags('برچسب‌ها: ',', ',''); ?></div>
<?php $rel=bidrubeh_related_posts(get_the_ID(),3); if(!empty($rel)): ?>
<div class="bd-related"><h3><?php esc_html_e('اخبار مرتبط','bidrubeh'); ?></h3><div class="bd-related-list"><?php foreach($rel as $rp){ echo '<a class="bd-related-card" href="'.esc_url(get_permalink($rp)).'">'; if(has_post_thumbnail($rp->ID)) echo get_the_post_thumbnail($rp->ID,[400,260],['class'=>'bd-related-thumb']); else echo '<span class="bd-related-thumb"></span>'; echo '<span class="bd-related-body"><strong>'.esc_html(get_the_title($rp)).'</strong><small>'.esc_html(bidrubeh_jdate($rp)).'</small></span></a>'; } ?></div></div>
<?php endif; ?>
</article>
<?php endwhile; ?>
</div>
<?php get_sidebar(); ?>
<div class="bd-single-comments"><?php comments_template(); ?></div>
</div></section>
<?php get_footer(); ?>
