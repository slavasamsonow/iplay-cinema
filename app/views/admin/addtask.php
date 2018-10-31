<h1>Страница создания задания</h1>
<form action="/admin/addtask/<?=$course['id']?>" method="post">
    <input type="hidden" name="course" value="<?=$course['id']?>">
    <div class="control-group form-group">
        <label>Курс: </label>
        <input type="text" class="form-control" value="<?=$course['name']?>" readonly>
    </div>
    <div class="control-group form-group">
        <label>Название: </label>
        <textarea class="form-control" name="name" required="true"></textarea>
    </div>
    <div class="control-group form-group">
        <label>Описание: </label>
        <textarea class="form-control" name="description"></textarea>
    </div>
    <div class="control-group form-group">
        <label>Дата и время: </label>
        <input type="text" class="form-control" name="datetime" value="">
    </div>
    <div class="control-group form-group">
        <label>Процент прохождения курса: </label>
        <input type="text" class="form-control" name="percent" value="">
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="datetimenull" value="0">
            <span> Основное задание курса (не привязано к дате) </span>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="active" value="1">
            <span> Нужно подтверждение </span>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="active" value="1" checked>
            <span> Активный </span>
        </label>
    </div>
    <div class="control-group form-group">
        <button type="submit" class="btn btn-default btn-sm">Создать саздание</button>
    </div>
</form>