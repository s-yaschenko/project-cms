{include file="header.tpl"}
<h1>Авторизация</h1>

{if !empty($message)}
    {foreach from=$message->getMessage() item=e key=k}
        <div class="alert alert-{$k}" role="alert">
            {$e}
        </div>
    {/foreach}
{/if}

<form  method="post" action="/login">
    <label class="sr-only" for="inlineFormInputName2">Login</label>
    <input type="text" name="email" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="email">

    <label class="sr-only" for="inlineFormInputName2">Name</label>
    <input type="password" name="password" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="password">

    <button type="submit" class="btn btn-primary mb-2">Войти</button>
</form>
{include file="bottom.tpl"}