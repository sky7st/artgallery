@extends('layouts.app')
@section('content')
@auth
<div id="artist-top-bar">
  <button class="btn btn-primary" data-toggle="modal" data-target="#insertArtist">Insert</button>
</div>
@endauth
<div id="artist-list" class="table-responsive-xl mt-2">
  <table class="table table-bordered table-condensed table-striped table-hover" id="artist_list" data-toggle="table" data-strip="true" data-pagination="true">
    <thead class="col-auto">
        <tr>
          <th data-field="id">ID</th>
          <th data-field="name">Artist Name</th>
          <th data-field="address">Artist Address</th>
          <th data-field="phone">Phone</th>
          <th data-field="usual_type">Type</th>
          <th data-field="usual_medium">Medium</th>
          <th data-field="usual_style">Style</th>
          <th data-field="delete_artist">Delete</th>
        </tr>
    </thead>
    @foreach ($artists as $artist)
      <tr class="table-row">
        <th id="artist_id">{{ $artist->id }}</th>
        <th>{{ $artist->name }}</th>
        <th>{{ $artist->address }}</th>
        <th>{{ $artist->phone }}</th>
        <th>{{ $artist->usual_type }}</th>
        <th>{{ $artist->usual_medium }}</th>
        <th>{{ $artist->usual_style }}</th>
        <th><button class="delete_artist btn btn-danger" data-delete="{{$artist->id}}">Delete</button> </th>
      </tr>
    @endforeach     
  </table>
</div>
<div id="page-link" class="text-center justify-content">{{ $artists->links() }}</div>
<div id="deleteArtistCheck" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteArtistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comfirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-danger">Do you sure you want to delete this artist?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" id="modalConfirm" class="btn btn-danger">Confirm</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
      </div>
    </div>
  </div>
</div>
<div id="insertArtist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateArtistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Artist</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="insertArtistForm" method="POST">
          @csrf
          <div class="form-row">
              <div class="form-group col">
                  <label for="ssn">SSN</label>
                  <input id="ssn" name="ssn" type="text" class="form-control" value="" required>
              </div>
              <div class="form-group col">
                  <label for="name">Name</label>
                  <input id="name" name="name" type="text" class="form-control" value="" required>
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
          <div class="form-row">
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="modalInsertConfirm" class="btn btn-primary">Insert</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
      </div>
    </div>
  </div>
</div>
  <script>
    $(document).ready(function($) {
      $(".table-row").click(function(e) {
          if(!$(e.target).is("button")){
            var id = $(this).find('th#artist_id').text();
            window.document.location = "/artist/" + id;
          }   
      });
      $('.delete_artist').click(function(e) {
        var target = $(e.target);
        var id = target.data("delete");
        $("#modalConfirm").data("delete", id)
        $('#modalConfirm').unbind().click(function(e){
          var id = $("#modalConfirm").data("delete");
          console.log("id=",id)
          var url = '/artist/' + id + '/delete'
          
          $.ajax({
            url: url,
            type: "GET",
            success: function(response){
              console.log(response)
              if(response.msg === "success"){
                alert("Delete success!!!")
                var lastPage = "/artist?page=" + response.data.lastPage
                location.href = lastPage
              }else{
                alert("Delete failed!!!")
                location.reload()
              } 
            }
          })
        });
        $('#deleteArtistCheck').modal('show')
      })
      $('#modalInsertConfirm').click(function(e) {
        var form = $("#insertArtistForm")[0]
        console.log(form)
        if(form.reportValidity()){
          $.ajax({
            type: "POST",
            url: "/artist/insert",
            data: $(form).serialize(),
            success: function(response){
              console.log(response)
              if(response.msg === "success"){
                alert("insert success!!!")
                var lastPage = "/artist?page=" + response.data.lastPage
                location.href = lastPage
              }else{
                alert("err:" + response.err)
                location.reload()
              }
            }
          })
        }
      })
    });
  </script>
  <style>
    .table-row {
      cursor: pointer;
      overflow-y: auto;
    }
    .pagination{
      justify-content: center!important;
    }
  </style>
@endsection