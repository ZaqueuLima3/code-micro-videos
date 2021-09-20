<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();

    }

    public function testFillableAttributeShouldHaveNameDescriptionAndIs_active()
    {
        $expected = ['name', 'description', 'is_active'];
        $this->assertEquals($expected, $this->category->getFillable());
    }

    public function testIfUseCorrectTraits()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);

    }

    public function testCastsAttributeShouldHaveIdToString()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testIdIsNotAutoIncrement()
    {
        $this->assertFalse($this->category->incrementing);
    }

    public function testDateAttributeShouldHaveIdToString()
    {
        $expected = ['deleted_at', 'updated_at', 'created_at'];
        foreach ($expected as $date) {
            $this->assertContains($date, $this->category->getDates());
        }
        $this->assertCount(count($expected), $this->category->getDates());
    }
}
