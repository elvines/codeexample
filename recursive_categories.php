<?php

class Categories {
    protected $categories = [];

    /**
     * @var bool
     * @comment This is a dirty hack to suppress notifications while returning a simple boolean instead of reference to variable
     */
    protected $hack = false;

    public function addCategory($category, $parent) {
        if ($this->isCategoryExists($category)) {
            throw new \InvalidArgumentException("Category $category already exists");
        }

        if (is_null($parent)) {
            if (isset($this->categories[$category])) {
                throw new \InvalidArgumentException("Root category $category already exists");
            }

            $this->categories[$category] = [];

            return;
        }

        $parentNode = &$this->findCategory($parent);

        $parentNode[$category] = [];

        if (!$parentNode) {
            throw new \InvalidArgumentException("Parent category $parent does not exist");
        }
    }

    public function getChildren($category) {
        $result = $this->findCategory($category);


        if ($result === false) {
            throw new \InvalidArgumentException("Failed to find category: $category");
        }

        return $result;
    }

    protected function isCategoryExists($category) {
        return $this->findCategory($category) !== false;
    }

    protected function &findCategory($category) {
        return $this->recursiveFind($this->categories, $category);
    }

    protected function &recursiveFind(&$searchCategories, $category) {
        if (empty($searchCategories)) {
            return $this->hack;
        }

        if (isset($searchCategories[$category])) {
            return $searchCategories[$category];
        }

        foreach ($searchCategories as &$newSearchCategory) {
            $result = &$this->recursiveFind($newSearchCategory, $category);

            if (is_array($result)) {
                return $result;
            }
        }

        return $this->hack;
    }
}


$c = new Categories();

$c->addCategory("A", null);

$c->addCategory("B", "A");
$c->addCategory("C", "A");
$c->addCategory("D", "C");
$c->addCategory("E", "C");
$c->addCategory("F", "B");

$childCategories = [];
$childCategories['A'] = $c->getChildren("A");
$childCategories['B'] = $c->getChildren("B");
$childCategories['C'] = $c->getChildren("C");

print_r($childCategories);

