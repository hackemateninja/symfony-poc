<?php

namespace App\Factory;

use App\Entity\Product;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\set;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
	
	private const PRODUCT_NAMES = [
		'Herbal Shine Shampoo',
		'Coconut Hydration Shampoo',
		'Tea Tree Scalp Care',
		'Argan Oil Repair Shampoo',
		'Volumizing Bamboo Shampoo',
		'Aloe Vera Smooth Shampoo',
		'Keratin Strength Shampoo',
		'Charcoal Detox Shampoo',
		'Honey Infusion Shampoo',
		'Citrus Fresh Shampoo',
	];
	
	private const DESCRIPTIONS = [
		'Gently cleanses and adds a natural shine to your hair.',
		'Deeply hydrates dry and brittle hair.',
		'Soothes itchy scalp and reduces dandruff.',
		'Repairs damaged hair and restores softness.',
		'Adds volume and bounce to fine hair.',
		'Smooths frizz and enhances silkiness.',
		'Strengthens hair strands and reduces breakage.',
		'Purifies scalp and removes buildup.',
		'Nourishes hair with organic honey extracts.',
		'Refreshes hair with a vibrant citrus scent.',
	];
	
	private const SIZES = [
		100,
		250,
		300,
		350,
		400,
		500,
		750,
		1000,
		2000,
		5000,
	];
	
	/**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->randomElement(self::PRODUCT_NAMES),
	          'description' => self::faker()->randomElement(self::DESCRIPTIONS),
            'size' => self::faker()->randomElement(self::SIZES),
	          'createdAt' => self::faker()->dateTime(),
	          'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
      return $this
          // ->afterInstantiate(function(Product $product): void {})
      ;
    }
}
