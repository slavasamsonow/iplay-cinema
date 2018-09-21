<h1>
    <?php if(isset($user['fname']) || isset($user['lname'])){
        echo $user['fname'].' '.$user['lname'];
    }elseif(isset($user['username'])){
        echo $user['username'];
    }else{
        echo $user['email'];
    }?>
</h1>
<div class="row">
    <div class="col-md-2">
        <a href="/account/editpass">Сменить пароль</a> <br>
        <a href="/account/logout">Выйти</a>
    </div>

</div>