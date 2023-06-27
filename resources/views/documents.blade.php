<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Documentos
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('documents.index') }}" method="GET">
                        <div>
                            <div>
                                <x-input-label for="name">Nome do arquivo:</x-input-label>
                                <x-text-input class="mt-1 block w-full" type="text" name="name" id="name" value="{{ request('name') }}" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="created_at">Data de criação:</x-input-label>
                                <x-text-input class="mt-1 block w-full" type="date" name="created_at" id="created_at" value="{{ request('created_at') }}" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="id_user">Usúario Criador:</x-input-label>
                                <select name="id_user" id="id_user" class="mt-1 block w-full">
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <x-primary-button type="submit">Pesquisar</x-primary-button>
                            </div>
                        </div>
                    </form>

                    <table class="min-w-full border-collapse block md:table mt-4">
                        @if ($documents->count() > 0)
                        <thead class="block md:table-header-group">
                            <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Nome do Documento</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Criação</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Última edição</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Criador</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Editar</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Excluir</th>
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Download</th>
                                @foreach ($documents as $document)

                                @foreach ($users as $user)
                                @if($user->id === $document->id_user && $userAtual === $user->id)
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Permissões</th>
                                @endif
                                @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                            @foreach ($documents as $document)
                            <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">{{ $document->name }}</td>
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">{{ date( 'd/m/Y' , strtotime($document->created_at))}}</td>
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">{{ date( 'd/m/Y H:i:s' , strtotime($document->updated_at))}}</td>
                                @foreach ($users as $user)
                                @if($user->id === $document->id_user)
                                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">{{ $user->name }}</td>
                                @endif
                                @endforeach

                                <td class="p-2 md:border md:border-grey-500 text-left md:table-cell flex flex-row">
                                    <a href="{{ route('documents.edit', $document->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                        Editar
                                    </a>
                                </td>
                                <td>
                                    <form class="pl-2" action="{{ route('documents.destroy', $document->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded" type="submit" onclick="return confirm('Tem certeza que deseja excluir este documento?')">Excluir</button>
                                    </form>
                                </td>
                                <td class="p-2 md:border md:border-grey-500 text-left md:table-cell flex flex-row">
                                    <a href="{{ route('documents.download', $document->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 border border-green-500 rounded">
                                        Download
                                    </a>
                                </td>
                                @foreach ($users as $user)
                                @if($user->id === $document->id_user && $userAtual === $user->id)
                                <td class="p-2 md:border md:border-grey-500 text-left md:table-cell flex flex-row">
                                    <a href="{{ route('permission.edit', $document->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                                        Editar Permissões(futuro)
                                    </a>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <thead class="block md:table-header-group mt-4">
                            <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Nome do Documento</th>
                            </tr>
                        </thead>
                        <tbody class="block md:table-row-group">
                            <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                                <td>Nenhum documento encontrado.</td>
                            </tr>
                        </tbody>

                        @endif
                    </table>

                    <!-- Formulário de upload de documentos -->
                    <form class="mt-4" action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block mb-2 text-md font-medium text-gray-900" for="arquivo">Selecione um arquivo:</label>
                        <input class="p-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="arquivo" id="arquivo" required accept=".pdf,.doc,.docx">
                        <p class="mt-1 text-sm"> ACEITO PDF, DOC OU DOCX</p>
                        <x-primary-button type="submit">Enviar arquivo</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>