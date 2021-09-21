<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testCategoryList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoriesKeys = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'id', 'name', 'description', 'created_at', 'updated_at', 'deleted_at', 'is_active'
        ], $categoriesKeys);
    }

    public function testCategoryCreate()
    {
        $category = Category::create([
            'name' => 'test1'
        ]);
        $category->refresh();
        $this->assertEquals(36, strlen($category->id));
        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue((bool)$category->is_active);
        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($category->description);
        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description', $category->description);
        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);
        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);
    }

    public function testCategoryUpdate()
    {
        /** @yar Category $category */
        $category = factory(Category::class)->create([
            'description' => 'test_description',
            'is_active' => false
        ]);
        $data = [
            'name' => 'test_name_update',
            'description' => 'test_description_update',
            'is_active' => true
        ];
        $category->update($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testCategoryDelete()
    {
        $category = factory(Category::class)->create();
        $category->delete();
        $categories = Category::all();
        $this->assertEmpty($categories);
    }

    public function testRestoreCategory()
    {
        $category = factory(Category::class)->create();
        $category->delete();
        $category->restore();
        $this->assertNotNull(Category::find($category->id));
    }
}
