<li class="template_itm">
    <span class="template_itm_cnt">
        <span class="template_itm_txt">
            <span class="template_itm_id">{{ $user->id }}</span>
            <span class="user_avatar">
                <img src="{{ asset($user->avatar) }}" alt="Avatar">
            </span>
            <span class="template_itm_name">{{ $user->name }}</span>
            <span class="template_itm_name">{{ $user->role_id }}</span>
        </span>
        <span class="itm_group_btn_all">
            <x-btn-action :doc="$user" route="users" type="edit" />
            <x-btn-action :doc="$user" route="users" type="delete" />
        </span>
    </span>
</li>