<?php

namespace Theme\September\Http\Resources;

use RvMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_name'   => $this->user->name,
            'user_avatar' => $this->user->avatar_url,
            'created_at'  => $this->created_at->diffForHumans(),
            'comment'     => $this->comment,
            'star'        => $this->star,
            'images'      => collect($this->images)->map(function ($image) {
                return [
                    'thumbnail' => RvMedia::getImageUrl($image, 'thumb'),
                    'full_url'  => RvMedia::getImageUrl($image),
                ];
            }),
        ];
    }
}
