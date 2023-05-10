<?php

namespace App\Orchid\Screens\Post;

use Orchid\Screen\Screen;
use App\Models\Post;
use App\Orchid\Layouts\Post\PostListLayout;
use Orchid\Screen\Actions\Link;

class PostListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            //Query data from the DB and assign it to a key
            'posts' => Post::filters()->defaultSort('id')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Blog Post";
    }

    public function description(): ?string
    {
        return "All blog posts";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        //Create button
        return [
            Link::make('Create new')
            ->icon('pencil')
            ->route('platform.post.edit')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            //Calling the table - get data from the DB
            PostListLayout::class
        ];
    }

}
