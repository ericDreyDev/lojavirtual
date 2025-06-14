<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tipos</title>
</head>
<body>
    <a href="{{ url('/') }}">Voltar</a> <a href="{{ url('/types/new') }}">Adicionar</a>
    <h3> Lista de tipos</h3> 
    
    
    @if (session('status'))
        <p>{{ session('status') }} </p>
    @endif   

     @if ($message = Session::get('error'))
        <p>{{ $message }} </p>
    @endif  
    
    <ul>
        @foreach($types as $type)
            <li> {{ $type['name'] }} 
                <a href="{{ url('/types/update', ['id' => $type->id]) }}">Editar</a>
                <a href="{{ url('/types/delete', ['id' => $type->id]) }}">Excluir</a>
            </li>
        @endforeach
    </ul>
    
</body>
</html>