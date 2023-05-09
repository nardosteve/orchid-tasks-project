<?php

namespace App\Orchid\Layouts\Post;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use App\Models\Post;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = '';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            // TD::make('title', 'Title')
            //     ->render(function (Post $post) {
            //         return Link::make($post->title)
            //             ->route('platform.post.edit', $post);
            //     }),

            // TD::make('created_at', 'Created'),
            // TD::make('updated_at', 'Last edit'),
        ];
    }
}
