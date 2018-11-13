<div class="container-fluid">
    <h1>Страница редактирования задания</h1>
    <form action="/admin/edittask/<?=$task['id']?>" method="post">
        <input type="hidden" name="taskid" value="<?=$task['id']?>">
        <input type="hidden" name="course" value="<?=$task['course']?>">
        <div class="control-group form-group">
            <label>Название: </label>
            <textarea class="form-control" name="name" required="true"><?=$task['name']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Описание: </label>
            <textarea class="form-control" name="description"><?=$task['description']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Дата и время: </label>
            <input type="text" class="form-control" name="timestart"
                   value="<?=date('d.m.Y H:i:s', $task['timestart'])?>">
        </div>
        <div class="control-group form-group">
            <label>Процент прохождения курса: </label>
            <input type="text" class="form-control" name="percent" value="<?=$task['percent']?>">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="datetimenull" value="0" <?php if($task['timestart'] == 0)
                    echo 'checked' ?>>
                <span> Основное задание курса (не привязано к дате) </span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="verify" value="1" <?php if($task['verify'] == 1)
                    echo 'checked' ?>>
                <span> Нужно подтверждение </span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="active" value="1" <?php if($task['active'] == 1)
                    echo 'checked' ?>>
                <span> Активный </span>
            </label>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Редактировать задание</button>
        </div>
    </form>
</div>