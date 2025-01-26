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
        if (! $request->file('insurance_img')) {
            return response()->json(['isSuccess' => true, 'error' => 'The insurance is required.'], 404);
        }
        
        $existingDocument = Document::where('user_id', $request->id)
            ->where('type', Document::INSURANCE)
            ->first();

        if ($existingDocument && $existingDocument->document_url) {
            $existingFilePath = str_replace(URL::to('/').'/storage/', '', $existingDocument->document_url);
            if (\Storage::exists('public/'.$existingFilePath)) {
                \Storage::delete('public/'.$existingFilePath);
            }
        }
        
        $imageName = time() . '-' .$request->insurance_img->getClientOriginalName();
        $request->insurance_img->storeAs('public/images/insurance', $imageName);
        $url = URL::to('/').'/storage/images/insurance/'.$imageName;

        $tableData = [
            'type'         => Document::INSURANCE,
            'user_id'      => $request->id,
            'status'      => Document::IN_PROGRESS,
            'document_url' => $url,
        ];

        Document::updateOrCreate(['user_id' => $request->id, 'type' => Document::INSURANCE], $tableData);

        $user = User::where('id', $request->id)->first();
        if (!empty($user)){
            $user->update(['is_verified_document' => false]);
        }
//            DB::table('users')
//                ->where('id', $request->id)
//                ->update($tableData);
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

//        if (!$request->hasFile('official_id') || !$request->hasFile('certificate')) {
//            return response()->json(['error' => 'The official id and certificate is required'], 401);
//        }

        //for official id image
        if ($request->file('official_id')) {
            $this->removeExistingFile(Document::OFFICIAL_ID, $user->id);
            $officialImageName = time() . '-' . $request->official_id->getClientOriginalName();
            $request->official_id->storeAs('public/images/documents', $officialImageName);
            $url = URL::to('/') . '/storage/images/documents/' . $officialImageName;

            $documentOfficialInput = [
                'type'         => Document::OFFICIAL_ID,
                'user_id'      => $user->id,
                'status'      => Document::IN_PROGRESS,
                'document_url' => $url,
            ];
            Document::updateOrCreate(['user_id' => $user->id, 'type' => Document::OFFICIAL_ID], $documentOfficialInput);
        }

        //for certificate pdf
        if ($request->file('certificate')) {
            $this->removeExistingFile(Document::CERTIFICATE, $user->id);
            $certificateFileName = time() . '-' . $request->certificate->getClientOriginalName();
            $request->certificate->storeAs('public/images/documents', $certificateFileName);
            $url = URL::to('/') . '/storage/images/documents/' . $certificateFileName;

            $documentCertificateInput = [
                'type'         => Document::CERTIFICATE,
                'user_id'      => $user->id,
                'status'      => Document::IN_PROGRESS,
                'document_url' => $url,
            ];
            Document::updateOrCreate(['user_id' => $user->id, 'type' => Document::CERTIFICATE], $documentCertificateInput);
        }

        //for resume pdf
        if ($request->file('resume')) {
            $this->removeExistingFile(Document::RESUME, $user->id);
            $resumeFileName = time() . '-' . $request->resume->getClientOriginalName();
            $request->resume->storeAs('public/images/documents', $resumeFileName);
            $url = URL::to('/') . '/storage/images/documents/' . $resumeFileName;

            $documentResumeInput = [
                'type'         => Document::RESUME,
                'user_id'      => $user->id,
                'status'      => Document::IN_PROGRESS,
                'document_url' => $url,
            ];
            
            Document::updateOrCreate(['user_id' => $user->id, 'type' => Document::RESUME], $documentResumeInput);
        }

        $user->update(['is_verified_document' => false]);

        return response()->json(['message' => 'document uploaded successfully', 200]);
    }
    
    private function removeExistingFile($documentType,$userId){
        $existingDocument = Document::where('user_id', $userId)
            ->where('type', $documentType)
            ->first();
        
        if ($existingDocument && $existingDocument->document_url) {
            $existingFilePath = str_replace(URL::to('/') . '/storage/', '', $existingDocument->document_url);
            if (\Storage::exists('public/' . $existingFilePath)) {
                \Storage::delete('public/' . $existingFilePath);
            }
        }

    }
}
