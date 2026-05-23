<div class="xcform-index">
    <h2><{$xoops_pagetitle}></h2>
    <{if $xcform_list}>
    <ul class="xcform-form-list">
        <{foreach item=f from=$xcform_list}>
        <li><a href="<{$f.url}>"><{$f.name}></a><{if $f.desc}> — <{$f.desc|truncate:80}><{/if}></li>
        <{/foreach}>
    </ul>
    <{else}>
    <p><{$xcform_lang_no_forms}></p>
    <{/if}>
</div>
