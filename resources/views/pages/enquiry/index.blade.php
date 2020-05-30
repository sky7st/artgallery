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
    <table class="table mt-4">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Work Title</th>
          <th scope="col">Artist</th>
          <th scope="col">Artist Asking Price</th>
          <th scope="col">Last Enquiry Subject</th>
          <th scope="col">Last Enquiry Time</th>
          <th scope="col">View Detail</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>{{ $enquiry->work->title }}</th>
          <td>{{ $enquiry->work->artist->name}}</td>
          <td>${{ $enquiry->work->asking_price}}</td>
          <td>{{ $enquiry->subject }}</td>
          <td>{{ $enquiry->created_at }}</td>
        <td><button class="viewEnquiryBtn btn btn-primary" data-work="{{ $enquiry->work->id }}" data-user="{{  $enquiry->user_id }}">View</button></td>
        </tr>
      </tbody>
    </table>
    {{-- {{ $enquiry }} --}}
    @endforeach
  @endif 
</div>  
<script>
  $(document).ready(function () {
    $(".viewEnquiryBtn").click(function (event) {
      var work_id = $(this).data('work')
      var user = $(this).data('user')
      location.href = "/enquiry/"+ work_id + "/" + user;
    })
  })
</script> 
@endrole
@endsection
