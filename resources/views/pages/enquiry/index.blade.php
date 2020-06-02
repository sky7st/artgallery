@extends('layouts.app')
@section('content')
@role('customer')
<div class="enquiry-title mt-2">
  <h2>Your Enquiries</h2>
</div>
<div class="enquiry-list">

  @if($enquirys->isEmpty())
    <span>You have no enquiry.</span>
  @else
    @foreach ($enquirys as $enquiry)
    {{-- {{ $enquiry }} --}}
    <table class="table mt-4">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Work Title</th>
          <th scope="col">Artist</th>
          <th scope="col">Artist Asking Price</th>
          {{-- <th scope="col">Last Enquiry Subject</th> --}}
          <th scope="col">Last Enquiry Time</th>
          <th scope="col">Last Saler Reply Time</th>
          <th scope="col">Work Status</th>
          <th scope="col">View Detail</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $enquiry->work->title }}</td>
          <td>{{ $enquiry->work->artist->name}}</td>
          <td>${{ $enquiry->work->asking_price}}</td>
          {{-- <td>{{ $enquiry->subject }}</td> --}}
          <td>{{ date_format(date_create($enquiry->cust_last_time), 'Y-m-d H:i') }}</td>
          <td>
            @if(is_null($enquiry->saler_last_time))
              Not replyed
            @else
              {{ date_format(date_create($enquiry->saler_last_time), 'Y-m-d H:i') }}
            @endif
          </td>
          <td>
            @if($enquiry->work->state === 2)
              @if ($enquiry->work->soldTrade->enquiry_pair->customer_id == $enquiry->customer_id)
                <b><span class="text-success">BOUGHT</span></b>
              @else
              <b><span class="text-danger">IS BOUGHT BY OTHER</span></b>
              @endif
            @else
            <b><span class="text-danger">UNSOLD</span></b>
            @endif
          </td>

        <td><button class="viewEnquiryBtn btn btn-primary" data-work="{{ $enquiry->work->id }}" data-user="{{  $enquiry->customer_id }}">View</button></td>
        </tr>
      </tbody>
    </table>
    {{-- {{ $enquiry }} --}}
    @endforeach
  @endif 
</div>  
@endrole
@role('saler|admin')
<div class="enquiry-title mt-2">
  <h2>All Unsold Work</h2>
</div>
<div class="enquiry-list">
  @if($unsold_works->isEmpty())
    <span>There are no unsold work now.</span>
  @else
  @foreach ($unsold_works as $unsold_work)
  {{-- {{ $unsold_work->enquiryPair }} --}}
  <div class="card mt-2">
    <div class="card-header">
      <div class="col">
        <div class="row">
          <div class="title-artist col-2">
            <div class="title row">
              <span><h4>{{ $unsold_work->title }}</h4></span>
            </div>
            <div class="artist row">
              by {{ $unsold_work->artist->name }}
            </div>
          </div>
          <div class="price col-2 mt-3">
            <span><h4>${{ $unsold_work->asking_price }}</h4></span>
          </div>
          <div class="state col-2 mt-3">
            @if ($unsold_work->state === 1)
              <span><h4 class="text-danger">Unsold</h4></span>   
            @else
            <span><h4 class="text-danger">Negotiating</h4></span> 
            @endif
          </div>
          <div class="count col-5 mt-2">
            <div class="count row">
              <div class="count col-auto"><h1>{{ count($unsold_work->enquiryPair) }}</h1></div>
              <div class="count-text col-auto mr-auto mt-2"><h4>&nbsp;Undone Customers' Enquiries</h4></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ul class="list-group list-group-flush">
      @if($unsold_work->enquirys->isEmpty())
        <li class="list-group-item">No Enquiry</li>
      @else 
        @if ($unsold_work->state === 1)
          @foreach ($unsold_work->enquiryPair as $enquiry)
          <li class="list-group-item"> 
            <div class="col">
              <div class="row">
                <div class="title-artist col-2">
                  <div class="name-label row">
                    <span>Customer Name:</span>
                  </div>
                  <div class="name row">
                    <span><h5><b>{{ $enquiry->customer->name }}</b> </h5></span>
                  </div>
                </div>
                {{-- <div class="subject col-3">
                  <div class="last-subject-label row">
                    <span>Last Enquiry Subject:</span>
                  </div>
                  <div class="last-subject row">
                    <span><h5><b>{{ $enquiry->subject }}</b> </h5></span>
                  </div>
                </div> --}}
                <div class="date col-2">
                  <div class="last-time-label row">
                    <span>Last Enquiry Time:</span>
                  </div>
                  <div class="lat-time-label row">
                    <span><h5><b>{{ $enquiry->created_at->format('Y-m-d H:i') }}</b> </h5></span>
                  </div>
                </div>
                <div class="enquiry-btn col-2">
                  <div class="enquiry-btn row mt-2">
                  <button class="viewEnquiryBtn btn btn-primary" data-work="{{ $enquiry->work_id}}" data-user="{{ $enquiry->customer_id}}">View Enquiry Detail</button>
                  </div>
                </div>
                @if($enquiry->saler_id === auth()->user()->id)
                <div class="contact-person col mt-2">
                  <span class="text-danger"><h3>You are the contact person!</h3></span>
                </div>
                @endif
              </div>
            </div>
          </li>
          @endforeach
        @else
          <li class="list-group-item"> 
            <span class="text-danger">This work is in negotiation</span>   
          </li>
        @endif
      @endif  
    </ul>
  </div>
  @endforeach
  @endif 
</div> 
<div id="page-link" class="text-center mt-2">{{ $unsold_works->links() }}</div>
@endrole
<script>
  $(document).ready(function () {
    $(".viewEnquiryBtn").click(function (event) {
      var work_id = $(this).data('work')
      var user = $(this).data('user')
      location.href = "/enquiry/"+ work_id + "/" + user;
    })
  })
</script>
@endsection

