<div class="xcp-wrap">
    <div class="xcp-header">
        <h2>📥 <{$xcf_subs_title}><{if $form}> — <{$form.name}><{/if}></h2>
        <a href="<{$module_url}>admin/forms.php" class="xcp-btn xcp-btn--gray"><{$xcf_subs_back}></a>
    </div>

    <div style="margin-bottom:16px">
        <select onchange="if(this.value)location.href='<{$module_url}>admin/submissions.php?form_id='+this.value" style="padding:7px 10px;border:1px solid #ddd;border-radius:4px">
            <option value=""><{$xcf_subs_select}></option>
            <{foreach item=f from=$forms}>
            <option value="<{$f.form_id}>"<{if $form_id eq $f.form_id}> selected<{/if}>><{$f.name}></option>
            <{/foreach}>
        </select>
    </div>

    <{if $form_id}>
    <table class="xcp-table">
        <thead><tr>
            <th>#</th>
            <th><{$xcf_subs_col_date}></th>
            <th><{$xcf_subs_col_ip}></th>
            <th><{$xcf_am_sub_status}></th>
            <th><{$xcf_am_actions}></th>
        </tr></thead>
        <tbody>
        <{if $subs}>
            <{foreach item=s from=$subs}>
            <tr>
                <td>#<{$s.sub_id}></td>
                <td><{$s.created_at|date_format:"%d.%m.%Y %H:%M"}></td>
                <td><{$s.ip}></td>
                <td><{if $s.status eq 0}><span class="xcp-badge xcp-new"><{$xcf_am_sub_new}></span><{else}><span class="xcp-badge xcp-on"><{$xcf_am_sub_read}></span><{/if}></td>
                <td>
                    <a href="<{$module_url}>admin/submissions.php?op=view&id=<{$s.sub_id}>" class="xcp-btn xcp-btn--blue"><{$xcf_subs_btn_view}></a>
                    <form method="post" action="<{$module_url}>admin/submissions.php" style="display:inline" onsubmit="return confirm('<{$xcf_subs_confirm_del}>')">
                    <input type="hidden" name="op" value="delete">
                    <input type="hidden" name="id" value="<{$s.sub_id}>">
                    <input type="hidden" name="form_id" value="<{$form_id}>">
                    <button type="submit" class="xcp-btn xcp-btn--red"><{$xcf_subs_btn_del}></button>
                </form>
                </td>
            </tr>
            <{/foreach}>
        <{else}>
            <tr><td colspan="5" class="xcp-empty"><{$xcf_subs_empty}></td></tr>
        <{/if}>
        </tbody>
    </table>
    <{/if}>
</div>
