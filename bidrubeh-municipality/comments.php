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
<div class="bd-comment-pending" role="status"><span class="bd-comment-pending-icon" aria-hidden="true">⏳</span><div><strong>دیدگاه شما در انتظار بررسی مدیر است.</strong><small>تا زمان تأیید یا رد آن، از این سیستم نمی‌توانید دیدگاه جدیدی ثبت کنید.</small></div></div>
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
  var form=document.getElementById('commentform');
  if(!form) return;
  form.noValidate=true;
  var fields=[
    {id:'author',empty:'لطفاً نام خود را وارد کنید.'},
    {id:'email',empty:'لطفاً ایمیل خود را وارد کنید.',invalid:'ایمیل وارد شده معتبر نیست.'},
    {id:'comment',empty:'لطفاً متن دیدگاه را وارد کنید.',short:'متن دیدگاه باید حداقل ۱۰ کاراکتر باشد.'}
  ];
  var summary=document.createElement('div');
  summary.className='bd-comment-error-summary';
  summary.setAttribute('role','alert');
  summary.hidden=true;
  form.insertBefore(summary,form.firstChild);
  function errorFor(item,el){
    var value=el.value.trim();
    if(!value) return item.empty;
    if(item.invalid&&!el.checkValidity()) return item.invalid;
    if(item.short&&Array.from(value).length<10) return item.short;
    return '';
  }
  function showError(el,message){
    var id=el.id+'-error';
    var node=document.getElementById(id);
    if(!node){
      node=document.createElement('small');
      node.id=id;
      node.className='bd-field-error';
      el.parentNode.appendChild(node);
    }
    node.textContent=message;
    node.hidden=!message;
    if(message){el.setAttribute('aria-invalid','true');el.setAttribute('aria-describedby',id);}
    else{el.removeAttribute('aria-invalid');el.removeAttribute('aria-describedby');}
  }
  fields.forEach(function(item){
    var el=document.getElementById(item.id);
    if(!el) return;
    el.addEventListener('input',function(){
      if(el.getAttribute('aria-invalid')==='true') showError(el,errorFor(item,el));
      if(!form.querySelector('[aria-invalid="true"]')) summary.hidden=true;
    });
  });
  form.addEventListener('submit',function(event){
    var first=null;
    fields.forEach(function(item){
      var el=document.getElementById(item.id);
      if(!el) return;
      var message=errorFor(item,el);
      showError(el,message);
      if(message&&!first) first=el;
    });
    if(first){
      event.preventDefault();
      summary.textContent='لطفاً موارد مشخص‌شده را اصلاح کنید.';
      summary.hidden=false;
      first.focus();
    }else{
      var button=form.querySelector('[type="submit"]');
      if(button) button.disabled=true;
    }
  });
})();
</script>
<?php endif; ?>
</div>
