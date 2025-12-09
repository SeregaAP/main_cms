<li class="template_itm">
    <span class="template_itm_cnt">
        <span class="template_itm_txt">
            <span class="template_itm_id">{{ $tem->id }}</span>
            <span class="template_itm_name">{{ $tem->name }}</span>
        </span>
        <span class="itm_group_btn_all template_itm_group_control">
            <x-btn-action :doc="$tem" route="templates" type="edit" />
            <x-btn-action :doc="$tem" route="templates" type="delete" />
        </span>
    </span>
</li>