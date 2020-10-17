<?php


namespace App\Services\Member;


use App\Http\Requests\Member\ResetPasswordRequest;
use App\Http\Requests\Member\UpdateRequest;
use App\Member;
use App\Util\CanUpload;
use Illuminate\Support\Facades\DB;

class UpdateService
{
    use CanUpload;

    public function update(UpdateRequest $request, Member $member) :bool
    {
        if ($request->hasFile('avatar')) {

            $photo = $request->file('avatar');

            $newPhotoName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);

            $member->photo = $this->uploadFile($photo, 'upload', $newPhotoName);
        }

        if ($request->name) {
            $member->name = $request->name;
        }

        if ($request->email) {
            $member->email = $request->email;
        }

        return DB::transaction(function () use ($member) {
            return $member->save();
        });
    }

    public function updatePassword(ResetPasswordRequest $request, Member $member)
    {
        $member->password = $request->password;

        return DB::transaction(function () use ($member) {
            return $member->save();
        });
    }
}
