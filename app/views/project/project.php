<div class="container-fluid projectPage">
    <h1>
        <?=$project['name']?>
    </h1>
    <div class="creator">Создатель:
        <a href="/user/id<?=$project['creatorid']?>">
            <?=$project['creatorfname'].' '.$project['creatorlname']?>
        </a>
        (<?=date('d.m.Y', $project['timestart'])?>)
    </div>
    <div class="row description">
        <div class="col-md-4">
            <div class="description">
                <?=$project['description']?>
            </div>
        </div>
        <div class="col-md-4">
            <?php if($project['video']): ?>
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?=$project['video']?>?rel=0&amp;controls=0&amp;showinfo=0"
                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            <?php endif ?>
        </div>
    </div>
    <h2>
        Видео проекта
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin' || isset($_SESSION['user']) && $project['creatorid'] == $_SESSION['user']['id']): ?>
            <a href="/project/<?=$project['id']?>/addvideo">+</a>
        <?php endif ?>
    </h2>
    <div class="row projectVideo">
        <?php foreach($videos as $videoItem): ?>
            <div class="col-md-3">
                <button data-action="modal" data-modal="video" data-videoname="<?=$videoItem["name"]?>" data-video='<iframe width="720" height="405"
                    src="https://www.youtube.com/embed/<?=$videoItem["source"]?>?rel=0"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        data-videodescription="<?=$videoItem["description"]?>">
                    <?php
                    if(!$videoItem['image']){
                        $videoItem['image'] = 'no-image.jpg';
                    }
                    ?>
                    <img src="/public/img/projects/videos/<?=$videoItem['image']?>" alt="<?=$videoItem["name"]?>">
                    <h3>
                        <?=$videoItem["name"]?>
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin' || isset($_SESSION['user']) && $project['creatorid'] == $_SESSION['user']['id']): ?>
                            <a href="/project/<?=$project['id']?>/editvideo/<?=$videoItem['id']?>">
                                <svg viewBox="0 0 528.899 528.899">
                                    <path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
		c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
		C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
		L27.473,390.597L0.3,512.69z"/>
                                </svg>
                            </a>
                        <?php endif ?></h3>
                    <p><?=$videoItem["description"]?></p>
                </button>
            </div>
        <?php endforeach ?>
    </div>
</div>

</div>

<div class="modal video">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Видео
    </div>
    <div class="modal-body">
        <div class="video"></div>
        <div class="description"></div>
    </div>
</div>

<div>