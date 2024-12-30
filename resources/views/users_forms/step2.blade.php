@extends('users_forms.master')
@section('title', 'Additional Info')


@section('content')

    <h1 class="mb-4">Additional Info <small>(Step 2 out of 2)</small></h1>
    <form action="{{ route('step2-data') }}" method="POST">
        @csrf
        <input type="text" name="user_id" hidden value="{{ $user->id }}">

        <div class="mb-4">
            <label>Gender</label>
            <div class="d-flex gap-3">
                <div>
                    <input type="radio" name="gender" id="male" value="male"
                        {{ old('gender', settings()->get($user->id . '_gender')) == 'male' ? 'checked' : '' }}>
                    <label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" name="gender" id="female" value="female"
                        {{ old('gender', settings()->get($user->id . '_gender')) == 'female' ? 'checked' : '' }}>
                    <label for="female">Female</label>
                </div>
            </div>
            @error('gender')
                <small class="text-danger">{{ $errors->first('gender') }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="moreInfo">Add More Info (Optional)</label>
            <textarea name="moreInfo" id="moreInfo" placeholder="Write here..."
                class="form-control @error('moreInfo')
                is-invalid
            @enderror">{{ old('moreInfo', settings()->get($user->id . '_moreInfo')) }}</textarea>
            @error('moreInfo')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-primary mb-5">Submit</button>


    </form>

    <div class="d-flex align-items-center gap-5">
        <button class="btn btn-secondary" onclick="location.href='{{ route('step1') }}'">Previous</button>
    </div>


@endsection

@section('scripts')

    <script>
        let country = document.getElementById('country');
        let oldCountry = '{{ old('country', settings()->get($user->id . '_country')) }}';
        country.value = oldCountry;
    </script>


@endsection
