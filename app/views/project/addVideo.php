<div class="container-fluid">
    <h1>Добавить новое видео к проекту "<?=$project['name']?>"</h1>
    <div class="row">
        <form action="/project/<?=$project['id']?>/addvideo" method="post" class="col-md-6">
            <input type="hidden" name="project" value="<?=$project['id']?>">
            <div class="control-group form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" required="true">
            </div>
            <div class="control-group form-group">
                <label>Описание:</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="control-group form-group">
                <label>Идентификатор видео youtube</label>
                <input type="text" class="form-control" name="source" required="true">
            </div>

            <div class="control-group form-group">
                <label>Фото:</label>
                <input type="file" name="image">
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="active" value="1" checked>
                    <span> Активный </span>
                </label>
            </div>

            <div class="control-group form-group">
                <button type="submit" class="btn btn-default btn-sm">Прикрепить видео</button>
            </div>
        </form>
    </div>
</div>