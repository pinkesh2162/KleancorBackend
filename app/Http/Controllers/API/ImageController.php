<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Image;
// New change
use App\Models\Document;
use App\Models\User;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $imageName = '';
        if ($request->file('avatar')) {
            $image = $request->avatar;
            $imageName = $image->getClientOriginalName();
            $image = Image::make($image)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(storage_path('app/public/images/avatar/' . $imageName), 70);
            $url = URL::to('/') . '/storage/app/public/images/avatar/' . $imageName;

            $tableData = [
                'avatar' => $url,
            ];

            DB::table('users')
                ->where('id', $request->id)
                ->update($tableData);
        }
        return response()->json(['isSuccess' => true, 'url' => $url]);
    }



    public function uploadPdf(Request $request)
    {
        $imageName = '';
        if ($request->file('insurance_img')) {
            $imageName = $request->insurance_img->getClientOriginalName();
            $request->insurance_img->storeAs('public/images/insurance', $imageName);
            $url = URL::to('/') . '/storage/images/insurance/' . $imageName;

            $tableData = [
                'insurance_img' => $url,
            ];

            DB::table('users')
                ->where('id', $request->id)
                ->update($tableData);
        }
        return response()->json(['isSuccess' => true, 'url' => $url]);
    }

    // public function uploadPdf(Request $request)
    // {
    //     $documentTypes = ['insurance_img', 'official_id', 'certificate', 'resume']; // Supported document types
    //     $uploadedUrls = [];
    //     $userId = $request->id;

    //     // Validate user existence
    //     $user = User::find($userId);
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 422);
    //     }

    //     foreach ($documentTypes as $type) {
    //         if ($request->file($type)) {
    //             $file = $request->file($type);

    //             if ($file->isValid()) {
    //                 $imageName = time() . '-' . $file->getClientOriginalName();
    //                 $file->storeAs('public/images/uploads', $imageName);
    //                 $url = URL::to('/') . '/storage/images/uploads/' . $imageName;

    //                 // Update database for 'insurance_img' or create new record for other document types
    //                 if ($type === 'insurance_img') {
    //                     DB::table('users')
    //                         ->where('id', $userId)
    //                         ->update([$type => $url]);
    //                 } else {
    //                     Document::create([
    //                         'user_id'      => $userId,
    //                         'document_url' => $url,
    //                         'document_type' => $type, // Optional for categorization
    //                     ]);
    //                 }

    //                 $uploadedUrls[$type] = $url;
    //             }
    //         }
    //     }

    //     if (empty($uploadedUrls)) {
    //         return response()->json(['error' => 'No valid files uploaded'], 400);
    //     }

    //     // Optionally, update user's document verification status
    //     $user->update(['is_verified_document' => false]);

    //     return response()->json(['isSuccess' => true, 'uploadedUrls' => $uploadedUrls]);
    // }


    // New change
    public function updateDocuments(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return response()->json(['error' => 'User not found'], 422);
        }

        if (!$request->hasFile('official_id') || !$request->hasFile('certificate')) {
            return response()->json(['error' => 'The official id and certificate is required'], 401);
        }

        //for official id image
        if ($request->file('official_id')) {
            $officialImageName = time() . '-' . $request->official_id->getClientOriginalName();
            $request->official_id->storeAs('public/images/documents', $officialImageName);
            $url = URL::to('/') . '/storage/images/documents/' . $officialImageName;

            $documentOfficialInput = [
                'type' => 'official_id',
                'user_id'      => $user->id,
                'document_url' => $url,
            ];
            Document::updateOrCreate(['user_id' => $user->id, 'type' => 'official_id'], $documentOfficialInput);
        }

        //for certificate pdf
        if ($request->file('certificate')) {
            $certificateFileName = time() . '-' . $request->certificate->getClientOriginalName();
            $request->certificate->storeAs('public/images/documents', $certificateFileName);
            $url = URL::to('/') . '/storage/images/documents/' . $certificateFileName;

            $documentCertificateInput = [
                'type' => 'certificate',
                'user_id'      => $user->id,
                'document_url' => $url,
            ];
            Document::updateOrCreate(['user_id' => $user->id, 'type' => 'certificate'], $documentCertificateInput);
        }

        //for resume pdf
        if ($request->file('resume')) {
            $resumeFileName = time() . '-' . $request->resume->getClientOriginalName();
            $request->resume->storeAs('public/images/documents', $resumeFileName);
            $url = URL::to('/') . '/storage/images/documents/' . $resumeFileName;

            $documentResumeInput = [
                'type' => 'resume',
                'user_id'      => $user->id,
                'document_url' => $url,
            ];
            Document::updateOrCreate(['user_id' => $user->id, 'type' => 'resume'], $documentResumeInput);
        }

        $user->update(['is_verified_document' => false]);

        return response()->json(['message' => 'document uploaded successfully', 200]);
    }
}
