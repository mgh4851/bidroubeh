<?php
if(post_password_required()) return;
?>
<div class="bd-comments">
<h2>دیدگاه‌ها <span class="bd-count">(<?php echo esc_html(bidrubeh_fa_digits(get_comments_number())); ?>)</span></h2>
<?php if(have_comments()): ?>
<ol class="bd-comment-list">
<?php wp_list_comments(['style'=>'ol','short_ping'=>true,'avatar_size'=>44,'max_depth'=>3,'callback'=>'bidrubeh_comment']); ?>
</ol>
<?php the_comments_navigation(['prev_text'=>'دیدگاه‌های قدیمی‌تر','next_text'=>'دیدگاه‌های جدیدتر']); ?>
<?php else: ?>
<p class="bd-no-comments">هنوز دیدگاهی ثبت نشده است. اولین نفر باشید!</p>
<?php endif; ?>
<?php if(!comments_open() && get_comments_number()): ?>
<p class="bd-no-comments">ارسال دیدگاه جدید برای این مطلب بسته شده است.</p>
<?php endif; ?>
</div>
<div class="bd-form-card loop-card">
<?php if(!comments_open()): ?>
<p class="bd-no-comments">ارسال دیدگاه برای این مطلب بسته شده است.</p>
<?php elseif(function_exists('bidrubeh_comment_blocked')&&bidrubeh_comment_blocked()): ?>
<div class="bd-sent-ok"><span>⏳</span><div><strong>دیدگاه شما در انتظار تأیید مدیر است.</strong><small>پس از تأیید یا حذف آن می‌توانید دیدگاه جدید ثبت کنید.</small></div></div>
<?php else: ?>
<?php
$bd_commenter=wp_get_current_commenter();
$bd_consent=empty($bd_commenter['comment_author_email'])?'':' checked="checked"';
comment_form([
  'title_reply'=>'ارسال دیدگاه',
  'title_reply_to'=>'پاسخ به %s',
  'cancel_reply_link'=>'انصراف از پاسخ',
  'label_submit'=>'ثبت دیدگاه',
  'submit_button'=>'<button name="%1$s" type="submit" id="%2$s" class="%3$s bd-submit">%4$s</button>',
  'comment_field'=>'<p class="comment-form-comment"><label for="comment">دیدگاه شما</label><textarea id="comment" name="comment" rows="4" required minlength="10" placeholder="دیدگاه خود را بنویسید…"></textarea></p>',
  'fields'=>[
    'author'=>'<p class="comment-form-author"><label for="author">نام *</label><input id="author" name="author" type="text" placeholder="نام شما" value="'.esc_attr($bd_commenter['comment_author']).'" required /></p>',
    'email'=>'<p class="comment-form-email"><label for="email">ایمیل *</label><input id="email" name="email" type="email" placeholder="ایمیل (نمایش داده نمی‌شود)" value="'.esc_attr($bd_commenter['comment_author_email']).'" required /></p>',
    'url'=>'',
    'cookies'=>'<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"'.$bd_consent.' /><label for="wp-comment-cookies-consent">نام، ایمیل و وب‌سایت من را در مرورگر ذخیره کن تا دفعه بعد لازم نباشد دوباره وارد کنم.</label></p>',
  ],
]);
?>
<script>
(function(){
  function faMsg(el,empty,short,invalid){
    if(!el) return;
    el.addEventListener('invalid',function(){
      if(el.validity.valueMissing) el.setCustomValidity(empty);
      else if(el.validity.tooShort) el.setCustomValidity(short);
      else if(el.validity.typeMismatch||el.validity.patternMismatch) el.setCustomValidity(invalid);
      else el.setCustomValidity('');
    });
    el.addEventListener('input',function(){el.setCustomValidity('');});
  }
  faMsg(document.getElementById('author'),'لطفاً نام خود را وارد کنید.','','');
  faMsg(document.getElementById('email'),'لطفاً ایمیل خود را وارد کنید.','','ایمیل وارد شده معتبر نیست.');
  faMsg(document.getElementById('comment'),'لطفاً متن دیدگاه را وارد کنید.','متن دیدگاه باید حداقل ۱۰ کاراکتر باشد.','');
})();
</script>
<?php endif; ?>
</div>
