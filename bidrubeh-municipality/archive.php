<?php get_header(); ?>
<section class="section"><div class="wrap content-grid">
<div>
<div class="loop-card"><h2><?php echo get_query_var('bd_news_archive')?'آخرین اخبار':wp_kses_post(get_the_archive_title()); ?></h2><?php if(!get_query_var('bd_news_archive')): ?><p><?php the_archive_description(); ?></p><?php else: ?><p>تازه‌ترین خبرهای منتشرشده در شهرداری بیدروبه</p><?php endif; ?></div>
<?php if(have_posts()): echo '<div class="news-grid" style="margin-bottom:14px">';
while(have_posts()): the_post(); ?>
<a class="news-thumb-card" href="<?php the_permalink(); ?>">
<?php if(has_post_thumbnail()) { the_post_thumbnail([400,260],['class'=>'news-thumb-img']); } else { echo '<span class="news-thumb-img news-thumb-ph"></span>'; } ?>
<span class="news-thumb-body"><strong><?php the_title(); ?></strong><small class="meta"><?php echo esc_html(bidrubeh_pdate('')); ?> | <span class="bd-comment-count"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a8 8 0 0 1-8 8H5l-2 2V12a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8z"/></svg><?php echo esc_html(bidrubeh_comments_label()); ?></span></small></span>
</a>
<?php endwhile; echo '</div>'; the_posts_pagination(); else: ?><div class="loop-card"><p>هنوز خبری منتشر نشده است.</p></div><?php endif; ?>
</div>
<?php get_sidebar(); ?>
</div></section>
<?php get_footer(); ?>
