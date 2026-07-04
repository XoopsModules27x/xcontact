<{if $block.form_url}>
    <div class="xcontact-wrap" id="xcontact-block-<{$block.form_id}>">
        <{if $block.embed}>
            <{if $block.success|default:false}>
                <div style="background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:16px;color:#2e7d32;font-weight:600">&#10003; <{$block.success_msg}></div>
            <{else}>
                <{if $block.errors|default:false}>
                    <div style="background:#ffebee;border:1px solid #ef9a9a;border-radius:5px;padding:12px;margin-bottom:12px;color:#c62828">
                        <strong><{$smarty.const._MB_XCONTACT_PLEASE_FIX}>:</strong><ul>
                        <{foreach from=$block.errors item=e}><li><{$e}></li><{/foreach}>
                        </ul>
                    </div>
                <{/if}>
            <{/if}>
            <{if $block.form|default:false}>
                <{if $block.form_desc}><p style="color:#666;font-size:13px;margin:0 0 8px"><{$block.form_desc}></p><{/if}>
                <{$block.form}>
            <{/if}>
        <{else}>
            <{if $block.form_desc}><p style="color:#666;font-size:13px;margin:0 0 8px"><{$block.form_desc}></p><{/if}>
            <a href="<{$block.form_url}>" style="display:inline-block;background:#1976d2;color:#fff;padding:8px 20px;border-radius:4px;text-decoration:none;font-size:14px;font-weight:600"><{$smarty.const._MB_XCONTACT_FILL_IN_FORM}> <{$icons.forward}></a>
        <{/if}>
    </div>
<{/if}>
