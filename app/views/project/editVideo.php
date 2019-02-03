<div class="container-fluid">
    <h1>Редактировать видео</h1>
    <div class="row">
        <form action="/project/<?=$video['project']?>/editvideo/<?=$video['id']?>" method="post" class="col-md-6">
            <input type="hidden" name="id" value="<?=$video['id']?>">
            <input type="hidden" name="project" value="<?=$video['project']?>">
            <input type="hidden" name="oldimage" value="<?=$video['image']?>">
            <div class="control-group form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" required="true" value="<?=$video['name']?>">
            </div>
            <div class="control-group form-group">
                <label>Описание:</label>
                <textarea class="form-control" name="description"><?=$video['description']?></textarea>
            </div>
            <div class="control-group form-group">
                <label>Идентификатор видео youtube</label>
                <input type="text" class="form-control" name="source" required="true" value="<?=$video['source']?>">
            </div>
            <?php
            if(!$video['image']){
                $video['image'] = 'no-image.jpg';
            }
            ?>
            <img src="/public/img/projects/videos/<?=$video['image']?>">
            <div class="control-group form-group">
                <label>Заменить фото:</label>
                <input type="file" name="image">
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="active" value="1" checked>
                    <span> Активный </span>
                </label>
            </div>

            <div class="control-group form-group">
                <button type="submit" class="btn btn-default btn-sm">Сохранить видео</button>
            </div>
        </form>
    </div>
</div>