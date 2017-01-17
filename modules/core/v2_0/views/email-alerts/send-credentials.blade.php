Dear {{$data['name']}},<br/>

Your credentials for "{{Setting::value('app-name')}}"  are following:<br/>

<table>
    <tr><th>Login URL:</th><td>{{URL::to("/");}}</td></tr>
    <tr><th>Username:</th><td>{{$data['email']}}</td></tr>
    <tr><th>Password:</th><td>{{$data['password']}}</td></tr>
</table>
