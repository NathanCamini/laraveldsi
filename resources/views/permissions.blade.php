<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Documento
        </h2>
    </x-slot>

    <form action="{{ route('documents.update', ['id' => $document->id]) }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">

                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Edição de documentos
                            </h2>
                        </header>

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nome')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $document->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="path" :value="__('Caminho')" />
                            <x-text-input readonly id="path" name="path" type="text" class="mt-1 block w-full opacity-75 bg-gray-400" :value="old('path', $document->path)" required autofocus autocomplete="path" />
                            <x-input-error class="mt-2" :messages="$errors->get('path')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="size" :value="__('Tamanho')" />
                            <x-text-input readonly id="size" name="size" type="text" class="mt-1 block w-full opacity-75 bg-gray-400" :value="old('size', $document->size)" required autofocus autocomplete="size" />
                            <x-input-error class="mt-2" :messages="$errors->get('size')" />
                        </div>
                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button type="submit">Atualizar</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</x-app-layout>