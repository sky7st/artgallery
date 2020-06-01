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
      @role('saler')
      @else
        <div class="want-buy row mt-4 text-left">
          <div class="col">
            <div class="row">
              @guest
                <label><b>WANT TO BUY?</b></label>
              @endguest
              @role('customer')
                <label><b>WANT TO BUY?</b></label>
              @endrole('customer')
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
                          @role('customer')
                            <input type="hidden" name="user" value="{{ $user_id }}">
                          @endrole
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
      @endrole
    @endcan
  </div>
</div>
@role('artist')
@can('isHimSelf', $work->artist->user, Auth::user())
  @php
      $trades = $work->enquiryPair()->with(['trade' => function($query){
        $query->whereNotNull('cust_confirmed');
      }])->get();
      $trades = $trades->filter(function($trade){
        return !is_null($trade->trade);
      });
  @endphp
  @if($work->state === 1)
    <div class="trade-title mt-2">
      <h2>All Trade Request For This Work</h2>
    </div>
    <div class="trade-list">
      {{-- {{ $trades }} --}}
      @if ($trades->isEmpty())
        <span>You have no trade request.</span> 
      @else
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Customer Name</th>
              <th scope="col">Saler Name</th>
              <th scope="col">Your Price</th>
              <th scope="col">Request Price</th>
              <th scope="col">Amount will receive</th>
              <th scope="col">Request Time</th>
              <th scope="col">Confirm/Reject</th>
            </tr>
          </thead>
            @foreach ($trades as $trade)
            <tr>
              @if(!is_null($trade->trade) && !is_null($trade->trade->cust_confirmed))
                <td>{{ $trade->customer->name }}</td>
                <td>{{ $trade->saler->name }}</td>
                <td>${{ $work->asking_price }}</td>
                <td>${{ $trade->trade->price }}</td>
                <td>${{ $trade->trade->price*0.9 }}</td>
                <td>{{ date_format(date_create($trade->trade->cust_confirmed_at), 'Y-m-d H:i') }}</td>
                <td><button class="confirmTradeBtn btn btn-primary" data-toggle="modal" data-target="#confirmTradeModal"
                  data-pair="{{ $trade->trade->enquiry_pair_id }}">Confirm/Reject</button></td>
              @endif
            </tr>
            @endforeach
        </table>
        <div id="confirmTradeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmTradeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content rounded-0">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="makeConfirm">
                <div id="confirm-text">
                  <span>Do you sure you want to ACCEPT/REJECT the trade?<span><br>
                  <span class="text-danger">*Trade will be done once you send ACCEPT!</span>
                </div>
                <form id="confirmTradeForm">
                  @csrf
                  <input type="hidden" name="pair" value="-1" id="pairIdInput"/>
                  <input type="hidden" name="confirm" value="-1" id="confirmInput"/>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="confirmBtn btn btn-success rounded-0" data-confirm="1">Accept</button>
                <button type="button" class="confirmBtn btn btn-danger rounded-0" data-confirm="2">Reject</button>
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
  @else
  <div class="trade-title mt-2">
    <div class="row">
      <h2 class="text-success mt-2">This work is sold!!</h2>
      <button class="btn btn-success btn-lg ml-2" id="view-receipt" data-toggle="modal" data-target="#viewReceiptModal">CHECK PAYMENT</button>
      
    </div>
    <div id="viewReceiptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewReceiptModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-0">
          <div class="modal-header">
            <h3 class='col-12 modal-title text-center'>
              PAYMENT
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </h3>
          </div>
          <div class="modal-body" id="viewReceipt">
            <span><h4>ART GALLERY</h4></span>
            <span><h5>Time: {{ date_format(date_create($work->soldTrade->artist_confirmed_at), 'Y-m-d H:i') }}</h5></span>
            <span><h5>Trade No: {{ $work->soldTrade->id }}</h5></span>
            <span><h5>Saler: {{ $work->soldTrade->enquiry_pair->saler->name }}</h5></span>
            <span><h5>Saler Phone: {{ $work->soldTrade->enquiry_pair->saler->phone }}</h5></span>
            <hr>
            <span><h4>DESCRIPTION</h4></span>
            <span><h5>Artist Name: {{ $work->artist->name }}</h5></span>
            <span><h5>Artist Address: {{ $work->artist->address }}</h5></span>
            <span><h5>Artist SSN: {{ $work->artist->user->ssn }}</h5></span>
            <span><h5>Title: {{ $work->title }}</h5></span>
            <span><h5>Type: {{ $work->type }}</h5></span>
            <span><h5>Medium: {{ $work->medium }}</h5></span>
            <span><h5>Style: {{ $work->style }}</h5></span>
            <span><h5>Size: {{ $work->size }}</h5></span>
            <span><h4><b>Selling Price: ${{ $work->soldTrade->price }}</b></h4></span>
            <span><h4><b>Amount Remitted: ${{ $work->soldTrade->price*0.9 }}</b></h4></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
@endcan
@endrole
<script>
@can('buy works')
  $('#submitEnquiry').click(function (event) {
    var form = $("#enquiryForm")[0];
    if(form.reportValidity()){
      console.log($(form).serialize())
      $.ajax({
        method: "POST",
        url: "/enquiry/" + "{{ $work->id }}" + "/" + "{{ auth()->user()->id }}" +  "/make",
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
@role('artist')
  @can('isHimSelf', $work->artist->user, Auth::user())
    $('#confirmTradeModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      var trade = button.data('pair') 
      $('#pairIdInput').val(trade)
    })
    $('.confirmBtn').click(function(event){
      var confirm = $(event.target).data('confirm')
      $('#confirmInput').val(confirm)
      var form = $('#confirmTradeForm')[0]
      $.ajax({
        method: "POST",
        url: "/trade/confirm",
        data: $(form).serialize(),
        success: function (response) {
          console.log(response)
          location.reload()
        }
      })
    })
  @endcan
@endrole
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