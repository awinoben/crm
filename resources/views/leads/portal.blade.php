<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('img/crm.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">
            <br>
            <center>
                <img src="{{ asset('img/crm.png') }}" alt="" width="100">
                <hr>
                <h3>Add Portal</h3>
                <hr>
            </center>
            <form action="{{ route('add.portal') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="industry_id">Select Industry</label>
                    <select name="industry_id" id="industry_id"
                            class="form-control @error('industry_id') is-invalid @enderror"
                            required>
                        <option value="industry_id" selected disabled>Select Industry</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                        @endforeach
                    </select>
                    @error('industry_id')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="url">Add Url</label>
                    <input type="url" name="url" id="url" class="form-control  @error('url') is-invalid @enderror"
                           placeholder="https://www.google.com/"
                           required>
                    @error('url')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="funnel">Add Funnel</label>
                    <input type="text" name="funnel" id="funnel" placeholder="FaceBook,Website,Twiiter,LinkedIn"
                           class="form-control  @error('funnel') is-invalid @enderror">
                    @error('funnel')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary text-center">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('sweetalert::alert')

</body>
</html>
