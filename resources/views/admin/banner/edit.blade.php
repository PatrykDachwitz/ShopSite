@extends('layouts.admin')

@section('content')
    <div class="content mx-4 mb-4 content-admin rounded">
        <div class="content-show w-100">
            <div class="header-show">
               <div class="header-show__btn-group">
                   <a href="{{ url()->previous() }}">
                        <picture>
                           <source srcset="/icon/back.webp" type="image/webp">
                           <img src="/icon/back.png" width="40" class="ms-4 my-4 me-2" height="40">
                       </picture>
                   </a>
                   <button class="btn btn-dark my-4 me-2 btn-custom" data-value="info">Informacje</button>
                   <button class="btn btn-dark my-4 me-2 btn-custom" data-value="contents">Treść</button>
                   <button class="btn btn-dark my-4 btn-custom" data-value="graphic">Grafiki</button>
               </div>
                <div class="header-show__icon-group">
                    <a>
                        <picture>
                            <source srcset="/icon/save.webp" type="image/webp">
                            <img src="/icon/save.png" width="30" height="30">
                        </picture>
                        <picture>
                            <source srcset="/icon/new.webp" type="image/webp">
                            <img src="/icon/new.png" class="mx-2" width="30" height="30">
                        </picture>
                        <picture>
                            <source srcset="/icon/delete.webp" type="image/webp">
                            <img src="/icon/delete.png" width="30" class="me-4" height="30">
                        </picture>
                    </a>
                </div>
            </div>@if( $errors->any())
                      {{ dump($errors) }}
                      @endif()
            @isset($banner)
                <form class="m-5" method="post" action="{{ route('admin.banner.update.post') }}" enctype="multipart/form-data">
                    @csrf
                    <input type='hidden' value="{{ $banner->id }}" name="id">
                    <div class="row customContent info d-flex" data-content="info">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Nazwa</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $banner->name) }}" placeholder="Nazwa">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputCity" class="form-label">Początek wyświeltania</label>
                            <input type="text" class="form-control @error('start-date') is-invalid @enderror" name="start-date" id="inputCity" value="{{ old('start-date', $banner['start-date']) }}">
                            @error('start-date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 ">
                            <label for="inputCity" class="form-label">Koniec wyświetlania</label>
                            <input type="text" class="form-control @error('end-date') is-invalid @enderror" name="end-date" id="inputCity" value="{{ old('end-date', $banner['end-date']) }}">
                            @error('end-date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 my-md-3">
                            <label for="inputState" class="form-label">Typ</label>
                            <select id="inputState" name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="{{ $banner->type->id }}" selected>{{ $banner->type->name }}</option>
                                @foreach($types ?? [] as $type)
                                    @if($banner->type->id !== $type->id)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 my-md-3">
                            <label for="inputState" class="form-label">Aktywny</label>
                            <select class="form-select @error('active') is-invalid @enderror" name="active">
                                @if($banner->active)
                                <option value="1" selected>Tak</option>
                                <option value="0">Nie</option>
                                @else
                                    <option value="0" selected>Nie</option>
                                    <option value="1" >Tak</option>
                                @endif
                            </select>
                            @error('active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 my-md-3">
                            <label for="inputState" class="form-label">Pozycja</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="inputCity" value="{{ old('position', $banner->position) }}">
                            @error('position')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <input type="submit" value="Zapisz baner" class="btn btn-dark col-md-2 ms-3">
                    </div>

                    <div class="row customContent d-none" data-content="contents">
                        <label for="inputCity" class="form-label">Treść</label>
                        <textarea class="form-control col-md-12 mx-2" name="contents">
                            @isset($contents)
                                {{ $contents }}
                            @endisset
                        </textarea>
                    </div>

                    <div class="row d-none customContent form-graphic" data-content="graphic">
                        <div class="col-lg-6 col-md-12 form-graphic__group" data-container="pc">
                            <div class="form-graphic__group-header">
                                <span class="fs-4">
                                Werjsa pc (1480 x 700)
                                </span>
                                <button class="btn btn-dark btn-add-file" data-type="pc">
                                    Dodaj grafikę
                                </button>
                            </div>
                            @foreach($banner->file ?? [] as $file)
                                @if($file->device === 'pc')
                                    <div class="form-graphic__group-item shadow-sm p-2">
                                        <div class="form-graphic__group-picture-title ms-3">
                                            <picture>
                                                <source srcset="{{ $file }}-min.webp" type="image/webp">
                                                <img src="{{ $file }}.png" width="100" height="60"/>
                                            </picture>
                                            <span class="fs-3">
                                                {{ $banner->name }}
                                           </span>
                                        </div>
                                        <div class="form-graphic__group-radio me-3">
                                            <input type="radio" class="form-graphic__radio" name="availableFile[pc][]" value="{{ $file->id }}"  @if($file->pivot->default) checked="checked" @endif>
                                            <span class="fs-5 mx-2">
                                                Aktywny
                                           </span>
                                            <a class="ms-3">
                                                <picture>
                                                    <source srcset="/icon/delete.webp" type="image/webp">
                                                    <img src="/icon/delete.png" width="30" height="30"/>
                                                </picture>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="form-graphic__group-item shadow-sm p-2">
                                <div class="form-graphic__group-picture-title ms-3">
                                   <input type="file">
                                </div>
                                <div class="form-graphic__group-radio me-3">
                                    <input type="radio" class="form-graphic__radio"  @if($file->pivot->default) selected @endif>
                                    <span class="fs-5 mx-2">
                                                Aktywny
                                           </span>
                                    <a class="ms-3">
                                        <picture>
                                            <source srcset="/icon/delete.webp" type="image/webp">
                                            <img src="/icon/delete.png" width="30" height="30"/>
                                        </picture>
                                    </a>
                                </div>
                            </div>

                        </div>

                       <div class="col-lg-6 col-md-12 form-graphic__group" data-container="mobile">
                            <div class="form-graphic__group-header">
                                <span class="fs-4">
                                Werjsa mobilna (620 x 420)
                                </span>
                                <button class="btn btn-dark btn-add-file" data-type="mobile">
                                    Dodaj grafikę
                                </button>
                            </div>
                           @foreach($banner->file ?? [] as $file)
                               @if($file->device === 'mobile')
                                   <div class="form-graphic__group-item shadow-sm p-2">
                                       <div class="form-graphic__group-picture-title ms-3">
                                           <picture>
                                               <source srcset="{{ $file }}-min.webp" type="image/webp">
                                               <img src="{{ $file }}.png" width="100" height="60"/>
                                           </picture>
                                           <span class="fs-3">
                                                {{ $banner->name }}
                                           </span>
                                       </div>
                                       <div class="form-graphic__group-radio me-3">
                                           <input type="radio" class="form-graphic__radio"  name="availableFile[mobile][]" value="{{ $file->id }}"  @if($file->pivot->default) checked="checked" @endif>
                                           <span class="fs-5 mx-2">
                                                Aktywny
                                           </span>
                                           <a class="ms-3">
                                               <picture>
                                                   <source srcset="/icon/delete.webp" type="image/webp">
                                                   <img src="/icon/delete.png" width="30" height="30"/>
                                               </picture>
                                           </a>
                                       </div>
                                   </div>
                               @endif
                           @endforeach
                       </div>
                    </div>

                </form>
            @endisset
        </div>
    </div>
@endsection