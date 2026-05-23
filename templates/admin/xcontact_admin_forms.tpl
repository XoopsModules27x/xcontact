<div class="xcp-wrap">
    <div class="xcp-header">
        <h2>📋 <{$xcf_forms_title}></h2>
        <a href="<{$module_url}>admin/form_edit.php" class="xcp-btn xcp-btn--green">➕ <{$xcf_forms_new}></a>
    </div>
    <div class="xcp-info">
        <{$xcf_forms_block_info}><br>
        <code><{$xoops_url}>/modules/xcontact/form.php?slug=SLUG</code>
    </div>
    <{if $msg eq 'deleted'}><div class="xcp-notice xcp-notice--ok"><{$xcf_forms_deleted}></div><{/if}>
    <table class="xcp-table">
        <thead><tr>
            <th><{$xcf_forms_col_name}></th>
            <th><{$xcf_forms_col_slug}></th>
            <th><{$xcf_forms_col_fields}></th>
            <th><{$xcf_forms_col_subs}></th>
            <th><{$xcf_forms_col_status}></th>
            <th><{$xcf_am_actions}></th>
        </tr></thead>
        <tbody>
        <{if $forms}>
            <{foreach item=f from=$forms}>
            <tr>
                <td><strong><{$f.name}></strong></td>
                <td>
                    <code><{$f.slug}></code><br>
                    <small style="color:#1976d2"><{$f.tpl_tag}></small>
                </td>
                <td><{$f.field_count}> <{$xcf_forms_field_count}></td>
                <td>
                    <a href="<{$module_url}>admin/submissions.php?form_id=<{$f.form_id}>"><{$f.total_subs}> <{$xcf_forms_sub_count}>
                    <{if $f.new_subs gt 0}><span class="xcp-badge xcp-new"><{$f.new_subs}> <{$xcf_am_sub_new}></span><{/if}></a>
                </td>
                <td>
                    <form method="post" action="<{$module_url}>admin/forms.php" style="display:inline">
                        <input type="hidden" name="op" value="toggle">
                        <input type="hidden" name="id" value="<{$f.form_id}>">
                        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0">
                            <{if $f.is_active}><span class="xcp-badge xcp-on"><{$xcf_forms_status_on}></span><{else}><span class="xcp-badge xcp-off"><{$xcf_forms_status_off}></span><{/if}>
                        </button>
                    </form>
                </td>
                <td>
                    <a href="<{$module_url}>admin/form_edit.php?id=<{$f.form_id}>" class="xcp-btn xcp-btn--blue"><{$xcf_forms_btn_edit}></a>
                    <a href="<{$module_url}>admin/submissions.php?form_id=<{$f.form_id}>" class="xcp-btn xcp-btn--gray"><{$xcf_forms_btn_subs}></a>
                    <form method="post" action="<{$module_url}>admin/forms.php" style="display:inline" onsubmit="return confirm('<{$xcf_forms_confirm_del}>')">
                    <input type="hidden" name="op" value="delete">
                    <input type="hidden" name="id" value="<{$f.form_id}>">
                    <button type="submit" class="xcp-btn xcp-btn--red"><{$xcf_forms_btn_del}></button>
                </form>
                </td>
            </tr>
            <{/foreach}>
        <{else}>
            <tr><td colspan="6" class="xcp-empty"><{$xcf_forms_empty}> <a href="<{$module_url}>admin/form_edit.php"><{$xcf_forms_create_first}></a></td></tr>
        <{/if}>
        </tbody>
    </table>
</div>
