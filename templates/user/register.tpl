{include file="header.tpl"}
<h1>Регистрация</h1>
{if !empty($message)}
    {foreach from=$message->getMessage() item=e key=k}
        <div class="alert alert-{$k}" role="alert">
            {$e}
        </div>
    {/foreach}
{/if}
<form action="" method="post">
    <input type="hidden" name="user_id" value="{$user->getId()}">
    <div class="form-group">
        <label for="name">Имя пользователя</label>
        <input id="name" type="text" name="name" class="form-control" required value="{$user->getName()}">
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input id="email" type="text" name="email" class="form-control" required value="{$user->getEmail()}">
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password_repeat">Повторите пароль</label>
        <input id="password_repeat" type="password" name="password_repeat" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
</form>

{include file="bottom.tpl"}