<h1><?=$test['name']?></h1>
<p><?=$test['description']?></p>
<form action="<?=explode('?',$_SERVER['REQUEST_URI'])[0];?>" method="post">
    <input type="hidden" name="testCode" value="<?=$test['code']?>">
    <?php foreach($test['questions'] as $keyQuestion => $question): ?>
        <p><b><?=$question['name']?></b></p>
        <?php foreach($question['answers'] as $keyAnswer => $answer):?>
            <div class="radio">
                <label>
                    <input type="radio" name="answers[<?=$keyQuestion?>]" value="<?=$keyAnswer?>" required>
                    <?=$answer?>
                </label>
            </div>
        <?php endforeach ?>
    <?php endforeach ?>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Электронная почта</label>
            <input type="email" class="form-control" name="email" placeholder="email" required>
        </div>
    </div>

    <button class="btn" type="submit">Отправить</button>
</form>