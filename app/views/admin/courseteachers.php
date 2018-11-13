<h1>Преподаватели курса "<?=$course['name']?>"</h1>

<a href="teachers/add" class="btn">Добавить преподавателя</a>

<?php if(!empty($teachers)):?>
<table class="teachers">
    <tr>
        <th>ФИО</th>
        <th>Текст</th>
        <th>Открепить</th>
    </tr>
    <?php foreach($teachers as $teacher): ?>
        <tr>
            <td>
                <?=$teacher['fname'].' '.$teacher['lname']?>
            </td>
            <td>

            </td>
            <td>
                <button class="btn" data-type="courseteacher" data-action="delete" data-course="<?=$course['id']?>" data-teacher="<?=$teacher['id']?>">
                    Удалить
                </button>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php else: ?>
<p> На данный момент нет преподавателей</p>
<?php endif ?>
