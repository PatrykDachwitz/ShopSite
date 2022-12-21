@extends('layouts.admin')

@section('itemGroup')
    @foreach($banners ?? [] as $banner)
        <div class="item-card">
            <div class="item-card__checbox-title d-flex">
                <input type="checkbox" class="mx-2 checkbox" value="{{ $banner->id }}"/>
                <span class="fs-4 ms-3">{{ $banner->name }}</span>
            </div>
            <div class="item-card__item_group me-2">
                <a class="mx-2" href="{{ route('admin.banner.show', ['banner' => $banner->id]) }}">
                    <picture>
                        <source srcset="/icon/view.webp" type="image/webp">
                        <img src="/icon/view.png" width="35" height="35" class="icon"/>
                    </picture>
                </a>
                <a class="mx-2" href="{{ route('admin.banner.edit', ['banner' => $banner->id]) }}">
                    <picture>
                        <source srcset="/icon/edit.webp" type="image/webp">
                        <img src="/icon/edit.png" width="35" height="35" class="icon"/>
                    </picture>
                </a>
                <picture>
                    <source srcset="/icon/delete.webp" type="image/webp">
                    <img src="/icon/delete.png" width="35" height="35" class="icon mx-2" value="{{ $banner->id }}"/>
                </picture>
            </div>
        </div>
    @endforeach
@endsection