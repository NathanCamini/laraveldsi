<x-app-layout>
    <!-- Exibição dos documentos -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Documentos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                </div>
            </div>
            @if ($documents->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nome do Documento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr>
                        <td>{{ $document->name }}</td>
                        <td>
                            <a href="{{ route('documents.edit', $document->id) }}">Editar</a>
                            <form action="{{ route('documents.destroy', $document->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este documento?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Nenhum documento encontrado.</p>
            @endif

            <!-- Formulário de upload de documentos -->
            <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="arquivo">Selecione um arquivo:</label>
                <input type="file" name="arquivo" id="arquivo" required accept=".pdf,.doc,.docx">
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>



</x-app-layout>