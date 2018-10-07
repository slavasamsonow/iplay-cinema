<h1>Создать новый курс</h1>
<div class="row">
    <form action="/admin/addcourse" method="post" class="col-md-6">
        <div class="control-group form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="name" required="true">
        </div>
        <div class="control-group form-group">
            <label>Описание:</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="control-group form-group">
            <label>Цена:</label>
            <input type="number" class="form-control" name="price" required="true" value="0">
        </div>
        <div class="control-group form-group">
            <label>тип:</label>
            <select class="form-control" name="type">
                <?php foreach($coursesTypes as $coursesType):?>
                <option value="<?=$coursesType['id']?>">
                    <?=$coursesType['name']?>
                </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="active" value="1" checked>
                <span> Активный </span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="private" value="1">
                <span> Приватный </span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="payment" value="1" checked>
                <span> Разрешен к оплате </span>
            </label>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Создать курс</button>
        </div>
    </form>
</div>