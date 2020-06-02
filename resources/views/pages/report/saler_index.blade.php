@extends('layouts.app')
@section('content')
<form id="searchForm">
@csrf
<div class="form-row">
  <div class="col-3">
    <label for="saler-select">Select Saler</label>
    <select name="saler" class="form-control" id="saler-select" aria-required="true">
      @foreach ($salers as $saler)
      <option value="{{ $saler->id }}">{{ $saler->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-3">
    <label for="startTime">Select Start Date</label>
    <input type="date" name="start" id="startTime" class="form-control" required>
  </div>
  <div class="col-3">
    <label for="endTime">Select End Date</label>
    <input type="date" name="end" id="endTime" class="form-control" required>
  </div>
  <div class="col-1 my-4">
    <button class="btn btn-primary rounded-0 form-control" id="searchBtn">Search</button>
  </div>
</div>
</form>

<script>
  $('#searchBtn').click(function (e) {
    e.preventDefault();
    var form = $('#searchForm')[0]
    if(form.reportValidity()){
      $.ajax({
      method: "POST",
      url: "/report/saler",
      data: $(form).serialize(),
      success: function (response) {
        console.log(response)
      }
    })  
    }
  })
</script>
@endsection