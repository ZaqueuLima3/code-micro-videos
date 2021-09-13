<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    private function makeSut(): Category
    {
        return new Category();
    }

    public function testFillableAttributeShouldHaveNameDescriptionAndIs_active()
    {
        $category = $this->makeSut();
        $expected = ['name', 'description', 'is_active'];
        $this->assertEquals($expected, $category->getFillable());
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
        $category = $this->makeSut();
        $casts = ['id' => 'string'];
        $this->assertEquals($casts, $category->getCasts());
    }

    public function testIdIsNotAutoIncrement()
    {
        $category = $this->makeSut();
        $this->assertFalse($category->incrementing);
    }

    public function testDateAttributeShouldHaveIdToString()
    {
        $category = $this->makeSut();
        $expected = ['deleted_at', 'updated_at', 'created_at'];
        foreach ($expected as $date) {
            $this->assertContains($date, $category->getDates());
        }
        $this->assertCount(count($expected), $category->getDates());
    }
}
