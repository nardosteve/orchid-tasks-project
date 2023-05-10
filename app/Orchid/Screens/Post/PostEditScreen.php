<?php

namespace App\Orchid\Screens\Post;

use Orchid\Screen\Screen;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Alert;

class PostEditScreen extends Screen
{
    public $post;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Post $post): iterable
    {
        $post->load('attachment');

        return [
            'post' => $post
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->post->exists ? 'Edit post' : 'Creating a new post';
    }

    public function description(): ?string
    {
        return "Blog posts";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create post')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->post->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->post->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->post->exists),
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
            //Form
            Layout::rows([
                Input::make('post.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this post.'),

                Cropper::make('post.hero')
                    ->targetId()
                    ->title('Large web banner image, generally in the front and center')
                    ->width(1000)
                    ->height(500),

                TextArea::make('post.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Relation::make('post.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),

                Quill::make('post.body')
                    ->title('Main text'),

                Upload::make('post.attachment')
                    ->title('All files')

            ])
        ];
    }

    /**
     * @param Post    $post
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Post $post, Request $request)
    {
        $post->fill($request->get('post'))->save();

        $post->attachment()->syncWithoutDetaching(
            $request->input('post.attachment', [])
        );

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.post.list');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Post $post)
    {
        $post->delete();

        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.post.list');
    }
}
