<div class="xcp-wrap">
    <div class="xcp-header">
        <h2><{$icons.envelope_open}> <{$smarty.const._AM_XCONTACT_SUB_VIEW_TITLE}> #<{$sub.sub_id|escape}> — <{$form_name|escape}></h2>
        <div>
        <a href="<{$module_url}>/admin/submissions.php?form_id=<{$sub.form_id|escape:'url'}>" class="xcp-btn xcp-btn--gray"><{$icons.back}> <{$smarty.const._AM_XCONTACT_SUB_VIEW_BACK}></a>
        <form method="post" action="<{$module_url}>/admin/submissions.php" style="display:inline" onsubmit="return confirm('<{$smarty.const._AM_XCONTACT_SUBS_CONFIRM_DEL|escape:"javascript"}>')">
            <input type="hidden" name="op" value="delete">
            <input type="hidden" name="sub_id" value="<{$sub.sub_id}>">
            <input type="hidden" name="form_id" value="<{$sub.form_id}>">
            <button type="submit" class="xcp-btn xcp-btn--red"><{$smarty.const._AM_XCONTACT_SUBS_BTN_DEL}></button>
            <{$xoops_token}>
        </form></div>
    </div>
    <h3 style="color:#888"><{$smarty.const._AM_XCONTACT_SUBS_COL_DATE}>: <{$sub.created_at|date_format:"%d.%m.%Y %H:%M"}> · IP: <{$sub.ip|escape}></h3>
    <{foreach key=k item=sub from=$data}>
        <div style="margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid #f0f0f0">
            <div style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;margin-bottom:3px"><{if isset($sub.name)}><{$sub.name}><{else}><{$k}><{/if}></div>
            <div style="font-size:13px;color:#222;background:#f8f9fa;padding:8px 10px;border-radius:4px;word-break:break-all">
                <{if $sub.type == 'signature' && $sub.value !== ''}>
                    <img src="<{$sub.value|escape}>" alt="<{$smarty.const._AM_XCONTACT_FT_SIGNATURE}>" title="<{$smarty.const._AM_XCONTACT_FT_SIGNATURE}>" style="max-width:200px;max-height:100px;">
                <{elseif $sub.type === 'image_choice' && is_array($sub.value)}>
                    <{foreach item=v_img from=$sub.value}>
                        <img src="<{$xcontact_upload_img_url}><{$v_img}>" alt="<{$v_img}>" title="<{$v_img}>" style="max-width:200px;max-height:100px;">
                    <{/foreach}>
                <{elseif $sub.type == 'file' &&  $sub.value|escape != ''}>
                    <{if $sub.filetype == $filetype_image}>
                        <!-- show image-->
                        <img src="<{$xcontact_upload_file_url}><{$sub.value|escape}>" alt="<{$sub.value|escape}>" title="<{$sub.value|escape}>" style="max-width:200px;max-height:100px;">
                    <{else}>
                        <!-- show value as iframe-->
                        <iframe style="width:100%;height:20em" src="<{$xcontact_upload_file_url}>/<{$sub.value|escape}>"></iframe>
                    <{/if}>
                     &nbsp;<a class="xcp-btn xcp-btn--blue" href="<{$xcontact_upload_file_url}><{$sub.value|escape}>" download title="<{$smarty.const._AM_XCONTACT_DOWNLOAD}>"><{$icons.download}></a>
                <{elseif $sub.type == 'email' &&  $sub.value|escape != ''}>
                    <{$sub.value|escape}>
                    <a class="xcp-btn xcp-btn--blue" href="mailto:<{$sub.value|escape}>">
                        <{$icons.envelope_open}> <{$smarty.const._REPLY}>
                    </a>
                <{elseif $sub.type == 'consent'}>
                    <{if $sub.value == 1}>
                        <{$smarty.const._AM_XCONTACT_CHECKED}>
                    <{else}>
                        <{$smarty.const._AM_XCONTACT_NOT_CHECKED}>
                    <{/if}>
                <{else}>
                    <{if $sub.value|is_array}><{$sub.value|implode:', '|escape}><{else}><{$sub.value|escape|nl2br}><{/if}>
                <{/if}>
            </div>
        </div>
    <{/foreach}>
</div>
