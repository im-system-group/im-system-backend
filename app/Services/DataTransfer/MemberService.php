<?php


namespace App\Services\DataTransfer;


use App\Member;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemberService
{
    public function dataTransfer()
    {
        $oldData = $this->getOldData();
        $this->toNewData($oldData);
        DB::transaction(fn() => Member::insert($oldData->toArray()));

        echo "Member Data Complete.\n";
    }

    private function getOldData(): Collection
    {
        return DB::connection('imold')->table('member')
            ->select('account', 'password', 'name', 'email', 'photo')
            ->get();
    }

    private function toNewData(Collection $oldData)
    {
        $oldData->transform(function ($member) {
            $member->photo = (substr($member->photo, 0, 2) != '..') ?
                'image/def_picture.jpg' :
                substr($member->photo, 3);

            $member->id = Str::orderedUuid();
            $member->created_at = Carbon::now()->toDateTimeString();
            $member->updated_at = Carbon::now()->toDateTimeString();
            return (array)$member;
        });
    }
}