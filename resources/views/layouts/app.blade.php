<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $company_setting->company_name ?? 'Pacific' }} - Travel Agency</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	@if(isset($company_setting) && $company_setting->favicon_path)
		<link rel="icon" href="{{ asset($company_setting->favicon_path) }}" type="image/x-icon">
	@endif
	@include('partials.styles')
</head>
<body>
	@include('partials.header')
	
	@yield('content')
	
	@include('partials.footer')
	
	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

	@include('partials.scripts')
</body>
</html>
