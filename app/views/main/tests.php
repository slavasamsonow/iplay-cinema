<h1><?=$test['name']?></h1>
<p><?=$test['description']?></p>
<form action="/tests" method="post">
    <input type="hidden" name="testCode" value="<?=$test['code']?>">
    <?php foreach($test['questions'] as $numQuestion => $question): ?>
        <p><b><?=$question['name']?></b></p>
        <?php foreach($question['answers'] as $answer):?>
            <div class="radio">
                <label>
                    <input type="radio" name="<?=$numQuestion?>" value="<?=$answer['val']?>">
                    <?=$answer['name']?>
                </label>
            </div>
        <?php endforeach ?>
    <?php endforeach ?>
    <div class="form-group">
        <label>Электронная почта</label>
        <input type="email" class="form-control" name="email" placeholder="email" required>
    </div>
    <button class="btn" type="submit">Отправить</button>
</form>