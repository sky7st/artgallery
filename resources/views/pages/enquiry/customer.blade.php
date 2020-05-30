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
    <div class="my-3 p-3 bg-white rounded box-shadow">
      <h6 class="border-bottom border-gray pb-2 mb-0">Your Enquiry Records</h6>
      @foreach ($work->enquirys as $enquiry)
        <div class="media text-muted pt-3">
          <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray ">
            <span class="d-block">
              @if ($enquiry->user_type === "customer")
                <strong class="text-gray-dark">You</strong>
              @endif
              <span class="small">{{ $enquiry->created_at->format('Y-m-d H:i')}}</span>
            </span> 
            {{ $enquiry->content}}
          </p>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection