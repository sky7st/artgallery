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
      <span>asking price: ${{ $work->asking_price }}</span>
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
    <div class="want-buy row mt-4 text-left">
      <div class="col">
        <div class="row">
          <label><b>WANT TO BUY?</b></label>
        </div>
        <div class="row">
          @guest
            <a href="/login" class="btn btn-danger btn-lg">LOGIN TO MAKE EQUIRY</a>   
          @endguest
          @auth
            @can('buy works')
            <a href="#" class="btn btn-primary btn-lg" id="make-equiry">MAKE EQUIRY</a> 
            @endcan
          @endauth
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  #summary {
    font-size: 14px;
    line-height: 1.5;
  }

  #summary p.collapse:not(.show) {
      height: 20px !important;
      overflow: hidden;
    
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;  
  }

  #summary p.collapsing {
      min-height: 20px !important;
  }

  #summary a.collapsed:after  {
      content: 'Read More';
  }

  #summary a:not(.collapsed):after {
      content: 'Read Less';
  }
  .collapsed {
    color: inherit;
  }
  .collapsed:hover {
    color: inherit;
  }
</style>
@endsection