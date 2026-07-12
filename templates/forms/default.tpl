<div class="xcontact-wrap" id="xcontact-<{$xcontact_form_id}>">
    <{if !empty($xcontact_error)}>
        <div class="xcontact-errors"><{$xcontact_error}></div>
    <{elseif $xcontact_success}>
        <div class="xcontact-success"><{$icons.checked}> <{$xcontact_settings.success_msg|default:$smarty.const._MD_XCONTACT_SUCCESS}></div>
    <{else}>
        <{if !empty($xcontact_errors)}>
            <div class="xcontact-errors"><strong><{$smarty.const._MD_XCONTACT_PLEASE_FIX}></strong>
                <ul>
                    <{foreach item=e from=$xcontact_errors}><li><{$e}></li><{/foreach}>
                </ul>
            </div>
        <{/if}>
        <{if $xcontact_form_descr|default:''}>
            <p style="color:#666;font-size:14px;margin-bottom:20px"><{$xcontact_form_descr|nl2br}></p>
        <{/if}>
    <{/if}>
    <!-- input form with necessary script -->
    <{if $form|default:''}>
        <{$form}>
    <{/if}>
</div> <!-- xcontact-wrap -->
