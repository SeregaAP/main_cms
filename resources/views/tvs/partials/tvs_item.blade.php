<li class="template_itm">
    <span class="template_itm_cnt">
        <span class="template_itm_txt">
            <span class="template_itm_id">{{ $tvf->id }}</span>
            <span class="template_itm_name">{{ $tvf->name }}</span>
        </span>
        <span class="itm_group_btn_all">
            <x-btn-action :doc="$tvf" route="tvs" type="edit" />
            <x-btn-action :doc="$tvf" route="tvs" type="delete" />
        </span>
    </span>
</li>