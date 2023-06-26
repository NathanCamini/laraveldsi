    <h1>Editar Documento</h1>

    <form action="{{ route('documents.update', ['id' => $document->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="name" id="name" value="{{ $document->name }}" required>
        </div>

        <div>
            <label for="caminho">Caminho:</label>
            <input type="text" name="path" id="path" value="{{ $document->path }}" required>
        </div>

        <div>
            <label for="tamanho">Tamanho:</label>
            <input type="number" name="size" id="size" value="{{ $document->size }}" required>
        </div>

        <!-- outros campos do documento -->

        <button type="submit">Atualizar</button>
    </form>

    <form action="{{ route('documents.destroy', $document->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este documento?')">Excluir</button>
    </form>