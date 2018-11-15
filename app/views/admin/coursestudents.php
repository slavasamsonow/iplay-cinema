<div class="container-fluid">
    <h1>Студенты курса "<?=$course['name']?>"</h1>

    <a href="students/add" class="btn">Добавить студента</a>

    <?php if(!empty($students)): ?>
        <table class="students">
            <tr>
                <th>ФИО</th>
                <th>Открепить</th>
            </tr>
            <?php foreach($students as $student): ?>
                <tr>
                    <td>
                        <?=$student['fname'].' '.$student['lname']?>
                    </td>
                    <td>
                        <button class="btn" data-type="coursestudent" data-action="delete"
                                data-course="<?=$student['courseid']?>" data-user="<?=$student['userid']?>">
                            Удалить
                        </button>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p> На данный момент нет студентов</p>
    <?php endif ?>
</div>