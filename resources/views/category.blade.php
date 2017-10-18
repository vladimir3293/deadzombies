@extends('admin')
@section('right_content')

    <form class="cat_edit_form" method="POST" action="/admin/category/{{ $category->cat_url }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="submit" value="Изменить">
    </form>
<!-- <div class="cat_edit_name">
            <a href="../index.html"></a>
        </div>
        <input name="cat_id" type="hidden" value="<?php //echo $cat_id;?>">
        <div class="cat_edit_other">
            <div class="cat_rename">
                <span>Переименовать</span>
                <input name="cat_rename" type="text">
            </div>
            <div class="cat_order">
                <span>Порядок <?php //echo $cat_all['cat_order'];?> </span>
                <input name="cat_order" type="number">
            </div>
            <div class="cat_rename">
                <span>Тайтл</span>
                <input name="cat_title" type="text" value="<?php //echo $cat_all['cat_title'];?>">
            </div>
            <div class="cat_rename">

                <span>Мета описание</span>
                <input name="cat_desc_meta" type="text" value="<?php //echo $cat_all['cat_desc_meta'];?>">
            </div>
            <div class="cat_rename">
                <span>Мета ключи</span>
                <input name="cat_key_meta" type="text" value="<?php //echo $cat_all['cat_key_meta'];?>">
            </div>

            <div class="cat_rename">
                <span>Заголовок h1</span>
                <input name="cat_h1" type="text" value="<?php //echo $cat_all['cat_h1'];?>">
            </div>

            <textarea name="cat_desc" class="cat_desc"><?php //echo $cat_all['cat_desc']; ?></textarea>
            <input type="submit" value="Изменить">
    </form>
-->
    <div class="cat_delete">
        <span>Удалить</span>
        <input name="cat_delete" type="checkbox" value="1">
    </div>
@parent
@endsection
