<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Danh mục sản phẩm</h3>
    </div>
    <div class="secion-detail">
        <?php UlCategories($categories) ?>
    </div>
</div>

<?php
    function UlCategories($categories, $parent_id = 0,$stt = 0){
        // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
        $cate_child = array();
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parent_id)
            {
                $cate_child[] = $item;
                unset($categories[$key]);
            }
        }
        // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
        if ($cate_child)
        {
            $class = "";
            if ($stt == 0){
                $class = "class='list-item'";
            }else{
                $class = "class='sub-menu'";
            }
            echo "<ul {$class}>";
            foreach ($cate_child as $key => $item)
            {
                // Hiển thị tiêu đề chuyên mục
                echo '<li>';
                echo   "<a href='". url("danh-muc/{$item->slug}/{$item->id}") ."' title=''>{$item->cat_title}</a>";
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                UlCategories($categories, $item->id,++$stt);
                echo '</li>';
            }
            echo '</ul>';
        }
    }
?>
