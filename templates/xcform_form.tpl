<div class="xcform-wrap" id="xcform-<{$xcform_form_id}>">
<style>
.xcform-wrap{max-width:680px;margin:0 auto;font-family:inherit}
.xcform-grid{display:flex;flex-wrap:wrap;margin:0 -8px;align-items:flex-start}
.xcform-col-12,.xcform-col-6,.xcform-col-4{padding:0 8px;box-sizing:border-box}
.xcform-col-12{width:100%;flex:0 0 100%}
.xcform-col-6{width:50%;flex:0 0 50%}
.xcform-col-4{width:33.333%;flex:0 0 33.333%}
@media(max-width:600px){.xcform-col-6,.xcform-col-4{width:100%;flex:0 0 100%}}
.xcform-fg{margin-bottom:16px}
.xcform-label{display:block;font-size:14px;font-weight:600;color:#333;margin-bottom:5px}
.xcform-req{color:#e53935;margin-left:2px}
.xcform-hint{font-size:12px;color:#888;margin-top:3px}
.xcform-wrap input[type=text],.xcform-wrap input[type=email],.xcform-wrap input[type=url],
.xcform-wrap input[type=tel],.xcform-wrap input[type=number],.xcform-wrap input[type=date],
.xcform-wrap input[type=time],.xcform-wrap textarea,.xcform-wrap select{
    width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;
    box-sizing:border-box;background:#fff;color:#333;transition:border-color .2s}
.xcform-wrap input:focus,.xcform-wrap textarea:focus,.xcform-wrap select:focus{
    border-color:#1976d2;outline:none;box-shadow:0 0 0 3px rgba(25,118,210,.1)}
.xcform-wrap textarea{height:120px;resize:vertical}
.xcform-heading{font-size:18px;font-weight:700;border-bottom:2px solid #1976d2;padding-bottom:6px;margin-bottom:14px}
.xcform-choice-list{display:flex;flex-direction:column;gap:7px}
.xcform-choice-list label{display:flex;align-items:center;gap:9px;padding:9px 12px;border:1px solid #ddd;border-radius:5px;cursor:pointer;font-size:13px}
.xcform-choice-list label:hover{border-color:#1976d2}
.xcform-choice-list input{width:auto;margin:0}
.xcform-dropdown{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;background:#fff}
.xcform-consent label{display:flex;align-items:flex-start;gap:9px;font-size:13px;line-height:1.5;cursor:pointer}
.xcform-consent input{width:auto;margin-top:2px;flex-shrink:0}
.xcform-sig-pad{border:1px solid #ddd;border-radius:5px;background:#fff;cursor:crosshair;display:block;touch-action:none;max-width:100%}
.xcform-sig-clear{padding:5px 14px;border:1px solid #ddd;border-radius:4px;background:#fff;cursor:pointer;font-size:12px;margin-top:6px}
.xcform-submit-btn{background:#1976d2;color:#fff;border:none;padding:12px 32px;border-radius:5px;font-size:15px;font-weight:700;cursor:pointer;transition:background .2s;margin-top:8px}
.xcform-submit-btn:hover{background:#1565c0}
.xcform-errors{background:#ffebee;border:1px solid #ef9a9a;border-radius:5px;padding:14px 16px;margin-bottom:16px;color:#c62828}
.xcform-errors ul{margin:8px 0 0 18px;font-size:13px}
.xcform-success{background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:20px;text-align:center;color:#2e7d32;font-weight:600;font-size:15px}
</style>

<{if !empty($xcform_error)}>
    <div class="xcform-errors"><{$xcform_error}></div>
<{elseif $xcform_success}>
    <div class="xcform-success">✅ <{$xcform_settings.success_msg|default:$xcform_lang_success}></div>
<{else}>

<{if $xcform_form.description}>
<p style="color:#666;font-size:14px;margin-bottom:20px"><{$xcform_form.description|nl2br}></p>
<{/if}>

<{if !empty($xcform_errors)}>
<div class="xcform-errors"><strong><{$xcform_lang_please_fix}></strong><ul>
<{foreach item=e from=$xcform_errors}><li><{$e}></li><{/foreach}>
</ul></div>
<{/if}>

<form method="post" action="" enctype="multipart/form-data" novalidate>
<input type="hidden" name="cf_form_id" value="<{$xcform_form_id}>">
<input type="hidden" name="cf_token"   value="<{$xcform_token}>">
<div style="position:absolute;left:-9999px;overflow:hidden;height:0">
    <input type="text" name="cf_hp" tabindex="-1" autocomplete="off">
</div>

<div class="xcform-grid">
<{foreach item=field from=$xcform_fields}>
<{assign var="fn"    value=$field.name}>
<{assign var="fw"    value=$field.width|default:12}>
<{assign var="fcol"  value="xcform-col-12"}>
<{if $fw eq 6}><{assign var="fcol" value="xcform-col-6"}><{/if}>
<{if $fw eq 4}><{assign var="fcol" value="xcform-col-4"}><{/if}>
<div class="<{$fcol}>">
<{if $field.type eq 'heading'}>
    <div class="xcform-heading"><{$field.label|escape}></div>
<{elseif $field.type eq 'label'}>
    <div class="xcform-fg"><span style="font-size:14px;color:#444"><{$field.label|escape}></span></div>
<{elseif $field.type eq 'paragraph'}>
    <div class="xcform-fg"><p style="font-size:13px;color:#666;line-height:1.6"><{$field.label|nl2br}></p></div>
<{elseif $field.type eq 'hidden'}>
    <input type="hidden" name="<{$fn|escape}>" value="<{$field.value|default:''|escape}>">
<{elseif $field.type eq 'short_text'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="text" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$field.placeholder|default:''|escape}>" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'long_text'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <textarea id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$field.placeholder|default:''|escape}>"<{if $field.required}> required<{/if}>><{$xcform_data[$fn]|default:''|escape}></textarea>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'email'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="email" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$field.placeholder|default:$xcform_lang_email_placeholder|escape}>" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'website'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="url" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="https://" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'phone'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="tel" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$xcform_lang_phone_placeholder}>" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'number'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="number" id="xcf_<{$fn}>" name="<{$fn|escape}>" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'date'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="date" id="xcf_<{$fn}>" name="<{$fn|escape}>" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'time'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="time" id="xcf_<{$fn}>" name="<{$fn|escape}>" value="<{$xcform_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'file'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <input type="file" id="xcf_<{$fn}>" name="<{$fn|escape}>" style="width:100%;padding:8px;border:1px dashed #bbb;border-radius:5px;background:#fafafa;font-size:13px"<{if $field.required}> required<{/if}>>
        <p class="xcform-hint"><{$xcform_lang_file_hint}><{if $field.description}> · <{$field.description|escape}><{/if}></p>
    </div>
<{elseif $field.type eq 'choice'}>
    <div class="xcform-fg">
        <label class="xcform-label"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <div class="xcform-choice-list">
            <{foreach item=opt from=$field.options}>
            <label><input type="checkbox" name="<{$fn|escape}>[]" value="<{$opt|escape}>"><span><{$opt|escape}></span></label>
            <{/foreach}>
        </div>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'dropdown'}>
    <div class="xcform-fg">
        <label class="xcform-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <select class="xcform-dropdown" id="xcf_<{$fn}>" name="<{$fn|escape}>"<{if $field.required}> required<{/if}>>
            <option value=""><{$xcform_lang_select_opt}></option>
            <{foreach item=opt from=$field.options}>
            <option value="<{$opt|escape}>"<{if $xcform_data[$fn]|default:'' eq $opt}> selected<{/if}>><{$opt|escape}></option>
            <{/foreach}>
        </select>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'image_choice'}>
    <div class="xcform-fg">
        <label class="xcform-label"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px">
            <{foreach item=opt from=$field.options}>
            <label style="border:2px solid #ddd;border-radius:6px;padding:10px;cursor:pointer;text-align:center;font-size:12px">
                <input type="checkbox" name="<{$fn|escape}>[]" value="<{$opt|escape}>" style="display:none">
                <div style="font-size:28px;margin-bottom:5px">🖼</div><{$opt|escape}>
            </label>
            <{/foreach}>
        </div>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'consent'}>
    <div class="xcform-fg xcform-consent">
        <label>
            <input type="checkbox" name="<{$fn|escape}>" value="1"<{if $xcform_data[$fn]|default:'' eq '1'}> checked<{/if}><{if $field.required}> required<{/if}>>
            <{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}>
        </label>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'signature'}>
    <div class="xcform-fg">
        <label class="xcform-label"><{$field.label|escape}><{if $field.required}><span class="xcform-req">*</span><{/if}></label>
        <canvas class="xcform-sig-pad" id="sig_<{$fn}>" width="580" height="140"></canvas>
        <input type="hidden" name="<{$fn|escape}>" id="sig_data_<{$fn}>">
        <button type="button" class="xcform-sig-clear" onclick="xcfSigClear('<{$fn|escape}>')">🗑 <{$xcform_lang_sig_clear}></button>
        <{if $field.description}><p class="xcform-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{/if}>
</div>
<{/foreach}>
</div>

<{if $xcform_settings.enable_captcha}>
<div class="xcform-fg" style="margin-top:8px">
    <label class="xcform-label"><{$xcform_lang_security_code}> <span class="xcform-req">*</span></label>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
        <{if $xcform_captcha.img}>
        <img src="<{$xcform_captcha.img}>" style="border:1px solid #ddd;border-radius:4px;height:44px">
        <{else}>
        <div style="background:#1976d2;color:#fff;padding:8px 16px;border-radius:4px;font-size:18px;font-weight:700;letter-spacing:6px;font-family:monospace"><{$xcform_captcha.code}></div>
        <{/if}>
        <input type="text" name="cf_captcha" placeholder="<{$xcform_lang_code_hint}>" required autocomplete="off" style="width:180px;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px">
    </div>
</div>
<{/if}>

<div><button type="submit" class="xcform-submit-btn" id="xcf-sbtn-<{$xcform_form_id}>"><{$xcform_lang_submit}></button></div>
</form>

<script>
<{literal}>
(function(){
    var pads=document.querySelectorAll('.xcform-sig-pad');
    pads.forEach(function(c){
        var ctx=c.getContext('2d'),dr=false;
        ctx.strokeStyle='#222';ctx.lineWidth=2;ctx.lineCap='round';
        function p(e){var r=c.getBoundingClientRect(),s=e.touches?e.touches[0]:e;return{x:(s.clientX-r.left)*(c.width/r.width),y:(s.clientY-r.top)*(c.height/r.height)};}
        c.addEventListener('mousedown',function(e){dr=true;var pt=p(e);ctx.beginPath();ctx.moveTo(pt.x,pt.y);});
        c.addEventListener('mousemove',function(e){if(!dr)return;var pt=p(e);ctx.lineTo(pt.x,pt.y);ctx.stroke();sync(c);});
        c.addEventListener('mouseup',function(){dr=false;});
        c.addEventListener('touchstart',function(e){e.preventDefault();dr=true;var pt=p(e);ctx.beginPath();ctx.moveTo(pt.x,pt.y);});
        c.addEventListener('touchmove',function(e){e.preventDefault();if(!dr)return;var pt=p(e);ctx.lineTo(pt.x,pt.y);ctx.stroke();sync(c);});
        c.addEventListener('touchend',function(){dr=false;});
    });
    function sync(c){var id=c.id.replace('sig_','');var i=document.getElementById('sig_data_'+id);if(i)i.value=c.toDataURL();}
    window.xcfSigClear=function(fn){var c=document.getElementById('sig_'+fn);if(c){c.getContext('2d').clearRect(0,0,c.width,c.height);var i=document.getElementById('sig_data_'+fn);if(i)i.value='';}};
<{/literal}>
    var btn=document.getElementById('xcf-sbtn-<{$xcform_form_id}>');
    var sending=<{$xcform_lang_sending|json_encode}>;
    if(btn)btn.closest('form').addEventListener('submit',function(){btn.disabled=true;btn.textContent=sending;});
<{literal}>
})();
<{/literal}>
</script>

<{/if}>
</div>
