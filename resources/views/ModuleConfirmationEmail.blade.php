<html>
<body>
<h1>Dear : {{$name}}</h1>
<p>Your Submission request for {{$moduleName}} is submitted, just click on this  <a href="{{url("/verify-modules/{$moduleURLName}/{$model->id}")}}">LINK</a> to verify</p>
</body>
</html>
