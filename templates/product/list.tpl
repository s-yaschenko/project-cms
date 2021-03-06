{include file="header.tpl"}


<div class="row">
    <div class="d-flex justify-content-between w-100">
        <h1>
            Товары
            {if $products.current_page != 1}
                <small>(стр: {$products.current_page})</small>
            {/if}
        </h1>
        <div class="btn">
            <a href="/product/create" class="btn btn-success">Добавить товар</a>
        </div>
    </div>
</div>
{if !empty($message)}
    {foreach from=$message->getMessage() item=e key=k}
        <div class="alert alert-{$k}" role="alert">
            {$e}
        </div>
    {/foreach}
{/if}

<div class="row">
    {foreach from=$products.items item=product}
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"  aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Фото товара</text></svg>
                <div class="card-body">
                    <p class="card-text"><a href="/product/{$product.id}">{$product.name}</a></p>
                    <p>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="/product/edit/{$product.id}" class="btn btn-sm btn-outline-secondary">Редактировать</a>
                            <a href="/product/buy/{$product.id}" class="btn btn-sm btn-outline-secondary">Купить</a>
                        </div>
                        <small class="text-muted">{$product.price}</small>
                    </div>
                    <div>
                        <p style="padding: 10px 10px 0 10px; font-size: 0.8em;">{$product.description}</p>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
</div>

{include file="pagination.tpl" paginator="$products"}
{include file="bottom.tpl"}