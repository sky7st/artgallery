@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-6">
    <button class="btn btn-primary" onclick="javascript:history.back()">Back</button>
    @can('update artist data')
      @can('isHimSelf', $artist->user, Auth::user())
        <button class="btn btn-primary ml-1"  data-toggle="modal" data-target="#updateArtist">Update Your Data</button>    
      @endcan
    @endcan
    @can('add new work')
      @can('isHimSelf', $artist->user, Auth::user())
        <button class="btn btn-primary ml-1"  data-toggle="modal" data-target="#add_work">Add New Work</button>    
      @endcan
    @endcan
  </div>
</div>
<div class="row">
  <div class="col-5 mt-2">
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
  <div class="col-7 mt-2">
    <div class="container text-center">
      <h4>Artworks by {{ $artist->name }}</h4>
    </div>
    <div class="col-12 mt-2 pl-0 pr-0 text-center" id="product_list">
      <div class="container">
        <ul class="d-flex flex-wrap list-group-horizontal">
          @foreach ($works as $index=>$work)
            <li class="list-group-item justify-content-left align-items-center mr-auto mt-2">
              @can('delete work')
                @can('isHimSelf', $artist->user, Auth::user())
                  <button type="button" id="deleteWorkBtn" class="delete-work close align-items-right mb-1">
                  <span aria-hidden="true" data-work="{{ $work->id }}" data-title="{{ $work->title }}">&times;</span>
                  </button>
                @endcan
              @endcan
              <div class="work-info">
                <a href="{{ '/work/'.$work->id }}">
                  <img src="{{ '/storage/images/arts/thumb/'.$work->image_thumb }}" style="max-width: 200px; max-height: 250px;" alt="no image">
                </a>
                <div class="work-detail mt-1">
                  <span class="text-center">
                    <a href="{{ '/work/'.$work->id }}" class="work-link">
                      <h3>{{ $work->title }}</h3>
                    </a>
                  </span>
                </div>
                <div class="work-price">
                    ${{ $work->asking_price}}
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@can('update artist data')
  @can('isHimSelf', $artist->user, Auth::user())
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
  @endcan
@endcan
@can('add new work')
  @can('isHimSelf', $artist->user, Auth::user())
    <div id="add_work" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="workDataModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Work</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="NewWorkForm" post="/work/insert" enctype='multipart/form-data'>
              @csrf
              <div class="form-group">
                <label for="title"><mark>*</mark>Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp" placeholder="Enter Title" required>
                <small id="titleHelp" class="form-text text-muted">You can't use the title you had used before.</small>
                <span class="error-title invalid-feedback" role="alert">  
                </span>
              </div>
              <div class="form-row" id="art-media">
                <div class="form-group col">
                  <label for="type"><mark>*</mark>Type</label>
                  <input id="type" name="type" type="text" class="form-control" value="" placeholder="Enter Type" required>
                  <span class="error-type invalid-feedback" role="alert">
                  </span>
                </div>
                <div class="form-group col">
                  <label for="style"><mark>*</mark>Style</label>
                  <input id="style" name="style" type="text" class="form-control" value="" placeholder="Enter Style" required>
                  <span class="error-style invalid-feedback" role="alert">
                  </span>
                </div>
                <div class="form-group col">
                  <label for="medium"><mark>*</mark>Medium</label>
                  <input id="medium" name="medium" type="text" class="form-control" value="" placeholder="Enter Medium" required>
                  <span class="error-medium invalid-feedback" role="alert">
                  </span>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <div class="form-group-row" id="size-price">
                    <label for="size"><mark>*</mark>Size</label>
                    <input type="text" class="form-control" id="size" name="size" placeholder="Enter Size" required>
                    <span class="invalid-size" role="alert">
                    </span>
                  </div>
                  <div class="form-group-row mt-3">
                    <label for="workImage"><mark>*</mark>Work Image</label>
                    <input type="file" name="image" class="form-control-file" id="workImage" accept=".jpg,.bmp,.png,.jpeg" onchange="readImage(this);" required>
                    <span class="error-image invalid-feedback" role="alert">
                    </span>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group-row">
                    <label for="price"><mark>*</mark>Asking Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="usDollar">$</span>
                      </div>
                      <input id="price" name="price" type="number" class="form-control" value="" placeholder="Enter Price" aria-describedby="usDollar" min="1" required> 
                      <span class="error-price invalid-feedback" role="alert">
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div id="preview-image-container" style="display: none;">
                      <img src="" alt="" id="preview-image" class="img-responsive fit-image">
                  </div>
                </div>
              </div>           
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Add some description....."></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="addWorkBtn">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
          </div>
        </div>
      </div>
    </div>
  @endcan
