<style>
    body {
        font-size: 24px;
        padding: 2%;
    }
</style>
@if($errors->any())
    @foreach($errors->all() as $error)
        # {{ $error }}
        <hr/>
    @endforeach

@endif
<h4>Would you like to reinstall this application? <a href="{{URL::route('setup')}}">Click Here</a></h4>
<hr/>
