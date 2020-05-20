@extends('layouts.app')
@section('content')
<a href="javascript:history.back()" class="btn btn-primary">Back</a>
<div class="row mt-2">
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">{{ $artist->name }}</h3>
        <p class="card-text">Address: {{ $artist->address }}</p>
        <p class="card-text">Phone: {{ $artist->phone }}</p>
        <p class="card-text">Type: {{ $artist->usual_type }}</p>
        <p class="card-text">Medium: {{ $artist->usual_medium }}</p>
        <p class="card-text">Style: {{ $artist->usual_style }}</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
      {{ var_dump($artist) }}
  </div>
</div>
<script>
  var address = "{{ $artist->name }}";
</script>
@endsection