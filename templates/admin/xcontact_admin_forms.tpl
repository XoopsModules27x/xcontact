<!-- Header -->
<{include file='db:xcontact_admin_header.tpl' }>

<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{if $form|default:false}>
    <{$form}>
<{/if}>

<div class="xcp-wrap">
    <div class="xcp-header">
        <h2><{$icons.list}> <{$smarty.const._AM_XCONTACT_FORMS_LIST}></h2>
        <a href="forms.php?op=new" class="xcp-btn xcp-btn--green"><{$icons.plus}> <{$smarty.const._AM_XCONTACT_FORMS_NEW}></a>
    </div>
    <div class="xcp-info">
        <{$smarty.const._AM_XCONTACT_FORMS_BLOCK_INFO}><br>
        <code><{$xoops_url}>/modules/xcontact/form.php?slug=SLUG</code>
    </div>
    <table class="xcp-table">
        <thead><tr>
            <th><{$smarty.const._AM_XCONTACT_FORMS_COL_NAME}></th>
            <th><{$smarty.const._AM_XCONTACT_FORMS_COL_SLUG}></th>
            <th><{$smarty.const._AM_XCONTACT_FORMS_COL_FIELDS}></th>
            <th><{$smarty.const._AM_XCONTACT_FORMS_COL_SUBS}></th>
            <th><{$smarty.const._AM_XCONTACT_FORMS_COL_STATUS}></th>
            <th><{$smarty.const._AM_XCONTACT_FORMS_COL_TEMPLATE}></th>
            <th><{$smarty.const._AM_XCONTACT_ACTIONS}></th>
        </tr></thead>
        <tbody>
        <{if $forms_list|default:false}>
            <{foreach item=f from=$forms_list}>
            <tr>
                <td><strong><{$f.name}></strong></td>
                <td>
                    <code><{$f.slug}></code><br>
                    <small style="color:#1976d2"><{$f.tpl_tag|default:''}></small>
                </td>
                <td><{$f.fields_count|default:0}> <{$smarty.const._AM_XCONTACT_FORMS_FIELDS_COUNT}></td>
                <td>
                    <a href="submissions.php?form_id=<{$f.form_id}>"><{$f.total_subs|default:0}> <{$smarty.const._AM_XCONTACT_FORMS_SUB_COUNT}>
                    <{if $f.new_subs|default:0 gt 0}><span class="xcp-badge xcp-new"><{$f.new_subs}> <{$smarty.const._AM_XCONTACT_SUB_NEW}></span><{/if}></a>
                </td>
                <td>
                    <form method="post" action="forms.php" style="display:inline">
                        <input type="hidden" name="op" value="toggle">
                        <input type="hidden" name="form_id" value="<{$f.form_id}>">
                        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0">
                            <{if $f.is_active|default:0}><span class="xcp-badge xcp-on"><{$smarty.const._AM_XCONTACT_FORMS_STATUS_ON}></span><{else}><span class="xcp-badge xcp-off"><{$smarty.const._AM_XCONTACT_FORMS_STATUS_OFF}></span><{/if}>
                        </button>
                        <{$xoops_token}>
                    </form>
                </td>
                <td class="center">
                    <{if $f.template_status|default:false}>
                        <img src="<{$xcontact_icons_url|escape}>/32/success.png" alt="<{$smarty.const._AM_XCONTACT_FORM_TEMPLATE_SUCCESS}>" title="<{$smarty.const._AM_XCONTACT_FORM_TEMPLATE_SUCCESS}>" style="width:24px;">
                    <{else}>
                        <img src="<{$xcontact_icons_url|escape}>/32/broken.png" alt="<{$smarty.const._AM_XCONTACT_FORM_TEMPLATE_BROKEN}>" title="<{$smarty.const._AM_XCONTACT_FORM_TEMPLATE_BROKEN}>" style="width:24px;">
                    <{/if}>
                </td>
                <td>
                    <a href="forms.php?op=edit&form_id=<{$f.form_id}>" class="xcp-btn xcp-btn--blue"><{$smarty.const._AM_XCONTACT_FORMS_BTN_EDIT}></a>
                    <a href="forms.php?op=clone&form_id_source=<{$f.form_id}>" class="xcp-btn xcp-btn--blue"><{$smarty.const._AM_XCONTACT_FORMS_BTN_CLONE}></a>
                    <a href="submissions.php?form_id=<{$f.form_id}>" class="xcp-btn xcp-btn--gray"><{$smarty.const._AM_XCONTACT_FORMS_BTN_SUBS}></a>
                    <form method="post" action="forms.php" style="display:inline" onsubmit="return confirm('<{$smarty.const._AM_XCONTACT_FORMS_CONFIRM_DEL|escape:"javascript"}>')">
                    <input type="hidden" name="op" value="delete">
                    <input type="hidden" name="form_id" value="<{$f.form_id}>">
                    <button type="submit" class="xcp-btn xcp-btn--red"><{$smarty.const._AM_XCONTACT_FORMS_BTN_DEL}></button>
                    <{$xoops_token}>
                </form>
                </td>
            </tr>
            <{/foreach}>
        <{else}>
            <tr><td colspan="6" class="xcp-empty"><{$smarty.const._AM_XCONTACT_FORMS_EMPTY}> <a href="forms.php?op=new"><{$smarty.const._AM_XCONTACT_FORMS_CREATE_FIRST}> <{$icons.forward}></a></td></tr>
        <{/if}>
        </tbody>
    </table>
</div>

<!-- Footer -->
<{include file='db:xcontact_admin_footer.tpl' }>
