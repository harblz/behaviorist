@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="columns">
        <div class="column is-12">
            <h3 class="title is-3">All Clients</h3>
            <clients-table></clients-table>
        </div>
    </div>
</div>
@endsection
