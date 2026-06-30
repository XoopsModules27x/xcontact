<div class="xcp-wrap">
    <div class="xcp-header">
        <h2><{$icons.envelope_open}> <{$smarty.const._AM_XCONTACT_SUB_VIEW_TITLE}> #<{$sub.sub_id|escape}> — <{$form_name|escape}></h2>
        <div>
        <a href="<{$module_url}>/admin/submissions.php?form_id=<{$sub.form_id|escape:'url'}>" class="xcp-btn xcp-btn--gray"><{$icons.back}> <{$smarty.const._AM_XCONTACT_SUB_VIEW_BACK}></a>
        <form method="post" action="<{$module_url}>/admin/submissions.php" style="display:inline" onsubmit="return confirm('<{$smarty.const._AM_XCONTACT_SUBS_CONFIRM_DEL}>')">
            <input type="hidden" name="op" value="delete">
            <input type="hidden" name="sub_id" value="<{$sub.sub_id}>">
            <input type="hidden" name="form_id" value="<{$sub.form_id}>">
            <button type="submit" class="xcp-btn xcp-btn--red"><{$smarty.const._AM_XCONTACT_SUBS_BTN_DEL}></button>
            <{$xoops_token}>
        </form></div>
    </div>
    <h3 style="color:#888"><{$smarty.const._AM_XCONTACT_SUBS_COL_DATE}>: <{$sub.created_at|date_format:"%d.%m.%Y %H:%M"}> · IP: <{$sub.ip|escape}></h3>
    <{foreach key=k item=v from=$data}>
    <div style="margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid #f0f0f0">
        <div style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;margin-bottom:3px"><{if isset($f_name[$k])}><{$f_name[$k]}><{else}><{$k}><{/if}></div>
        <div style="font-size:13px;color:#222;background:#f8f9fa;padding:8px 10px;border-radius:4px;word-break:break-all">
            <{if $f_type[$k] == 'signature' && $v !== ''}>
                <img src="<{$v|escape}>" alt="<{$smarty.const._AM_XCONTACT_FT_SIGNATURE}>" title="<{$smarty.const._AM_XCONTACT_FT_SIGNATURE}>" style="max-width:200px;max-height:100px;">
            <{elseif $f_type[$k] === 'image_choice' && is_array($v)}>
                <{foreach item=v_img from=$v}>
                    <img src="<{$xcontact_upload_img_url}><{$v_img}>" alt="<{$v_img}>" title="<{$v_img}>" style="max-width:200px;max-height:100px;">
                <{/foreach}>
            <{elseif $f_type[$k] == 'file' &&  $v|escape != ''}>
                <{$v|escape}> <a class="xcp-btn xcp-btn--blue" href="<{$xcontact_upload_file_url}><{$v|escape}>" download title="<{$smarty.const._AM_XCONTACT_DOWNLOAD}>"><{$icons.download}></a>
            <{elseif $f_type[$k] == 'email' &&  $v|escape != ''}>
                <{$v|escape}>
                <a class="xcp-btn xcp-btn--blue" href="mailto:<{$v|escape}>" class="btn btn-primary">
                    <{$icons.envelope_open}> <{$smarty.const._REPLY}>
                </a>
            <{elseif $f_type[$k] == 'consent'}>
                <{if $v == 1}>
                    <{$smarty.const._AM_XCONTACT_CHECKED}>
                <{else}>
                    <{$smarty.const._AM_XCONTACT_NOT_CHECKED}>
                <{/if}>
            <{else}>
                <{if $v|is_array}><{$v|implode:', '|escape}><{else}><{$v|escape|nl2br}><{/if}>
            <{/if}>
        </div>
    </div>
    <{/foreach}>
</div>
