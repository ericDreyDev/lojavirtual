<form action="{{ url('types/update') }}" method="POST">
    @csrf
    <!-- campo oculto passando o ID como parâmetro no request -->
    <input type="hidden" name="id" value="{{ $type['id'] }}">
    <label>Nome:</label><br>
    <input name="name" type="text" value="{{ $type['name'] }}" /><br>
   
    <input type="submit" value="Salvar" />
</form>