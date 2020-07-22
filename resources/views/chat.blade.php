<!DOCTYPE html>
<html>
<head>
	<title>Chat App</title>
	<link rel="stylesheet" type="text/css" href="{{asset('js/jquery.min.js')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('js/Scrollbar.min.js')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/Scrollbar.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
	<meta name="csrf-token"content="{{csrf_token()}}">
	<style>
		 
	</style>
</head>
<body>
	<div id="app">
		@include('logout')
		<br>	
		<chathome :authuser="{{auth()->user()}}" :currentuserid="{{Auth()->user()->id}}"></chathome>
	</div>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>