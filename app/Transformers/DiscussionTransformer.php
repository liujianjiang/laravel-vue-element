<?php

namespace App\Transformers;

use App\Discussion;
use League\Fractal\TransformerAbstract;

class DiscussionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];

    protected $availableIncludes  = [
        'comments',
        'tags',
        'user'
    ];

    public function transform(Discussion $discussion)
    {
        $content = json_decode($discussion->content);

        return [
            'id'            => $discussion->id,
            'user_id'       => $discussion->user_id,
            'user'          => [
                'name'   => $discussion->user->name
            ],
            'title'         => $discussion->title,
            'content_raw'   => $content->raw,
            'content_html'  => $content->html,
            'status'        => (bool) $discussion->status,
            'created_at'    => $discussion->created_at->diffForHumans(),
        ];
    }




    /**
     * Include User
     *
     * @param Discussion $discussion
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUser(Discussion $discussion)
    {
        $user = $discussion->user;

        return $this->item($user, new UserTransformer);
    }
}
