<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{

    public function index()
    {
        $documents = Documents::all();
        return view('documents', compact('documents'));
    }

    public function upload(Request $request)
    {
        // Valide os dados enviados pelo formulário
        $this->validate($request, [
            'arquivo' => 'required|file|max:2048|mimes:pdf,doc,docx',
        ]);

        // Salve o arquivo na pasta de upload
        $arquivo = $request->file('arquivo');
        $nomeArquivo = $arquivo->getClientOriginalName();
        $arquivo->move(public_path('uploads'), $nomeArquivo);

        // Crie um registro para o documento no banco de dados
        $documento = new Documents;
        $documento->name = $nomeArquivo;
        $documento->path = 'uploads/' . $nomeArquivo;
        $documento->size = filesize('uploads/' . $nomeArquivo);
        $documento->id_user = Auth::user()->id;
        $documento->save();

        // Redirecione para a página de dashboard ou faça outras ações necessárias
        return redirect()->route('dashboard')->with('success', 'Documento enviado com sucesso!');
    }

    public function edit($id)
    {
        $document = Documents::findOrFail($id);
        return view('documentsedit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        // Valide os dados enviados pelo formulário
        // $this->validate($request, [
        //     'name' => 'required',
        //     // adicione outras validações se necessário
        // ]);

        // Atualize os dados do documento no banco de dados
        $documento = Documents::findOrFail($id);
        $documento->update([
            'name' => $request->name,
            'path' => $request->path,
            'size' => $request->size,
        ]);
        // $documento->name = $request->name;
        // $documento->save();

        // Redirecione para a página de dashboard ou faça outras ações necessárias
        return redirect()->route('dashboard')->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Encontre e exclua o documento do banco de dados
        $documento = Documents::findOrFail($id);
        $documento->delete();

        // Exclua o arquivo físico do servidor, se necessário
        // ...

        // Redirecione para a página de dashboard ou faça outras ações necessárias
        return redirect()->route('dashboard')->with('success', 'Documento excluído com sucesso!');
    }
}
