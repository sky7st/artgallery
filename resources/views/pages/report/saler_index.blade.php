@extends('layouts.app')
@section('content')
<form id="searchForm">
@csrf
<div class="form-row">
  <div class="col-3">
    <label for="saler-select">Select Saler</label>
    <select name="saler" class="form-control" id="saler-select" aria-required="true">
      <option value="-1">All Salers</option>
      @foreach ($salers as $saler)
      <option value="{{ $saler->id }}">{{ $saler->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-3">
    <label for="startTime">Select Start Date</label>
    <input type="date" name="start" id="startTime" class="form-control" required>
  </div>
  <div class="col-3">
    <label for="endTime">Select End Date</label>
    <input type="date" name="end" id="endTime" class="form-control" required>
  </div>
  <div class="col-1 my-4">
    <button class="btn btn-primary rounded-0" id="searchBtn">Search</button>
  </div>
  <div class="col my-4">
    <button class="btn btn-success rounded-0" id="searchAllBtn" type="button">Search With Out Date</button>
  </div>
</div>
</form>
<div class="card mt-2" style="display:none" id="saler-card">
  <div class="card-header">
    <div class="col">
      <div class="row">
        <div class="col-6">
          <h2><span id="saler-name"></span></h2>
        </div>
        <div class="col-6 text-right">
          <h2><span id="saler-total" class="text-danger"></span></h2> 
        </div>
      </div>
    </div>
  </div>
  <ul class="list-group list-group-flush" id="work-list">
    
  </ul>
  <li class="list-group-item" id="work-li" style="display: none"> 
    <div class="row">
      <div class="title-work col-3">
        <div class="title-label row">
          <span>Title:</span>
        </div>
        <div class="title row">
          <span><h5 id="title"></h5></span>
        </div>
      </div>
      <div class="artist-work col-2">
        <div class="artist-label row">
          <span>Artist:</span>
        </div>
        <div class="artist row">
          <span><h5 id="artist"></h5></span>
        </div>
        <div class="customer-label row">
          <span>Customer:</span>
        </div>
        <div class="customer row">
          <span><h5 id="customer"></h5></span>
        </div>
      </div>
      <div class="col">
        <div class="row">
          <div class="col-3">
            <div class="ask-price-label">
              <span>Asking Price:</span>
            </div>
          </div>
          <div class="col-3">
            <div class="ask-price-label">
              <span>Sold Price:</span>
            </div>
          </div>
          <div class="time-work col-3">
            <div class="time-label">
              <span>Sold Time:</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="ask-price-label">
              <span><h5 id="ask-price"></h5></span>
            </div>
          </div>
          <div class="col-3">
            <div class="ask-price-label">
              <span><h5 id="sold-price"></h5></span>
            </div>
          </div>
          <div class="time-work col-4">
            <div class="time-label">
              <span><h5 id="time"></h5></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="address-label">
              <span>Customer Address:</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="address-artist">
              <span><h5 id="address"></h5></span>
            </div>
          </div>
        </div>
      </div>
    </div> 
  </li> 
</div>
<div id="saler-list"></div>

<script>
  $('#searchBtn').click(function (e) {
    e.preventDefault();
    var form = $('#searchForm')[0]
    if(form.reportValidity()){
      $.ajax({
      method: "POST",
      url: "/report/saler",
      data: $(form).serialize(),
      success: function (response) {
        if(response.msg === "success"){
          var salers = response.data.salers
          // console.log(salers)
          renderSalers(salers)
        }
      }
    })  
    }
  })
  $('#searchAllBtn').click(function (e) {
    var saler = $('#saler-select').val()
    console.log(saler)
    var data = {
      "id": saler
    }
    $.ajax({
      method: "GET",
      url: "/report/saler/"+saler,
      success: function (response) {
        if(response.msg === "success"){
          var salers = response.data.salers
          console.log(salers)
          renderSalers(salers)
        }
      }
    })  
  })
  function renderSalers(salers) {
    $('#saler-list').html('')
    salers.forEach( saler => {
      console.log(saler)
      var salerCard = $('#saler-card').clone()
      salerCard.find('#saler-name').text(saler.name)
      var total = ""
      if (saler.totalSum)
        total = "$" + saler.totalSum 
      else if(saler.betweenSum)
        total = "$" + saler.betweenSum 
      else
        total = "$0"
      
      salerCard.find('#saler-total').text(total)
      salerCard.show()
      $('#saler-list').append(salerCard)

      var saleWorks = saler.all_sold_trade ? saler.all_sold_trade : saler.sold_trade_between
      var workList = salerCard.find('#work-list')
      var work = salerCard.find('#work-li')
      workList.html('')
      if(saleWorks.length === 0)
        workList.html('<li class="list-group-item">No Sold Work</li>')
      else{
        saleWorks.forEach(item => {
          var workItem = work.clone()
          // console.log(item)
          var title = '<a href="/enquiry/' + item.enquiry_pair.work.id + "/" + item.enquiry_pair.customer_id + '">' + item.enquiry_pair.work.title + '</a>'
          workItem.find('#title').html(title)
          var artist = '<a href="/artist/' + item.enquiry_pair.work.artist.id + '">' + item.enquiry_pair.work.artist.name + '</a>'
          workItem.find('#artist').html(artist)
          workItem.find('#ask-price').text("$"+item.enquiry_pair.work.asking_price)
          workItem.find('#sold-price').text("$"+item.price)
          workItem.find('#time').text(item.artist_confirmed_at)
          workItem.find('#customer').text(item.enquiry_pair.customer.name)
          workItem.find('#address').text(item.enquiry_pair.customer.address)
          workItem.show()
          workList.append(workItem)
        })
      }
    })
  }
</script>
@endsection