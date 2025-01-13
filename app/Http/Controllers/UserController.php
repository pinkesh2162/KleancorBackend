<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id', 'desc')->get(); 
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3|max:30',      
            'last_name' => 'required|min:3|max:30',    
            'email' => 'required|min:3|max:30',
            'is_admin' => 'required',
            'status' => 'required'
        ]);
        User::create($request->all());
        return redirect()->route('users.index')->with('message', 'User Added Successfully!!');
    }

    public function show(Request $request, $id)
    {
        $user = User::with('documents')->findOrFail($id);
        $user->insurance_img_type = $this->getDocumentType($user->insurance_img);

        foreach ($user->documents as $document) {
            $document->doc_type = $this->getDocumentType($document->document_url);
        }

        return view('users.show', ['user' => $user]);
    }

    protected function getDocumentType($url){
        $docType = null;

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        $types = [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'],
            'document' => ['doc', 'docx', 'pdf', 'txt', 'odt'],
            'spreadsheet' => ['xls', 'xlsx', 'csv'],
            'presentation' => ['ppt', 'pptx'],
            'compressed' => ['zip', 'rar', '7z', 'tar', 'gz'],
        ];

        foreach ($types as $type => $extensions) {
            if (in_array(strtolower($extension), $extensions)) {
                $docType = $type;
                break;
            }
        }
        
        return $docType;
    }

    public function verifying(Request $request, $id)
    {
        $user = User::with('documents')->findOrFail($id);

        if (!$user->insurance_img) {
            return back()->withErrors(['error' => 'The insurance is required.']);
        }

        $missingDocument = $user->documents->firstWhere('document_url', null);

        if ($missingDocument) {
            return back()->withErrors(['error' => "The {$missingDocument->type} is required."]);
        }

        $user->update(['is_verified_document' => true]);

        return redirect()->route('users.index');
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|min:3|max:30',      
            'last_name' => 'required|min:3|max:30',    
            'email' => 'required|min:3|max:150',
            'is_admin' => 'required',
            'status' => 'required'
        ]);
  
        $user->update($request->all());
        return redirect()->route('users.index')->with('message', 'User Updated Successfully!!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('error', 'User Delete Successfully!!');
    }
}
