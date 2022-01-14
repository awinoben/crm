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
                <h3>{{ $campaign->name }}</h3>
                <hr>
            </center>
            <form action="{{ route('lead.generation') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $campaign->id }}" name="campaign_id" id="campaign_id">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror"
                            required>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Full Name/Company Name</label>
                    <input type="text" name="name" id="name" class="form-control  @error('name') is-invalid @enderror"
                           required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">E-mail Address</label>
                    <input type="text" name="email" id="email"
                           class="form-control  @error('email') is-invalid @enderror">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control">
                    @error('phone_number')
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
