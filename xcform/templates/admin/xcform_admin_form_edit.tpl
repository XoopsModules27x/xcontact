<style>
.xcp-builder{display:grid;grid-template-columns:220px 1fr;gap:20px;min-height:500px}
.xcp-palette{background:#1e1e2e;border-radius:8px;padding:12px}
.xcp-palette h4{color:#aaa;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin:0 0 10px}
.xcp-ft{display:flex;align-items:center;gap:8px;padding:8px 10px;margin-bottom:4px;background:#2a2a3d;border-radius:6px;cursor:grab;color:#ddd;font-size:12px;font-weight:600;border:1px solid transparent;transition:all .15s;user-select:none}
.xcp-ft:hover{background:#35354f;border-color:#4a4a6a;color:#fff}
.xcp-ft-icon{width:26px;height:26px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0}
.xcp-ic-green{background:#2e7d32}.xcp-ic-teal{background:#00695c}.xcp-ic-blue{background:#1565c0}.xcp-ic-purple{background:#6a1b9a}.xcp-ic-orange{background:#e65100}.xcp-ic-grey{background:#455a64}
.xcp-canvas{background:#f8f9fa;border-radius:8px;padding:14px;min-height:380px;border:2px dashed #ddd}
.xcp-canvas.dragover{border-color:#1976d2;background:#e3f2fd}
.xcp-canvas-empty{text-align:center;padding:60px 20px;color:#aaa;pointer-events:none}
.xcp-field-item{background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:10px 12px;margin-bottom:7px;display:flex;align-items:center;gap:8px;transition:box-shadow .15s}
.xcp-field-item:hover{box-shadow:0 2px 8px rgba(0,0,0,.1);border-color:#bbb}
.xcp-field-item.selected{border-color:#1976d2;box-shadow:0 0 0 2px rgba(25,118,210,.2)}
.xcp-fi-drag{color:#ccc;cursor:grab;font-size:17px;flex-shrink:0}
.xcp-fi-info{flex:1;min-width:0}
.xcp-fi-info strong{font-size:13px;color:#222;display:block}
.xcp-fi-info span{font-size:11px;color:#888}
.xcp-fi-actions button{width:28px;height:28px;border:1px solid #ddd;border-radius:4px;cursor:pointer;background:#fff;font-size:13px;margin-left:3px}
.xcp-fi-actions button:hover{background:#f0f0f0}
.xcp-inspector{position:fixed;right:0;top:0;bottom:0;width:290px;background:#fff;box-shadow:-4px 0 20px rgba(0,0,0,.12);z-index:1000;display:none;overflow-y:auto}
.xcp-inspector.open{display:block}
.xcp-isp-hd{background:#1976d2;color:#fff;padding:12px 14px;display:flex;justify-content:space-between;align-items:center;font-weight:700;font-size:14px}
.xcp-isp-body{padding:14px}
.xcp-isp-fg{margin-bottom:11px}
.xcp-isp-fg label{display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:3px}
.xcp-isp-fg input,.xcp-isp-fg textarea,.xcp-isp-fg select{width:100%;padding:6px 8px;border:1px solid #ddd;border-radius:4px;font-size:12px;box-sizing:border-box}
.xcp-isp-fg textarea{height:65px;resize:vertical}
.xcp-isp-toggle{display:flex;align-items:center;gap:7px;margin-bottom:9px;font-size:12px;font-weight:600;color:#444}
.xcp-isp-toggle input{width:auto}
.xcp-tabs{display:flex;gap:0;border-bottom:2px solid #1976d2;margin-bottom:18px}
.xcp-tab{padding:9px 18px;cursor:pointer;font-size:13px;font-weight:600;color:#666;border:none;background:none;border-bottom:2px solid transparent;margin-bottom:-2px}
.xcp-tab.active{color:#1976d2;border-bottom-color:#1976d2}
.xcp-tab-panel{display:none}.xcp-tab-panel.active{display:block}
</style>

<div class="xcp-wrap">
<h2><{if $is_edit}>✏️ <{$xcf_lang_edit_title}> <{$form.name}><{else}>➕ <{$xcf_lang_new_title}><{/if}></h2>

<form method="post" action="<{$module_url}>admin/form_edit.php<{if $is_edit}>?id=<{$form.form_id}><{/if}>">
<input type="hidden" name="op" value="save">
<input type="hidden" name="fields_json" id="xcf-fields-json" value='<{$form.fields|escape}>'>
<{$xoops_token_html}>

<div class="xcp-tabs">
    <button type="button" class="xcp-tab active" data-tab="builder">🧩 <{$xcf_lang_tab_builder}></button>
    <button type="button" class="xcp-tab" data-tab="settings">⚙️ <{$xcf_lang_tab_settings}></button>
</div>

<div id="tab-builder" class="xcp-tab-panel active">
<div class="xcp-builder">
    <div class="xcp-palette">
        <h4><{$xcf_lang_field_types}></h4>
        <div class="xcp-ft" data-type="short_text"   draggable="true" ondblclick="xcfAdd('short_text')"><div class="xcp-ft-icon xcp-ic-green">T</div><{$xcf_lang_ft_short_text}></div>
        <div class="xcp-ft" data-type="long_text"    draggable="true" ondblclick="xcfAdd('long_text')"><div class="xcp-ft-icon xcp-ic-green">T&#818;</div><{$xcf_lang_ft_long_text}></div>
        <div class="xcp-ft" data-type="email"        draggable="true" ondblclick="xcfAdd('email')"><div class="xcp-ft-icon xcp-ic-teal">@</div><{$xcf_lang_ft_email}></div>
        <div class="xcp-ft" data-type="website"      draggable="true" ondblclick="xcfAdd('website')"><div class="xcp-ft-icon xcp-ic-teal">🔗</div><{$xcf_lang_ft_website}></div>
        <div class="xcp-ft" data-type="phone"        draggable="true" ondblclick="xcfAdd('phone')"><div class="xcp-ft-icon xcp-ic-teal">📞</div><{$xcf_lang_ft_phone}></div>
        <div class="xcp-ft" data-type="number"       draggable="true" ondblclick="xcfAdd('number')"><div class="xcp-ft-icon xcp-ic-teal">#</div><{$xcf_lang_ft_number}></div>
        <div class="xcp-ft" data-type="date"         draggable="true" ondblclick="xcfAdd('date')"><div class="xcp-ft-icon xcp-ic-blue">📅</div><{$xcf_lang_ft_date}></div>
        <div class="xcp-ft" data-type="time"         draggable="true" ondblclick="xcfAdd('time')"><div class="xcp-ft-icon xcp-ic-blue">⏰</div><{$xcf_lang_ft_time}></div>
        <div class="xcp-ft" data-type="file"         draggable="true" ondblclick="xcfAdd('file')"><div class="xcp-ft-icon xcp-ic-blue">📎</div><{$xcf_lang_ft_file}></div>
        <div class="xcp-ft" data-type="hidden"       draggable="true" ondblclick="xcfAdd('hidden')"><div class="xcp-ft-icon xcp-ic-grey">🚫</div><{$xcf_lang_ft_hidden}></div>
        <div class="xcp-ft" data-type="label"        draggable="true" ondblclick="xcfAdd('label')"><div class="xcp-ft-icon xcp-ic-grey">L</div><{$xcf_lang_ft_label}></div>
        <div class="xcp-ft" data-type="heading"      draggable="true" ondblclick="xcfAdd('heading')"><div class="xcp-ft-icon xcp-ic-grey">H</div><{$xcf_lang_ft_heading}></div>
        <div class="xcp-ft" data-type="paragraph"    draggable="true" ondblclick="xcfAdd('paragraph')"><div class="xcp-ft-icon xcp-ic-grey">¶</div><{$xcf_lang_ft_paragraph}></div>
        <div class="xcp-ft" data-type="choice"       draggable="true" ondblclick="xcfAdd('choice')"><div class="xcp-ft-icon xcp-ic-purple">☑</div><{$xcf_lang_ft_choice}></div>
        <div class="xcp-ft" data-type="image_choice" draggable="true" ondblclick="xcfAdd('image_choice')"><div class="xcp-ft-icon xcp-ic-purple">🖼</div><{$xcf_lang_ft_image_choice}></div>
        <div class="xcp-ft" data-type="dropdown"     draggable="true" ondblclick="xcfAdd('dropdown')"><div class="xcp-ft-icon xcp-ic-purple">▼</div><{$xcf_lang_ft_dropdown}></div>
        <div class="xcp-ft" data-type="consent"      draggable="true" ondblclick="xcfAdd('consent')"><div class="xcp-ft-icon xcp-ic-purple">✓</div><{$xcf_lang_ft_consent}></div>
        <div class="xcp-ft" data-type="signature"    draggable="true" ondblclick="xcfAdd('signature')"><div class="xcp-ft-icon xcp-ic-orange">✒</div><{$xcf_lang_ft_signature}></div>
    </div>
    <div>
        <div id="xcf-canvas" class="xcp-canvas">
            <div id="xcf-empty" class="xcp-canvas-empty">
                <p style="font-size:14px;font-weight:600"><{$xcf_lang_drag_hint}></p>
            </div>
        </div>
        <div style="margin-top:12px;text-align:right">
            <button type="submit" class="xcp-btn xcp-btn--green" style="padding:10px 24px;font-size:14px">💾 <{$xcf_lang_save_form}></button>
        </div>
    </div>
</div>
</div>

<div id="tab-settings" class="xcp-tab-panel">
<div class="xcp-wrap" style="max-width:600px">
    <div class="xcp-isp-fg"><label><{$xcf_lang_set_form_name}></label><input type="text" name="form_name" value="<{$form.name|escape}>" required></div>
    <div class="xcp-isp-fg"><label><{$xcf_lang_set_form_slug}></label><input type="text" name="form_slug" value="<{$form.slug|escape}>" placeholder="<{$xcf_lang_set_slug_placeholder}>" pattern="[a-z0-9\-]+" required><small style="color:#888"><{$xcf_lang_set_slug_hint}></small></div>
    <div class="xcp-isp-fg"><label><{$xcf_lang_set_desc}></label><textarea name="form_desc"><{$form.description|escape}></textarea></div>
    <div class="xcp-isp-fg"><label><{$xcf_lang_set_success_msg}></label><input type="text" name="success_msg" value="<{$settings.success_msg|default:$xcf_lang_set_default_success|escape}>"></div>
    <div class="xcp-isp-fg"><label><{$xcf_lang_set_notify_email}></label><input type="email" name="notify_email" value="<{$settings.notify_email|default:''|escape}>"><small style="color:#888"><{$xcf_lang_set_email_hint}></small></div>
    <div class="xcp-isp-fg"><label><{$xcf_lang_set_email_subject}></label><input type="text" name="email_subject" value="<{$settings.email_subject|default:$xcf_lang_set_default_subject|escape}>"></div>
    <label class="xcp-isp-toggle"><input type="checkbox" name="is_active" value="1"<{if !empty($form.is_active)}> checked<{/if}>> <{$xcf_lang_set_is_active}></label>
    <label class="xcp-isp-toggle"><input type="checkbox" name="enable_captcha" value="1"<{if !empty($settings.enable_captcha)}> checked<{/if}>> <{$xcf_lang_set_captcha}></label>
    <div style="margin-top:18px"><button type="submit" class="xcp-btn xcp-btn--green" style="padding:10px 24px">💾 <{$xcf_lang_save}></button></div>
</div>
</div>

</form>
</div>

<!-- Inspector -->
<div id="xcf-inspector" class="xcp-inspector">
    <div class="xcp-isp-hd"><span id="xcf-isp-title"><{$xcf_lang_isp_title}></span><button onclick="xcfCloseInspector()" style="background:none;border:none;color:#fff;font-size:18px;cursor:pointer">✕</button></div>
    <div id="xcf-isp-body" class="xcp-isp-body"></div>
</div>

<script>
var XCF_TYPES = {
    short_text:{l:<{$xcf_lang_ft_short_text|json_encode}>},
    long_text:{l:<{$xcf_lang_ft_long_text|json_encode}>},
    email:{l:<{$xcf_lang_ft_email|json_encode}>},
    website:{l:<{$xcf_lang_ft_website|json_encode}>},
    phone:{l:<{$xcf_lang_ft_phone|json_encode}>},
    number:{l:<{$xcf_lang_ft_number|json_encode}>},
    date:{l:<{$xcf_lang_ft_date|json_encode}>},
    time:{l:<{$xcf_lang_ft_time|json_encode}>},
    file:{l:<{$xcf_lang_ft_file|json_encode}>},
    hidden:{l:<{$xcf_lang_ft_hidden|json_encode}>},
    label:{l:<{$xcf_lang_ft_label|json_encode}>},
    heading:{l:<{$xcf_lang_ft_heading|json_encode}>},
    paragraph:{l:<{$xcf_lang_ft_paragraph|json_encode}>},
    choice:{l:<{$xcf_lang_ft_choice|json_encode}>},
    image_choice:{l:<{$xcf_lang_ft_image_choice|json_encode}>},
    dropdown:{l:<{$xcf_lang_ft_dropdown|json_encode}>},
    consent:{l:<{$xcf_lang_ft_consent|json_encode}>},
    signature:{l:<{$xcf_lang_ft_signature|json_encode}>}
};
var XCF_LANG = {
    confirm_del:   <{$xcf_lang_confirm_del|json_encode}>,
    required_lbl:  <{$xcf_lang_required_lbl|json_encode}>,
    isp_content:   <{$xcf_lang_isp_content|json_encode}>,
    isp_label:     <{$xcf_lang_isp_field_label|json_encode}>,
    isp_name:      <{$xcf_lang_isp_field_name|json_encode}>,
    isp_ph:        <{$xcf_lang_isp_placeholder|json_encode}>,
    isp_val:       <{$xcf_lang_isp_default_val|json_encode}>,
    isp_opts:      <{$xcf_lang_isp_options|json_encode}>,
    isp_required:  <{$xcf_lang_isp_required|json_encode}>,
    isp_desc:      <{$xcf_lang_isp_desc|json_encode}>,
    isp_width:     <{$xcf_lang_isp_width|json_encode}>,
    isp_full:      <{$xcf_lang_isp_width_full|json_encode}>,
    isp_save:      <{$xcf_lang_isp_save|json_encode}>,
    isp_settings:  <{$xcf_lang_isp_settings_suffix|json_encode}>,
    def_option1:   <{$xcf_lang_isp_default_option|json_encode}>,
    def_option2:   <{$xcf_lang_isp_default_option2|json_encode}>
};
<{literal}>
var xcfFields = [], xcfDragType = null, xcfDragIdx = null, xcfSelIdx = null;

function xcfEsc(s){var d=document.createElement('div');d.textContent=s;return d.innerHTML;}

function xcfRender(){
    var c=document.getElementById('xcf-canvas');
    var em=document.getElementById('xcf-empty');
    c.querySelectorAll('.xcp-field-item').forEach(function(el){el.remove();});
    if(!xcfFields.length){if(em)em.style.display='block';return;}
    if(em)em.style.display='none';
    xcfFields.forEach(function(f,i){
        var t=XCF_TYPES[f.type]||{l:f.type};
        var wl=f.width===6?'½':f.width===4?'⅓':'';
        var div=document.createElement('div');
        div.className='xcp-field-item'+(i===xcfSelIdx?' selected':'');
        if(f.width===6){div.style.cssText='display:inline-flex;vertical-align:top;width:calc(50% - 5px);margin-right:6px;box-sizing:border-box';}
        else if(f.width===4){div.style.cssText='display:inline-flex;vertical-align:top;width:calc(33.333% - 6px);margin-right:6px;box-sizing:border-box';}
        div.setAttribute('data-idx',i);div.setAttribute('draggable','true');
        div.innerHTML='<span class="xcp-fi-drag">⠿</span><div class="xcp-fi-info"><strong>'+xcfEsc(f.label||t.l)+'</strong><span>'+t.l+(f.required?' · '+XCF_LANG.required_lbl:'')+(wl?' · '+wl:'')+'</span></div><div class="xcp-fi-actions"><button onclick="xcfEdit('+i+')" title="✏️">✏️</button><button onclick="xcfDel('+i+')" title="🗑" style="color:#d32f2f">🗑</button></div>';
        div.addEventListener('dragstart',function(e){xcfDragIdx=i;e.dataTransfer.effectAllowed='move';});
        div.addEventListener('dragover',function(e){e.preventDefault();});
        div.addEventListener('drop',function(e){e.preventDefault();e.stopPropagation();if(xcfDragIdx!==null&&xcfDragIdx!==i){var m=xcfFields.splice(xcfDragIdx,1)[0];xcfFields.splice(i,0,m);xcfDragIdx=null;xcfRender();xcfSync();}});
        c.appendChild(div);
    });
}

function xcfAdd(type){
    var t=XCF_TYPES[type]||{};
    xcfFields.push({type:type,name:'field_'+Date.now(),label:t.l||type,placeholder:'',required:false,options:(['choice','dropdown','image_choice'].indexOf(type)>=0)?[XCF_LANG.def_option1,XCF_LANG.def_option2]:[],value:'',description:'',width:12});
    xcfRender();xcfSync();xcfEdit(xcfFields.length-1);
}

function xcfDel(i){
    if(!confirm(XCF_LANG.confirm_del))return;
    xcfFields.splice(i,1);
    if(xcfSelIdx===i){xcfSelIdx=null;xcfCloseInspector();}
    xcfRender();xcfSync();
}

function xcfEdit(i){
    xcfSelIdx=i;
    var f=xcfFields[i];
    var t=XCF_TYPES[f.type]||{};
    document.getElementById('xcf-isp-title').textContent=t.l+' '+XCF_LANG.isp_settings;
    var hasOpts=['choice','dropdown','image_choice'].indexOf(f.type)>=0;
    var isStatic=['label','heading','paragraph'].indexOf(f.type)>=0;
    var isHidden=f.type==='hidden';
    var body=document.getElementById('xcf-isp-body');
    var html='';
    if(isStatic) html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_content+'</label><textarea id="isp-label">'+xcfEsc(f.label||'')+'</textarea></div>';
    else html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_label+'</label><input type="text" id="isp-label" value="'+xcfEsc(f.label||'')+'"></div>';
    html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_name+'</label><input type="text" id="isp-name" value="'+xcfEsc(f.name||'')+'"></div>';
    if(!isStatic&&!isHidden) html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_ph+'</label><input type="text" id="isp-ph" value="'+xcfEsc(f.placeholder||'')+'"></div>';
    if(isHidden) html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_val+'</label><input type="text" id="isp-val" value="'+xcfEsc(f.value||'')+'"></div>';
    if(hasOpts) html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_opts+'</label><textarea id="isp-opts" rows="5">'+xcfEsc((f.options||[]).join('\n'))+'</textarea></div>';
    if(!isStatic&&f.type!=='heading') html+='<label class="xcp-isp-toggle"><input type="checkbox" id="isp-req"'+(f.required?' checked':'')+'>'+' '+XCF_LANG.isp_required+'</label>';
    html+='<div class="xcp-isp-fg"><label>'+XCF_LANG.isp_desc+'</label><input type="text" id="isp-desc" value="'+xcfEsc(f.description||'')+'"></div>';
    html+='<div class="xcp-isp-fg" id="xcf-width-box"></div>';
    html+='<button class="xcp-btn xcp-btn--blue" onclick="xcfSave('+i+')" style="width:100%;justify-content:center;padding:9px;margin-top:4px">'+XCF_LANG.isp_save+'</button>';
    body.innerHTML=html;
    // Genişlik seçici
    (function(){
        var wb=document.getElementById('xcf-width-box');
        if(!wb)return;
        var cw=f.width||12;
        var opts=[{w:12,label:XCF_LANG.isp_full,cols:1},{w:6,label:'1/2',cols:2},{w:4,label:'1/3',cols:3}];
        var h='<label style="display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:5px">'+XCF_LANG.isp_width+'</label><div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px">';
        opts.forEach(function(o){
            var sel=cw===o.w;
            var bc=sel?'#1976d2':'#ddd';
            var boxes='';
            for(var k=0;k<o.cols;k++) boxes+='<div style="background:'+(k===0?(sel?'#1976d2':'#bbb'):'#e0e0e0')+';height:9px;border-radius:2px;flex:1"></div>';
            h+='<label style="display:flex;flex-direction:column;align-items:center;gap:4px;border:2px solid '+bc+';border-radius:6px;padding:7px;cursor:pointer;font-size:11px;font-weight:600" onclick="xcfSetW('+i+','+o.w+')">';
            h+='<div style="display:flex;gap:2px;width:100%">'+boxes+'</div>'+o.label+'</label>';
        });
        h+='</div>';
        wb.innerHTML=h;
    })();
    document.getElementById('xcf-inspector').classList.add('open');
    xcfRender();
}

function xcfSetW(i,w){xcfFields[i].width=w;xcfSync();xcfEdit(i);}

function xcfSave(i){
    var f=xcfFields[i];
    var lbl=document.getElementById('isp-label');
    var nm=document.getElementById('isp-name');
    var ph=document.getElementById('isp-ph');
    var req=document.getElementById('isp-req');
    var desc=document.getElementById('isp-desc');
    var val=document.getElementById('isp-val');
    var opts=document.getElementById('isp-opts');
    if(lbl)f.label=lbl.value;
    if(nm)f.name=nm.value.replace(/[^a-z0-9_]/gi,'_').toLowerCase();
    if(ph)f.placeholder=ph.value;
    if(req)f.required=req.checked;
    if(desc)f.description=desc.value;
    if(val)f.value=val.value;
    if(opts)f.options=opts.value.split('\n').map(function(s){return s.trim();}).filter(Boolean);
    if(!f.width)f.width=12;
    xcfRender();xcfSync();
}

function xcfCloseInspector(){document.getElementById('xcf-inspector').classList.remove('open');xcfSelIdx=null;xcfRender();}

function xcfSync(){var h=document.getElementById('xcf-fields-json');if(h)h.value=JSON.stringify(xcfFields);}

// Init
document.addEventListener('DOMContentLoaded',function(){
    // Palette drag
    document.querySelectorAll('.xcp-ft').forEach(function(el){
        el.addEventListener('dragstart',function(e){xcfDragType=el.getAttribute('data-type');xcfDragIdx=null;e.dataTransfer.effectAllowed='copy';});
    });
    var canvas=document.getElementById('xcf-canvas');
    canvas.addEventListener('dragover',function(e){e.preventDefault();canvas.classList.add('dragover');});
    canvas.addEventListener('dragleave',function(){canvas.classList.remove('dragover');});
    canvas.addEventListener('drop',function(e){e.preventDefault();canvas.classList.remove('dragover');if(xcfDragType){xcfAdd(xcfDragType);xcfDragType=null;}});
    // Load existing
    var h=document.getElementById('xcf-fields-json');
    if(h&&h.value){try{xcfFields=JSON.parse(h.value)||[];}catch(e){xcfFields=[];}xcfRender();}
    // Tabs
    document.querySelectorAll('.xcp-tab').forEach(function(tab){
        tab.addEventListener('click',function(){
            document.querySelectorAll('.xcp-tab').forEach(function(t){t.classList.remove('active');});
            document.querySelectorAll('.xcp-tab-panel').forEach(function(p){p.classList.remove('active');});
            tab.classList.add('active');
            var t=document.getElementById('tab-'+tab.getAttribute('data-tab'));
            if(t)t.classList.add('active');
        });
    });
});
<{/literal}>
</script>
