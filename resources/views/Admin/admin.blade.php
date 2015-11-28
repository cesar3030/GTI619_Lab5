@extends('app')

@section('content')
<div class="container">
  <h1 class="text-title">{{ $title }}</h1>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">General parameters</div>
        <div class="panel-body">
          You are in the admin page
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Users management</div>
        <div class="panel-body">
          You are in the admin page
        </div>
      </div>
    </div>
  </div>
</div>
@endsection