@endcan
@can('delete work')
  @can('isHimSelf', $artist->user, Auth::user())
    <div id="deleteWorkModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteWorkModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Delete Work</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="delete-check">
            <input type="hidden" name="id" value="-1" id="deleteWorkId"/>
            <div class="confirm-text text-danger">
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="deleteWorkConfirm" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
          </div>
        </div>
      </div>
    </div>
  @endcan
@endcan 
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
  @can('add new work')
    @can('isHimSelf', $artist->user, Auth::user())
      $('#add_work').on('hidden.bs.modal', function (e) {
        $('#NewWorkForm').find("input, textarea").val("");
        $('#preview-image')
          .attr('src', '');
        $('#preview-image-container').hide()
        $('#NewWorkForm').find('input').removeClass('is-invalid')
      })
      $("#addWorkBtn").click(function (e) {
        var form = $("#NewWorkForm")[0]
        if(form.reportValidity()){
          $(form).submit();    
        }
      })
      $('#NewWorkForm').submit(function(event) {
        event.preventDefault();
        console.log('submit')
        $.ajax({
            type: "POST",
            url: "/work/insert",
            data: new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response){
              console.log(response)
              if(response.message === "success"){
                alert("Insert new work success!!!")
                location.reload()
              }else{
                alert("err:" + response.err)
                // location.reload()
              }
            },
            error: function (reject) {
              if( reject.status === 422 ) {
                var errors = reject.responseJSON.errors;
                console.log(errors)

                $.each(errors, function (key, val) {
                  // $(".error-" + key).show();
                  $("#"+key).addClass('is-invalid')
                  $(".error-" + key).text(val[0]);
                });
              }
            }
          })
    });
      function readImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-image')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            $('#preview-image-container').show()
        }
      }
    @endcan
  @endcan  
  @can('delete work')
    @can('isHimSelf', $artist->user, Auth::user()) 
    $(document).ready(function ($) {
      $('.delete-work').click(function (event) {
        var id = $(event.target).data('work')
        var title = $(event.target).data('title')
        $('.confirm-text').html("Do you sure you want to delete <br> "+title + " ?" )
        $('#deleteWorkId').val(id)
        $('#deleteWorkModal').modal('show')
      })
      $('#deleteWorkConfirm').click(function (event) {
        var id = $('#deleteWorkId').val()
        $.ajax({
          method: "GET",
          url: "/work/" + id + "/delete",
          success: function (response) {
            console.log(response)
            if(response.msg === "success"){
              $('#deleteWorkModal').modal('hide')
              alert('Delete success!')
              location.reload()
            }else{
              
            }
          }
        })
      })
    })
    @endcan
  @endcan 
</script>
<style>
  .table-row {
    cursor: pointer;
    overflow-y: auto;
  }
  .work-link { color: inherit; } 
  .work-link:hover 
  {
    color: inherit;
    cursor:pointer;  
  }
  .fit-image{
    width: 100%;
    object-fit: cover;
    height: 100%;
  }
  .close:focus{
    outline: none;
    box-shadow: none;
  }
</style>
@endsection