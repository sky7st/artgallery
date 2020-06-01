@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-12">
    <h2>All Unsold Works</h2>
  </div>
</div>
<div class="row">
  <div class="col-12 mt-2 pl-0 pr-0 text-center" id="product_list">
    <ul class="d-flex flex-wrap list-group-horizontal">
      @foreach ($works as $index=>$work)
        <li class="list-group-item justify-content-left align-items-center mr-3 mt-2">
        {{-- @can('delete work')
            @can('isHimSelf', $artist->user, Auth::user())
            <button type="button" id="deleteWorkBtn" class="delete-work close align-items-right mb-1">
            <span aria-hidden="true" data-work="{{ $work->id }}" data-title="{{ $work->title }}">&times;</span>
            </button>
            @endcan
        @endcan --}}
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
          <div class="artist">
            <span>
              by
              <a href="/artist/{{ $work->artist_id }}"> {{ $work->artist->name }} </a>
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
@endsection