<?php

namespace App\Command;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-products',
    description: 'Import products from JSON file',
)]
class ImportProductsCommand extends Command
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        parent::__construct();
        $this->dm = $dm;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $jsonFile = __DIR__ . '/../../data/products.json';
        
        if (!file_exists($jsonFile)) {
            $io->error('JSON file not found at: ' . $jsonFile);
            return Command::FAILURE;
        }

        $jsonContent = file_get_contents($jsonFile);
        $data = json_decode($jsonContent, true);

        if (!isset($data['SearchResult']['Items'])) {
            $io->error('Invalid JSON structure. Expected "SearchResult.Items" key.');
            return Command::FAILURE;
        }

        $this->dm->createQueryBuilder(Product::class)
            ->remove()
            ->getQuery()
            ->execute();

        $io->info('Cleared existing products');

        $position = 1;
        foreach ($data['SearchResult']['Items'] as $item) {
            $product = new Product();
            $product->setAsin($item['ASIN'] ?? '');
            $product->setTitle($item['ItemInfo']['Title']['DisplayValue'] ?? '');
            $product->setBrand($item['ItemInfo']['ByLineInfo']['Brand']['DisplayValue'] ?? null);
            $product->setImageUrl($item['Images']['Primary']['Large']['URL'] ?? '');
            $product->setProductUrl($item['DetailPageURL'] ?? '');
            
            // Process price
            if (isset($item['Offers']['Listings'][0]['Price'])) {
                $priceData = $item['Offers']['Listings'][0]['Price'];
                $product->setPrice($priceData['Amount'] ?? null);
                $product->setCurrency($priceData['Currency'] ?? 'EUR');
                
                // Process discount
                if (isset($priceData['Savings']['Percentage'])) {
                    $product->setDiscount((int)$priceData['Savings']['Percentage']);
                }
            }

            // Process features
            if (isset($item['ItemInfo']['Features']['DisplayValues']) && is_array($item['ItemInfo']['Features']['DisplayValues'])) {
                $product->setFeatures($item['ItemInfo']['Features']['DisplayValues']);
            }

            $product->setPosition($position++);
            $product->generateRandomRating();

            $this->dm->persist($product);

            $io->text('Imported: ' . $product->getTitle());
        }

        $this->dm->flush();

        $io->success('Products imported successfully!');

        return Command::SUCCESS;
    }
}
