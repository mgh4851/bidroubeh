<?php
defined('ABSPATH') || exit;

function bidrubeh_admin_content_links(){
  $news=get_category_by_slug('akhbar');
  $notice=get_category_by_slug(trim((string)get_theme_mod('bd_notice_cat','etelaeieh')));
  $photo=get_category_by_slug(trim((string)get_theme_mod('bd_photo_cat','gozaresh-tasviri')));
  return ['خبر جدید'=>$news,'اطلاعیه جدید'=>$notice,'گزارش تصویری جدید'=>$photo,'جاذبه جدید'=>bidrubeh_tourism_term(),'شهید جدید'=>bidrubeh_martyrs_term()];
}
add_filter('option_default_category',function($category){
  global $pagenow;
  if(!is_admin()||$pagenow!=='post-new.php'||!current_user_can('edit_posts')||($_GET['post_type']??'post')!=='post')return $category;
  $id=absint($_GET['bd_category']??0);
  return $id&&term_exists($id,'category')?$id:$category;
});
function bidrubeh_admin_setting_links(){
  return ['اطلاعات و ساعات کاری'=>'bidrubeh_city','لوگو و عکس‌های هدر'=>'bidrubeh_brand','واحدهای شهرداری'=>'bd_units','مراحل پروانه ساختمانی'=>'bd_permit','نواحی و محلات'=>'bidrubeh_zones','کارت‌های اطلاعاتی'=>'bidrubeh_info','درصدهای شهر'=>'bd_city_gauges'];
}
function bidrubeh_admin_render_settings(){
  foreach(bidrubeh_admin_setting_links() as $label=>$section){
    echo '<a class="button" href="'.esc_url(add_query_arg('autofocus[section]',$section,admin_url('customize.php'))).'">'.esc_html($label).'</a> ';
  }
}
add_action('wp_dashboard_setup',function(){
  if(!current_user_can('edit_posts'))return;
  wp_add_dashboard_widget('bd_municipal_tools','کارهای روزانه شهرداری',function(){
    echo '<div class="bd-admin-panel"><h3>ثبت محتوای تازه</h3><div class="bd-admin-actions">';
    foreach(bidrubeh_admin_content_links() as $label=>$term){
      $url=$term?add_query_arg('bd_category',(int)$term->term_id,admin_url('post-new.php')):admin_url('post-new.php');
      echo '<a class="button button-primary" href="'.esc_url($url).'">'.esc_html($label).'</a>';
    }
    echo '</div><div class="bd-admin-counts">';
    if(current_user_can('read_private_posts')){
      $q=new WP_Query(['post_type'=>'bidrubeh_msg','post_status'=>'private','posts_per_page'=>1,'fields'=>'ids','meta_query'=>['relation'=>'OR',['key'=>'bd_read','value'=>'0'],['key'=>'bd_read','compare'=>'NOT EXISTS']]]);
      echo '<a href="'.esc_url(admin_url('edit.php?post_type=bidrubeh_msg&bd_read_filter=unread')).'"><strong>'.esc_html(bidrubeh_fa_digits($q->found_posts)).'</strong> پیام خوانده‌نشده</a>';
    }
    if(current_user_can('moderate_comments'))echo '<a href="'.esc_url(admin_url('edit-comments.php?comment_status=moderated')).'"><strong>'.esc_html(bidrubeh_fa_digits(wp_count_comments()->moderated)).'</strong> دیدگاه منتظر تأیید</a>';
    echo '</div><h3>آخرین مطالب منتشرشده</h3><ul class="bd-admin-recent">';
    foreach(get_posts(['post_type'=>'post','post_status'=>'publish','numberposts'=>5]) as $post){
      $url=current_user_can('edit_post',$post->ID)?get_edit_post_link($post->ID):get_permalink($post);
      echo '<li><a href="'.esc_url($url).'">'.esc_html(get_the_title($post)).'</a><small>'.wp_kses_post(bidrubeh_admin_publication_date('',$post)).'</small></li>';
    }
    echo '</ul>';
    if(current_user_can('edit_theme_options')){echo '<h3>تنظیمات اطلاعات شهرداری</h3><div class="bd-admin-actions">';bidrubeh_admin_render_settings();echo '</div>';}
    echo '</div>';
  });
});
add_action('admin_menu',function(){
  add_theme_page('اطلاعات شهرداری','اطلاعات شهرداری','edit_theme_options','bd-city-settings',function(){
    if(!current_user_can('edit_theme_options'))return;
    echo '<div class="wrap"><h1>اطلاعات شهرداری</h1><p>بخش مورد نظر را برای ویرایش انتخاب کنید. پس از تغییر، دکمهٔ «انتشار» را بزنید.</p><div class="bd-admin-actions">';bidrubeh_admin_render_settings();echo '</div></div>';
  });
});
add_filter('manage_post_posts_columns',function($columns){
  $result=[];
  foreach($columns as $key=>$label){
    if($key==='date')continue;
    $result[$key]=$label;
    if($key==='cb')$result['bd_thumbnail']='عکس شاخص';
    if($key==='title'){
      $result['bd_actions']='عملیات';
      $result['bd_last_status']='آخرین وضعیت';
    }
  }
  $result['bd_views']='تعداد بازدید';return $result;
},20);
add_filter('post_row_actions',function($actions,$post){
  $screen=get_current_screen();
  if(!$screen||$screen->id!=='edit-post')return $actions;
  $GLOBALS['bd_post_row_actions'][$post->ID]=$actions;
  return [];
},PHP_INT_MAX,2);
add_action('manage_post_posts_custom_column',function($column,$id){
  if($column==='bd_thumbnail')echo has_post_thumbnail($id)?get_the_post_thumbnail($id,[56,42],['class'=>'bd-admin-thumb','alt'=>'']):'<span class="bd-admin-muted">بدون عکس</span>';
  if($column==='bd_views')echo esc_html(bidrubeh_fa_digits(number_format_i18n(bidrubeh_post_views($id))));
  if($column==='bd_actions'){
    $actions=$GLOBALS['bd_post_row_actions'][$id]??[];
    if($actions){
      echo '<div class="row-actions bd-post-row-actions">';
      foreach($actions as $key=>$action)echo '<span class="'.esc_attr(sanitize_html_class($key)).'">'.$action.'</span>';
      echo '</div>';
      unset($GLOBALS['bd_post_row_actions'][$id]);
    }
  }
  if($column==='bd_last_status'){
    $post=get_post($id);
    if(!$post)return;
    $status=get_post_status_object($post->post_status);
    echo '<strong class="bd-post-status bd-post-status-'.esc_attr(sanitize_html_class($post->post_status)).'">'.esc_html($status?$status->label:$post->post_status).'</strong>';
    if($post->post_modified&&$post->post_modified!=='0000-00-00 00:00:00'){
      $date=DateTimeImmutable::createFromFormat('!Y-m-d H:i:s',$post->post_modified,wp_timezone());
      if($date){
        [$year,$month,$day]=bidrubeh_g2j((int)$date->format('Y'),(int)$date->format('n'),(int)$date->format('j'));
        echo '<small class="bd-post-status-date">آخرین ویرایش: <span dir="ltr">'.esc_html(bidrubeh_fa_digits(sprintf('%04d/%02d/%02d',$year,$month,$day).' '.$date->format('H:i'))).'</span></small>';
      }
    }
  }
},10,2);
function bidrubeh_message_states(){return ['new'=>'بررسی نشده','reviewing'=>'در حال بررسی','resolved'=>'رسیدگی شده'];}
add_filter('manage_bidrubeh_msg_posts_columns',function($columns){$columns['bd_tracking']='پیگیری';return $columns;});
add_action('manage_bidrubeh_msg_posts_custom_column',function($column,$id){
  if($column==='bd_tracking')echo esc_html(bidrubeh_message_states()[get_post_meta($id,'_bd_tracking',true)]??'بررسی نشده');
},10,2);
add_action('add_meta_boxes_bidrubeh_msg',function($post){
  if(!current_user_can('edit_post',$post->ID))return;
  add_meta_box('bd_message_tracking','پیگیری و یادداشت داخلی',function($post){
    wp_nonce_field('bd_message_tracking','bd_message_tracking_nonce');
    echo '<p><label for="bd_tracking">وضعیت پیگیری</label></p><select id="bd_tracking" name="bd_tracking">';
    $value=get_post_meta($post->ID,'_bd_tracking',true)?:'new';
    foreach(bidrubeh_message_states() as $key=>$label)echo '<option value="'.esc_attr($key).'"'.selected($value,$key,false).'>'.esc_html($label).'</option>';
    echo '</select><p><label for="bd_internal_note">یادداشت داخلی</label></p><textarea id="bd_internal_note" name="bd_internal_note" rows="5" class="widefat">'.esc_textarea(get_post_meta($post->ID,'_bd_internal_note',true)).'</textarea><p class="description">این یادداشت فقط در پنل مدیریت دیده می‌شود و برای فرستنده ارسال نمی‌شود.</p>';
  },'bidrubeh_msg','side');
});
add_action('save_post_bidrubeh_msg',function($id){
  if(wp_is_post_revision($id)||wp_is_post_autosave($id)||(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)||!current_user_can('edit_post',$id))return;
  if(!isset($_POST['bd_message_tracking_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bd_message_tracking_nonce'])),'bd_message_tracking'))return;
  $status=sanitize_key(wp_unslash($_POST['bd_tracking']??''));
  if(isset(bidrubeh_message_states()[$status]))update_post_meta($id,'_bd_tracking',$status);
  if(isset($_POST['bd_internal_note']))update_post_meta($id,'_bd_internal_note',sanitize_textarea_field(wp_unslash($_POST['bd_internal_note'])));
});
add_action('restrict_manage_posts',function($type,$which){
  if($type!=='bidrubeh_msg'||$which!=='top')return;
  $read=sanitize_key($_GET['bd_read_filter']??'');$state=sanitize_key($_GET['bd_tracking_filter']??'');
  echo '<label class="screen-reader-text" for="bd_read_filter">وضعیت خواندن</label><select id="bd_read_filter" name="bd_read_filter"><option value="">همه پیام‌ها</option><option value="unread"'.selected($read,'unread',false).'>خوانده‌نشده</option><option value="read"'.selected($read,'read',false).'>خوانده‌شده</option></select>';
  echo '<label class="screen-reader-text" for="bd_tracking_filter">وضعیت پیگیری</label><select id="bd_tracking_filter" name="bd_tracking_filter"><option value="">همه وضعیت‌های پیگیری</option>';
  foreach(bidrubeh_message_states() as $key=>$label)echo '<option value="'.esc_attr($key).'"'.selected($state,$key,false).'>'.esc_html($label).'</option>';
  echo '</select>';
},10,2);
add_action('pre_get_posts',function($query){
  if(!is_admin()||!$query->is_main_query()||$query->get('post_type')!=='bidrubeh_msg')return;
  $existing=(array)$query->get('meta_query');$clauses=['relation'=>'AND'];
  if($existing)$clauses[]=$existing;
  $read=sanitize_key($_GET['bd_read_filter']??'');$state=sanitize_key($_GET['bd_tracking_filter']??'');
  if($read==='read')$clauses[]=['key'=>'bd_read','value'=>'1'];
  if($read==='unread')$clauses[]=['relation'=>'OR',['key'=>'bd_read','value'=>'0'],['key'=>'bd_read','compare'=>'NOT EXISTS']];
  if(isset(bidrubeh_message_states()[$state]))$clauses[]=$state==='new'?['relation'=>'OR',['key'=>'_bd_tracking','value'=>'new'],['key'=>'_bd_tracking','compare'=>'NOT EXISTS']]:['key'=>'_bd_tracking','value'=>$state];
  if(count($clauses)>1)$query->set('meta_query',$clauses);
});
add_action('add_meta_boxes_post',function($post){
  add_meta_box('bd_content_help','یادآوری پیش از انتشار',function($post){
    echo '<p>عنوان کوتاه، دستهٔ درست و عکس مناسب را بررسی کنید.</p>';
    if(!has_post_thumbnail($post))echo '<p>برای این نوشته هنوز عکس شاخص انتخاب نشده است.</p>';
    elseif(trim((string)get_post_meta(get_post_thumbnail_id($post),'_wp_attachment_image_alt',true))==='')echo '<p>توضیح کوتاه عکس شاخص را در بخش «متن جایگزین» رسانه وارد کنید؛ این متن به خوانندگانِ ابزارهای خواندن صفحه کمک می‌کند.</p>';
    else echo '<p>عکس شاخص و متن جایگزین آن ثبت شده‌اند.</p>';
    echo '<p>«نمایش چرخشی» همان بخش تعویض خودکار تصاویر در بالای صفحهٔ اصلی است.</p>';
  },'post','side','low');
});
add_action('admin_enqueue_scripts',function(){wp_enqueue_style('bd-admin-tools',get_template_directory_uri().'/assets/admin.css',[],BIDRUBEH_VER);});

