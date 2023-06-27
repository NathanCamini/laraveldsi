<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index(Request $request, $id)
    {
        // dd($request);

        // $documento = Permissions::findOrFail($id, 'id_user');
        // $documento = Permissions::where('id_doc', $id);
        // $permissions = new Permissions;

        // $permissions->update([
        //     'edit' => $request->input('edit'),
        //     'delete' => $request->input('delete'),
        // ]);

        // return view('permissions', compact('teste'));
        return view('dashboard');
    }
}
