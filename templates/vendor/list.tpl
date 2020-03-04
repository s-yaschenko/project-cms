{include file="header.tpl"}
<h1>Производители</h1>
{if !empty($message)}
    {foreach from=$message->getMessage() item=e key=k}
        <div class="alert alert-{$k}" role="alert">
            {$e}
        </div>
    {/foreach}
{/if}

<div class="row">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Название</th>
                <th scope="col" width="1" style="white-space: nowrap;">
                    <a class="btn btn-success" href="/vendor/create">Добавить категорию</a>
                </th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$vendors item=vendor}
            <tr>
                <td>{$vendor.name} <small class="text-secondary">({$vendor.id})</small> </td>
                <td style="white-space: nowrap;">
                    <a href="/folder/edit/{$vendor.id}" class="btn btn-sm btn-primary">Редактировать</a>
                    <form style="display:inline-block;" action="/vendor/delete" method="post">
                        <input type="hidden" name="id" value="{$vendor.id}">
                        <input type="submit" class="btn btn-sm btn-danger ml-2" value="Удалить"/>
                    </form>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
{include file="bottom.tpl"}