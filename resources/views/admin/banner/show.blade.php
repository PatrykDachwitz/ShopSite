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
            </div>
            @isset($banner)
                <form class="m-5">
                    <div class="row customContent info d-flex" data-content="info">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Nazwa</label>
                            <input type="text" class="form-control @error('name') is-valid @enderror" name="name" value="{{ old('name', $banner->name) }}" readonly>
                            @error('name')
                                <div class="valid-feedback">
                                    {{ $error }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="inputAddress" class="form-label">Pozycja</label>
                            <input type="number" name="position" class="form-control @error('position') is-valid @enderror" value="{{ old('position' , $banner->position) }}"readonly>
                            @error('position')
                            <div class="valid-feedback">
                                {{ $error }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputState" class="form-label">Aktywny</label>
                            <select class="form-select @error('active') is-valid @enderror" name="active" readonly>
                                @if($banner->active)
                                    <option value="true" selected>Tak</option>
                                    <option value="false">Nie</option>
                                @else
                                    <option value="false" selected>Nie</option>
                                    <option value="true">Tak</option>
                                @endif
                            </select>
                            @error('active')
                            <div class="valid-feedback">
                                {{ $error }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 my-md-3">
                            <label for="inputState" class="form-label">Typ</label>
                            <select id="inputState" name="type" class="form-select @error('type') is-valid @enderror" readonly>
                                <option value="1" selected>Slider</option>
                                <option value="1">4 banery</option>
                                <option value="2">Sekcja produktu</option>
                            </select>
                            @error('type')
                            <div class="valid-feedback">
                                {{ $error }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-5 my-md-3">
                            <label for="inputCity" class="form-label">Początek wyświeltania</label>
                            <input type="text" class="form-control @error('start-data') is-valid @enderror" name="start-data" id="inputCity" value="{{ old('start-data', $banner['start-data']) }}" readonly>
                            @error('start-data')
                            <div class="valid-feedback">
                                {{ $error }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-5 my-md-3">
                            <label for="inputCity" class="form-label">Koniec Wyświetlania</label>
                            <input type="text" class="form-control @error('end-data') is-valid @enderror" name="end-data" id="inputCity" value="{{ old('end-data', $banner['end-data']) }}" readonly>
                            @error('end-data')
                            <div class="valid-feedback">
                                {{ $error }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row customContent d-none" data-content="contents">
                        <label for="inputCity" class="form-label">Treść</label>
                        <textarea class="form-control col-md-12 mx-2" readonly>
                            @isset($contents)
                                {{ $contents }}
                            @endisset
                        </textarea>
                    </div>

                    <div class="row d-none customContent form-graphic" data-content="graphic">
                       <div class="col-lg-6 col-md-12 form-graphic__group">
                            <span class="fs-4">
                                Werjsa pc (1200 x 800)
                            </span>
                       </div>

                       <div class="col-lg-6 col-md-12 form-graphic__group">
                            <div class="form-graphic__group-header">
                                <span class="fs-4">
                                Werjsa mobilna (800 x 1200)
                                </span>
                            </div>
                           <div class="form-graphic__group-item shadow-sm p-2">
                               <div class="form-graphic__group-picture-title ms-3">
                                   <picture>
                                       <source srcset="/icon/new.webp" type="image/webp">
                                       <img src="/icon/new.png" width="100" height="60"/>
                                   </picture>
                                   <span class="fs-3">
                                       Banner 1
                                   </span>
                               </div>
                               <div class="form-graphic__group-radio me-3">
                                   <input type="radio" class="form-graphic__radio" >
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
                    </div>

                </form>
            @endisset
        </div>
    </div>
@endsection