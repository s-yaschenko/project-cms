{include file="header.tpl"}
<h1>{$product.name}</h1>

<div class="card">
    <h5 class="card-header">{$product.name} <span class="badge badge-success">Цена: {$product.price}</span></h5>
    <div class="card-body">
        <h5 class="card-title">Информация о товаре</h5>
        <p class="card-text">
        <ul>
            <li>Кол-во товара: {$product.amount}</li>
            {assign var=product_vendor_id value=$product.vendor_id}
            <li>Производитель: {$vendors[$product_vendor_id].name}</li>
            <li>Категории:
                {foreach from=$product->getFolderIds() item=folder_id name=product_folder_ids}
                    {$folders[$folder_id].name}
                    {if !$smarty.foreach.product_folder_ids.last}, {/if}
                    {foreachelse}
                    &ndash;
                {/foreach}
            </li>
        </ul>
        </p>
        <hr>
        <h5 class="card-title">Описание</h5>
        <p class="card-text">{$product.description}</p>
        <hr>
        <a href="/product/buy/{$product.id}" class="btn btn-primary">Купить</a>
    </div>
</div>
{include file="bottom.tpl"}