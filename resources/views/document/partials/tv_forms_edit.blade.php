@if(isset($tvForms) && $tvForms->isNotEmpty())
    <div class="acardion-item">
        <div class="acardion_header">
            <span class="acardion_name">Дополнительные поля</span>
            <button class="acardion_btn" type="button">
                <i class="fa-sharp fa-solid fa-angle-right"></i>
            </button>
        </div>
        <div class="acardion_grid">
            @foreach ($tvForms as $tv)
                @php
                    $config = $tv->config ?? [];
                    $value = isset($tvValues[$tv->id]) ? $tvValues[$tv->id]->value : ($config['default'] ?? null);
                @endphp

                <div class="tv tv-{{ $tv->type }}">
                    {{-- TEXT --}}
                    @if ($tv->type === 'text')
                        <!--<input
                            type="text"
                            name="tv[{{ $tv->id }}]"
                            value="{{ $value }}"
                            placeholder="{{ $config['placeholder'] ?? '' }}"
                            maxlength="{{ $config['maxlength'] ?? 255 }}"
                        >-->
                        <x-input 
                            placeholder="{{ $config['placeholder'] ?? '' }}" 
                            type="text" 
                            name="tv[{{ $tv->id }}]" 
                            label="{{ $tv->name }} : {{ $tv->key }}" 
                            :required="false"
                            autocomplete="tv[{{ $tv->id }}]"
                            value="{{ $value }}"
                            autofocus
                            maxlength="255"
                        />
                    @endif

                    {{-- IMAGE --}}
                    @if ($tv->type === 'image')
                        <div class="input_image-group">
                            <span>{{ $tv->name }} : {{ $tv->key }}</span>
                            <div class="input_image_cnt">
                                <img src="{{ asset($value) }}" alt="">
                                <div class="input_image_control">
                                    <input hidden  id="inp-{{ $tv->id }}" name="tv[{{ $tv->id }}][old]" value="{{ $value }}">
                                    <button data-id="inp-{{ $tv->id }}" type="button" class="file-modal-open">Загрузить</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- MIGX --}}
                    @if ($tv->type === 'migx')
                        <input
                            type="hidden"
                            name="tv[{{ $tv->id }}]"
                            value="{{ $value }}"
                            data-migx
                            data-config='{{ json_encode($config, JSON_HEX_APOS | JSON_HEX_QUOT) }}'
                        >
                        <button type="button" class="btn-migx" data-tv-id="{{ $tv->id }}">
                            Редактировать {{ $tv->name }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <x-btn  type="submit"  text="Сохронить" />
@endif