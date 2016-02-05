<?php
namespace SamBurns\SupermarketCodeKata;

use SamBurns\SupermarketCodeKata\Item\Crisps;
use SamBurns\SupermarketCodeKata\Item\Drink;
use SamBurns\SupermarketCodeKata\Item\Sandwich;

class BasketPriceCalculator
{
    /** @var Crisps[] */
    private $crisps = [];

    /** @var Drink[] */
    private $drinks = [];

    /** @var Sandwich[] */
    private $sandwiches = [];

    public function addItem(ItemInterface $item)
    {
        if ($item instanceof Crisps) {
            $this->crisps[] = $item;
        }
        if ($item instanceof Drink) {
            $this->drinks[] = $item;
        }
        if ($item instanceof Sandwich) {
            $this->sandwiches[] = $item;
        }
    }

    public function getTotalPrice() : float
    {
        $total = 0.0;

        // Get total for meal deals
        $total += $this->getMealDealTotal();

        // Calculate total for crisps
        foreach ($this->crisps as $crisp) {
            $total += $crisp->getUnitCost();
        }

        // Calculate total for drinks
        foreach ($this->drinks as $drink) {
            $total += $drink->getUnitCost();
        }

        // Calculate total for sandwiches
        foreach ($this->sandwiches as $sandwich) {
            $total += $sandwich->getUnitCost();
        }

        return $total;
    }

    public function getMealDealTotal(): int
    {
        // Get the highest array
        $max = $this->highest();
        $total = 0;

        // Count number of meals that we have
        for ($i=0; $i<$max; $i++) {
            if (isset($this->sandwiches[$i]) &&
                isset($this->crisps[$i]) &&
                isset($this->drinks[$i])
            ) {
                // Remove this set from their respective arrays
                unset($this->sandwiches[$i]);
                unset($this->crisps[$i]);
                unset($this->drinks[$i]);

                // Add to total
                $total += 3;
            }
        }

        return $total;
    }

    public function highest(): int
    {
        return max(
            count($this->drinks),
            count($this->crisps),
            count($this->sandwiches)
        );
    }
}
