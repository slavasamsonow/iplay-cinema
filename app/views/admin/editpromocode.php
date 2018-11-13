<div class="container-fluid">
    <h1>Редактировать промокод</h1>
    <div class="row">
        <form action="/admin/editpromocode/<?=$promocode['id']?>" method="post" class="col-md-6">
            <input type="hidden" name="promocodeid" value="<?=$promocode['id']?>">
            <div class="control-group form-group">
                <label>Код</label>
                <input type="text" class="form-control" name="code" required="true" value="<?=$promocode['code']?>">
            </div>
            <div class="control-group form-group">
                <label>Скидка (в рублях или %)</label>
                <input type="text" class="form-control" name="sale" required="true" value="<?=$promocode['sale']?>">
            </div>
            <div class="control-group form-group">
                <label>Дата и время начала</label>
                <input type="text" class="form-control" name="timestart" required="true"
                       value="<?=date('d.m.Y H:i:m', $promocode['timestart'])?>">
            </div>
            <div class="control-group form-group">
                <label>Дата и время конца</label>
                <input type="text" class="form-control" name="timeend" required="true"
                       value="<?=date('d.m.Y H:i:m', $promocode['timeend'])?>">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="noEnd" value="1" <? if($promocode['noEnd'] == 1){
                        echo 'checked';
                    } ?>>
                    <span> Без конца </span>
                </label>
            </div>
            <div class="control-group form-group">
                <label>Курс:</label>
                <select class="form-control" name="course">
                    <option value="all" <? if($promocode['course'] == 'all'){
                        echo 'selected';
                    } ?>>Все
                    </option>
                    <?php foreach($coursesList as $coursesListItem): ?>
                        <option value="<?=$coursesListItem['id']?>" <? if($promocode['course'] == $coursesListItem['id']){
                            echo
                            'selected';
                        } ?>>
                            <?=$coursesListItem['name']?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="active" value="1" <? if($promocode['active'] == 1){
                        echo 'checked';
                    } ?>>
                    <span> Активный </span>
                </label>
            </div>
            <div class="control-group form-group">
                <button type="submit" class="btn btn-default btn-sm">Редактировать промокод</button>
            </div>
        </form>
    </div>
</div>