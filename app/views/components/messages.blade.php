@if (isset($errors) && count($errors) > 0)

	@foreach ($errors as $error)
	    		<div class="alert alert-error">
	    			<h3>{{ $error['title'] }}</h3>
	    			<p>
	    				{{ $error['details'] }}
	    			</p>
	    		</div>
	@endforeach

@endif


@if (isset($alerts) && count($alerts) > 0)

	@foreach ($alerts as $alert)
	    		<div class="alert">
	    			<h3>{{ $alert['title'] }}</h3>
	    			<p>
	    				{{ $alert['details'] }}
	    			</p>
	    		</div>
	@endforeach

@endif
