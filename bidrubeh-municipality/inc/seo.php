<?php
/** Search and sharing metadata for the municipal home page and news posts. */

function bidrubeh_seo_plugin_active(){
  return defined('WPSEO_VERSION')||defined('RANK_MATH_VERSION')||defined('AIOSEO_VERSION')||defined('SEOPRESS_VERSION');
}
function bidrubeh_seo_clean_text($value){
  $value=wp_strip_all_tags(strip_shortcodes((string)$value),true);
  $value=html_entity_decode($value,ENT_QUOTES|ENT_HTML5,get_bloginfo('charset'));
  return trim((string)preg_replace('/\s+/u',' ',$value));
}
function bidrubeh_seo_is_placeholder($value){
  return (bool)preg_match('/لید خبر در اینجا|این یک متن نمونه|متن نمونه اطلاع‌رسانی|قالب پوینت|در ادامه مشروح خبر می‌آید/u',$value);
}
function bidrubeh_seo_is_news_post($post){
  if(!$post||$post->post_type!=='post') return false;
  $excluded=bidrubeh_latest_news_exclude();
  return !$excluded||!has_category($excluded,$post);
}
function bidrubeh_seo_description($post){
  $manual=bidrubeh_seo_clean_text(get_post_meta($post->ID,'_bd_seo_description',true));
  if($manual!=='') return wp_trim_words($manual,32,'…');
  foreach([$post->post_excerpt,$post->post_content] as $source){
    $value=bidrubeh_seo_clean_text($source);
    if($value!==''&&!bidrubeh_seo_is_placeholder($value)) return wp_trim_words($value,32,'…');
  }
  return sprintf('خبر «%s» در پایگاه اطلاع‌رسانی شهرداری بیدروبه، شهرستان اندیمشک.',bidrubeh_seo_clean_text(get_the_title($post)));
}
function bidrubeh_seo_json_ld($data){
  echo '<script type="application/ld+json">'.wp_json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT)."</script>\n";
}
add_action('wp_head',function(){
  if(bidrubeh_seo_plugin_active()) return;
  $site_name=get_bloginfo('name');
  $site_url=home_url('/');
  if(is_front_page()){
    $description='پایگاه رسمی شهرداری بیدروبه در شهرستان اندیمشک، استان خوزستان؛ اخبار، اطلاعیه‌ها، خدمات شهری و راه‌های ارتباط با شهرداری.';
    echo '<meta name="description" content="'.esc_attr($description).'">' . "\n";
    echo '<link rel="canonical" href="'.esc_url($site_url).'">' . "\n";
    bidrubeh_seo_json_ld(['@context'=>'https://schema.org','@type'=>'WebSite','name'=>$site_name,'url'=>$site_url,'inLanguage'=>'fa-IR']);
    return;
  }
  if(!is_singular('post')) return;
  $post=get_queried_object();
  if(!bidrubeh_seo_is_news_post($post)) return;
  $url=get_permalink($post);
  $title=bidrubeh_seo_clean_text(get_the_title($post));
  $description=bidrubeh_seo_description($post);
  $image=get_the_post_thumbnail_url($post,'full');
  echo '<meta name="description" content="'.esc_attr($description).'">' . "\n";
  echo '<meta property="og:type" content="article">' . "\n";
  echo '<meta property="og:site_name" content="'.esc_attr($site_name).'">' . "\n";
  echo '<meta property="og:title" content="'.esc_attr($title).'">' . "\n";
  echo '<meta property="og:description" content="'.esc_attr($description).'">' . "\n";
  echo '<meta property="og:url" content="'.esc_url($url).'">' . "\n";
  if($image) echo '<meta property="og:image" content="'.esc_url($image).'">' . "\n";
  echo '<meta name="twitter:card" content="'.($image?'summary_large_image':'summary').'">' . "\n";
  if(bidrubeh_seo_is_placeholder(bidrubeh_seo_clean_text($post->post_content))||bidrubeh_seo_clean_text($post->post_content)==='') return;
  $article=['@context'=>'https://schema.org','@type'=>'NewsArticle','headline'=>$title,'description'=>$description,'mainEntityOfPage'=>$url,'datePublished'=>get_post_time('c',false,$post),'dateModified'=>get_post_modified_time('c',false,$post),'inLanguage'=>'fa-IR','publisher'=>['@type'=>'Organization','name'=>$site_name,'url'=>$site_url]];
  if($image) $article['image']=$image;
  $author=trim((string)get_the_author_meta('display_name',$post->post_author));
  if($author!=='') $article['author']=['@type'=>'Person','name'=>$author];
  bidrubeh_seo_json_ld($article);
},5);

add_action('add_meta_boxes_post',function(){
  add_meta_box('bd_seo_description','توضیح خبر برای جست‌وجو',function($post){
    wp_nonce_field('bd_seo_description','bd_seo_description_nonce');
    $value=get_post_meta($post->ID,'_bd_seo_description',true);
    echo '<p><label for="bd_seo_description">خلاصه‌ای دقیق و مخصوص همین خبر بنویسید. اگر خالی بماند، از چکیده یا متن واقعی خبر استفاده می‌شود.</label></p>';
    echo '<textarea id="bd_seo_description" name="bd_seo_description" rows="3" class="widefat" maxlength="300">'.esc_textarea($value).'</textarea>';
  },'post','normal','default');
});
add_action('save_post_post',function($post_id){
  if(wp_is_post_revision($post_id)||wp_is_post_autosave($post_id)||(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)||!current_user_can('edit_post',$post_id)) return;
  if(!isset($_POST['bd_seo_description_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bd_seo_description_nonce'])),'bd_seo_description')) return;
  $value=sanitize_textarea_field(wp_unslash($_POST['bd_seo_description']??''));
  if($value==='') delete_post_meta($post_id,'_bd_seo_description');
  else update_post_meta($post_id,'_bd_seo_description',$value);
});
