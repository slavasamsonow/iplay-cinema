<?php

namespace app\models;

use app\core\Model;

class Course extends Model{

    /**
     * Работа с кусом
     */

    /**
     * Создает курс
     *
     * @param $data
     *
     * @return string
     */
    public function create($data){
        $params = $this->processTextIn($data);
        $params['timestart'] = $this->toUnixTime($params['timestart']);
        $params['timeend'] = $this->toUnixTime($params['timeend']);
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `courses` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    /**
     * Обвновление информации курса
     *
     * @param $id
     * @param $data
     *
     * @return bool
     */
    public function update($id, $data){
        $params = $this->processTextIn($data);
        $params['timestart'] = $this->toUnixTime($params['timestart']);
        $params['timeend'] = $this->toUnixTime($params['timeend']);
        $paramNV = $this->db->paramNV($params);
        $params['id'] = $id;

        $this->db->query('UPDATE `courses` SET '.$paramNV.' WHERE `id` = :id', $params);
        return true;
    }

    /**
     * Возвращает список курсов для обучения студента
     * @return array
     */
    public function getStudyCoursesList(){
        $params = [
            'userId' => $_SESSION['user']['id'],
        ];
        $allCourses = $this->db->row('SELECT c.*, uc.percent FROM courses c JOIN user_courses uc ON c.id = uc.course WHERE uc.user = :userId ORDER BY c.timestart ASC', $params);
        $courses = [
            'Активные' => [],
            'Предстоящие' => [],
            'Прошедшие' => []
        ];
        foreach($allCourses as $course){
            if($course['timestart'] < time() && ($course['timeend'] > time() || !$course['timeend'])){
                $courses['Активные'][] = $course;
            }
            if($course['timestart'] > time()){
                $courses['Предстоящие'][] = $course;
            }
            if($course['timeend'] < time() && $course['timeend']){
                $courses['Прошедшие'][] = $course;
            }
        }
        return $courses;
    }

    /**
     * Возвращает список всех курсов
     * @return array
     */
    public function getAll(){
        $courses = $this->db->row('SELECT * FROM courses c ORDER BY c.timestart ASC');
        return $courses;
    }

    /**
     * Возвращает список активных курсов
     *
     * @param $param
     *
     * @return array
     */
    public function getActive($param = []){
        $params = [
            'timestart' => time(),
        ];
        $usl = '';
        if(isset($param['coursesType'])){
            switch($param['coursesType']){
                case 'event':
                    $params['type'] = 1;
                    break;
                case 'basic':
                    $params['type'] = 2;
                    break;
                case 'main':
                    $params['type'] = 3;
                    break;
            }
            $usl .= 'AND c.type = :type';
        }

        $coursesList = $this->db->row('SELECT * FROM courses c WHERE c.active = 1 AND c.type != 0 AND c.timestart > :timestart '.$usl.' ORDER BY c.timestart ASC', $params);
        return $coursesList;
    }

    /**
     * Возвращает данные о курсе
     *
     * @param $courseId
     *
     * @return bool
     */
    public function getItem($courseId){
        $params = [
            'id' => $courseId,
        ];
        $course = $this->db->row('SELECT c.*, ct.eng AS `type` FROM courses c JOIN courses_type ct ON c.type = ct.id WHERE c.id = :id', $params);

        if(empty($course)){
            return false;
        }
        return $course[0];
    }

    /**
     * Возвращает данные о курсе для редактирования
     *
     * @param $courseId
     *
     * @return bool|mixed
     */
    public function getItemActive($courseId){
        if(!$course = $this->getItem($courseId)){
            return false;
        }
        return $this->processTextOut($course);
    }



    /**
     * Работа с типами курсов
     */
    /**
     * Возвращает список типов курсов
     * @return array
     */
    public function getCoursesTypes(){
        return $this->db->row('SELECT ct.id, ct.name FROM courses_type ct');
    }



    /**
     * Работа с преподавателями курса
     */

    /**
     * Возвращает список преподавателей курса
     *
     * @param $courseId
     *
     * @return array
     */
    public function getTeachers($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        $teachers = $this->db->row('SELECT u.* FROM courses_teachers ct JOIN users u ON ct.teacher=u.id WHERE ct.course = :courseid', $params);

        foreach($teachers as $key => $teacher){
            if($teacher['username'] == ''){
                $teachers[$key]['username'] = 'id'.$teacher['id'];
            }
        }

        return $teachers;
    }

    public function addTeachers($courseId, $userId){
        $params = [
            'teacher' => $userId,
            'course' => $courseId,
        ];
        $id = $this->db->column('SELECT ct.id FROM courses_teachers ct WHERE ct.teacher = :teacher AND ct.course = :course', $params);
        if($id){
            $this->error = 'Этот пользователь уже является преподавателем этого курса';
            return false;
        }

        $params = [
            'course' => $courseId,
            'teacher' => $userId,
        ];
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `courses_teachers` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    public function removeTeacher($courseId, $teacherId){
        $params = [
            'course' => $courseId,
            'teacher' => $teacherId
        ];
        $this->db->query('DELETE FROM courses_teachers WHERE course = :course AND teacher = :teacher', $params);
    }



    /**
     * Работа с кураторами курса
     */

    /**
     * Возвращает список кураторов курса
     *
     * @param $courseId
     *
     * @return array
     */
    public function getCurators($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        $curators = $this->db->row('SELECT u.id, u.username, u.fname, u.lname, u.photo FROM user_courses uc JOIN users u ON uc.curator=u.id WHERE uc.course = :courseid GROUP BY u.id', $params);

        foreach($curators as $key => $curator){
            if($curator['username'] == ''){
                $curators[$key]['username'] = 'id'.$curator['id'];
            }
        }

        return $curators;
    }



    /**
     * Работа с программой курса
     */

    /**
     * Возвращает программу курса
     *
     * @param $courseId
     *
     * @return array
     */
    public function getProgram($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        return $this->db->row('SELECT cp.name, cp.description FROM courses_programs cp WHERE cp.course = :courseid', $params);
    }



    /**
     * Работа с проектами курса
     */

    /**
     * Возвращает список проектов курса
     *
     * @param $courseId
     *
     * @return array
     */
    public function getProjectsCourse($courseId){
        $params = [
            'course' => $courseId,
        ];
        $projectsList = $this->db->row('SELECT p.* FROM projects p WHERE p.course = :course', $params);
        return $projectsList;
    }



    /**
     * Работа с заданиями курса
     */

    /**
     * Возвращает задания курса
     *
     * @param $courseId
     * @param string $userId
     *
     * @return array
     */
    public function getTasksCourse($courseId, $userId = ''){
        if($userId == ''){
            $userId = $_SESSION['user']['id'];
        }

        $params = [
            'course' => $courseId,
        ];
        $tasksCourse = $this->db->row('SELECT * FROM courses_tasks WHERE course = :course', $params);
        $params = [
            'user' => $userId,
        ];
        $tasks = $this->db->row('SELECT task FROM user_tasks WHERE user = :user', $params);

        $tasksId = [];
        foreach($tasks as $task){
            $tasksId[] = $task['task'];
        }

        $params = [];
        $i = 0;
        foreach($tasksCourse as $taskC){
            if(!in_array($taskC['id'], $tasksId)){
                $params['task'.$i] = $taskC['id'];
                $params['user'.$i] = $_SESSION['user']['id'];
                if($i == 0){
                    $values = '(:task'.$i.',:user'.$i.')';
                }
                else{
                    $values .= ', (:task'.$i.',:user'.$i.')';
                }
                $i++;
            }
        }

        if(isset($values)){
            $this->db->query('INSERT INTO user_tasks (task, user) VALUES '.$values, $params);
        }
        $params = [
            'user' => $userId,
            'course' => $courseId,
            'timestart' => time(),
        ];
        $tasks = $this->db->row('SELECT ct.*, ct.id AS taskid, ut.* FROM courses_tasks ct LEFT JOIN user_tasks ut ON ut.task=ct.id WHERE ut.user = :user AND ct.course = :course AND ct.timestart <= :timestart ORDER BY `timestart` DESC', $params);

        $taskDate = [
            'Общие' => [],
        ];
        foreach($tasks as $task){
            $index = date('d.m.Y', $task['timestart']);
            if($task['timestart'] == 0)
                $index = 'Общие';

            $taskDate[$index]['taskslist'][] = $task;

            if(!isset($taskDate[$index]['count'])){
                $taskDate[$index]['count'] = 1;
            }
            else{
                $taskDate[$index]['count']++;
            }

            if(!isset($taskDate[$index]['done'])){
                $taskDate[$index]['done'] = 0;
            }
            if($task['status'] == 'done'){
                $taskDate[$index]['done']++;
            }
        }
        if(empty($taskDate['Общие'])){
            unset($taskDate['Общие']);
        }
        return $taskDate;
    }

    /**
     * Изменение статуса задания
     *
     * @param $taskId
     * @param string $userid
     *
     * @return array
     */
    public function changeTask($taskId, $userid = ''){
        if($userid == ''){
            $userid = $_SESSION['user']['id'];
        }

        $params = [
            'task' => $taskId,
            'user' => $userid,
        ];
        $task = $this->db->row('SELECT ct.*, ct.id AS taskid, ut.* FROM user_tasks ut JOIN courses_tasks ct ON ut.task = ct.id WHERE ut.task = :task AND ut.user = :user', $params);

        if(empty($task)){
            return [
                'error' => 'Ошибка инициализации'
            ];
        }
        else{
            $task = $task[0];
        }
        if($task['status'] == 'verify'){
            return [
                'error' => 'Это поле сейчас на стадии проверки'
            ];
        }

        $params = [
            'id' => $task['id'],
            'comment' => $task['comment'],
        ];
        if($task['verify'] == 1){
            if($task['status'] == 'done'){
                return [
                    'error' => 'Это поле уже проверено. Его нельзя менять'
                ];
            }
            if($task['taskid'] == '1'){
                if($_SESSION['user']['active'] == 1){
                    $params['status'] = 'done';
                }
                else{
                    return [
                        'error' => 'Вы не подтвердили свой email'
                    ];
                }
            }
            else{
                $params['status'] = 'verify';
                $params['comment'] = 'Запрос на проверку домашнего задания отправлен';
            }
        }
        else{
            if($task['status'] == 'done'){
                $params['status'] = 'ndone';
            }
            else if($task['status'] == 'ndone'){
                $params['status'] = 'done';
            }
        }

        $this->db->query('UPDATE user_tasks ut SET ut.status = :status, ut.comment = :comment WHERE id = :id', $params);
        $status = $params['status'];
        $comment = $params['comment'];

        $params = [
            'user' => $userid,
            'statusN' => 'done',
            'course' => $task['course'],
        ];
        $allTask = $this->db->row('SELECT * FROM `courses_tasks` t JOIN `user_tasks` u ON u.task=t.id WHERE u.user=:user AND u.status=:statusN AND t.course = :course', $params);

        $allpercent = 0;
        foreach($allTask as $task){
            $allpercent += $task['percent'];
        }
        if($allpercent < 0)
            $allpercent = 0;
        if($allpercent > 100)
            $allpercent = 100;

        $params = [
            'percent' => $allpercent,
            'course' => $task['course'],
            'user' => $userid,
        ];
        $this->db->query('UPDATE `user_courses` SET `percent` = :percent WHERE `course` = :course AND `user` = :user', $params);

        return [
            'status' => $status,
            'percent' => $allpercent,
            'comment' => $comment,
        ];
    }



    /**
     * Работа с участниками курса
     */

    /**
     * Возвращает список студентов курса
     *
     * @param $courseId
     *
     * @return array
     */
    /**
     * Проверяет принадлежность студента к курсу
     *
     * @param $courseId
     * @param string $userid
     *
     * @return bool
     */
    public function checkCourse($courseId, $userid = ''){
        if($userid == ''){
            $userid = $_SESSION['user']['id'];
        }

        $params = [
            'userid' => $userid,
            'courseid' => $courseId,
        ];
        $course = $this->db->row('SELECT c.*, u.percent FROM courses c JOIN user_courses u ON c.id=u.course WHERE u.user=:userid AND u.course = :courseid', $params);

        if(isset($course[0])){
            return $course[0];
        }
        else{
            return false;
        }
    }

    public function getCourseStudents($courseId, $params = []){
        $params = [
            'course' => $courseId,
        ];

        if(isset($param['users'])){
            $usl['users'] = 'uc.user IN('.$param['users'].')';
        }
        if(isset($param['courses'])){
            $usl['courses'] = 'uc.course IN('.$param['courses'].')';
        }


        $uslText = '';
        if(!empty($usl)){
            foreach($usl as $uslItem){
                $uslText .= 'AND '.$uslItem;
            }
        }
        $query = 'SELECT
        u.id AS userid, u.fname, u.lname, u.photo, u.username,
        c.id AS courseid, c.name AS coursename, c.type,
        uc.percent
        FROM user_courses uc
        JOIN users u ON uc.user = u.id
        JOIN courses c ON uc.course = c.id
        WHERE uc.course = :course '.
            $uslText
            .'
        ORDER BY uc.course ASC, u.fname ASC, u.lname ASC';
        //        debug($params);
        $userCoursesList = $this->db->row($query, $params);

        foreach($userCoursesList as $key => $userCourses){
            if($userCourses['type'] == 0){
                unset($userCoursesList[$key]);
            }
            else{
                $userCoursesList[$key]['fullName'] = $userCourses['fname'].' '.$userCourses['lname'];
            }
        }
        return $userCoursesList;


        $params = [
            'course' => $courseId,
        ];
        $usersList = $this->db->row('SELECT * FROM user_courses uc JOIN users u ON uc.user = u.id WHERE uc.course = :course', $params);
        foreach($usersList as $key => $user){
            if($user['username'] == ''){
                $usersList[$key]['username'] = 'id'.$user['id'];
            }
        }
        return $usersList;
    }

    public function addCourseStudent($courseId, $userId){
        $params = [
            'user' => $userId,
            'course' => $courseId,
        ];
        $id = $this->db->column('SELECT uc.id FROM user_courses uc WHERE uc.user = :user AND uc.course = :course', $params);
        if($id){
            $this->error = 'У этого пользователя уже есть этот курс';
            return false;
        }

        $paramNandV = $this->db->paramNandV($params);
        $this->db->query('INSERT INTO user_courses ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    public function removeCourseStudent($courseId, $userId){
        $params = [
            'user' => $userId,
            'course' => $courseId
        ];
        $id = $this->db->column('SELECT uc.id FROM user_courses uc WHERE uc.user = :user AND uc.course = :course', $params);
        if(!$id){
            $this->error = 'У этого пользователя нет этого курса';
            return false;
        }

        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM user_courses WHERE id = :id', $params);
        return [
            'status' => 'delete',
        ];
    }


    public function grantApplicationUser($data){
        $varsAmo = [
            'name' => 'Заявка на грант',
            'nameCourse' => $data['course'],
            'sale' => 0,
            'contact_id' => $_SESSION['user']['amoid'],
        ];
        $this->amo->newLead($varsAmo);
        return true;
    }

    public function grantApplicationGuest($data){
        $varsAmo = [
            'name' => 'Заявка на грант',
            'nameCourse' => $data['course'],
            'sale' => 0,
        ];
        if($amoContact = $this->amo->searchContact($data['email'])){
            $varsAmo['contact_id'] = $amoContact['id'];
            $notes = [
                'Email: '.$data['email'],
                'Телефон: '.$data['phone'],
                'Город: '.$data['city'],
            ];
            $this->amo->addNotesContact($amoContact['id'], $notes);
        }
        else{
            $varsAmoNew = [
                'email' => $data['email'],
            ];

            if(isset($data['fio'])){
                $varsAmoNew['name'] = $data['fio'];
            }
            else{
                $varsAmoNew['name'] = $data['email'];
            }

            if(isset($dataPayer['city'])){
                $varsAmoNew['city'] = $data['city'];
            }

            if(isset($dataPayer['phone'])){
                $varsAmoNew['phone'] = $data['phone'];
            }

            $varsAmo['contact_id'] = $this->amo->newContact($varsAmoNew);
        }
        $amoid = $this->amo->newLead($varsAmo);

        return true;
    }

    public function registerCourseUser($data){
        $varsAmo = [
            'name' => 'Заявка на курс',
            'nameCourse' => $data['course'],
            'sale' => 0,
            'contact_id' => $_SESSION['user']['amoid'],
        ];
        $this->amo->newLead($varsAmo);
        return true;
    }

    /**
     * Регистрация гостя на курс
     *
     * @param $data
     *
     * @return bool
     */
    public function registerСourseGuest($data){
        $varsAmo = [
            'name' => 'Заявка на курс',
            'nameCourse' => $data['course'],
            'sale' => 0,
        ];
        if($amoContact = $this->amo->searchContact($data['email'])){
            $varsAmo['contact_id'] = $amoContact['id'];
            $notes = [
                'Email: '.$data['email'],
                'Телефон: '.$data['phone'],
                'Город: '.$data['city'],
            ];
            $this->amo->addNotesContact($amoContact['id'], $notes);
        }
        else{
            $varsAmoNew = [
                'email' => $data['email'],
            ];

            if(isset($data['fio'])){
                $varsAmoNew['name'] = $data['fio'];
            }
            else{
                $varsAmoNew['name'] = $data['email'];
            }

            if(isset($dataPayer['city'])){
                $varsAmoNew['city'] = $data['city'];
            }

            if(isset($dataPayer['phone'])){
                $varsAmoNew['phone'] = $data['phone'];
            }

            $varsAmo['contact_id'] = $this->amo->newContact($varsAmoNew);
        }

        $amoid = $this->amo->newLead($varsAmo);

        if(isset($data['email'])){
            $_SESSION['guest']['email'] = $data['email'];
        }
        if(isset($data['fio'])){
            $_SESSION['guest']['fio'] = $data['fio'];
        }
        if(isset($data['phone'])){
            $_SESSION['guest']['phone'] = $data['phone'];
        }
        if(isset($data['city'])){
            $_SESSION['guest']['city'] = $data['city'];
        }

        ob_start();
        ?>
        <h1 style="font-family: Arial, sans-serif;font-size: 18px;">Ваша заявка принята</h1>
        <p style="line-height: 1.5em;">
            В скором времени мы с вами свяжемся
        </p>
        <?
        $message = ob_get_clean();

        $this->phpmailer($data['email'], $data['fio'], 'Ваша заявка принята', $message);

        return true;
    }
}