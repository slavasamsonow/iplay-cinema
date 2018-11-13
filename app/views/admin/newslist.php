<div class="container-fluid">
    <h1><span class="big">Новости</span></h1>
    <a href="/admin/addnews" class="btn">Создать новость</a>
    <?php if(!empty($news)): ?>
        <div class="newslist">
            <?php for($i = 0; $i < count($news); $i++): ?>
                <?php if($i % 3 == 0): ?>
                    <div class="row">
                <?php endif ?>
                <div class="news col-md-4">
                    <h2>
                        <?=$news[$i]['title']?>
                    </h2>
                    <div class="date-start">
                        Дата:
                        <?=date('d.m.Y', $news[$i]['timestart'])?>
                    </div>
                    <div class="param">
                        Активный:
                        <?php if($news[$i]['active'] == 1){
                            echo 'Да';
                        }
                        else{
                            echo 'Нет';
                        } ?> <br>
                        Автор:
                        <?=$news[$i]['author']?>
                    </div>
                    <br>
                    <div class="description">
                        <?=$news[$i]['caption']?>
                    </div>
                    <br>
                    <a href="/admin/editnews/<?=$news[$i]['id']?>" class="btn btn-default btn-sm">Редактировать</a>
                </div>
                <?php if($i % 3 == 2 || $i + 1 == count($news)): ?>
                    </div>
                <?php endif ?>
            <?php endfor ?>
        </div>
    <?php else: ?>
        На данный момент нет новостей
    <?php endif ?></div>