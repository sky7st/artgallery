@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col">
    <button class="btn btn-primary" onclick="javascript:history.back()">Back</button>
    @can('update artist data')
      @can('isHimSelf', $artist->user, Auth::user())
        <button class="btn btn-primary ml-1"  data-toggle="modal" data-target="#updateArtist">Update</button>    
      @endcan
    @endcan
  </div>
</div>
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
  <div class="col-sm-6 text-center">
      <h4>Art List</h4>
  </div>
</div>
<div id="updateArtist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="insertArtistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Artist</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="updateArtistForm" method="POST" action="{{ route('pages.artist.update', $artist->id) }}">
          @csrf
          <div class="form-row">
              <div class="form-group col">
                  <label for="ssn">SSN</label>
              <input id="ssn" name="ssn" type="text" class="form-control" value="{{ $artist->artist_ssn }}" disabled>
              </div>
              <div class="form-group col">
                  <label for="name">Name</label>
                  <input id="name" name="name" type="text" class="form-control" value="{{ $artist->name }}" required>
              </div>
              <div class="form-group col">
                  <label for="phone">Phone</label>
                  <input id="phone" name="phone" type="text" class="form-control" value="{{ $artist->phone }}" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col">
                <label for="add">Address</label>
                <input id="add" name="add" type="text" class="form-control" value="{{ $artist->address }}" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col">
                  <label for="umedium">Usual Medium</label>
                  <input id="umedium" name="umedium" type="text" class="form-control" value="{{ $artist->usual_medium }}">
              </div>
              <div class="form-group col">
                  <label for="ustyle">Usual Style</label>
                  <input id="ustyle" name="ustyle" type="text" class="form-control" value="{{ $artist->usual_style }}">
              </div>
              <div class="form-group col">
                  <label for="utype">Usual Type</label>
                  <input id="utype" name="utype" type="text" class="form-control" value="{{ $artist->usual_type }}">
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="modalUpdateConfirm" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
      </div>
    </div>
  </div>
</div>
<script>
  @can('update artist data')
    @can('isHimSelf', $artist->user, Auth::user())
      $("#modalUpdateConfirm").click(function(e) {
        var form = $("#updateArtistForm")[0];
        var action = $(form).attr('action')
        if(form.reportValidity()){
          $.ajax({
            url: action,
            type: "POST",
            data: $(form).serialize(),
            success: function (response){
              console.log(response)
              if(response.msg === "success"){
                alert('Update success')
              }else{
                alert("err: " + response.err)
              }
              location.reload()
            }
          })
        }
      })
    @endcan
  @endcan
</script>
@endsection