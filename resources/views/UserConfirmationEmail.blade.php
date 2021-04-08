<html>
<body>
<h2>Dear : {{$name}}</h2>
<p>Your Submission request for Backend User is submitted, just click on this  <a href="{{url("/admin/user-verify/?id={$model->id}")}}">LINK</a> to verify</p>
</body>
</html>
