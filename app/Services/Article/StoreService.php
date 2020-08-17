<?php


namespace App\Services\Article;


use App\Article;
use App\Http\Requests\Article\StoreRequest;
use App\Member;
use App\Util\CanUpload;

class StoreService
{
    use CanUpload;

    public function store(Member $member, StoreRequest $request)
    {
        $article = new Article([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $originImage = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            $article->image = $this->uploadFile($image, 'postupload', $originImage);
        }

        $article->author()->associate($member);
        $article->save();
    }

}