function bidrubeh_clear_admin_words($translation){
  if(!is_admin())return $translation;
  return strtr($translation,['انتقال به زباله‌دان'=>'انتقال به سطل زباله','جفنگ'=>'هرزنامه','صافی'=>'فیلتر']);
}
add_filter('gettext','bidrubeh_clear_admin_words',20);
add_filter('gettext_with_context','bidrubeh_clear_admin_words',20);
add_filter('ngettext','bidrubeh_clear_admin_words',20);
add_filter('ngettext_with_context','bidrubeh_clear_admin_words',20);

add_action('customize_controls_enqueue_scripts',function(){
  wp_enqueue_script('bd-customizer-cards',get_template_directory_uri().'/js/customizer-cards.js',['customize-controls'],BIDRUBEH_VER,true);
  wp_enqueue_style('bd-customizer-cards',get_template_directory_uri().'/assets/customizer-cards.css',[],BIDRUBEH_VER);
});
add_action('customize_register',function($customizer){
  for($i=1;$i<=6;$i++){
    $labels=['title'=>'عنوان کارت','desc'=>'توضیح کوتاه کارت'];
    for($n=1;$n<=3;$n++){
      $labels['n'.$n.'v']='عدد آمار '.bidrubeh_fa_digits($n);
      $labels['n'.$n.'l']='عنوان آمار '.bidrubeh_fa_digits($n);
    }
    foreach($labels as $field=>$label){$control=$customizer->get_control('bd_info'.$i.'_'.$field);if($control)$control->label=$label;}
  }
},30);
