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
.xcontact-oi-container {
    display: inline-block;
    border: 3px solid transparent;
    cursor: pointer;
    margin: 5px;
}

.xcontact-oi-container.aktiv {
    border-color: blue;
}
.xcontact-fg-label span {font-size:14px;color:#444;}
.xcontact-fg-paragraph p {font-size:13px;color:#666;line-height:1.6}
.xcontact-fg-file input {width:100%;padding:8px;border:1px dashed #bbb;border-radius:5px;background:#fafafa;font-size:13px}
.xcontact-fg-imgchoice-container {display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px}
.xcontact-fg-imgchoice-container label {border:2px solid #ddd;border-radius:6px;padding:1px;cursor:pointer;text-align:center;font-size:12px;}
.xcontact-fg-imgchoice-container img {cursor:pointer}



</style>

<{if !empty($xcontact_error)}>
    <div class="xcontact-errors"><{$xcontact_error}></div>
<{elseif $xcontact_success}>
    <div class="xcontact-success"><{$icons.checked}> <{$xcontact_settings.success_msg|default:$smarty.const._MD_XCONTACT_SUCCESS}></div>
<{else}>
    <{if $xcontact_form_descr|default:''}>
        <p style="color:#666;font-size:14px;margin-bottom:20px"><{$xcontact_form_descr|nl2br}></p>
    <{/if}>

    <{if !empty($xcontact_errors)}>
        <div class="xcontact-errors"><strong><{$smarty.const._MD_XCONTACT_PLEASE_FIX}></strong>
            <ul>
                <{foreach item=e from=$xcontact_errors}><li><{$e}></li><{/foreach}>
            </ul>
        </div>
    <{/if}>
<{/if}>

<!-- input form with necessary script -->
<{if $form|default:''}>
    <{$form}>

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

    <{literal}>
    })();
    <{/literal}>
        document.querySelectorAll(".xcontact-oi-container").forEach(container => {
            const input = container.parentElement.querySelector("input[type='checkbox']");
            if (input) {
                input.addEventListener("change", () => {
                    container.classList.toggle("aktiv", input.checked);
                });
                container.classList.toggle("aktiv", input.checked);
            }
        });
    </script>
<{/if}>

</div> <!-- xcontact-wrap -->
