@if (Session::get('message'))
    <div style="color:lime">
        <p>Form submited successfully <br>
        {{ Session::get('message') }} </p>
    </div>
@elseif ($errors->any())
    <div style="color:crimson">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif