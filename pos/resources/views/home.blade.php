@extends('layouts.dashboard')

@section('content')
@can('View Dashboard')
@php
  $branches= array();
  $branchcount = array();
  for($i=0; $i<count($topbranch); $i++){
    array_push($branches,$topbranch[$i]['branch']);
    array_push($branchcount,$topbranch[$i]['numbers']);
  }
@endphp
<div class="card" style="padding:15px">
    <div class="row">
      <div class="col-md-3" style="padding:15px">
        <div class="card" style="background-color: #5F7A61; padding:15px; color:white">
          <center>
            <strong>
            <h3>{{ count($sales) }}</h3>
            <i class="mdi mdi-shopping"></i>
            <small>Total Sale Records</small>
          </strong></center>
        </div>
        
      </div>
      <div class="col-md-3" style="padding:15px">
      <div class="card" style="background-color: #6F4C5B; padding:15px; color:white">
          <center>
            <strong>
            <h3>{{ count($categories) }}</h3>
            <i class="mdi mdi-yelp"></i>
            <small>Categories</small>
          </strong></center>
        </div>
      </div>
      <div class="col-md-3" style="padding:15px">
      <div class="card" style="background-color: #345B63; padding:15px; color:white">
          <center>
            <strong>
            <h3>{{ count($users) }}</h3>
            <i class="mdi mdi-account-settings"></i>
            <small>Users</small>
          </strong></center>
        </div>
      </div>
      <div class="col-md-3" style="padding:15px">
      <div class="card" style="background-color: #293B5F; padding:15px; color:white">
          <center>
            <strong>
            <h3>{{ count($branch) }}</h3>
            <i class="mdi mdi-source-branch"></i>
            <small>Branches</small>
          </strong></center>
        </div>
      </div>
    </div>
    <div class="row" style="padding:15px">
        <div class="col-md-6" style="">
        <canvas id="category" style="width:100%"></canvas>
        </div>
        <div class="col-md-6">
        <canvas id="sales" style="width:80%"></canvas>
        </div>
    </div>
    <div class="">
      <div class="row" style="padding:15px">
        <div class="col-md-12 card">
          <br>
          <table class="table table-bordered table-hover">
            <tr style="background-color: #E5DCC3">
              <th>Name</th>
              <th>Email</th>
              <th>Branch</th>
              <th>Department</th>
              <th>Contact No</th>
            </tr>
            @foreach($newUser as $n)
            <tr>
              <td> {{ $n->name }}</td>
              <td> {{ $n->email }}</td>
              <td> {{ $n->branch }}</td>
              <td> {{ $n->department }}</td>
              <td> {{ $n->contact_no }}</td>
            </tr>
            @endforeach
            
          </table>
          <br>
        </div>
        <div class="col-md-4">
          
        </div>
        <div class="col-md-4">
          
        </div>
      </div>
    </div>
</div>

<script>
var xValues = <?php echo json_encode($branches); ?>;
var yValues = <?php echo json_encode($branchcount); ?>;
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("sales", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Statistic based on sale Records"
    }
  }
});
var categortyX = ["Highest Record", "Average Record", "Lowest Record",];
var categoryY = [<?php echo json_encode($highestincome); ?>,<?php echo json_encode($averageincome); ?>,<?php echo json_encode($lowestincome); ?>];
var barColors = ["#172774","#AB6D23","#51050F"];

new Chart("category", {
  type: "bar",
  data: {
    labels: categortyX,
    datasets: [{
      backgroundColor: barColors,
      data: categoryY
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Sale Records"
    }
  }
});
</script>
@endcan
@endsection
