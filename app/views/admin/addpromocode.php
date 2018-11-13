<div class="container-fluid">
    <h1>Создать новый промокод</h1>
    <div class="row">
        <form action="/admin/addpromocode" method="post" class="col-md-6">
            <div class="control-group form-group">
                <label>Код</label>
                <input type="text" class="form-control" name="code" required="true">
            </div>
            <div class="control-group form-group">
                <label>Скидка (в рублях или %)</label>
                <input type="text" class="form-control" name="sale" required="true">
            </div>
            <div class="control-group form-group">
                <label>Дата и время начала</label>
                <input type="text" class="form-control" name="timestart" required="true"
                       value="<?=date('d.m.Y H:i:', time())?>00">
            </div>
            <div class="control-group form-group">
                <label>Дата и время конца</label>
                <input type="text" class="form-control" name="timeend" required="true"
                       value="<?=date('d.m.Y H:i:', time())?>00">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="noEnd" value="1">
                    <span> Без конца </span>
                </label>
            </div>
            <div class="control-group form-group">
                <label>Курс:</label>
                <select class="form-control" name="course">
                    <option value="all">Все</option>
                    <?php foreach($coursesList as $coursesListItem): ?>
                        <option value="<?=$coursesListItem['id']?>">
                            <?=$coursesListItem['name']?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="control-group form-group">
                <button type="submit" class="btn btn-default btn-sm">Создать промокод</button>
            </div>
        </form>
    </div>
</div>