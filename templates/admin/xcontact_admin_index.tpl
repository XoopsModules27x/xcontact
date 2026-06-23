<!-- Header -->
<{include file='db:xcontact_admin_header.tpl' }>

<{if $displaySampleButton|default:false}>
    <div class="xcp-header" style="justify-content: start;">
        <a class="xcp-btn xcp-btn--green pull-left" href="../testdata/index.php?op=load" title="<{$smarty.const.CO_XCONTACT_ADD_SAMPLEDATA}>"><{$smarty.const.CO_XCONTACT_ADD_SAMPLEDATA}></a>
        <a class="xcp-btn xcp-btn--green pull-left" href="../testdata/index.php?op=save" title="<{$smarty.const.CO_XCONTACT_SAVE_SAMPLEDATA}>"><{$smarty.const.CO_XCONTACT_SAVE_SAMPLEDATA}></a>
    </div>
<{/if}>
<div class="xcp-dashboard">
    <h2 class="xcp-title"><{$icons.dashboard}> <{$dashboard_title}></h2>
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
            <div class="xcp-widget-title"><{$icons.form}> <{$smarty.const._AM_XCONTACT_DASH_RECENT_FORMS}></div>
            <{if $recent_forms|default:false}>
            <table class="xcp-table">
                <tr><th><{$smarty.const._AM_XCONTACT_DASH_COL_AD}></th><th><{$smarty.const._AM_XCONTACT_DASH_COL_SLUG}></th><th><{$smarty.const._AM_XCONTACT_FORM_ACTIVE}></th><th><{$smarty.const._AM_XCONTACT_ACTIONS}></th></tr>
                <{foreach item=f from=$recent_forms}>
                <tr>
                    <td><{$f.name}></td>
                    <td><code><{$f.slug}></code></td>
                    <td><{if $f.is_active}><span class="xcp-badge xcp-on"><{$smarty.const._AM_XCONTACT_FORMS_STATUS_ON}></span><{else}><span class="xcp-badge xcp-off"><{$smarty.const._AM_XCONTACT_FORMS_STATUS_OFF}></span><{/if}></td>
                    <td><a href="<{$module_url}>admin/forms.php?op=edit&form_id=<{$f.form_id}>" class="xcp-btn xcp-btn--blue"><{$smarty.const._AM_XCONTACT_FORMS_BTN_EDIT}></a></td>
                </tr>
                <{/foreach}>
            </table>
            <{else}><p class="xcp-empty"><{$smarty.const._AM_XCONTACT_DASH_NO_FORMS}> <a href="<{$module_url}>admin/forms.php?op=new"><{$smarty.const._AM_XCONTACT_DASH_NEW_FORM}></a></p><{/if}>
        </div>
        <div class="xcp-widget">
            <div class="xcp-widget-title"><{$icons.submission}> <{$smarty.const._AM_XCONTACT_DASH_RECENT_SUBS}></div>
            <{if $recent_subs|default:false}>
            <table class="xcp-table">
                <tr><th><{$smarty.const._AM_XCONTACT_DASH_COL_FORM}></th><th><{$smarty.const._AM_XCONTACT_DASH_COL_DATE}></th><th><{$smarty.const._AM_XCONTACT_SUB_STATUS}></th><th><{$smarty.const._AM_XCONTACT_ACTIONS}></th></tr>
                <{foreach item=s from=$recent_subs}>
                <tr>
                    <td><{$s.form_name}></td>
                    <td><{$s.created_at|date_format:"%d.%m.%Y %H:%M"}></td>
                    <td><{if $s.status eq 0}><span class="xcp-badge xcp-new"><{$smarty.const._AM_XCONTACT_SUB_NEW}></span><{else}><span class="xcp-badge xcp-on"><{$smarty.const._AM_XCONTACT_SUB_READ}></span><{/if}></td>
                    <td><a href="<{$module_url}>admin/submissions.php?op=view&id=<{$s.sub_id}>" class="xcp-btn xcp-btn--blue"><{$smarty.const._AM_XCONTACT_DASH_BTN_VIEW}></a></td>
                </tr>
                <{/foreach}>
            </table>
            <{else}><p class="xcp-empty"><{$smarty.const._AM_XCONTACT_DASH_NO_SUBS}></p><{/if}>
        </div>
    </div>
    <div class="xcp-quick">
        <a href="<{$module_url}>admin/forms.php?op=new" class="xcp-btn xcp-btn--green"><{$icons.plus}> <{$smarty.const._AM_XCONTACT_MENU_NEW_FORM}></a>
        <a href="<{$module_url}>admin/forms.php"        class="xcp-btn xcp-btn--blue"><{$icons.list}> <{$smarty.const._AM_XCONTACT_DASH_BTN_FORMS}></a>
        <a href="<{$module_url}>admin/submissions.php"  class="xcp-btn xcp-btn--orange"><{$icons.submission}> <{$smarty.const._AM_XCONTACT_MENU_SUBMISSIONS}></a>
    </div>
</div>

<!-- Footer -->
<{include file='db:xcontact_admin_footer.tpl' }>
