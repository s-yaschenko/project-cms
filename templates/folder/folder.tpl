{include file="header.tpl"}
<h1>
    {if $folder->getId() == 0}
        Добавить категорию
    {else}
        Редактировать категорию: {$folder->getName()}
    {/if}
</h1>

<form action="" method="post">
    <input type="hidden" name="user_id" value="{$folder->getId()}">
    <div class="form-group">
        <label for="name">Название категории</label>
        <input id="name" type="text" name="name" class="form-control" required value="{$folder->getName()}">
    </div>

    <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
</form>

{include file="bottom.tpl"}