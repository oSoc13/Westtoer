@extends('layouts.master')

@section('content')

	<div class="well">
		<p>
			<ul>
				<li><a href="{{ URL::to('/ui') }}">Dashboard</a></li>
				<li><a href="{{ URL::to('/api') }}">API</a></li>
			</ul>
		</p>
	</div>
@stop