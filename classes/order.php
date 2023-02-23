<?php

/**
 * Order classs represents an order from my diner
 * @Zoe Fortin
 */

class Order
{
    private $_food;
    private $_meal;
    private $_condiments;

    function __construct()
    {
        $this->_food = "";
        $this->_meal = "";
        $this->_condiments = "";
    }

    /**
     * getFood returns the food item ordered
     * @return string
     */
    public function getFood()
    {
        return $this->_food;
    }

    /**
     * setFood returns the food item ordered
     * @param string
     */
    public function setFood($food)
    {
        $this->_food = $food;
    }

    /**
     * getFood returns the meal ordered
     * @return string
     */
    public function getMeal()
    {
        return $this->_meal;
    }

    /**
     * setMeal returns the meal ordered
     * @param string
     */
    public function setMeal($meal)
    {
        $this->_meal = $meal;
    }

    /**
     * getCondiments returns the meal ordered
     * @return string
     */
    public function getCondiments()
    {
        return $this->_condiments;
    }

    /**
     * setCondiments returns the meal ordered
     * @param string
     */
    public function setCondiments($condiments)
    {
        $this->_condiments = $condiments;
    }
}