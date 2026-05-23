<div class="xcontact-index">
    <h2><{$xoops_pagetitle}></h2>
    <{if $xcontact_list}>
    <ul class="xcontact-form-list">
        <{foreach item=f from=$xcontact_list}>
        <li><a href="<{$f.url}>"><{$f.name}></a><{if $f.desc}> — <{$f.desc|truncate:80}><{/if}></li>
        <{/foreach}>
    </ul>
    <{else}>
    <p><{$xcontact_lang_no_forms}></p>
    <{/if}>
</div>
