<div class="xcp-dashboard">
    <h2 class="xcp-title"><{$dashboard_title}></h2>
    <div class="xcp-stat-grid">
        <{foreach item=card from=$stat_cards}>
        <div class="xcp-stat-card xcp-stat-card--<{$card.mod}>">
            <div class="xcp-stat-value"><{$card.value}></div>
            <div class="xcp-stat-label"><{$card.label}></div>
        </div>
        <{/foreach}>
    </div>
    <div class="xcp-widgets">
        <div class="xcp-widget">
            <div class="xcp-widget-title">🆕 <{$xcf_dash_recent_forms}></div>
            <{if $recent_forms}>
            <table class="xcp-table">
                <tr><th><{$xcf_dash_col_name}></th><th><{$xcf_dash_col_slug}></th><th><{$xcf_am_stat_status}></th><th><{$xcf_am_actions}></th></tr>
                <{foreach item=f from=$recent_forms}>
                <tr>
                    <td><{$f.name}></td>
                    <td><code><{$f.slug}></code></td>
                    <td><{if $f.is_active}><span class="xcp-badge xcp-on"><{$xcf_forms_status_on}></span><{else}><span class="xcp-badge xcp-off"><{$xcf_forms_status_off}></span><{/if}></td>
                    <td><a href="<{$module_url}>admin/form_edit.php?id=<{$f.form_id}>" class="xcp-btn xcp-btn--blue"><{$xcf_forms_btn_edit}></a></td>
                </tr>
                <{/foreach}>
            </table>
            <{else}><p class="xcp-empty"><{$xcf_dash_no_forms}> <a href="<{$module_url}>admin/form_edit.php"><{$xcf_dash_new_form}></a></p><{/if}>
        </div>
        <div class="xcp-widget">
            <div class="xcp-widget-title">📥 <{$xcf_dash_recent_subs}></div>
            <{if $recent_subs}>
            <table class="xcp-table">
                <tr><th><{$xcf_dash_col_form}></th><th><{$xcf_dash_col_date}></th><th><{$xcf_am_sub_status}></th><th><{$xcf_am_actions}></th></tr>
                <{foreach item=s from=$recent_subs}>
                <tr>
                    <td><{$s.form_name}></td>
                    <td><{$s.created_at|date_format:"%d.%m.%Y %H:%M"}></td>
                    <td><{if $s.status eq 0}><span class="xcp-badge xcp-new"><{$xcf_am_sub_new}></span><{else}><span class="xcp-badge xcp-on"><{$xcf_am_sub_read}></span><{/if}></td>
                    <td><a href="<{$module_url}>admin/submissions.php?op=view&id=<{$s.sub_id}>" class="xcp-btn xcp-btn--blue"><{$xcf_dash_btn_view}></a></td>
                </tr>
                <{/foreach}>
            </table>
            <{else}><p class="xcp-empty"><{$xcf_dash_no_subs}></p><{/if}>
        </div>
    </div>
    <div class="xcp-quick">
        <a href="<{$module_url}>admin/form_edit.php"  class="xcp-btn xcp-btn--green">➕ <{$xcf_am_menu_new_form}></a>
        <a href="<{$module_url}>admin/forms.php"       class="xcp-btn xcp-btn--blue">📋 <{$xcf_dash_btn_forms}></a>
        <a href="<{$module_url}>admin/submissions.php" class="xcp-btn xcp-btn--orange">📥 <{$xcf_am_menu_subs}></a>
    </div>
</div>
