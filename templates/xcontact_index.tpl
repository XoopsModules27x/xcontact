<div class="xcontact-index">
    <h2><{$xoops_pagetitle}></h2>
    <{if $xcontact_list}>
        <ul class="xcontact-form-list">
            <{foreach item=f from=$xcontact_list}>
            <li><a href="<{$f.url|escape}>"><{$f.name}></a><{if $f.description_short|default:''}> — <{$f.description_short|escape}><{/if}></li>
            <{/foreach}>
        </ul>
        <{if $pagenav|default:''}>
            <div class="clear">&nbsp;</div>
            <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
            <div class="clear spacer"></div>
        <{/if}>
    <{else}>
        <p><{$xcontact_lang_no_forms}></p>
    <{/if}>
</div>
