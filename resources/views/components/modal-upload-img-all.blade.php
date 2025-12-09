<div class="tv_modal_upload_img" @if($inputSelector) data-input="{{ $inputSelector }}" @endif>
    <div class="tv_modal_upload_cnt">
        <div class="tv_modal_upload_header">
            <span>Выбрать файл</span>
            <button type="button" class="close_btn_variant_img">
                <i class="fal fa-xmark"></i>
            </button>
        </div>
        <div class="tv_modal_upload_flex">
            <ul class="tv_modal_upload_folder"></ul>
            <div id="tv_modal_upload_file" class="tv_modal_upload_file"></div>
        </div>
    </div>
</div>