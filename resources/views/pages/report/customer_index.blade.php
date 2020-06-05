@extends('layouts.app')
@section('content')
<div id="customer-list" class="table-responsive-xl mt-2">
  <table class="table table-bordered table-condensed table-striped table-hover" id="customer_list" data-toggle="table" data-strip="true" data-pagination="true">
    <thead class="col-auto">
        <tr>
          <th data-field="id">ID</th>
          <th data-field="name">Customer Name</th>
          <th data-field="address">Customer Address</th>
          <th data-field="phone">Phone</th>
          <th data-field="sale-ly">Amount Last Year</th>
          <th data-field="sale-ty">Amount This Year</th>
        </tr>
    </thead>
    @foreach ($customers as $customer)
      <tr class="table-row">
        <th id="customer_id">{{ $customer->id }}</th>
        <th>{{ $customer->name }}</th>
        <th>{{ $customer->address }}</th>
        <th>{{ $customer->phone }}</th>
        <th>${{ $customer->lastYearSum }}</th>
        <th>${{ $customer->thisYearSum }}</th>
      </tr>
    @endforeach     
  </table>
</div>
<div id="page-link" class="text-center justify-content">{{ $customers->links() }}</div>
<style>
  .table-row {
    cursor: pointer;
    overflow-y: auto;
  }
  .pagination{
    justify-content: center!important;
  }
</style>
@endsection