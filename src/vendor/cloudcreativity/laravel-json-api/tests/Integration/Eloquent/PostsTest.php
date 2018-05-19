<?php

namespace CloudCreativity\LaravelJsonApi\Tests\Integration\Eloquent;

use CloudCreativity\LaravelJsonApi\Tests\Http\Controllers\PostsController;
use CloudCreativity\LaravelJsonApi\Tests\Models\Post;
use CloudCreativity\LaravelJsonApi\Tests\Models\Tag;

class PostsTest extends TestCase
{

    /**
     * @var string
     */
    protected $resourceType = 'posts';

    /**
     * Test searching with a sort parameter.
     */
    public function testSortedSearch()
    {
        $a = factory(Post::class)->create([
            'title' => 'Title A',
        ]);

        $b = factory(Post::class)->create([
            'title' => 'Title B',
        ]);

        $response = $this->doSearch(['sort' => '-title']);
        $response->assertSearchResponse()->assertContainsOnly(['posts' => [$a->getKey(), $b->getKey()]]);

        $json = $response->decodeResponseJson();
        $actual = [array_get($json, 'data.0.id'), array_get($json, 'data.1.id')];
        $this->assertEquals([$b->getKey(), $a->getKey()], $actual);
    }

    /**
     * Test that we can search posts for specific ids
     */
    public function testSearchById()
    {
        $models = factory(Post::class, 2)->create();
        // this model should not be in the search results
        $this->createPost();

        $this->doSearchById($models)
            ->assertSearchByIdResponse($models);
    }

    /**
     * Test the create resource route.
     */
    public function testCreate()
    {
        /** @var Tag $tag */
        $tag = factory(Tag::class)->create();
        $model = $this->createPost(false);

        $data = [
            'type' => 'posts',
            'attributes' => [
                'title' => $model->title,
                'slug' => $model->slug,
                'content' => $model->content,
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'users',
                        'id' => (string) $model->author_id,
                    ],
                ],
                'tags' => [
                    'data' => [
                        [
                            'type' => 'tags',
                            'id' => (string) $tag->getKey(),
                        ],
                    ],
                ],
            ],
        ];

        $id = $this
            ->doCreate($data)
            ->assertCreateResponse($data);

        $this->assertModelCreated($model, $id, ['title', 'slug', 'content', 'author_id']);
        $this->assertDatabaseHas('post_tag', [
            'post_id' => $id,
            'tag_id' => $tag->getKey(),
        ]);
    }

    /**
     * Test the read resource route.
     */
    public function testRead()
    {
        $model = $this->createPost();
        $model->tags()->create(['name' => 'Important']);;

        $this->doRead($model)->assertReadResponse($this->serialize($model));
    }

    /**
     * Test the update resource route.
     */
    public function testUpdate()
    {
        $model = $this->createPost();

        $data = [
            'type' => 'posts',
            'id' => (string) $model->getKey(),
            'attributes' => [
                'slug' => 'posts-test',
                'title' => 'Foo Bar Baz Bat',
            ],
        ];

        $this->doUpdate($data)->assertUpdateResponse($data);
        $this->assertModelPatched($model, $data['attributes'], ['content']);
    }

    /**
     * Issue 125.
     *
     * If the model caches any of its relationships prior to a hydrator being invoked,
     * any changes to that relationship will not be serialized when the schema serializes
     * the model.
     *
     * @see https://github.com/cloudcreativity/laravel-json-api/issues/125
     */
    public function testUpdateRefreshes()
    {
        /** @var PostsController $controller */
        $controller = $this->app->make(PostsController::class);
        $this->app->instance(PostsController::class, $controller);

        $controller->on('saving', function ($model) {
            $model->tags; // causes the model to cache the tags relationship
        });

        $model = $this->createPost();
        /** @var Tag $tag */
        $tag = factory(Tag::class)->create();

        $data = [
            'type' => 'posts',
            'id' => (string) $model->getKey(),
            'relationships' => [
                'tags' => [
                    'data' => [
                        ['type' => 'tags', 'id' => (string) $tag->getKey()],
                    ],
                ],
            ],
        ];

        $this->doUpdate($data)->assertUpdateResponse($data);

        $this->assertDatabaseHas('post_tag', [
            'post_id' => $model->getKey(),
            'tag_id' => $tag->getKey(),
        ]);
    }

    /**
     * Test the delete resource route.
     */
    public function testDelete()
    {
        $model = $this->createPost();

        $this->doDelete($model)->assertDeleteResponse();
        $this->assertModelDeleted($model);
    }

    /**
     * Just a helper method so that we get a type-hinted model back...
     *
     * @param bool $create
     * @return Post
     */
    private function createPost($create = true)
    {
        $builder = factory(Post::class);

        return $create ? $builder->create() : $builder->make();
    }

    /**
     * Get the posts resource that we expect in server responses.
     *
     * @param Post $model
     * @return array
     */
    private function serialize(Post $model)
    {
        return [
            'type' => 'posts',
            'id' => $id = (string) $model->getKey(),
            'attributes' => [
                'title' => $model->title,
                'slug' => $model->slug,
                'content' => $model->content,
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'users',
                        'id' => (string) $model->author_id,
                    ],
                ],
                'tags' => [
                    'data' => $model->tags->map(function (Tag $tag) {
                        return ['type' => 'tags', 'id' => (string) $tag->getKey()];
                    })->all(),
                ],
                'comments' => [
                    'links' => [
                        'self' => "http://localhost/api/v1/posts/$id/relationships/comments",
                        'related' => "http://localhost/api/v1/posts/$id/comments",
                    ],
                ],
            ],
        ];
    }
}
