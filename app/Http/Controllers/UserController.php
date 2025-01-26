<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::when(@$request->status == '0' || @$request->status == '1', function ($query) use ($request) {
            return $query->where('status', $request->status == '1');
        })
            ->orderBy('id', 'desc')->get();
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
            'status' => 'required',
            'address' => 'required|min:3|max:50',
            'contact' => 'required|numeric',
            'gender' => 'required|string|min:4|max:6',
        ]);
        User::create($request->all());
        return redirect()->route('users.index')->with('message', 'User Added Successfully!!');
    }

    public function show(Request $request, $id)
    {
        $user = User::with('documents')->findOrFail($id);
//        $user->insurance_img_type = $this->getDocumentType($user->insurance_img);

        foreach ($user->documents as $document) {
            $document->doc_type = $this->getDocumentType($document->document_url);
        }

        return view('users.show', ['user' => $user]);
    }

    protected function getDocumentType($url)
    {
        $docType = null;

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        $types = [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg','avif'],
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
        $document = Document::where('type', $request->type)
            ->where('user_id', $id)
            ->first();

        if (! $document) {
            return back()->withErrors(['error' => 'The document is not found.'], 404);
        }

        $document->update(['status' => $request->status]);

        $allDocumentsVerified = !Document::where('user_id', $id)
            ->where('status', '!=', Document::VERIFIED)
            ->exists();

        User::where('id', $id)->update(['is_verified_document' => $allDocumentsVerified]);

        return redirect()->back()->with(['success' => 'Document status updated successfully.']);
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
            'address' => 'required|min:3|max:50',
            'contact' => 'required|numeric',
            'email' => 'required|min:3|max:150',
            'gender' => 'required|string|min:4|max:6',
            'is_admin' => 'required',
            'status' => 'required'
        ]);

        $user->update($request->all());
        return redirect()->route('users.index')->with('message', 'User Updated Successfully!!');
    }

    public function changeStatus(Request $request, User $user)
    {
        $user->update(['status' => $user->status = !$user->status]);

        return redirect()->route('users.index')->with('message', 'Status Updated Successfully!!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('error', 'User Delete Successfully!!');
    }

    public function deleteAllUsers(Request $request)
    {
        if (empty($request->usersId)) {
            return redirect()->back()->withErrors('users not found.');
        }

        User::whereIn('id', explode(',', $request->usersId))->delete();

        return redirect()->route('users.index')->with('error', 'User Delete Successfully!!');
    }
}
