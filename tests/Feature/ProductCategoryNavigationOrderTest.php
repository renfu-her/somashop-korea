<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductCategoryNavigationOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_menu_dropdown_uses_admin_defined_sort_order(): void
    {
        $this->createCategoryTree();

        $html = view('frontend.layouts.partials.main-menu')->render();

        $this->assertSame(
            [
                'Alpha Root',
                'Alpha Child A',
                'Alpha Child B',
                'Beta Root',
                'Beta Child A',
            ],
            $this->extractMainMenuCategoryOrder($html)
        );
    }

    public function test_product_list_and_detail_sidebars_share_the_same_sorted_category_tree(): void
    {
        $tree = $this->createCategoryTree();
        $product = $this->createProductWithPrimaryImage($tree['alphaChildA']);

        $listResponse = $this->get(route('products.category', $tree['alphaChildA']->id));
        $detailResponse = $this->get(route('products.show', $product->id));

        $listResponse->assertOk();
        $detailResponse->assertOk();

        $expectedOrder = [
            'Alpha Root',
            'Alpha Child A',
            'Alpha Grandchild A',
            'Alpha Grandchild B',
            'Alpha Child B',
            'Beta Root',
            'Beta Child A',
        ];

        $listSidebarOrder = $this->extractSidebarCategoryOrder($listResponse->getContent());
        $detailSidebarOrder = $this->extractSidebarCategoryOrder($detailResponse->getContent());

        $this->assertSame($expectedOrder, $listSidebarOrder);
        $this->assertSame($expectedOrder, $detailSidebarOrder);
        $this->assertSame($listSidebarOrder, $detailSidebarOrder);
    }

    private function createCategoryTree(): array
    {
        $betaRoot = $this->createCategory('Beta Root', 20);
        $alphaRoot = $this->createCategory('Alpha Root', 10);

        $betaChildA = $this->createCategory('Beta Child A', 15, $betaRoot->id);
        $alphaChildB = $this->createCategory('Alpha Child B', 20, $alphaRoot->id);
        $alphaChildA = $this->createCategory('Alpha Child A', 10, $alphaRoot->id);

        $alphaGrandchildB = $this->createCategory('Alpha Grandchild B', 20, $alphaChildA->id);
        $alphaGrandchildA = $this->createCategory('Alpha Grandchild A', 10, $alphaChildA->id);

        return compact(
            'alphaRoot',
            'betaRoot',
            'alphaChildA',
            'alphaChildB',
            'betaChildA',
            'alphaGrandchildA',
            'alphaGrandchildB'
        );
    }

    private function createCategory(string $name, int $sortOrder, int $parentId = 0): Category
    {
        return Category::create([
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'parent_id' => $parentId,
            'sort_order' => $sortOrder,
        ]);
    }

    private function createProductWithPrimaryImage(Category $category): Product
    {
        $product = Product::create([
            'name' => 'Sorted Navigation Product',
            'slug' => 'sorted-navigation-product',
            'description' => 'Test product',
            'price' => 100,
            'cash_price' => 90,
            'stock' => 5,
            'category_id' => $category->id,
            'is_active' => true,
            'content' => '<p>Test content</p>',
            'sort_order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'primary.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        return $product;
    }

    private function extractMainMenuCategoryOrder(string $html): array
    {
        return $this->extractTextByXPath(
            $html,
            "//*[contains(concat(' ', normalize-space(@class), ' '), ' product-item ')]//ul[contains(concat(' ', normalize-space(@class), ' '), ' sub-menu ')]/li/a
            | //*[contains(concat(' ', normalize-space(@class), ' '), ' product-item ')]//ul[contains(concat(' ', normalize-space(@class), ' '), ' sub-sub-menu ')]/li/a"
        );
    }

    private function extractSidebarCategoryOrder(string $html): array
    {
        return $this->extractTextByXPath(
            $html,
            "//*[@id='accordionLeftMenu']//button | //*[@id='accordionLeftMenu']//div[contains(concat(' ', normalize-space(@class), ' '), ' card-body ')]//a"
        );
    }

    private function extractTextByXPath(string $html, string $xpath): array
    {
        $document = new \DOMDocument();

        libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();

        $nodes = (new \DOMXPath($document))->query($xpath);
        $results = [];

        foreach ($nodes as $node) {
            $results[] = $this->normalizeText($node->textContent);
        }

        return $results;
    }

    private function normalizeText(string $text): string
    {
        return trim((string) preg_replace('/\s+/', ' ', $text));
    }
}
