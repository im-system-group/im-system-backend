<?php


namespace App\Services\Article;


use App\Article;
use App\Http\Requests\Article\UpdateRequest;
use App\Member;
use App\Util\CanUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateService
{
    use CanUpload;

    public function update(Article $article, UpdateRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $originImage = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            Storage::disk('public')->delete($article->image);
            $article->image = $this->uploadFile($image, 'postupload', $originImage);
        }

        DB::transaction(function () use ($article, $request) {
            $article->title = $request->title;
            $article->content = $request->content;
            $article->save();
        });
    }

    public function favorite(Member $member, Article $article, bool $favorite)
    {
        $likeInfoCollection = collect($article->like_info);
        $likeInfo = $favorite ?
            $likeInfoCollection->add($member->id) : $likeInfoCollection->filter(fn($likeMember) => $likeMember != $member->id);

        DB::transaction(function () use ($likeInfo, $article){
            $article->like_info = $likeInfo;
            $article->save();
        });
    }

}