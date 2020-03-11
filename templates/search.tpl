{include file="header.tpl"}
<h1>Поиск</h1>
<div class="row">
    {foreach from=$products item=product}
    <div class="card w-100 mb-2">
        <h5 class="card-header"><a href="/product/{$product.id}">{$product.name}</a> <span class="badge badge-success">Цена: {$product.price}</span></h5>
        <div class="card-body">
            <a href="/product/buy/{$product.id}" class="btn btn-primary mr-1">Купить</a>
        </div>
    </div>
    {/foreach}
</div>
{include file="bottom.tpl"}