@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">                   
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Who are you') }}</label>
                            <div class="col-md-6">
                                <select name="role" class="form-control col-5" id="roleSelect">
                                    @foreach ( $regRoles as $role )
                                    <option value="{{$role->id}}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="ssn">SSN</label>
                            <input id="ssn" name="ssn" type="text" class="form-control @error('ssn') is-invalid @enderror" value="" required>
                            @error('ssn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>

                            <div class="form-group col">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                              <label for="add">Address</label>
                              <input id="add" name="add" type="text" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="form-row" id="usual-art">
                            <div class="form-group col">
                                <label for="umedium">Usual Medium</label>
                                <input id="umedium" name="umedium" type="text" class="form-control" value="">
                            </div>
                            <div class="form-group col">
                                <label for="ustyle">Usual Style</label>
                                <input id="ustyle" name="ustyle" type="text" class="form-control" value="">
                            </div>
                            <div class="form-group col">
                                <label for="utype">Usual Type</label>
                                <input id="utype" name="utype" type="text" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $('#roleSelect').change(function () {
        if(this.value === "3"){
            $('#usual-art').hide()
        }else{
            $('#usual-art').show()
        }
    })
</script>
@endsection
