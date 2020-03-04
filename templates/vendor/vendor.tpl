{include file="header.tpl"}
<h1>
    {if $vendor.id == 0}
        Добавить производителя
    {else}
        Редактировать производителя: {$vendor.name}
    {/if}
</h1>

<form action="" method="post">
    <input type="hidden" name="user_id" value="{$vendor.id}">
    <div class="form-group">
        <label for="name">Название производителя</label>
        <input id="name" type="text" name="name" class="form-control" required value="{$vendor.name}">
    </div>

    <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
</form>

{include file="bottom.tpl"}