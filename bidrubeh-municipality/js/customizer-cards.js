(function(){
  if(!window.wp||!wp.customize)return;
  wp.customize.bind('ready',function(){
    var embedded=[];
    for(var i=1;i<=6;i++){
      ['title','desc','n1v','n1l','n2v','n2l','n3v','n3l'].forEach(function(field){
        var control=wp.customize.control('bd_info'+i+'_'+field);
        if(control)embedded.push(control.deferred.embedded);
      });
    }
    jQuery.when.apply(jQuery,embedded).done(function(){setTimeout(organize,0);});
    function organize(){
    var section=document.getElementById('sub-accordion-section-bidrubeh_info');
    if(!section||section.querySelector('.bd-info-group'))return;
    var digits='۰۱۲۳۴۵۶۷۸۹';
    for(var number=1;number<=6;number++){
      (function(index){
        var prefix='bd_info'+index+'_';
        var titleControl=wp.customize.control(prefix+'title');
        if(!titleControl)return;
        var wrapper=document.createElement('li');wrapper.className='bd-info-group';
        var details=document.createElement('details');details.open=index===1;
        var summary=document.createElement('summary');
        var title=document.createElement('span');title.className='bd-info-group-title';
        var status=document.createElement('small');status.className='bd-info-group-status';
        summary.appendChild(title);summary.appendChild(status);details.appendChild(summary);
        var fields=document.createElement('ul');fields.className='bd-info-fields';details.appendChild(fields);
        var help=document.createElement('p');help.className='bd-info-help';help.textContent='با خالی کردن عنوان، این کارت در سایت نمایش داده نمی‌شود.';details.appendChild(help);
        wrapper.appendChild(details);
        var first=titleControl.container[0];first.parentNode.insertBefore(wrapper,first);
        ['title','desc','n1v','n1l','n2v','n2l','n3v','n3l'].forEach(function(field){
          var control=wp.customize.control(prefix+field);
          if(control)fields.appendChild(control.container[0]);
        });
        function update(value){
          value=String(value||'').trim();
          title.textContent='کارت '+String(index).replace(/[0-9]/g,function(d){return digits[Number(d)];})+(value?' — '+value:'');
          status.textContent=value?'دارای عنوان':'بدون عنوان';
          wrapper.classList.toggle('bd-info-empty',!value);
        }
        wp.customize(prefix+'title',function(setting){update(setting.get());setting.bind(update);});
      })(number);
    }
    }
  });
})();
