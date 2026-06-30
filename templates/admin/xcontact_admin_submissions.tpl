<!-- Header -->
<{include file='db:xcontact_admin_header.tpl' }>

<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<div class="xcp-wrap">
    <div class="xcp-header">
        <h2><{$icons.submission}> <{$smarty.const._AM_XCONTACT_SUBS_TITLE}></h2>
        <a href="<{$module_url}>admin/forms.php" class="xcp-btn xcp-btn--gray"><{$icons.back}> <{$smarty.const._AM_XCONTACT_SUBS_BACK}></a>
    </div>

    <div style="margin-bottom:16px">
        <select onchange="if(this.value)location.href='<{$module_url}>admin/submissions.php?form_id='+this.value" style="padding:7px 10px;border:1px solid #ddd;border-radius:4px">
            <option value=""><{$smarty.const._AM_XCONTACT_SUBS_SELECT}></option>
            <{foreach item=f from=$forms|default:[]}>
            <option value="<{$f.form_id}>"<{if $form_id|default:0 eq $f.form_id}> selected<{/if}>><{$f.name}></option>
            <{/foreach}>
        </select>
    </div>

    <{if $form_id|default:0}>
    <table class="xcp-table">
        <thead><tr>
            <th>#</th>
            <th><{$smarty.const._AM_XCONTACT_SUBS_COL_DATE}></th>
            <th><{$smarty.const._AM_XCONTACT_SUBS_COL_IP}></th>
            <th><{$smarty.const._AM_XCONTACT_SUB_STATUS}></th>
            <th><{$smarty.const._AM_XCONTACT_ACTIONS}></th>
        </tr></thead>
        <tbody>
        <{if $submissions_count|default:0}>
            <{foreach item=s from=$submissions_list}>
            <tr>
                <td>#<{$s.sub_id}></td>
                <td><{$s.created_at|date_format:"%d.%m.%Y %H:%M"}></td>
                <td><{$s.ip}></td>
                <td><{if $s.status eq 0}><span class="xcp-badge xcp-new"><{$smarty.const._AM_XCONTACT_SUB_NEW}></span><{else}><span class="xcp-badge xcp-on"><{$smarty.const._AM_XCONTACT_SUB_READ}></span><{/if}></td>
                <td>
                    <a href="<{$module_url}>admin/submissions.php?op=view&sub_id=<{$s.sub_id}>" class="xcp-btn xcp-btn--blue"><{$smarty.const._AM_XCONTACT_SUBS_BTN_VIEW}></a>
                    <form method="post" action="<{$module_url}>admin/submissions.php" style="display:inline" onsubmit="return confirm('<{$smarty.const._AM_XCONTACT_SUBS_CONFIRM_DEL|escape:"javascript"}>')">
                        <input type="hidden" name="op" value="delete">
                        <input type="hidden" name="sub_id" value="<{$s.sub_id}>">
                        <input type="hidden" name="form_id" value="<{$form_id}>">
                        <button type="submit" class="xcp-btn xcp-btn--red"><{$smarty.const._AM_XCONTACT_SUBS_BTN_DEL}></button>
                        <{$xoops_token}>
                    </form>
                </td>
            </tr>
            <{/foreach}>
        <{else}>
            <tr><td colspan="5" class="xcp-empty"><{$smarty.const._AM_XCONTACT_SUBS_EMPTY}></td></tr>
        <{/if}>
        </tbody>
    </table>
    <{/if}>
</div>

<!-- Footer -->
<{include file='db:xcontact_admin_footer.tpl' }>
