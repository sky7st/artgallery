@extends('layouts.app')
@section('content')
<div>
  <table class="table table-bordered table-condensed table-striped table-hover" id="artist_list" data-toggle="table" data-strip="true" data-pagination="true">
    <thead>
        <tr>
          <th data-field="id">ID</th>
          <th data-field="name">Artist Name</th>
          <th data-field="address">Artist Address</th>
          <th data-field="phone">Artist Phone</th>
          <th data-field="usual_type">Artist Type</th>
          <th data-field="usual_medium">Artist Medium</th>
          <th data-field="usual_style">Artist Style</th>
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
<div id="deleteArtistCheck" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
            }
          })
        });

        $('#deleteArtistCheck').modal('show')
      })

    });

    
  </script>
  <style>
    .table-row {
        cursor: pointer;
    }
  </style>
@endsection