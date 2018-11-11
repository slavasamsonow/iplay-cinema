<h1>Редактировать курс</h1>
<div class="row">
    <form action="/admin/editcourse/<?=$course['id']?>" method="post" class="col-md-6">
        <input type="hidden" name="courseid" value="<?=$course['id']?>">
        <div class="control-group form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="name" required="true" value="<?=$course['name']?>">
        </div>
        <div class="control-group form-group">
            <label>Краткая аннотация:</label>
            <textarea class="form-control" name="caption"><?=$course['caption']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Описание:</label>
            <textarea class="form-control" name="description"><?=$course['description']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Дата и время начала (МСК):</label>
            <input type="text" class="form-control" name="timestart" required="true"
                   value="<?=date('d.m.Y H:i:s', $course['timestart'])?>">
        </div>
        <div class="control-group form-group">
            <label>Дата и время окончания (МСК):</label>
            <input type="text" class="form-control" name="timeend" required="true"
                   value="<?=date('d.m.Y H:i:s', $course['timeend'])?>">
        </div>
        <div class="control-group form-group">
            <label>Цена:</label>
            <input type="number" class="form-control" name="price" required="true" value="<?=$course['price']?>">
        </div>
        <div class="control-group form-group">
            <label>тип:</label>
            <select class="form-control" name="type">
                <?php foreach($coursesTypes as $coursesType): ?>
                    <option value="<?=$coursesType['id']?>" <?php if($course['type'] == $coursesType['id']) echo 'selected'; ?>>
                        <?=$coursesType['name']?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="control-group form-group">
            <label>Фото:</label>
            <input type="file" name="image">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="active" value="1" <?php if($course['active'] == 1) echo 'checked'; ?>>
                <span> Активный </span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="private" value="1" <?php if($course['private'] == 1) echo 'checked'; ?>>
                <span> Приватный </span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="payment" value="1" <?php if($course['payment'] == 1) echo 'checked'; ?>>
                <span> Разрешен к оплате </span>
            </label>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Редактировать курс</button>
        </div>
    </form>
</div>