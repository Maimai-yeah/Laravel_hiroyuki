@foreach ($cards as $card)
    <div class="col-4 col-md-2 mb-3 p-0">
        <div class="card-item-area" data-card-id="{{ $card->id }}">
            <div class="card-item-area-inner">
                <div class="card-item-element">
                    <figure>
                        <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="img-fluid" />
                    </figure>
                    <div class="mt-2">
                        {{-- 任意で追加情報があればここに表示 --}}
                        <p class="text-center small text-muted mb-0">{{ $card->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
