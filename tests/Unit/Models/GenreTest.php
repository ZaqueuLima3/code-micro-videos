<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class GenreTest extends TestCase
{
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();

    }

    public function testFillableAttributeShouldHaveNameAndIs_active()
    {
        $expected = ['name', 'is_active'];
        $this->assertEquals($expected, $this->genre->getFillable());
    }

    public function testIfUseCorrectTraits()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];
        $genreTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);

    }

    public function testCastsAttributeShouldHaveIdAndIs_active()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $this->assertEquals($casts, $this->genre->getCasts());
    }

    public function testIdIsNotAutoIncrement()
    {
        $this->assertFalse($this->genre->incrementing);
    }

    public function testDateAttributeShouldHaveIdToString()
    {
        $expected = ['deleted_at', 'updated_at', 'created_at'];
        foreach ($expected as $date) {
            $this->assertContains($date, $this->genre->getDates());
        }
        $this->assertCount(count($expected), $this->genre->getDates());
    }
}
