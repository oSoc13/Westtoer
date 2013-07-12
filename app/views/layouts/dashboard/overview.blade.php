@extends('layouts.master')

@section('content')

	<div class="row-fluid">
		<div class="span6">
			@yield('newscreen')
		</div>
		<div class="span6">
			@yield('screens')
		</div>
	</div>
@stop