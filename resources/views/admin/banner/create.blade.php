@extends('layouts.admin')

@section('content')
    <div class="content mx-4 mb-4 content-admin rounded">
        <div class="content-show w-100">
                <form class="m-5" method="post" action="{{ route('admin.banner.store') }}">
                    @csrf
                    <div class="row customContent info d-flex" data-content="info">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Nazwa</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', "") }}" placeholder="Nazwa">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputCity" class="form-label">Początek wyświeltania</label>
                            <input type="text" class="form-control @error('start-date') is-invalid @enderror" name="start-date" id="inputCity" value="{{ old('start-date', $actualyDate) }}">
                            @error('start-date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 ">
                            <label for="inputCity" class="form-label">Koniec wyświetlania</label>
                            <input type="text" class="form-control @error('end-date') is-invalid @enderror" name="end-date" id="inputCity" value="{{ old('end-date', $actualyDate) }}">
                            @error('end-date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 my-md-3">
                            <label for="inputState" class="form-label">Typ</label>
                            <select id="inputState" name="type" class="form-select @error('type') is-invalid @enderror">
                                @foreach($types ?? [] as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 my-md-3">
                            <label for="inputState" class="form-label">Aktywny</label>
                            <select class="form-select @error('active') is-invalid @enderror" name="active">
                                    <option value="1" selected>Tak</option>
                                    <option value="0">Nie</option>
                            </select>
                            @error('active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <input type="submit" value="Zapisz baner" class="btn btn-dark col-md-2 ms-3">
                    </div>

                </form>
        </div>
    </div>
@endsection