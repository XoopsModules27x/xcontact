<{if $block.form_url}>
<div class="xcontact-block">
<{if $block.embed}>
  <{if $block.success}>
    <div style="background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:16px;color:#2e7d32;font-weight:600">&#10003; <{$block.success_msg}></div>
  <{else}>
    <{if $block.errors}>
      <div style="background:#ffebee;border:1px solid #ef9a9a;border-radius:5px;padding:12px;margin-bottom:12px;color:#c62828">
        <strong><{$smarty.const._MB_XCONTACT_PLEASE_FIX}>:</strong><ul>
        <{foreach from=$block.errors item=e}><li><{$e}></li><{/foreach}>
        </ul>
      </div>
    <{/if}>
    <form method="post" action="" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="cf_form_id" value="<{$block.form_id}>">
    <{$block.xoops_token}>
    <div style="position:absolute;left:-9999px;height:0;overflow:hidden"><input type="text" name="cf_hp" tabindex="-1" autocomplete="off"></div>
    <{foreach from=$block.fields item=field}>
      <{assign var=fn value=$field.name}>
      <{if $field.type eq 'heading'}>
        <div style="font-size:16px;font-weight:700;border-bottom:2px solid #1976d2;padding-bottom:5px;margin-bottom:12px"><{$field.label}></div>
      <{elseif $field.type eq 'short_text' or $field.type eq 'email' or $field.type eq 'phone' or $field.type eq 'website' or $field.type eq 'number' or $field.type eq 'date' or $field.type eq 'time'}>
        <div style="margin-bottom:12px">
          <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px"><{$field.label}><{if $field.required}> <span style="color:#e53935">*</span><{/if}></label>
          <input style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px;box-sizing:border-box" type="<{$field.input_type}>" name="<{$fn}>" value="<{$block.data[$fn]|default:''}>"<{if $field.required}> required<{/if}>>
        </div>
      <{elseif $field.type eq 'long_text'}>
        <div style="margin-bottom:12px">
          <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px"><{$field.label}><{if $field.required}> <span style="color:#e53935">*</span><{/if}></label>
          <textarea style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px;box-sizing:border-box;height:100px;resize:vertical" name="<{$fn}>"<{if $field.required}> required<{/if}>><{$block.data[$fn]|default:''}></textarea>
        </div>
      <{elseif $field.type eq 'dropdown'}>
        <div style="margin-bottom:12px">
          <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px"><{$field.label}><{if $field.required}> <span style="color:#e53935">*</span><{/if}></label>
          <select style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px;background:#fff" name="<{$fn}>"<{if $field.required}> required<{/if}>>
            <option value=""><{$smarty.const._MB_XCONTACT_OPTION_SELECT}></option>
            <{foreach from=$field.options item=opt}>
              <option value="<{$opt}>"<{if $block.data[$fn]|default:'' eq $opt}> selected<{/if}>><{$opt}></option>
            <{/foreach}>
          </select>
        </div>
      <{elseif $field.type eq 'consent'}>
        <div style="margin-bottom:12px">
          <label style="display:flex;align-items:flex-start;gap:8px;font-size:13px;cursor:pointer">
            <input style="margin-top:2px" type="checkbox" name="<{$fn}>" value="1"<{if $block.data[$fn]|default:'' eq '1'}> checked<{/if}><{if $field.required}> required<{/if}>>
            <span><{$field.label}><{if $field.required}> <span style="color:#e53935">*</span><{/if}></span>
          </label>
        </div>
      <{/if}>
    <{/foreach}>
    <div><button style="background:#1976d2;color:#fff;border:none;padding:10px 28px;border-radius:4px;font-size:14px;font-weight:700;cursor:pointer" type="submit"><{$smarty.const._SUBMIT}></button></div>
    </form>
  <{/if}>
<{else}>
  <{if $block.form_desc}><p style="color:#666;font-size:13px;margin:0 0 8px"><{$block.form_desc}></p><{/if}>
  <a href="<{$block.form_url}>" style="display:inline-block;background:#1976d2;color:#fff;padding:8px 20px;border-radius:4px;text-decoration:none;font-size:14px;font-weight:600"><{$smarty.const._MB_XCONTACT_FILL_IN_FORM}> <{$icons.forward}></a>
<{/if}>
</div>
<{/if}>
