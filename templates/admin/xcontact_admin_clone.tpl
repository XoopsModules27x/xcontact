<!-- Header -->
<{include file='db:xcontact_admin_header.tpl' }>

<div class="xcp-wrap">
    <div class="xcp-header">
        <h2><{$icons.clone}> <{$smarty.const._AM_XCONTACT_MENU_CLONE}></h2>
    </div>

    <{if $form|default:''}>
        <{$form|default:false}>
    <{/if}>
    <{if $result|default:''}>
        <{$result|default:false}>
    <{/if}>
    <{if $error|default:''}>
        <div class="errorMsg"><strong><{$error|default:false}></strong></div>
    <{/if}>
</div>

<!-- Footer -->
<{include file='db:xcontact_admin_footer.tpl' }>
