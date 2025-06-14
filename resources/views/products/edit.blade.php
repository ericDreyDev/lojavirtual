<form action="{{ url('products/update') }}" method="POST">
    @csrf
    <!-- campo oculto passando o ID como parâmetro no request -->
    <input type="hidden" name="id" value="{{ $product['id'] }}">
    <label>Nome:</label><br>
    <input name="name" type="text" value="{{ $product['name'] }}" /><br>
    <label>Descrição:</label><br>
    <input name="description" type="textarea" value="{{ $product['description'] }}"/><br>
    <label>Quantidade:</label><br>
    <input name="quantity" type="number" value="{{ $product['quantity'] }}"/><br>
    <label>Preço:</label><br>
    <input name="price" type="number" value="{{ $product['price'] }}"/><br>
    <label>Tipo:</label><br>
     <select name="type_id">
        @foreach($types as $type)
            <option value="{{ $type->id }}" {{ $product->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
    </select><br>
    <input type="submit" value="Salvar" />
</form>