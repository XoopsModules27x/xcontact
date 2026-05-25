<div class="xcp-wrap">
    <div class="xcp-header">
        <h2>📧 <{$smarty.const._AM_XCONTACT_SUB_VIEW_TITLE}> #<{$sub.sub_id}> — <{$form.name}></h2>
        <a href="<{$module_url}>admin/submissions.php?form_id=<{$sub.form_id}>" class="xcp-btn xcp-btn--gray"><{$smarty.const._AM_XCONTACT_SUB_VIEW_BACK}></a>
    </div>
    <p style="color:#888;font-size:12px"><{$smarty.const._AM_XCONTACT_SUBS_COL_DATE}>: <{$sub.created_at|date_format:"%d.%m.%Y %H:%M"}> · IP: <{$sub.ip}></p>
    <{foreach key=k item=v from=$data}>
    <div style="margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid #f0f0f0">
        <div style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;margin-bottom:3px"><{if isset($fmap[$k])}><{$fmap[$k]}><{else}><{$k}><{/if}></div>
        <div style="font-size:13px;color:#222;background:#f8f9fa;padding:8px 10px;border-radius:4px;word-break:break-all">
            <{if $v|is_array}><{$v|implode:', '|escape}><{else}><{$v|escape|nl2br}><{/if}>
        </div>
    </div>
    <{/foreach}>
</div>
