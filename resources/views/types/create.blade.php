<form action="{{ url('types/new') }}" method="POST">
    @csrf
    <label>Nome:</label><br>
    <input name="name" type="text" /><br>
   
    <input type="submit" value="Salvar" />

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</form>
