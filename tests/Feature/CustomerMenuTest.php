<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_see_menu_page()
    {
        $response = $this->get(route('customer.menu'));
        
        $response->assertStatus(200);
        $response->assertSee('Menu Kopi Kita');
    }

    public function test_menu_shows_products()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Kopi Susu Gula Aren',
            'price' => 18000,
            'is_available' => true,
        ]);

        $response = $this->get(route('customer.menu'));
        
        $response->assertStatus(200);
        $response->assertSee('Kopi Susu Gula Aren');
        $response->assertSee('18.000');
    }

    public function test_menu_shows_categories()
    {
        $category = Category::factory()->create(['name' => 'Kopi']);
        $product = Product::factory()->create(['category_id' => $category->id]); // create product so category is visible

        $response = $this->get(route('customer.menu'));
        
        $response->assertStatus(200);
        $response->assertSee('Kopi');
    }

    public function test_customer_can_filter_by_category()
    {
        $cat1 = Category::factory()->create(['name' => 'Kopi']);
        $cat2 = Category::factory()->create(['name' => 'Teh']);
        
        $prod1 = Product::factory()->create(['category_id' => $cat1->id, 'name' => 'Espresso']);
        $prod2 = Product::factory()->create(['category_id' => $cat2->id, 'name' => 'Lychee Tea']);

        $response = $this->get(route('customer.menu', ['category' => $cat1->id]));
        
        $response->assertStatus(200);
        $response->assertSee('Espresso');
        $response->assertDontSee('Lychee Tea');
    }

    public function test_customer_can_search_products()
    {
        $category = Category::factory()->create();
        
        $prod1 = Product::factory()->create(['category_id' => $category->id, 'name' => 'Americano']);
        $prod2 = Product::factory()->create(['category_id' => $category->id, 'name' => 'Cappuccino']);

        $response = $this->get(route('customer.menu', ['search' => 'Americano']));
        
        $response->assertStatus(200);
        $response->assertSee('Americano');
        $response->assertDontSee('Cappuccino');
    }

    public function test_unavailable_products_are_shown_but_marked()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Kopi Kosong',
            'is_available' => false,
        ]);

        $response = $this->get(route('customer.menu'));
        
        $response->assertStatus(200);
        $response->assertSee('Kopi Kosong');
        $response->assertSee('Habis');
    }
}
