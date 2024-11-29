<form action="{{ route('movies.filter')}}" class="card px-3 pt-3 filter-form">
    <div class="row">
        <div class="col">
            <h3 class="">Thể Loại</h3>
            <div class="form-check rounded-1">
                <div class="row p-3">
                    @foreach ($genresList as $genre)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2">
                        <input class="form-check-input" name="genre[]" type="checkbox" value="{{ $genre->id }}" id="flexCheckGenre{{ $genre->id }}">
                        <label class="form-check-label" for="flexCheckGenre{{ $genre->id }}">
                            {{ $genre->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-8">
            <h3 class="">Quốc gia</h3>
            <div class="form-check rounded-1">
                <div class="row p-3">                           
                    @foreach ($countries as $country)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-2">
                        <input class="form-check-input" name="country" type="radio" name="flexRadioCountry" value="{{ $country->id }}" id="flexRadioCountry{{ $country->id }}">
                        <label class="form-check-label" for="flexRadioCountry{{ $country->id }}">
                            {{ $country->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h3 class="">Danh mục</h3>
            <div class="form-check rounded-1">
                <div class="row p-3">                           
                    @foreach ($categories as $category)
                    <div class="col-6 col-sm-4 col-md-6 col-lg-6 mb-2">
                        <input class="form-check-input" name="category" type="radio" name="flexRadioCategory" value="{{ $category->id }}" id="flexRadioCategory{{ $category->id }}">
                        <label class="form-check-label" for="flexRadioCategory{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <h3 class="">Năm sản xuất</h3>
            <div class="form-check rounded-1">
                <div class="row p-3">                          
                    @foreach ($release_years as $release_year)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-2">
                        <input class="form-check-input" name="release_year" type="radio" value="{{ $release_year->id }}" id="flexCheckReleaseYear{{ $release_year->id }}">
                        <label class="form-check-label" for="flexCheckReleaseYear{{ $release_year->id }}">
                            {{ $release_year->year }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 text-end filter-button mb-3">
        <button type="reset" class="btn"><i class="fa-solid fa-arrows-rotate"></i>Đặt lại</button>
        <button type="submit" class="btn  ms-1">Xác nhận lọc <i class="fa-solid fa-caret-right"></i></button>
    </div>
</form>
