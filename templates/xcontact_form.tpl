<div class="xcontact-wrap" id="xcontact-<{$xcontact_form_id}>">
<style>
.xcontact-wrap{max-width:680px;margin:0 auto;font-family:inherit}
.xcontact-grid{display:flex;flex-wrap:wrap;margin:0 -8px;align-items:flex-start}
.xcontact-col-12,.xcontact-col-6,.xcontact-col-4{padding:0 8px;box-sizing:border-box}
.xcontact-col-12{width:100%;flex:0 0 100%}
.xcontact-col-6{width:50%;flex:0 0 50%}
.xcontact-col-4{width:33.333%;flex:0 0 33.333%}
@media(max-width:600px){.xcontact-col-6,.xcontact-col-4{width:100%;flex:0 0 100%}}
.xcontact-fg{margin-bottom:16px}
.xcontact-label{display:block;font-size:14px;font-weight:600;color:#333;margin-bottom:5px}
.xcontact-req{color:#e53935;margin-left:2px}
.xcontact-hint{font-size:12px;color:#888;margin-top:3px}
.xcontact-wrap input[type=text],.xcontact-wrap input[type=email],.xcontact-wrap input[type=url],
.xcontact-wrap input[type=tel],.xcontact-wrap input[type=number],.xcontact-wrap input[type=date],
.xcontact-wrap input[type=time],.xcontact-wrap textarea,.xcontact-wrap select{
    width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;
    box-sizing:border-box;background:#fff;color:#333;transition:border-color .2s}
.xcontact-wrap input:focus,.xcontact-wrap textarea:focus,.xcontact-wrap select:focus{
    border-color:#1976d2;outline:none;box-shadow:0 0 0 3px rgba(25,118,210,.1)}
.xcontact-wrap textarea{height:120px;resize:vertical}
.xcontact-heading{font-size:18px;font-weight:700;border-bottom:2px solid #1976d2;padding-bottom:6px;margin-bottom:14px}
.xcontact-choice-list{display:flex;flex-direction:column;gap:7px}
.xcontact-choice-list label{display:flex;align-items:center;gap:9px;padding:9px 12px;border:1px solid #ddd;border-radius:5px;cursor:pointer;font-size:13px}
.xcontact-choice-list label:hover{border-color:#1976d2}
.xcontact-choice-list input{width:auto;margin:0}
.xcontact-dropdown{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;background:#fff}
.xcontact-consent label{display:flex;align-items:flex-start;gap:9px;font-size:13px;line-height:1.5;cursor:pointer}
.xcontact-consent input{width:auto;margin-top:2px;flex-shrink:0}
.xcontact-sig-pad{border:1px solid #ddd;border-radius:5px;background:#fff;cursor:crosshair;display:block;touch-action:none;max-width:100%}
.xcontact-sig-clear{padding:5px 14px;border:1px solid #ddd;border-radius:4px;background:#fff;cursor:pointer;font-size:12px;margin-top:6px}
.xcontact-submit-btn{background:#1976d2;color:#fff;border:none;padding:12px 32px;border-radius:5px;font-size:15px;font-weight:700;cursor:pointer;transition:background .2s;margin-top:8px}
.xcontact-submit-btn:hover{background:#1565c0}
.xcontact-errors{background:#ffebee;border:1px solid #ef9a9a;border-radius:5px;padding:14px 16px;margin-bottom:16px;color:#c62828}
.xcontact-errors ul{margin:8px 0 0 18px;font-size:13px}
.xcontact-success{background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:20px;text-align:center;color:#2e7d32;font-weight:600;font-size:15px}
</style>

<{if !empty($xcontact_error)}>
    <div class="xcontact-errors"><{$xcontact_error}></div>
<{elseif $xcontact_success}>
    <div class="xcontact-success"><{$icon.checked}> <{$xcontact_settings.success_msg|default:$smarty.const._MD_XCONTACT_SUCCESS}></div>
<{else}>

<{if $xcontact_form.description}>
<p style="color:#666;font-size:14px;margin-bottom:20px"><{$xcontact_form.description|nl2br}></p>
<{/if}>

<{if !empty($xcontact_errors)}>
<div class="xcontact-errors"><strong><{$smarty.const._MD_XCONTACT_PLEASE_FIX}></strong><ul>
<{foreach item=e from=$xcontact_errors}><li><{$e}></li><{/foreach}>
</ul></div>
<{/if}>

<form id="form_<{$xcontact_form_id}>" method="post" action="" enctype="multipart/form-data" novalidate>
<input type="hidden" name="cf_form_id" value="<{$xcontact_form_id}>">
<{$xoops_token}>
<div style="position:absolute;left:-9999px;overflow:hidden;height:0">
    <input type="text" name="cf_hp" tabindex="-1" autocomplete="off">
</div>

<div class="xcontact-grid">
<{foreach item=field from=$xcontact_fields}>
<{assign var="fn"    value=$field.name}>
<{assign var="fw"    value=$field.width|default:12}>
<{assign var="fcol"  value="xcontact-col-12"}>
<{if $fw eq 6}><{assign var="fcol" value="xcontact-col-6"}><{/if}>
<{if $fw eq 4}><{assign var="fcol" value="xcontact-col-4"}><{/if}>
<div class="<{$fcol}>">
<{if $field.type eq 'heading'}>
    <div class="xcontact-heading"><{$field.label|escape}></div>
<{elseif $field.type eq 'label'}>
    <div class="xcontact-fg"><span style="font-size:14px;color:#444"><{$field.label|escape}></span></div>
<{elseif $field.type eq 'paragraph'}>
    <div class="xcontact-fg"><p style="font-size:13px;color:#666;line-height:1.6"><{$field.label|nl2br}></p></div>
<{elseif $field.type eq 'hidden'}>
    <input type="hidden" name="<{$fn|escape}>" value="<{$field.value|default:''|escape}>">
<{elseif $field.type eq 'short_text'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="text" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$field.placeholder|default:''|escape}>" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'long_text'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <textarea id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$field.placeholder|default:''|escape}>"<{if $field.required}> required<{/if}>><{$xcontact_data[$fn]|default:''|escape}></textarea>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'email'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="email" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$field.placeholder|default:$smarty.const._MD_XCONTACT_EMAIL_PLACEHOLDER|escape}>" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'website'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="url" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="https://" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'phone'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="tel" id="xcf_<{$fn}>" name="<{$fn|escape}>" placeholder="<{$smarty.const._MD_XCONTACT_PHONE_PLACEHOLDER|escape}>" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'number'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="number" id="xcf_<{$fn}>" name="<{$fn|escape}>" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'date'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="date" id="xcf_<{$fn}>" name="<{$fn|escape}>" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'time'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="time" id="xcf_<{$fn}>" name="<{$fn|escape}>" value="<{$xcontact_data[$fn]|default:''|escape}>"<{if $field.required}> required<{/if}>>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'file'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <input type="file" id="xcf_<{$fn}>" name="<{$fn|escape}>" style="width:100%;padding:8px;border:1px dashed #bbb;border-radius:5px;background:#fafafa;font-size:13px"<{if $field.required}> required<{/if}>>
        <p class="xcontact-hint"><{$cf_fileupload_size|escape}><br><{$cf_fileupload_types|escape}><{if $field.description}><br><{$field.description|escape}><{/if}></p>
    </div>
<{elseif $field.type eq 'choice'}>
    <div class="xcontact-fg">
        <label class="xcontact-label"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <div class="xcontact-choice-list">
            <{foreach item=opt from=$field.options}>
            <label><input type="checkbox" name="<{$fn|escape}>[]" value="<{$opt|escape}>"><span><{$opt|escape}></span></label>
            <{/foreach}>
        </div>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'dropdown'}>
    <div class="xcontact-fg">
        <label class="xcontact-label" for="xcf_<{$fn}>"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <select class="xcontact-dropdown" id="xcf_<{$fn}>" name="<{$fn|escape}>"<{if $field.required}> required<{/if}>>
            <option value=""><{$smarty.const._MD_XCONTACT_SELECT_OPT}></option>
            <{foreach item=opt from=$field.options}>
            <option value="<{$opt|escape}>"<{if $xcontact_data[$fn]|default:'' eq $opt}> selected<{/if}>><{$opt|escape}></option>
            <{/foreach}>
        </select>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'image_choice'}>
    <div class="xcontact-fg">
        <label class="xcontact-label"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px">
            <{foreach item=opt from=$field.options}>
            <label style="border:2px solid #ddd;border-radius:6px;padding:10px;cursor:pointer;text-align:center;font-size:12px">
                <input type="checkbox" name="<{$fn|escape}>[]" value="<{$opt|escape}>" style="display:none">
                <div style="font-size:28px;margin-bottom:5px">🖼</div>aaaa<{$opt|escape}>bbbb
            </label>
            <{/foreach}>
        </div>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'consent'}>
    <div class="xcontact-fg xcontact-consent">
        <label>
            <input type="checkbox" name="<{$fn|escape}>" value="1"<{if $xcontact_data[$fn]|default:'' eq '1'}> checked<{/if}><{if $field.required}> required<{/if}>>
            <{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}>
        </label>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{elseif $field.type eq 'signature'}>
    <div class="xcontact-fg">
        <label class="xcontact-label"><{$field.label|escape}><{if $field.required}><span class="xcontact-req">*</span><{/if}></label>
        <canvas class="xcontact-sig-pad" id="sig_<{$fn}>" width="580" height="140"></canvas>
        <input type="hidden" name="<{$fn|escape}>" id="sig_data_<{$fn}>">
        <button type="button" class="xcontact-sig-clear" onclick="xcfSigClear('<{$fn|escape}>')">🗑 <{$smarty.const._MD_XCONTACT_SIG_CLEAR}></button>
        <{if $field.description}><p class="xcontact-hint"><{$field.description|escape}></p><{/if}>
    </div>
<{/if}>
</div>
<{/foreach}>
</div>

<{if $xcontact_settings.enable_captcha}>
<div class="xcontact-fg" style="margin-top:8px">
    <label class="xcontact-label"><{$smarty.const._MD_XCONTACT_SECURITY_CODE}> <span class="xcontact-req">*</span></label>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
        <{if $xcontact_captcha.img}>
        <img src="<{$xcontact_captcha.img}>" style="border:1px solid #ddd;border-radius:4px;height:44px">
        <{else}>
        <div style="background:#1976d2;color:#fff;padding:8px 16px;border-radius:4px;font-size:18px;font-weight:700;letter-spacing:6px;font-family:monospace"><{$xcontact_captcha.code}></div>
        <{/if}>
        <input type="text" name="cf_captcha" placeholder="<{$smarty.const._MD_XCONTACT_CODE_HINT|escape}>" required autocomplete="off" style="width:180px;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px">
    </div>
</div>
<{/if}>

<div><button type="submit" class="xcontact-submit-btn" id="xcf-sbtn-<{$xcontact_form_id}>"><{$smarty.const._MD_XCONTACT_SUBMIT}></button></div>
</form>

<script>
<{literal}>
(function(){
    var pads=document.querySelectorAll('.xcontact-sig-pad');
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
    var btn=document.getElementById('xcf-sbtn-<{$xcontact_form_id}>');
    var sending=<{$smarty.const._MD_XCONTACT_SENDING|json_encode}>;
    if(btn)btn.closest('form').addEventListener('submit',function(){btn.disabled=true;btn.textContent=sending;});
<{literal}>
})();
<{/literal}>
</script>

<{/if}>
</div>
