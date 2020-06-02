@extends('layouts.app')
@section('content')
@php
  $work = $enquiryPair->work;
  $enquirys = $enquiryPair->enquirys;
@endphp
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
        <div class="work-state row mt-4 text-center">
          @if($work->state === 1)
            <div class="col bg-danger">
              <span><h1 class="text-white mt-2">UNSOLD</h1></span>
            </div>
          @else
            @if ($work->soldTrade->enquiry_pair->customer_id == auth()->user()->id)
              <div class="col bg-success">
                <span><h3 class="text-white mt-2">BOUGHT</h3></span>
              </div>
            @else
              <div class="col bg-danger">
                <span><h3 class="text-white mt-2">SOLD</h3></span>
              </div> 
            @endif
          @endif
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
        @role('customer')
          @if ($work->state===2)
            <button class="btn btn-success btn-lg ml-2" id="view-receipt" data-toggle="modal" data-target="#viewReceiptModal">VIEW RECEIPT</button>
            <div id="viewReceiptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewReceiptModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content rounded-0">
                  <div class="modal-header">
                    <h3 class='col-12 modal-title text-center'>
                      CHECK
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
                    <span><h5>Buyer Name: {{ $work->soldTrade->enquiry_pair->customer->name }}</h5></span>
                    <span><h5>Buyer Address: {{ $work->soldTrade->enquiry_pair->customer->address }}</h5></span>
                    <span><h5>Work Title: {{ $work->title }}</h5></span>
                    <span><h5>Work Type: {{ $work->type }}</h5></span>
                    <span><h5>Work Medium: {{ $work->medium }}</h5></span>
                    <span><h5>Work Style: {{ $work->style }}</h5></span>
                    <span><h5>Work Size: {{ $work->size }}</h5></span>
                    <span><h4><b>Work Price: ${{ $work->soldTrade->price }}</b></h4></span>
                  </div>
                </div>
              </div>
            </div>
          @endif
        @endrole
        @role('saler|admin')
          @if ($work->state === 2)
            <button class="btn btn-danger btn-lg ml-2">IS SOLD</button>
          @else
            @if(is_null($enquiryPair->trade))
            <button class="btn btn-success btn-lg ml-2" id="send-trade" data-toggle="modal" data-target="#sendTradeModal">SEND TRADE</button>
            <div id="sendTradeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="sendTradeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content rounded-0">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="makeTrade">
                    <form method="post" id="tradeForm">
                      @csrf
                    <input type="hidden" name="pair_id" value="{{$enquiryPair->id}}">
                      <label for="price">PRICE</label>
                      <input type="number" name="price" value="" class="form-control col-6" required/>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="submitTrade" class="btn btn-primary mr-auto rounded-0">Submit</button>
                  </div>
                </div>
              </div>
            </div>
            @else
              @if (is_null($enquiryPair->trade->cust_confirmed))
                <button class="btn btn-secondary btn-lg ml-2" disabled>WAITING FOR CUSTOMER'S COMFIRM</button>
              @else
                @if(!$enquiryPair->trade->artist_confirmed)
                  <button class="btn btn-secondary btn-lg ml-2" disabled>WAITING FOR ARTIST'S COMFIRM</button>
                @else
                  <button class="btn btn-success btn-lg ml-2" disabled>TRADE SUCCESS</button>
                @endif
              @endif
            @endif 
          @endif
        @endrole
        @role('customer')
          @if(!is_null($enquiryPair->trade) && $work->state === 1)
            @if(is_null($enquiryPair->trade->cust_confirmed))
              <button class="confirmTrade btn btn-success btn-lg ml-2" data-toggle="modal" data-target="#confirmTradeModal" data-confirm="1" data-pair="{{$enquiryPair->id}}">ACCEPT TRADE</button>
              <button class="confirmTrade btn btn-danger btn-lg ml-2" data-toggle="modal" data-target="#confirmTradeModal" data-confirm="2" data-pair="{{$enquiryPair->id}}">REJECT TRADE</button>
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

                      </div>
                      <form id="confirmTradeForm">
                        @csrf
                        <input type="hidden" name="pair" value="-1" id="tradeInputPair"/>
                        <input type="hidden" name="confirm" value="-1" id="tradeInputConfirm">
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="submitTrade" class="btn btn-success rounded-0">Accept</button>
                      <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
              @else
              @if($enquiryPair->trade->cust_confirmed === 1)
                <button class="btn btn-secondary btn-lg ml-2" disabled>TRADE ACCEPTED</button>
              @else
                <button class="btn btn-secondary btn-lg ml-2" disabled>TRADE REJECTED</button>
              @endif
            @endif
          @endif
        @endrole
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
            @role('saler|admin') @if ($enquiry->user_type === "saler" || $enquiry->user_type === "admin") text-right @endif @endrole">
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
  @role('saler|admin')
    $('#submitTrade').click(function (e) {
      var form = $('#tradeForm')[0];
      if(form.reportValidity()){
      console.log($(form).serialize())
      $.ajax({
        method: "POST",
        url: "/trade/make",
        data: $(form).serialize(),
        success: function (response) {
          console.log(response)
          if(response.msg === "success"){

            alert("Send Trade Success!!")
            location.reload();
          }
        }
      })
    }
  })
  @endrole
  @role('customer')
    $('#confirmTradeModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      var confirm = button.data('confirm') 
      var pair_id = button.data('pair')
      var modal = $(this)
      var check = confirm === 1 ? "ACCEPT" : "REJECT"
      var html = "Do you sure you want to <b>" + check + "</b> the trade?"
      $('#tradeInputPair').val(pair_id)
      $('#tradeInputConfirm').val(confirm)
      modal.find('#confirm-text').html(html)
      if(confirm === 1){
        $('#submitTrade').attr('class', 'btn btn-success rounded-0')
        $('#submitTrade').text('Accept')
      }else{
        $('#submitTrade').attr('class', 'btn btn-danger rounded-0')
        $('#submitTrade').text('Reject')
      }
    })
    $('#submitTrade').click(function (e) {
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
  @endrole
</script>
<style>
  .modal-header {
    border-bottom: 0 none;
  }

  .modal-footer {
    border-top: 0 none;
  }
</style>
@endsection