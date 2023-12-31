<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Permissions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{

    public function index(Request $request)
    {
        if($request){
            $query = Documents::query();
    
            if ($request->filled('name')) {
                $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }
    
            if ($request->filled('created_at')) {
                $query->whereDate('created_at', '=', $request->input('created_at'));
            }

            if ($request->filled('id_user')) {
                $query->where('id_user', '=', $request->input('id_user'));
            }
    
            $documents = $query->get();
        } else {
            $documents = Documents::all();
        }

        $users = User::All();;
        $userAtual = Auth::user()->id;

        return view('documents', compact('documents','users', 'userAtual'));
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'arquivo' => 'required|file|max:2048|mimes:pdf,doc,docx',
        ]);

        $arquivo = $request->file('arquivo');
        $extension = $arquivo->getClientOriginalExtension();
        $nomeArquivoOriginal = $arquivo->getClientOriginalName();
        $nomeArquivo = time() . '.' . $nomeArquivoOriginal;
        $arquivo->move(public_path('uploads'), $nomeArquivo);

        $documento = new Documents;
        $documento->name = $nomeArquivoOriginal;
        $documento->path = 'uploads/' . $nomeArquivo;
        $documento->size = filesize('uploads/' . $nomeArquivo);
        $documento->id_user = Auth::user()->id;
        $documento->save();

        $permissions = new Permissions;
        $permissions->edit = true;
        $permissions->delete = true;

        return redirect()->route('documents.index')->with('success', 'Documento enviado com sucesso!');
    }

    public function edit($id)
    {
        $document = Documents::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    public function download($id) 
    {
        $document = Documents::findOrFail($id);
        $nomeOriginal = $document->name;
        $caminhoArquivo = $document->path;
        $caminhoArquivoFinal = str_replace("/","\\",$caminhoArquivo);
        return response()->download("C:\Users\camin\Desktop\laravel\laraveldsi\public\\" . $caminhoArquivoFinal, $nomeOriginal);
    }

    public function update(Request $request, $id)
    {
        $documento = Documents::findOrFail($id);
        $documento->update([
            'name' => $request->name,
            'path' => $request->path,
            'size' => $request->size,
        ]);

        return redirect()->route('documents.index')->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $documento = Documents::findOrFail($id);
        $documento->delete();

        return redirect()->route('documents.index')->with('success', 'Documento excluído com sucesso!');
    }
}