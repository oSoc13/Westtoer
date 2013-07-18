@extends('layouts.master')

@section('content')
	<div class="well">
		<h2>Westtoer API</h2>
		<ul>
			<li>
				<a href="{{{ URL::to('/api/event/') }}}">/api/event/{screen_id}</a><br>
				Aggregated list of events and attractions based on screen.
				<ul>
					<li><strong>screen_id</strong>: Identification of the screen (optional: if no screen_id, shows all events and attractions)</li>
				</ul>
			</li>
			<li>
				<a href="{{{ URL::to('/api/weather/1') }}}">/api/weather/{screen_id}</a><br>
				Weatherinfo for events set in screen.
				<ul>
					<li><strong>screen_id</strong>: Identification of the screen (required)</li>
				</ul>
			</li>
		</ul>
	</div>
@stop