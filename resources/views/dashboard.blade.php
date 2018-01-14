@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="columns">
        <div class="column is-5">
            <div id="newsItems" class="container">
                <div class="notification is-primary">
                  <button class="delete"></button>
                  Primar lorem ipsum dolor sit amet, consectetur
                  adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
                  consectetur adipiscing elit
                </div>
            </div>
        </div>
    </div>
	<div class="columns">
    	<div class="column is-7">
    		<h3 class="title is-3">Today's Appointments</h3>
    		<appointments-list></appointments-list>
    	</div>
        <div class="column is-7">

        </div>
    </div>
</div>
@endsection
