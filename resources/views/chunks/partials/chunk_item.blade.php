<li class="template_itm">
    <span class="template_itm_cnt">
        <span class="template_itm_txt">
            <span class="template_itm_id">{{ $chunk->id }}</span>
            <span class="template_itm_name">{{ $chunk->name }}</span>
        </span>
        <span class="itm_group_btn_all">
            <x-btn-action :doc="$chunk" route="chunks" type="edit" />
            <x-btn-action :doc="$chunk" route="chunks" type="delete" />
        </span>
    </span>
</li>