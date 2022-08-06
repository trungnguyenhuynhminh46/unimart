<?php

namespace App\Components;

class CategoryBuilder
{
    private $data;
    private $htmlSelectCats = '';
    private $categoryIds = [];
    function __construct($data)
    {
        $this->data = $data;
    }

    // Hàm này sẽ in ra category có index truyền vào và các con của nó, kết quả trả về sau khi đã vét cạn xong
    function categoriesMaker($selectedId = null, $parent_id = null, $prefix = '')
    {
        $categories = $this->data;
        foreach ($categories as $category) {
            if ($category->parent_id == $parent_id) {
                if (($selectedId != null) && ($selectedId == $category->id)) {
                    $this->htmlSelectCats .= "<option value='{$category->id}' selected>" . $prefix . " {$category->name}</option>";
                } else {
                    $this->htmlSelectCats .= "<option value='{$category->id}'>" . $prefix . " {$category->name}</option>";
                }
                $this->categoriesMaker($selectedId, $category->id, $prefix . '--');
                // Chú ý: Truyền trực tiếp $prefix.'--' không làm thay đổi biến $prefix
            }
        }
        return $this->htmlSelectCats;
    }

    function categoryIdsMaker($parent_id = null)
    {
        $categories = $this->data;
        foreach ($categories as $category) {
            if ($category->parent_id == $parent_id) {
                $this->categoryIds[] = $category->id;
                $this->categoryIdsMaker($category->id);
            }
        }
        return $this->categoryIds;
    }
}
