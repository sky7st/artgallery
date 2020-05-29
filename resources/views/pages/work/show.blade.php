@extends('layouts.app')
@section('content')
<div class="row pt-2">
  <div class="work-image col-12 col-sm-12 col-md-7 col-lg-8">
    <img src="{{ '/storage/images/arts/org/'.$work->image_path }}" style="max-width: 580px; max-height: 600px;">
  </div>
  <div class="work-descript col-12 col-sm-12 col-md-5 col-lg-4 pr-md-0 pr-lg-0">
    <div class="page-title row text-left">
      <h1><b>{{ $work->title }}</b></h1>  
    </div>
    <div class="artist row text-left">
      <h4>
        by 
        <a href="/artist/{{ $work->artist_id }}"> {{ $work->artist->name }} </a>
      </h4>
    </div>
    <div class="price-info row text-left mt-3">
      <h2>
      <span>${{ $work->asking_price }}</span>
      </h2>
    </div>
    <div class="work-detail row mt-5 text-left">
      <div class="col-6">
        <div class="row">
          <label><b>SIZE</b></label>
        </div>
        <div class="row">
          {{ $work->size }}
        </div>
        <div class="row mt-2">
          <label><b>TYPE</b></label>
        </div>
        <div class="row">
          {{ $work->type }}
        </div>
        <div class="row mt-2">
          <label><b>STYLE</b></label>
        </div>
        <div class="row">
          {{ $work->style }}
        </div>
        <div class="row mt-2">
          <label><b>MEDIUM</b></label>
        </div>
        <div class="row">
          {{ $work->medium }}
        </div>
      </div>
      <div class="col-6">
        <div class="row">
          <label ><b>DESCRIPTION</b></label>
        </div>
        <div class="work-description row text=left">
          <div id="summary">
            <p class="collapse" id="collapseSummary">
              {{ $work->descript}}
            </p>
            <a class="collapsed" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
          </div>
        </div>
      </div>
    </div>
    @can('isHimSelf', $work->artist->user, Auth::user())
    @else
      <div class="want-buy row mt-4 text-left">
        <div class="col">
          <div class="row">
            <label><b>WANT TO BUY?</b></label>
          </div>
          <div class="row">
            @guest
              <a href="/login" class="btn btn-danger btn-lg">LOGIN TO MAKE ENQUIRY</a>   
            @endguest
            @auth
              @can('buy works')
              <a href="#" class="btn btn-primary btn-lg" id="make-enquiry" data-toggle="modal" data-target="#makeEnquiryModal">MAKE ENQUIRY</a> 
              <div id="makeEnquiryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="makeEnquiryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content rounded-0">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="makeEnquiry">
                      <form id="enquiryForm">
                        @csrf
                        <input type="hidden" name="work" value="{{ $work->id }}">
                        <div class="form-row">
                          <div class="form-group col">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="enquiry-input form-control" id="name" placeholder="Name"  readonly="readonly"/>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ auth()->user()->email }}" class="enquiry-input form-control" id="email" placeholder="Email"  readonly="readonly"/>
                          </div>
                        </div>
                        <div class="form-row">                        
                          <div class="form-group col">
                            <input type="text" name="subject" class="enquiry-input form-control" id="subject" placeholder="Subject" required/>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col">
                            <textarea id="query" name="query" rows="4" placeholder="Query" class="enquiry-input form-control" required></textarea>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="submitEnquiry" class="btn btn-primary mr-auto rounded-0">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              @endcan
            @endauth
          </div>
        </div>
      </div>
    @endcan
  </div>
</div>

<script>
@can('buy works')
  $('#submitEnquiry').click(function (event) {
    var form = $("#enquiryForm")[0];
    if(form.reportValidity()){
      console.log($(form).serialize())
      $.ajax({
        method: "POST",
        url: "/enquiry/make",
        data: $(form).serialize(),
        success: function (response) {
          if(response.msg === "success"){
            alert("Send Enquiry Success!!")
            location.href = "/enquiry";
          }
        }
      })
    }
  })
@endcan
</script>

<style>

  .modal-header {
    border-bottom: 0 none;
  }

  .modal-footer {
    border-top: 0 none;
  }

  .enquiry-input{
    border-radius:0px !important;
  }
</style>
@endsection