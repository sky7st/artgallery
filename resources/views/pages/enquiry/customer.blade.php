@extends('layouts.app')
@section('content')
<div class="row pt-2">
  <div class="work-descript col-5 pr-md-0 pr-lg-0">
    <div class="work-image col-12 col-sm-12 col-md-7 col-lg-8">
      <img src="{{ '/storage/images/arts/org/'.$work->image_path }}" style="max-width: 400px; max-height: 400px;">
    </div>
    <div class="page-title row text-left mt-1">
      <div class="col-auto">
        <h2><b>{{ $work->title }}</b></h2>  
      </div>
      <div class="col ml-auto align-center mt-1">
        <div class="row">
          <h4>
            by 
            <a href="/artist/{{ $work->artist_id }}"> {{ $work->artist->name }} </a>
          </h4>
        </div>  
      </div>
    </div>
    <div class="description-body row col-auto">
      <div class="price-etc col-5">
        <div class="price-info row">
          <h2>
          <span>${{ $work->asking_price }}</span>
          </h2>
        </div>
        <div class="row">
          <span><b>SIZE</b></span>
        </div>
        <div class="row">
          <span>{{ $work->size }}</span>
        </div>
        <div class="row">
          <span><b>TYPE</b></span>
        </div>
        <div class="row">
          <span>{{ $work->type }}</span>
        </div>
        <div class="row">
          <span><b>STYLE</b></span>
        </div>
        <div class="row">
          <span>{{ $work->style }}</span>
        </div>
        <div class="row">
          <span><b>MEDIUM</b></span>
        </div>
        <div class="row">
          <span>{{ $work->medium }}</span>
        </div>
      </div>
      <div class="description-content col-5">
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
  </div>
  <div class="enquirys col-6">
    <div class="operation row">
      <div class="col">
        <a href="#" class="btn btn-primary btn-lg" id="make-enquiry" data-toggle="modal" data-target="#makeEnquiryModal">
        @role('customer')  
          MAKE ENQUIRY
        @else
          SEND REPLY
        @endrole
        </a> 
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
                  {{-- <div class="form-row">                        
                    <div class="form-group col">
                      <input type="text" name="subject" class="enquiry-input form-control" id="subject" placeholder="Subject" required/>
                    </div>
                  </div> --}}
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
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
      <h4 class="border-bottom border-gray pb-2 mb-0">Your Enquiry Records</h4>
      @foreach ($enquirys as $enquiry)
        <div class="media text-muted pt-3">
          <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray
            @role('customer') @if ($enquiry->user_type === "customer") text-right @endif @endrole
            @role('saler') @if ($enquiry->user_type === "saler") text-right @endif @endrole">
            <span class="d-block ">
              @if ($enquiry->user_type === "customer")
                @role('customer')
                  <strong class="text-gray-dark">You</strong>
                @else
                  <strong class="text-gray-dark">{{$enquiry->user->name}}</strong>
                @endrole
              @else
                @role('customer')
                  <strong class="text-gray-dark">Saler:{{$enquiry->user->name}}</strong>
                @else
                  <strong class="text-gray-dark">You</strong>
                @endrole
              @endif
                <span class="small">{{ $enquiry->created_at->format('Y-m-d H:i')}} says:</span>

            </span> 
            {{ $enquiry->content}}
          </p>
        </div>
      @endforeach
    </div>
  </div>
</div>
<script>
  $('#submitEnquiry').click(function (event) {
    var form = $("#enquiryForm")[0];
    if(form.reportValidity()){
      console.log($(form).serialize())
      $.ajax({
        method: "POST",
        url: "{{"/enquiry/".$work->id."/".$user_id."/make"}}",
        data: $(form).serialize(),
        success: function (response) {
          if(response.msg === "success"){
            alert("Send Enquiry Success!!")
            location.reload();
          }
        }
      })
    }
  })
</script>
@endsection