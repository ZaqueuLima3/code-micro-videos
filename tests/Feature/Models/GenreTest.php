<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testGenreList()
    {
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $this->assertCount(1, $genres);
        $genresKeys = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'id', 'name', 'created_at', 'updated_at', 'deleted_at', 'is_active'
        ], $genresKeys);
    }

    public function testGenreCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genre->refresh();
        $this->assertEquals(36, strlen($genre->id));
        $this->assertEquals('test1', $genre->name);
        $this->assertTrue((bool)$genre->is_active);
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);
        $genre = factory(Genre::class)->create([
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testGenreUpdate()
    {
        /** @yar Genre $genre */
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ]);
        $data = [
            'name' => 'test_name_update',
            'is_active' => true
        ];
        $genre->update($data);
        $this->assertEquals('test_name_update', $genre->name);
        $this->assertTrue($genre->is_active);
    }

    public function testGenreDelete()
    {
        $genre = factory(Genre::class)->create();
        $genre->delete();
        $genres = Genre::all();
        $this->assertEmpty($genres);
    }

    public function testRestoreGenre()
    {
        $genre = factory(Genre::class)->create();
        $genre->delete();
        $genre->restore();
        $this->assertNotNull(Genre::find($genre->id));
    }
}
