@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>
        <div class="panel-body">
          <h3>You are in the circle page</h3>
          <div class="circle"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
