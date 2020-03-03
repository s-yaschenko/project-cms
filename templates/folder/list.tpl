{include file="header.tpl"}

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
                <th scope="col" width="1">#</th>
                <th scope="col">Название</th>
                <th scope="col" width="1" style="white-space: nowrap;">
                    <a class="btn btn-success" href="/folder/create">Добавить категорию</a>
                </th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$folders item=folder}
            <tr>
                <th scope="row">{$folder->getId()}</th>
                <td>{$folder->getName()}</td>
                <td style="white-space: nowrap;">

                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
{include file="bottom.tpl"}